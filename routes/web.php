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
use App\Http\Controllers\PostController;
use App\Http\Controllers\CouponController;
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
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/{id}/update-role', [UserController::class, 'updateRole'])->name('update-role');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

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
    //bai viêt
    Route::prefix('admin/posts')->name('admin.posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');
        Route::get('/create', [PostController::class, 'create'])->name('create');
        Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('destroy');
    });

    //thanh toan
    Route::prefix('admin/order')->name('admin.order.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::delete('/delete/{id}', [PaymentController::class, 'delete'])->name('delete');
    });
});
//quizz cho người dùng
Route::get('/quizzes/{lessonId}', [HomeController::class, 'showQuiz'])->name('quizzes');
Route::post('/quizzes/{quiz}/submit', [HomeController::class, 'submitQuiz'])->name('submit.quiz');


// Route::get('/{quiz}', [QuizController::class, 'show'])->name('show');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/chi-tiet/{id}', [HomeController::class, 'detail'])->name('detail');
Route::get('/lessons/{id}', [HomeController::class, 'lesson'])->name('lesson');
Route::get('/thanh-toan/{course_id}', [HomeController::class, 'loading'])->name('loading');


// Route::get('/lessons/{id}', function () {
//     $title = "Bài học";
//     return view('lesson', compact('title'));
// })->name('lessons');

Route::get('/dang-nhap', function () {
    $title = "Đăng nhập";
    return view('auth.login', compact('title'));
})->name('login');

Route::post('/dang-nhap', [UserController::class, 'login'])->name('login.submit');

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


//vnpay
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/result', [PaymentController::class, 'showResult'])->name('payment.result');

//quen mat khau
Route::get('/quen-mat-khau', [UserController::class, 'forgotPassword'])->name('password.forgot');
Route::post('/quen-mat-khau', [UserController::class, 'sendResetLink'])->name('password.send-link');
Route::get('/xac-nhan-otp', [UserController::class, 'verifyOtp'])->name('password.verify-otp');
Route::post('/xac-nhan-otp', [UserController::class, 'validateOtp'])->name('password.validate-otp');
Route::get('/dat-lai-mat-khau', [UserController::class, 'showResetForm'])->name('password.reset');
Route::post('/dat-lai-mat-khau', [UserController::class, 'resetPassword'])->name('password.update');
//post for user
Route::get('/post', [PostController::class, 'list'])->name('posts.list');
Route::get('/post/{id}', [PostController::class, 'showForUser'])->name('post.view');

//dang nhap voi google va facebook
Route::get('/auth/google', [UserController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [UserController::class, 'handleGoogleCallback']);

Route::get('/auth/facebook', [UserController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [UserController::class, 'handleFacebookCallback']);

//tien do hoc tap
Route::post('lesson/{lesson}/complete', [HomeController::class, 'completeLesson'])->name('completeLesson')->middleware('auth');
Route::post('/lesson/next/{next_lesson_id?}', [HomeController::class, 'nextLesson'])->name('nextLesson');

//teacher
Route::get('/teacher-request', [UserController::class, 'showTeacherRequestForm'])
    ->name('teacher.request.form');

Route::post('/request-teacher', [UserController::class, 'requestTeacher'])
    ->name('request.teacher');
Route::middleware(['auth'])->group(function () {});
Route::prefix('admin/users')->name('admin.users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/{id}/update-role', [UserController::class, 'updateRole'])->name('update-role');
    Route::post('/{id}/approve-teacher', [UserController::class, 'approveTeacherRequest'])->name('approve-teacher');
    Route::post('/{id}/reject-teacher', [UserController::class, 'rejectTeacherRequest'])->name('reject-teacher');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
});

// Coupon


Route::prefix('admin/coupons')->name('admin.coupon.')->group(function () {
    Route::get('/', [CouponController::class, 'index'])->name('index');
    Route::get('/create', [CouponController::class, 'create'])->name('create');
    Route::post('/store', [CouponController::class, 'store'])->name('store');
    Route::get('/{id}', [CouponController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [CouponController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [CouponController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [CouponController::class, 'delete'])->name('delete');
});
