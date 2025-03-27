<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
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
    //user
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

    //quizz
    Route::prefix('admin/quizzes')->name('admin.quizzes.')->group(function () {
        Route::get('/', [QuizController::class, 'index'])->name('index');
        Route::get('/create', [QuizController::class, 'create'])->name('create');
        Route::post('/', [QuizController::class, 'store'])->name('store');
        Route::get('/{quiz}', [QuizController::class, 'show'])->name('show');
        Route::get('/{quiz}/edit', [QuizController::class, 'edit'])->name('edit');
        Route::put('/{quiz}', [QuizController::class, 'update'])->name('update');
        Route::delete('/{quiz}', [QuizController::class, 'destroy'])->name('destroy');
    });
    //questions
    Route::prefix('admin/questions')->name('admin.questions.')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('index');
        Route::get('/create', [QuestionController::class, 'create'])->name('create');
        Route::post('/', [QuestionController::class, 'store'])->name('store');
        Route::get('/{question}', [QuestionController::class, 'show'])->name('show');
        Route::get('/{question}/edit', [QuestionController::class, 'edit'])->name('edit');
        Route::put('/{question}', [QuestionController::class, 'update'])->name('update');
        Route::delete('/{question}', [QuestionController::class, 'destroy'])->name('destroy');
    });
    //answers
    Route::prefix('admin/answers')->name('admin.answers.')->group(function () {
        Route::get('/', [AnswerController::class, 'index'])->name('index');
        Route::get('/create', [AnswerController::class, 'create'])->name('create');
        Route::post('/', [AnswerController::class, 'store'])->name('store');
        Route::get('/{answer}', [AnswerController::class, 'show'])->name('show');
        Route::get('/{answer}/edit', [AnswerController::class, 'edit'])->name('edit');
        Route::put('/{answer}', [AnswerController::class, 'update'])->name('update');
        Route::delete('/{answer}', [AnswerController::class, 'destroy'])->name('destroy');
    });

});
//quizz cho người dùng
// Route hiển thị quiz cho user
Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('showquizz');
// Route nộp bài
Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submitQuiz'])->name('submit.quiz');
// Route::get('/{quiz}', [QuizController::class, 'show'])->name('show');



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/chi-tiet/{id}', [HomeController::class, 'detail'])->name('detail');

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

//enrollment
Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');

Route::get('/lessons/{id}', function () {
    $title = "Bài học";
    return view('lesson', compact('title'));
})->name('lessons');

//vnpay
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/result', [PaymentController::class, 'showResult'])->name('payment.result');
