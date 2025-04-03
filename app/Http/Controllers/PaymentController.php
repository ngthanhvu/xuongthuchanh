<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\CourseConfirmationMail;

class PaymentController extends Controller
{
    public function index()
    {
        $title = 'Quản Lí Hóa Đơn';
        $payments = Payment::with(['user', 'course'])->paginate(12);
        return view('admin.order.index', compact('title', 'payments'));
    }

    public function delete($id)
    {
        $payment = Payment::find($id);
        $payment->delete();
        return redirect()->route('admin.order.index')->with('success', 'Xóa Hóa Đơn Thành Công');
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
            return redirect()->route('login');
        }

        $course = Course::findOrFail($request->course_id);
        $originalPrice = $course->price; // Lấy giá gốc từ database

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($enrollment) {
            return redirect()->route('payment.result', [
                'status' => 'already_enrolled',
                'course_id' => $request->course_id,
            ]);
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
            if ($existingPayment->status === 'pending' || $existingPayment->status === 'failed') {
                $existingPayment->delete();
            }
        }

        // Xử lý coupon
        $finalAmount = $originalPrice; // Bắt đầu với giá gốc từ database
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
                    } else { // fixed
                        $discountAmount = $coupon->discount_value;
                    }
                    $finalAmount = max(0, $finalAmount - $discountAmount);
                }
            }
        }

        // Kiểm tra xem $request->price có khớp với $finalAmount không
        if (abs($request->price - $finalAmount) > 0.01) {
            Log::warning('Price mismatch detected', [
                'request_price' => $request->price,
                'calculated_final_amount' => $finalAmount,
                'course_id' => $request->course_id,
            ]);
            // Có thể trả về lỗi nếu cần
            // return redirect()->back()->with('error', 'Giá thanh toán không hợp lệ.');
        }

        $payment = Payment::create([
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'payment_date' => now(),
            'amount' => $finalAmount,
            'payment_method' => 'VNPay',
            'status' => 'pending',
            'coupon_id' => $coupon?->id,
        ]);

        $randomString = strtoupper(substr(md5(uniqid(rand(), true)), 0, 6));
        $vnp_TxnRef = $payment->id . '_' . $randomString;
        $vnp_OrderInfo = 'Thanh toán khóa học ' . $request->course_id;
        $vnp_OrderType = 'course_payment';
        $vnp_Amount = $finalAmount * 100; // Sử dụng số tiền đã giảm
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

                    // Tăng used_count của coupon nếu có
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
                        Mail::to($user->email)->send(new CourseConfirmationMail($course));
                    }

                    Log::info('Payment updated:', $payment->toArray());
                    Log::info('Enrollment created/updated:', $enrollment->toArray());

                    return redirect()->route('payment.result', ['status' => '00', 'course_id' => $payment->course_id]);
                } else {
                    $status = ($responseCode === "24") ? 'canceled' : 'failed';
                    $payment->update(['status' => $status]);

                    Log::info('Payment updated:', $payment->toArray());

                    return redirect()->route('payment.result', ['status' => $responseCode, 'course_id' => $payment->course_id]);
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
                default => 'Có lỗi xảy ra trong quá trình thanh toán.',
            };

            return view('payment.failure', [
                'message' => $message,
                'course_id' => $courseId,
            ]);
        }
    }
}