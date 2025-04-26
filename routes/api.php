<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'vn'], function() {
    Route::get('/', [ApiController::class,'api_vn']);
    Route::get('/provinces', [ApiController::class, 'getAllProvinces']);
    Route::get('/districts/{provinceCode}', [ApiController::class, 'getDistrictsByProvinceCode']);
    Route::get('/wards/{provinceCode}/{districtCode}', [ApiController::class, 'getWardsByDistrictCode']);
    Route::get('banks', [ApiController::class, 'getBank']);
});
