<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\LessonController;
use App\Models\Lesson;

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

    //danh mục
    Route::prefix('admin/category')->name('admin.category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/store', [CategoryController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CategoryController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [CategoryController::class, 'delete'])->name('delete');
    });

    //khóa học
    Route::prefix('admin/course')->name('admin.course.')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::get('/create', [CourseController::class, 'create'])->name('create');
        Route::post('/store', [CourseController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [CourseController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [CourseController::class, 'delete'])->name('delete');
    });

    //chương bài học
    Route::prefix('admin/sections')->name('admin.sections.')->group(function () {
        Route::get('/', [SectionController::class, 'index'])->name('index');
        Route::get('/create', [SectionController::class, 'create'])->name('create');
        Route::post('/store', [SectionController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SectionController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [SectionController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [SectionController::class, 'delete'])->name('delete');
    });

    //bài học
    Route::prefix('admin/lessons')->name('admin.lessons.')->group(function () {
        Route::get('/', [LessonController::class, 'index'])->name('index');
        Route::get('/create', [LessonController::class, 'create'])->name('create');
        Route::post('/store', [LessonController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LessonController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [LessonController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [LessonController::class, 'delete'])->name('delete');
    });
    Route::get('/admin/users',[UserController::class, 'index'])->name('admin.users.index');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/chi-tiet', function () {
    $title = "Chi tiết";
    return view('detail', compact('title'));
});

Route::get('/lession', function () {
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
Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/delete-avatar', [UserController::class, 'deleteAvatar'])->name('profile.delete.avatar');
Route::get('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.changePassword');
Route::put('/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.updatePassword');
