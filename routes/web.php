<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\FrontController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Front
Route::get('/', [FrontController::class,'home']);

Route::group(['prefix' => 'hotel'], function() {
    Route::get('/', [FrontController::class,'hotel']);
    Route::get('room/{id}', [FrontController::class,'roomDetail']);
    Route::post('room/{id}', [FrontController::class,'roomDetail_post']);
    Route::get('/room/{id}/book', [FrontController::class,'roomBook'])->middleware('checkstatus');
    Route::post('/room/{id}/book', [FrontController::class,'roomBook_post']);
});

Route::get('account', [FrontController::class,'account'])->middleware('checklogin');
Route::post('account', [FrontController::class,'account_post'])->middleware('checklogin');

Route::get('room', [FrontController::class,'roomUser'])->middleware('checkstatus')->name('roomUser');

Route::post('review/{id}', [FrontController::class,'review_post'])->middleware('checklogin');

Route::get('contact', [FrontController::class,'contact']);
Route::get('hinh-thuc-thanh-toan', [FrontController::class,'payment']);

//Auth
Route::group(['middleware' => 'notauth'], function() {
    Route::get('/login', [AuthController::class,'getLogin']);
    Route::post('/login', [AuthController::class,'postLogin']);
    Route::get('/register', [AuthController::class,'getRegister']);
    Route::post('/register', [AuthController::class,'postRegister']);
    Route::get('/forgot', [AuthController::class,'getForgot']);
});

// Admin
Route::group(['prefix' => 'admin', 'middleware' => 'staff'], function() {
    Route::get('/', [BackController::class,'home']);
    Route::get('/profile', [BackController::class,'profile']);
    Route::post('/profile', [BackController::class,'profile_post']);
    Route::group(['prefix' => 'room'], function () {
        Route::get('list', [BackController::class,'roomList']);
        Route::get('list/find', [BackController::class,'roomListFind']);
        Route::get('service/{id}', [BackController::class,'roomService']);
        Route::post('service/{id}', [BackController::class,'roomService_post']);
        Route::get('checkout/{id}', [BackController::class,'roomCheckOut']);
        Route::post('checkout/{id}', [BackController::class,'roomCheckOut_post']);
        Route::get('checkin/{id}', [BackController::class,'roomCheckIn']);
        Route::post('checkin/{id}', [BackController::class,'roomCheckIn_post']);
        Route::group(['middleware' => 'admin'], function() {
            Route::get('add', [BackController::class,'roomAdd']);
            Route::post('add', [BackController::class,'roomAdd_post']);
            Route::get('delete/{id}', [BackController::class,'roomDelete']);
            Route::get('edit/{id}', [BackController::class,'roomEdit']);
            Route::post('edit/{id}', [BackController::class,'roomEdit_post']);
        });
    });
    Route::group(['prefix' => 'service'], function() {
        Route::get('list', [BackController::class,'serviceList']);
        Route::get('edit/{id}', [BackController::class,'serviceEdit']);
        Route::post('edit/{id}', [BackController::class,'serviceEdit_post']);
        Route::get('delete/{id}', [BackController::class,'serviceDelete']);
        Route::get('add', [BackController::class,'serviceAdd']);
        Route::post('add', [BackController::class,'serviceAdd_post']);
    });
    Route::group(['prefix' => 'staff'], function() {
        Route::get('/list', [BackController::class,'userList']);
        Route::group(['middleware' => 'admin'], function() {
            Route::get('edit/{id}', [BackController::class,'userEdit']);
            Route::post('edit/{id}', [BackController::class,'userEdit_post']);
        });
    });
    Route::group(['prefix' => 'typeroom'], function() {
        Route::get('list', [BackController::class,'typeRoomList']);
        Route::group(['middleware' => 'admin'], function() {
            Route::get('delete/{id}', [BackController::class,'typeRoomDelete']);
            Route::get('add', [BackController::class,'typeRoomAdd']);
            Route::post('add', [BackController::class,'typeRoomAdd_post']);
        });
    });
    Route::group(['prefix' => 'settings'], function() {
        Route::get('/', [BackController::class,'settingEdit']);
        Route::post('/', [BackController::class,'settingEdit_post']);
        Route::group(['prefix' => 'student'], function() {
            Route::get('/', [BackController::class,'student']);
            Route::post('/', [BackController::class,'student_post']);
            Route::get('/add', [BackController::class,'studentAdd']);
            Route::post('/add', [BackController::class,'studentAdd_post']);
            Route::get('on/{id}', [BackController::class,'studentOn']);
            Route::get('off/{id}', [BackController::class,'studentOff']);
        });
        Route::group(['prefix' => 'pay'], function() {
            Route::get('/', [BackController::class,'pay']);
            Route::post('/', [BackController::class,'pay_post']);
        });
    });
});

Route::get('/logout', [AuthController::class,'getLogout']);
