<?php
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
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
});

// Admin route
Route::group(['middleware' => 'auth.admin'], function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');


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


Route::get('/courses/{id}/videos', [VideoDisplayController::class, 'show'])->name('videos.show');


