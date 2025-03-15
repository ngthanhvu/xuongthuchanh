<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/register', function () {
    return view('auth.register');
});
