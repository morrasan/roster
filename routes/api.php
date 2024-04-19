<?php

use App\Http\Controllers\Api\ActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::controller(ActivityController::class)->group(function () {
    Route::get('activities', 'index');
    Route::get('activities/next-week', 'nextWeekActivities');
    Route::get('activities/standby-next-week', 'standbyNextWeekActivities');
    Route::get('activities/from/{location}', 'activitiesFromLocation')->where('location', '[A-Z]{3}');
    Route::post('activities', 'store');
});
