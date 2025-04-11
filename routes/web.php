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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SavedCourseController;


use App\Models\Lesson;

//Admin
Route::middleware(['check.admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

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
        Route::get('/free', [CourseController::class, 'freeCourses'])->name('free');
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
Route::get('/khoa-hoc', [HomeController::class, 'course'])->name('course');


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

//profile
Route::get('/profile', [UserController::class, 'profile'])->name('profile');

Route::put('/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');
Route::post('/profile/delete-avatar', [UserController::class, 'deleteAvatar'])->name('profile.delete.avatar');
Route::get('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.changePassword');
Route::put('/profile/update-password', [UserController::class, 'updatePassword'])->name('profile.updatePassword');
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/you-course', [UserController::class, 'youcourse'])->name('profile.youcourse');
});

//userPayment
Route::get('/userPayment', [UserController::class, 'userPayment'])->name('userPayment');

//enrollment
Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');


//vnpay
Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/payment/result', [PaymentController::class, 'showResult'])->name('payment.result');

// Route cho Momo
Route::post('/momo/payment', [PaymentController::class, 'createMomoPayment'])->name('payment.createMomoPayment');
Route::post('/momo/callback', [PaymentController::class, 'momoCallback'])->name('payment.momoCallback');
Route::get('/orders/{id}', [PaymentController::class, 'show'])->name('admin.order.show');

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
Route::middleware('auth')->group(function () {
    Route::middleware('auth')->get('/lo-trinh', [HomeController::class, 'reveal'])->name('reveal');
    Route::post('/lo-trinh-lesson/{id}', [LessonController::class, 'completeLesson'])->name('completeLesson');
});
//teacher
Route::get('/teacher-request', [UserController::class, 'showTeacherRequestForm'])
    ->name('teacher.request.form');

Route::post('/request-teacher', [UserController::class, 'requestTeacher'])
    ->name('request.teacher');
Route::middleware(['auth'])->group(function () {});
Route::prefix('admin/users')->name('admin.users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::post('/{id}/update-role', [UserController::class, 'updateRole'])->name('update-role');
    Route::put('/{id}/approve-teacher', [UserController::class, 'approveTeacherRequest'])->name('approve-teacher');
    Route::put('/{id}/reject-teacher', [UserController::class, 'rejectTeacherRequest'])->name('reject-teacher');
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
Route::post('/coupon/apply', [CouponController::class, 'applyCoupon'])->name('coupon.apply');

//search
Route::get('/search', [HomeController::class, 'search'])->name('search');

//chua them ok
Route::get('/frontend-path', [HomeController::class, 'frontendPath'])->name('frontend-path');
Route::get('/backend-path', [HomeController::class, 'backendPath'])->name('backend-path');
Route::get('/learning-paths', [HomeController::class, 'lotrinh'])->name('learning-paths.index');

// Review
Route::resource('reviews', ReviewController::class)->middleware('auth');
Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])
    ->name('reviews.reply')
    ->middleware('check.admin');
Route::resource('reviews', ReviewController::class)->middleware('auth');


