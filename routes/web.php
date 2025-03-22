<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Home;

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
        Route::post('/delete/{id}', [CategoriesController::class, 'delete'])->name('delete');
    });

    Route::prefix('admin/course')->name('admin.course.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/store', [CourseController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CourseController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CourseController::class, 'delete'])->name('delete');
    });

});


// // User
// Route::get('/', function () {
//     $title = "Trang chủ";
//     return view('index', compact('title', 'course'));
// });

Route::get('/', [Home::class, 'index'])->name('home');


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

Route::get('/profile', [UserController::class, 'profile'])->name('profile');
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/delete-avatar', [UserController::class, 'deleteAvatar'])->name('profile.deleteAvatar');

