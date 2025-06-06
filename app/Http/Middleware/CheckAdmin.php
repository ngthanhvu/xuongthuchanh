<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap')->with('error', 'Vui lòng đăng nhập để tiếp tục');
        }

        $user = Auth::user();
        $allowedRoles = ['admin', 'owner']; // Danh sách vai trò được phép

        if (!in_array($user->role, $allowedRoles)) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này');
        }

        return $next($request);
    }
}