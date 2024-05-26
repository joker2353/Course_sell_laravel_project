<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\admin\CourseApplicationController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\CourseControllers;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\admin\UserController;
use App\Models\CourseApplication;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('front.home');
// });
Route::get('/',[HomeController::class,'homepage'])->name('Home');
Route::get('/courses',[CourseController::class,'index'])->name('courses');
Route::get('/courses/detail/{id}',[CourseController::class,'detail'])->name('jobDetail');
Route::post('/apply-course',[CourseController::class,'apply'])->name('apply');
Route::post('/save-course',[CourseController::class,'saveCourse'])->name('saveCourse');
Route::get('/forgot-password',[AccountController::class,'forgotPassword'])->name('account.forgotPassword');
Route::post('/process-forgot-password',[AccountController::class,'processForgotPassword'])->name('account.processforgotPassword');
Route::get('/reset-password/{token}',[AccountController::class,'resetPassword'])->name('account.resetPassword');
Route::post('/process-reset-password',[AccountController::class,'processResetPassword'])->name('account.processResetPassword');


Route::get('/account/register',[AccountController::class,'register'])->name('account.register')->middleware('redAuth');
Route::post('/account/register-process',[AccountController::class,'registerProcess'])->name('account.registerProcess')->middleware('redAuth');
Route::get('/account/login',[AccountController::class,'login'])->name('account.login');
Route::post('/account/auth',[AccountController::class,'auth'])->name('account.auth');


Route::get('/account/profile',[AccountController::class,'profile'])->name('account.profile');
Route::put('/account/update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile')->middleware('auth');
Route::post('/account/update-password',[AccountController::class,'updatePass'])->name('account.updatePass')->middleware('auth');
Route::post('/account/update-profile-pic',[AccountController::class,'updateProPic'])->name('account.updateProPic')->middleware('auth');
Route::get('/account/logout',[AccountController::class,'logout'])->name('account.logout')->middleware('auth');



Route::get('/account/create-course',[AccountController::class,'createCourse'])->name('account.createCourse')->middleware('auth');


Route::post('/account/save-Course',[AccountController::class,'saveCourse'])->name('account.saveCourse')->middleware('auth');



Route::get('/account/my-courses',[AccountController::class,'myCourses'])->name('account.myCourses')->middleware('auth');



Route::get('/account/my-courses/edit/{courseId}',[AccountController::class,'editCourse'])->name('account.editCourse')->middleware('auth');



Route::post('/account/update/{jobId}',[AccountController::class,'updateJob'])->name('account.updateJob')->middleware('auth');
Route::post('/account/update-course/{courseId}',[AccountController::class,'updateCourse'])->name('account.updateCourse')->middleware('auth');


Route::post('/account/delete',[AccountController::class,'deleteJob'])->name('account.deleteJob')->middleware('auth');
Route::post('/account/delete',[AccountController::class,'deleteCourse'])->name('account.deleteCourse')->middleware('auth');
Route::any('/account/media/{cId}',[CourseController::class,'media'])->name('account.media')->middleware('auth');
Route::any('/account/pub-req',[AccountController::class,'pubReq'])->name('account.pubreq')->middleware('auth');



Route::get('/account/enrollments',[AccountController::class,'enrollment'])->name('account.enrollment')->middleware('auth');


Route::post('/remove-applications',[AccountController::class,'removeApp'])->name('account.removeapp')->middleware('auth');
Route::post('/remove-enrollments',[AccountController::class,'removeEnroll'])->name('account.removeenroll')->middleware('auth');



Route::get('/saved-courses',[AccountController::class,'savedCourse'])->name('account.savedCourse')->middleware('auth');

Route::post('/remove-saved-applications',[AccountController::class,'removesavedApp'])->name('account.removesaveapp')->middleware('auth');


Route::get('/admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard')->middleware('checkRole');
Route::get('/admin/users',[UserController::class,'index'])->name('admin.users')->middleware('checkRole');
Route::get('/admin/pub-reqlist',[UserController::class,'pubReqlist'])->name('admin.pubReqlist')->middleware('checkRole');
Route::get('/admin/users/{id}',[UserController::class,'edit'])->name('admin.users.edit')->middleware('checkRole');
Route::get('/admin/pub-request-permit/{id}',[UserController::class,'pubRequest'])->name('admin.pubRequest')->middleware('checkRole');
Route::get('/admin/pub-request-remove/{id}',[UserController::class,'remRequest'])->name('admin.remRequest')->middleware('checkRole');


Route::put('/admin/users/{id}',[UserController::class,'update'])->name('admin.users.update')->middleware('checkRole');
Route::post('/admin/users/destroy',[UserController::class,'destroy'])->name('admin.users.destroy')->middleware('checkRole');
Route::get('/admin/courses',[CourseControllers::class,'index'])->name('admin.courses')->middleware('checkRole');
Route::get('/admin/courses/edit/{id}',[CourseControllers::class,'editCourse'])->name('admin.courses.edit')->middleware('checkRole');
Route::put('/admin/courses/update/{id}',[CourseControllers::class,'update'])->name('admin.courses.update')->middleware('checkRole');
Route::post('/admin/courses/destroy',[CourseControllers::class,'destroy'])->name('admin.courses.destroy')->middleware('checkRole');
Route::get('/admin/enrollments',[CourseApplicationController::class,'index'])->name('admin.enrollments')->middleware('checkRole');
Route::any('/admin/enrollments/delete',[CourseApplicationController::class,'destroy'])->name('admin.enrollments.destroy')->middleware('checkRole');



Route::any('/checkout/{price}/{title}', 'App\Http\Controllers\StripeController@checkout')->name('checkout');

Route::get('/success', 'App\Http\Controllers\StripeController@success')->name('success');