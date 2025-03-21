<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.resetpassword');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Gửi liên kết đặt lại mật khẩu
        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'Chúng tôi đã gửi một liên kết đặt lại mật khẩu vào email của bạn!');
        }

        return back()->withErrors(['email' => 'Không thể tìm thấy người dùng với email này.']);
    }
}
