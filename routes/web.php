<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


//Admin
Route::middleware('check.role.admin')->group(function () {
    Route::get('/admin', function () {
        $title = 'Trang quản trị';
        return view('admin.index', compact('title'));
    });

    Route::get('/admin/users', function () {
        $title = 'Khoá học';
        return view('admin.course.index', compact('title'));
    });
});


//User
Route::get('/', function () {
    $title = "Trang chủ";
    return view('index', compact('title'));
});
Route::get('/course', function () {
    $title = "Chi tiết khoá học";
    return view('detail', compact('title'));
});
Route::get('/lesson', function () {
    $title = "Bài học";
    return view('lesson', compact('title'));
});
// Admin
Route::get('/admin', function () {
    $title = "Admin";
    return view('admin.index', compact('title'));
});


Route::get('/dang-nhap', function () {
    $title = "Đăng nhập";
    return view('auth.login', compact('title'));
});
Route::post('/dang-nhap', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/register', [UserController::class, 'register']);
Route::get('/register', function () {
    $title = "Đăng ký";
    return view('auth.register', compact('title'));
});
