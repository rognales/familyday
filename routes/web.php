<?php

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

Route::get('/', 'ParticipantController@index')->name('index');
Route::get('/summary', 'AdminController@summary')->name('index');

Route::get('/theme', 'ParticipantController@index');

Auth::routes(['verify' => false]);

Route::get('/registration', 'ParticipantController@index')->name('registration_home');
Route::post('/registration', 'ParticipantController@store')->name('registration_create');

Route::get('/participant/{slug}', 'ParticipantController@show')->name('registration_show');

Route::get('/attend/{slug}', 'ParticipantController@attend')->name('attend');
Route::get('/attend', 'AttendanceController@index')->name('attendance_index');

Route::prefix('admin')->group(function () {
  Route::get('/', 'AdminController@index')->name('admin_index');

  Route::get('/user', 'AdminController@user')->name('admin_user');
  Route::get('/user/deleted', 'AdminController@user_deleted')->name('admin_user_deleted');
  Route::get('/user/ajax', 'AdminController@user_ajax')->name('admin_user_ajax');
  Route::get('/user/deleted/ajax', 'AdminController@user_deleted_ajax')->name('admin_user_deleted_ajax');
  Route::post('/user/email', 'ParticipantController@sendEmail')->name('admin_resend_email');
  Route::delete('/user/delete', 'ParticipantController@delete')->name('admin_user_delete');
  Route::get('/dependants/ajax/{pid}', 'AdminController@dependants_ajax')->name('admin_dependants_ajax');

  Route::get('/member', 'AdminController@member')->name('admin_member');
  Route::get('/member/ajax', 'AdminController@member_ajax')->name('admin_member_ajax');

  Route::get('/staff', 'AdminController@staff')->name('admin_staff');
  Route::get('/staff/ajax', 'AdminController@staff_ajax')->name('admin_staff_ajax');

  Route::prefix('payment')->group(function () {
    Route::get('/', 'AdminController@payment')->name('admin_payment');
    Route::post('/ajax/update', 'AdminController@paymentUpdate')->name('admin_payment_ajax_update');
    Route::get('/ajax', 'AdminController@payment_ajax')->name('admin_payment_ajax');
  });
  Route::get('/attend', 'AdminController@attend')->name('admin_attend');
  Route::get('/attend_full', 'AdminController@attend_full')->name('admin_attend_full');
  Route::get('/attend/ajax', 'AdminController@attend_ajax')->name('admin_attend_ajax');
  Route::get('/attend_full/ajax', 'AdminController@attend_full_ajax')->name('admin_attend_full_ajax');

});

Route::get('/zaiman','AdminController@zaiman');