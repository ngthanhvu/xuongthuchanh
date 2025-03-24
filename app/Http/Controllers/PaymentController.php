<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourseConfirmationMail;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $vnp_TmnCode = config('services.vnpay.tmn_code');
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $vnp_Url = config('services.vnpay.url');
        $vnp_ReturnUrl = config('services.vnpay.callback'); // Sử dụng từ config

        // Validate request
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'price' => 'required|numeric|min:0',
        ]);

        $vnp_TxnRef = $request->course_id; // Mã khóa học làm mã giao dịch
        $vnp_OrderInfo = 'Thanh toán khóa học ' . $vnp_TxnRef;
        $vnp_OrderType = 'course_payment';
        $vnp_Amount = $request->price * 100; // Giá tiền (VND) nhân 100
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();
        $vnp_CreateDate = now()->format('YmdHis');

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

        return response()->json(['url' => $vnp_Url]);
    }

    public function callback(Request $request)
    {
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        $inputData = $request->all();
        $vnp_SecureHash = $inputData['vnp_SecureHash'];

        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);

        ksort($inputData);

        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= ($hashData ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        if ($secureHash === $vnp_SecureHash) {
            $courseId = $inputData['vnp_TxnRef'];
            $course = Course::find($courseId);

            if ($course) {
                $responseCode = $inputData['vnp_ResponseCode'];

                if ($responseCode === "00") {
                    $user = Auth::user();
                    if (!$user) {
                        return redirect()->to(env('FRONTEND_URL') . "/thanh-cong?status=97&course_id={$courseId}");
                    }

                    // Tạo hoặc cập nhật enrollment
                    $enrollment = Enrollment::firstOrCreate(
                        ['user_id' => $user->id, 'course_id' => $course->id],
                        ['status' => 'paid']
                    );

                    // Gửi email xác nhận
                    if ($user->email) {
                        Mail::to($user->email)->send(new CourseConfirmationMail($course));
                    }

                    $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status=00&course_id={$courseId}";
                    return redirect()->to($frontendUrl);
                } else {
                    $status = ($responseCode === "24") ? 'canceled' : 'fail';
                    $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status={$responseCode}&course_id={$courseId}";
                    return redirect()->to($frontendUrl);
                }
            } else {
                $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status=01&course_id={$courseId}";
                return redirect()->to($frontendUrl);
            }
        } else {
            $frontendUrl = env('FRONTEND_URL') . "/thanh-cong?status=01&course_id={$inputData['vnp_TxnRef']}";
            return redirect()->to($frontendUrl);
        }
    }
}