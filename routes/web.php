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
//dang nhap
Route::get('/dang-nhap', function () {
    $title = "Dang nhap";
    return view('auth.login', compact('title'));
});
