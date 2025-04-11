<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\PaymentItem;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\CourseConfirmationMail;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    private $geminiClient;

    public function __construct()
    {
        $this->geminiClient = new Client([
            'base_uri' => 'https://api.gemini.google.com/v1/',
            'headers' => [
                'Authorization' => 'Bearer ' . config('services.gemini.api_key'),
                'Content-Type' => 'application/json',
            ],
        ]);
    }

    private function callGeminiApi($prompt)
    {
        try {
            $response = $this->geminiClient->post('generate', [
                'json' => [
                    'prompt' => $prompt,
                    'max_tokens' => 100,
                ],
            ]);
            $data = json_decode($response->getBody(), true);
            return $data['text'] ?? 'Không thể tạo nội dung từ Gemini.';
        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            return 'Có lỗi khi gọi Gemini API.';
        }
    }

    public function index()
    {
        $title = 'Quản Lí Hóa Đơn';
        $payments = Payment::with(['user', 'course', 'paymentItems'])->paginate(5);
        return view('admin.order.index', compact('title', 'payments'));
    }

    public function show($id)
    {
        $payment = Payment::with(['user', 'course', 'paymentItems.course'])->findOrFail($id);
        $title = 'Chi Tiết Hóa Đơn #' . $payment->id;
        return view('admin.order.show', compact('title', 'payment'));
    }

    public function delete($id)
    {
        $payment = Payment::find($id);
        if ($payment) {
            $payment->delete(); // Các PaymentItem sẽ tự động bị xóa do ON DELETE CASCADE
            return redirect()->route('admin.order.index')->with('success', 'Xóa Hóa Đơn Thành Công');
        }
        return redirect()->route('admin.order.index')->with('error', 'Không tìm thấy hóa đơn');
    }

    public function create(Request $request)
    {
        $vnp_TmnCode = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url = config('services.vnpay.url');
        $vnp_ReturnUrl = config('services.vnpay.callback');

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'price' => 'required|numeric|min:0',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đăng ký khóa học');
        }

        $course = Course::findOrFail($request->course_id);

        // Check if the course has at least one section
        if ($course->sections()->count() === 0) {
            return redirect()->back()->with('error', 'Khóa học chưa được hoàn tất, bạn không thể đăng ký.');
        }

        $originalPrice = $course->price;

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $request->course_id)
            ->first();
        if ($enrollment) {
            return redirect()->route('payment.result', [
                'status' => 'already_enrolled',
                'course_id' => $request->course_id,
            ]);
        }

        if ($course->price == 0) {
            Enrollment::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ],
                [
                    'enrollment_at' => now(),
                ]
            );

            if ($user->email && $course) {
                try {
                    Mail::to($user->email)->send(new CourseConfirmationMail($course));
                    Log::info('Email sent to user:', ['email' => $user->email]);
                } catch (\Exception $e) {
                    Log::error('Failed to send email:', ['error' => $e->getMessage()]);
                }
            }

            return redirect()->route('payment.result', [
                'status' => '00',
                'course_id' => $course->id,
            ])->with('success', 'Đăng ký khóa học miễn phí thành công!');
        }

        $existingPayment = Payment::where('user_id', $user->id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($existingPayment) {
            if ($existingPayment->status === 'success') {
                return redirect()->route('payment.result', [
                    'status' => 'already_paid',
                    'course_id' => $request->course_id,
                ]);
            }
            if ($existingPayment->status === 'failed') {
                $existingPayment->delete();
            }
        }

        // Xử lý coupon
        $finalAmount = $originalPrice;
        $coupon = null;
        $discountAmount = 0;

        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->isValid()) {
                if ($finalAmount >= $coupon->min_order_value) {
                    if ($coupon->discount_type === 'percentage') {
                        $discountAmount = ($coupon->discount_value / 100) * $finalAmount;
                        if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
                            $discountAmount = $coupon->max_discount_amount;
                        }
                    } else {
                        $discountAmount = $coupon->discount_value;
                    }
                    $finalAmount = max(0, $finalAmount - $discountAmount);
                }
            }
        }

        if (abs($request->price - $finalAmount) > 0.01) {
            Log::warning('Price mismatch detected', [
                'request_price' => $request->price,
                'calculated_final_amount' => $finalAmount,
                'course_id' => $request->course_id,
            ]);
            return redirect()->back()->with('error', 'Giá thanh toán không hợp lệ.');
        }

        $payment = Payment::create([
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'payment_date' => now(),
            'amount' => $finalAmount,
            'payment_method' => 'VNPay',
            'status' => 'failed',
            'coupon_id' => $coupon?->id,
        ]);

        // Tạo bản ghi PaymentItem
        $payment->paymentItems()->create([
            'course_id' => $request->course_id,
            'amount' => $finalAmount,
            'description' => "Thanh toán cho khóa học {$course->title}",
        ]);

        // Sử dụng Gemini để tạo thông điệp thanh toán
        $prompt = "Tạo một thông điệp ngắn gọn và thân thiện để thông báo người dùng về thanh toán khóa học '{$course->title}' với số tiền " . number_format($finalAmount) . " VND.";
        $geminiMessage = $this->callGeminiApi($prompt);
        Log::info('Gemini generated message:', ['message' => $geminiMessage]);

        $randomString = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
        $vnp_TxnRef = $payment->id . '_' . $randomString;
        $vnp_OrderInfo = $geminiMessage;
        $vnp_OrderType = 'course_payment';
        $vnp_Amount = $finalAmount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();
        $vnp_CreateDate = date('YmdHis');

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);

        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . rtrim($query, '&');

        if ($vnp_HashSecret) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        }

        Log::info('Payment created:', $payment->toArray());
        return redirect()->to($vnp_Url);
    }

    public function callback(Request $request)
    {
        Log::info('VNPay Callback Received:', $request->all());

        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'] ?? '';

        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);

        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= ($hashData ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            $paymentIdParts = explode('_', $inputData['vnp_TxnRef']);
            $paymentId = $paymentIdParts[0];
            $payment = Payment::find($paymentId);

            if ($payment) {
                $responseCode = $inputData['vnp_ResponseCode'] ?? '99';

                if ($responseCode === "00") {
                    $payment->update([
                        'status' => 'success',
                        'payment_date' => now(),
                    ]);

                    if ($payment->coupon_id) {
                        $coupon = Coupon::find($payment->coupon_id);
                        if ($coupon) {
                            $coupon->increment('used_count');
                        }
                    }

                    $user = Auth::user();
                    if (!$user) {
                        Log::warning('No authenticated user for payment:', ['payment_id' => $paymentId]);
                        return redirect()->route('payment.result', ['status' => '97', 'course_id' => $payment->course_id]);
                    }

                    $enrollment = Enrollment::firstOrCreate(
                        [
                            'user_id' => $user->id,
                            'course_id' => $payment->course_id,
                        ],
                        [
                            'enrollment_at' => now(),
                        ]
                    );

                    $course = Course::find($payment->course_id);
                    if ($user->email && $course) {
                        try {
                            Mail::to($user->email)->send(new CourseConfirmationMail($course));
                            Log::info('Email sent to user:', ['email' => $user->email]);
                        } catch (\Exception $e) {
                            Log::error('Failed to send email:', ['error' => $e->getMessage()]);
                        }
                    }

                    Log::info('Payment updated:', $payment->toArray());
                    Log::info('Enrollment created/updated:', $enrollment->toArray());

                    return redirect()->route('payment.result', ['status' => '00', 'course_id' => $payment->course_id]);
                } else {
                    $status = ($responseCode === "24") ? 'canceled' : 'failed';
                    $payment->update(['status' => $status]);

                    // Sử dụng Gemini để tạo thông báo lỗi
                    $prompt = "Tạo một thông điệp ngắn gọn và thân thiện để thông báo người dùng rằng thanh toán cho khóa học ID {$payment->course_id} đã thất bại với mã lỗi {$responseCode}.";
                    $geminiMessage = $this->callGeminiApi($prompt);
                    Log::info('Gemini generated error message:', ['message' => $geminiMessage]);

                    Log::info('Payment updated:', $payment->toArray());

                    return redirect()->route('payment.result', ['status' => $responseCode, 'course_id' => $payment->course_id])
                        ->with('error', $geminiMessage);
                }
            } else {
                Log::error('Payment not found:', ['payment_id' => $paymentId]);
                return redirect()->route('payment.result', ['status' => '01', 'course_id' => $inputData['vnp_TxnRef']]);
            }
        } else {
            $paymentIdParts = explode('_', $inputData['vnp_TxnRef']);
            $paymentId = $paymentIdParts[0];
            $payment = Payment::find($paymentId);
            if ($payment) {
                $payment->update(['status' => 'failed']);
                Log::info('Payment updated (hash mismatch):', $payment->toArray());
            }
            Log::warning('Invalid VNPay hash:', ['received' => $vnp_SecureHash, 'calculated' => $secureHash]);
            return redirect()->route('payment.result', ['status' => '01', 'course_id' => $inputData['vnp_TxnRef']]);
        }
    }

    public function showResult(Request $request)
    {
        $status = $request->query('status');
        $courseId = $request->query('course_id');
        $course = Course::find($courseId);

        if ($status === '00') {
            return view('payment.success', [
                'course' => $course,
            ]);
        } else {
            $message = match ($status) {
                '24' => 'Thanh toán bị hủy.',
                '97' => 'Vui lòng đăng nhập để hoàn tất đăng ký.',
                '01' => 'Thanh toán thất bại. Vui lòng thử lại.',
                'already_enrolled' => 'Bạn đã đăng ký khóa học này rồi.',
                'already_paid' => 'Bạn đã thanh toán cho khóa học này.',
                default => 'Có lỗi xảy ra trong quá trình thanh toán.',
            };

            return view('payment.failure', [
                'message' => $message,
                'course_id' => $courseId,
            ]);
        }
    }

    public function createMomoPayment(Request $request)
    {
        $partnerCode = config('services.momo.partner_code');
        $accessKey = config('services.momo.access_key');
        $secretKey = config('services.momo.secret_key');
        $endpoint = config('services.momo.endpoint');
        $redirectUrl = config('services.momo.return_url');
        $ipnUrl = $redirectUrl;

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'price' => 'required|numeric|min:0',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán');
        }

        $course = Course::findOrFail($request->course_id);

        if ($course->sections()->count() === 0) {
            return redirect()->back()->with('error', 'Khóa học chưa được hoàn tất, bạn không thể đăng ký.');
        }

        $originalPrice = $course->price;

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $request->course_id)
            ->first();
        if ($enrollment) {
            return redirect()->route('payment.result', [
                'status' => 'already_enrolled',
                'course_id' => $request->course_id,
            ]);
        }

        $finalAmount = $originalPrice;
        $coupon = null;
        $discountAmount = 0;

        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            if ($coupon && $coupon->isValid()) {
                if ($finalAmount >= $coupon->min_order_value) {
                    if ($coupon->discount_type === 'percentage') {
                        $discountAmount = ($coupon->discount_value / 100) * $finalAmount;
                        if ($coupon->max_discount_amount && $discountAmount > $coupon->max_discount_amount) {
                            $discountAmount = $coupon->max_discount_amount;
                        }
                    } else {
                        $discountAmount = $coupon->discount_value;
                    }
                    $finalAmount = max(0, $finalAmount - $discountAmount);
                }
            }
        }

        if (abs($request->price - $finalAmount) > 0.01) {
            Log::warning('Price mismatch detected', [
                'request_price' => $request->price,
                'calculated_final_amount' => $finalAmount,
                'course_id' => $request->course_id,
            ]);
            return redirect()->back()->with('error', 'Giá thanh toán không hợp lệ.');
        }

        $payment = Payment::create([
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'payment_date' => now(),
            'amount' => $finalAmount,
            'payment_method' => 'Momo',
            'status' => 'failed',
            'coupon_id' => $coupon?->id,
        ]);

        $payment->paymentItems()->create([
            'course_id' => $request->course_id,
            'amount' => $finalAmount,
            'description' => "Thanh toán cho khóa học {$course->title}",
        ]);

        $orderId = time() . "_" . $payment->id;
        $orderInfo = "Thanh toán khóa học '{$course->title}'";
        $amount = (int)$finalAmount;
        $extraData = base64_encode(json_encode([
            'payment_id' => $payment->id,
            'course_id' => $request->course_id
        ]));
        $requestId = time() . "";

        $requestData = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => 'captureWallet',
            'lang' => 'vi'
        ];

        $rawHash = "accessKey=" . $accessKey .
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl .
            "&requestId=" . $requestId .
            "&requestType=captureWallet";

        $signature = hash_hmac('sha256', $rawHash, $secretKey);
        $requestData['signature'] = $signature;

        Log::info('MoMo Request Data', $requestData);

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->post($endpoint, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => $requestData
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);
            Log::info('MoMo Response', $responseBody);

            $payment->update([
                'transaction_info' => json_encode([
                    'request' => $requestData,
                    'response' => $responseBody
                ])
            ]);
            if (isset($responseBody['payUrl'])) {
                return redirect()->to($responseBody['payUrl']);
            } else {
                Log::error('MoMo payment error', $responseBody);
                return redirect()->back()->with('error', 'Không thể kết nối với cổng thanh toán MoMo. Chi tiết: ' . ($responseBody['message'] ?? 'Unknown error'));
            }
        } catch (\Exception $e) {
            Log::error('MoMo API Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi kết nối với MoMo: ' . $e->getMessage());
        }
    }

    public function momoCallback(Request $request)
    {
        Log::info('Momo Callback Received:', $request->all());
        $resultCode = $request->resultCode;

        if ($resultCode == 0) {
            $orderId = $request->orderId;
            $orderParts = explode('_', $orderId);
            $paymentId = $orderParts[1] ?? null;

            if ($paymentId) {
                $payment = Payment::find($paymentId);

                if ($payment) {
                    $payment->update([
                        'status' => 'success',
                        'payment_date' => now(),
                        'transaction_id' => $request->transId
                    ]);

                    $user = User::find($payment->user_id);
                    if ($user) {
                        Enrollment::firstOrCreate(
                            [
                                'user_id' => $user->id,
                                'course_id' => $payment->course_id,
                            ],
                            [
                                'enrollment_at' => now(),
                            ]
                        );
                    }

                    return redirect()->route('payment.success', [
                        'status' => 'success',
                        'course_id' => $payment->course_id
                    ]);
                }
            }
        }

        return redirect()->route('payment.failure', [
            'status' => 'failed',
            'message' => $request->message ?? 'Thanh toán thất bại',
            'code' => $resultCode
        ]);
    }
}
