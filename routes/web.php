<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;


//Admin
Route::middleware('check.role:admin')->group(function () {
    Route::get('/admin', function () {
        $title = 'Trang quản trị';
        return view('admin.index', compact('title'));
    });

    Route::get('/admin/users', function () {
        $title = 'Khoá học';
        return view('admin.course.index', compact('title'));
    });

    Route::prefix('admin/category')->name('admin.category.')->group(function () {
        Route::get('/', [CategoriesController::class, 'index'])->name('index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('create');
        Route::post('/store', [CategoriesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CategoriesController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CategoriesController::class, 'delete'])->name('delete');
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

//profile
Route::get('/profile', function () {
    $title = "Trang ca nhan";
    return view('profile', compact('title'));
});