//teacher
Route::middleware(['check.teacher'])->group(function () {
    Route::get('/teacher', [AdminController::class, 'index'])->name('teacher.dashboard');

    Route::prefix('teacher/category')->name('teacher.category.')->group(function () {
        Route::get('/', [CategoryController::class, 'indexTeacher'])->name('index');
        Route::get('/create', [CategoryController::class, 'createTeacher'])->name('create');
        Route::post('/store', [CategoryController::class, 'storeTeacher'])->name('store');
        Route::get('/edit/{id}', [CategoryController::class, 'editTeacher'])->name('edit');
        Route::put('/update/{id}', [CategoryController::class, 'updateTeacher'])->name('update');
        Route::post('/delete/{id}', [CategoryController::class, 'destroyTeacher'])->name('delete');
    });

    //khoa hoc
    Route::prefix('teacher/course')->name('teacher.course.')->group(function () {
        Route::get('/', [CourseController::class, 'indexTeacher'])->name('index');
        Route::get('/free', [CourseController::class, 'freeCoursesTeacher'])->name('free');
        Route::get('/create', [CourseController::class, 'createTeacher'])->name('create');
        Route::post('/store', [CourseController::class, 'storeTeacher'])->name('store');

        Route::get('/edit/{id}', [CourseController::class, 'editTeacher'])->name('edit');
        Route::put('/update/{id}', [CourseController::class, 'updateTeacher'])->name('update');
        Route::delete('/delete/{id}', [CourseController::class, 'deleteTeacher'])->name('delete');
    });

    //section
    Route::prefix('teacher/sections')->name('teacher.sections.')->group(function () {
        Route::get('/', [SectionController::class, 'indexTeacher'])->name('index');
        Route::get('/create', [SectionController::class, 'createTeacher'])->name('create');
        Route::post('/store', [SectionController::class, 'storeTeacher'])->name('store');
        Route::get('/edit/{id}', [SectionController::class, 'editTeacher'])->name('edit');
        Route::put('/update/{id}', [SectionController::class, 'updateTeacher'])->name('update');
        Route::delete('/delete/{id}', [SectionController::class, 'deleteTeacher'])->name('delete');
    });

    //lesson
    Route::prefix('teacher/lessons')->name('teacher.lessons.')->group(function () {
        Route::get('/', [LessonController::class, 'indexTeacher'])->name('index');
        Route::get('/create', [LessonController::class, 'createTeacher'])->name('create');
        Route::post('/store', [LessonController::class, 'storeTeacher'])->name('store');
        Route::get('/edit/{id}', [LessonController::class, 'editTeacher'])->name('edit');
        Route::put('/update/{id}', [LessonController::class, 'updateTeacher'])->name('update');
        Route::delete('/delete/{id}', [LessonController::class, 'deleteTeacher'])->name('delete');
    });

    //quizz
    Route::prefix('teacher/quizzes')->name('teacher.quizzes.')->group(function () {
        Route::get('/', [QuizController::class, 'indexTeacher'])->name('index');
        Route::get('/create', [QuizController::class, 'createTeacher'])->name('create');
        Route::post('/', [QuizController::class, 'storeTeacher'])->name('store');
        Route::get('/{quiz}', [QuizController::class, 'showTeacher'])->name('show');
        Route::get('/{quiz}/edit', [QuizController::class, 'editTeacher'])->name('edit');
        Route::put('/{quiz}', [QuizController::class, 'updateTeacher'])->name('update');
        Route::delete('/{quiz}', [QuizController::class, 'destroyTeacher'])->name('destroy');
    });
    //questions
    Route::prefix('teacher/questions')->name('teacher.questions.')->group(function () {
        Route::get('/', [QuestionController::class, 'indexTeacher'])->name('index');
        Route::get('/create', [QuestionController::class, 'createTeacher'])->name('create');
        Route::post('/', [QuestionController::class, 'storeTeacher'])->name('store');
        Route::get('/{question}', [QuestionController::class, 'showTeacher'])->name('show');
        Route::get('/{question}/edit', [QuestionController::class, 'editTeacher'])->name('edit');
        Route::put('/{question}', [QuestionController::class, 'updateTeacher'])->name('update');
        Route::delete('/{question}', [QuestionController::class, 'destroyTeacher'])->name('destroy');
    });
    //answers
    Route::prefix('teacher/answers')->name('teacher.answers.')->group(function () {
        Route::get('/', [AnswerController::class, 'indexTeacher'])->name('index');
        Route::get('/create', [AnswerController::class, 'createTeacher'])->name('create');
        Route::post('/', [AnswerController::class, 'storeTeacher'])->name('store');
        Route::get('/{answer}', [AnswerController::class, 'showTeacher'])->name('show');
        Route::get('/{answer}/edit', [AnswerController::class, 'editTeacher'])->name('edit');
        Route::put('/{answer}', [AnswerController::class, 'updateTeacher'])->name('update');
        Route::delete('/{answer}', [AnswerController::class, 'destroyTeacher'])->name('destroy');
    });
});

//bình luận khóa học
Route::middleware('auth')->group(function () {
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/reply', [CommentController::class, 'update'])->name('comments.reply');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::post('/comments/{id}/like', [CommentController::class, 'like'])->name('comments.like');
    Route::post('/comments/reply', [CommentController::class, 'reply'])->name('comments.reply');
});

Route::prefix('admin')->group(function () {
    Route::get('/comments', [CommentController::class, 'adminComments'])->name('admin.comments');
    Route::delete('/admin/comments/{id}', [CommentController::class, 'adminDelete'])->name('admin.comment.delete');
    Route::delete('/comments/bulk-delete', [CommentController::class, 'adminBulkDelete'])->name('admin.comments.bulk-delete');
});



Route::get('/courses/{course}', [CourseController::class, 'detail'])->name('courses.detail');

Route::post('/chat-with-gemini', [ChatController::class, 'chat'])->name('chat.gemini');

//luu khoa học và yêu thích
Route::middleware(['auth'])->group(function () {
    Route::post('/save-course/{courseId}', [SavedCourseController::class, 'toggleSave'])->name('courses.toggleSave');
});
Route::get('/khoa-hoc/yeu-thich', [CourseController::class, 'favoriteCourses'])->name('courses.favorites');
