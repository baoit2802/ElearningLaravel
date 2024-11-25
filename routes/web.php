<?php
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\VideoDisplayController;
use App\Models\Course;
use App\Http\Controllers\CourseRegistrationController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ExamController;


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [CourseController::class, 'index'])->name('home');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/courses/{id}/registration', [CourseRegistrationController::class, 'show'])->name('courses.show');

    Route::post('/courses/{id}/register', [CourseRegistrationController::class, 'register'])->name('courses.register');
    Route::get('/courses/payment/{id}', [CourseRegistrationController::class, 'payment'])->name('courses.payment');
    Route::post('/courses/payment/{id}', [CourseRegistrationController::class, 'processPayment'])->name('courses.processPayment');
    Route::get('/my-courses', [CourseRegistrationController::class, 'myCourses'])->name('courses.my_courses');
    //Giỏ hàng
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{courseId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::get('/cart/vnpay-return', [CartController::class, 'returnPayment'])->name('cart.returnPayment');

    Route::post('/payment/{courseId}', [PaymentController::class, 'createPayment'])->name('payment.create');
    Route::get('/vnpay-return', [PaymentController::class, 'returnPayment'])->name('payment.return');
    //Tim kiem
    Route::get('/search', [CourseController::class, 'search'])->name('courses.search');

    // Exam
    Route::get('/exams', [ExamController::class, 'listExams'])->name('exams.list');
    Route::get('/exams/{exam}/start', [ExamController::class, 'startExam'])->name('exams.start');
    Route::post('/exams/{exam}/submit', [ExamController::class, 'submitExam'])->name('exams.submit');
    Route::post('/exams/{exam}/save-progress', [ExamController::class, 'saveProgress'])->name('exams.saveProgress');



});

// Admin route
Route::group(['middleware' => 'auth.admin'], function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/home', [CourseController::class, 'adminHome'])->name('home');
        Route::resource('courses', CourseController::class)->except('index');

        //Exam
        Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
        Route::get('/exams/create', [ExamController::class, 'create'])->name('exams.create');
        Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');
        Route::get('/exams/{id}/edit', [ExamController::class, 'edit'])->name('exams.edit');
        Route::put('/exams/{id}', [ExamController::class, 'update'])->name('exams.update');
        Route::delete('/exams/{id}', [ExamController::class, 'destroy'])->name('exams.destroy');
        Route::get('/exams/{id}/questions', [ExamController::class, 'manageQuestions'])->name('exams.questions.index');
        Route::post('/exams/{id}/questions', [ExamController::class, 'addQuestion'])->name('exams.questions.store');
        Route::put('/exams/{exam}/questions', [ExamController::class, 'updateQuestion'])->name('exams.questions.update');
        Route::delete('/exams/questions/{question}', [ExamController::class, 'deleteQuestion'])->name('exams.questions.destroy');



        Route::resource('users', UserController::class); // CRUD user
        Route::resource('courses', CourseController::class); // CRUD course
    });
    Route::resource('videos', VideoController::class)->names([
        'index' => 'admin.videos.index',
        'create' => 'admin.videos.create',
        'store' => 'admin.videos.store',
        'edit' => 'admin.videos.edit',
        'update' => 'admin.videos.update',
        'destroy' => 'admin.videos.destroy',
    ]);
    Route::get('/registrations', [CourseRegistrationController::class, 'adminIndex'])->name('admin.registrations.index');
    Route::delete('/admin/registrations/{id}', [CourseRegistrationController::class, 'destroy'])->name('admin.registrations.destroy');

});

// Authentication routes
Route::group([], function () {
    Route::get('/login', [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::get('/courses/{id}/videos', [VideoDisplayController::class, 'show'])->name('videos.show');


