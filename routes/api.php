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
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (){
return view('welcome');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('user/create', [ApiController::class, 'Register']);
Route::post('user/login', [ApiController::class, 'Login']);

 Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('user/update/{id}', [ApiController::class, 'Update']);
    Route::post('user/delete/{id}', [ApiController::class, 'Delete']);
    Route::post('user/{id}', [ApiController::class, 'Getuser']);
    Route::post('users', [ApiController::class, 'GetUsers']);

 });