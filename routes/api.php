<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('employees', [EmployeeController::class, 'index']);
Route::post('employees', [EmployeeController::class, 'store']);
Route::delete('employees/{id}', [EmployeeController::class, 'destroy']);
Route::put('employees/{id}', [EmployeeController::class, 'update']);
