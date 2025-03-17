<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/admin/course', function () {
    $title = "Khoá học";
    return view('admin.course.index', compact('title'));
});

Route::get('/login', function () {
    $title = "Đăng nhập";
    return view('auth.login', compact('title'));
});
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
Route::post('/register', [UserController::class, 'register']);
Route::get('/register', function () {
    $title = "Đăng ký";
    return view('auth.register', compact('title'));
});
