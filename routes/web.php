<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', function () {
    $title = "Trang chủ";
    return view('index', compact('title'));
});
Route::get('/chi-tiet', function () {
    $title = "Chi tiết khoá học";
    return view('detail', compact('title'));
});
Route::get('/bai-hoc', function () {
    $title = "Bài học";
    return view('lesson', compact('title'));
});
// Admin
Route::get('/admin', function () {
    $title = "Admin";
    return view('admin.index', compact('title'));
});
Route::get('/dang-ky', [RegisterController::class, 'showRegistrationForm'])->name('dang-ky');
Route::post('/dang-ky', [RegisterController::class, 'register']);
Route::get('/admin/khoa-hoc', function () {
    $title = "Khoá học";
    return view('admin.khoa-hoc.index', compact('title'));
});

