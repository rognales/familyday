<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ParticipantEmailController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', [ParticipantController::class, 'index'])->name('index');

Auth::routes();

Route::get('/registration', [ParticipantController::class, 'index'])->name('registration_home');
Route::post('/registration', [ParticipantController::class, 'store'])->name('registration_create');

Route::post('/participant/{slug}/upload', [UploadController::class, 'store'])->name('registration_upload_store');
Route::get('/uploads/{upload}', [UploadController::class, 'show'])->name('upload_show');
Route::get('/participant/{slug}', [ParticipantController::class, 'show'])->name('registration_show');

Route::get('/attend/{slug}', [ParticipantController::class, 'attend'])->name('attend');
Route::get('/attend', [AttendanceController::class, 'index'])->name('attendance_index');

Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin_index');

    Route::get('/user', [AdminController::class, 'user'])->name('admin_user');
    Route::get('/user/deleted', [AdminController::class, 'user_deleted'])->name('admin_user_deleted');
    Route::get('/user/ajax', [AdminController::class, 'user_ajax'])->name('admin_user_ajax');
    Route::get('/user/deleted/ajax', [AdminController::class, 'user_deleted_ajax'])->name('admin_user_deleted_ajax');
    Route::post('/user/email', ParticipantEmailController::class)->name('admin_resend_email');
    // Changed from DELETE to POST due to TM nub
    // Route::delete('/user/delete', [ParticipantController::class, 'delete'])->name('admin_user_delete');
    Route::post('/user/delete', [ParticipantController::class, 'delete'])->name('admin_user_delete');

    Route::get('/dependants/ajax/{pid}', [AdminController::class, 'dependants_ajax'])->name('admin_dependants_ajax');

    Route::get('/member', [AdminController::class, 'member'])->name('admin_member');
    Route::get('/staff', [AdminController::class, 'staff'])->name('admin_staff');

    Route::prefix('payment')->group(function () {
        Route::get('/', [AdminController::class, 'payment'])->name('admin_payment');
        Route::post('/ajax/update', [AdminController::class, 'paymentUpdate'])->name('admin_payment_ajax_update');
        Route::get('/ajax', [AdminController::class, 'payment_ajax'])->name('admin_payment_ajax');
    });

    Route::get('/attend', [AdminController::class, 'attend'])->name('admin_attend');
    Route::get('/attend_full', [AdminController::class, 'attend_full'])->name('admin_attend_full');
    Route::get('/attend/ajax', [AdminController::class, 'attend_ajax'])->name('admin_attend_ajax');
    Route::get('/attend_full/ajax', [AdminController::class, 'attend_full_ajax'])->name('admin_attend_full_ajax');
});
