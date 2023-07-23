<?php

use App\Http\Controllers\Api\AuthC;
use App\Http\Controllers\crudc;
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

Route::any('/', function () {
    return response()->json([
        'message' => 'akses dilarang'
    ], 403);
})->name('login');
Route::post('/register', [AuthC::class, 'register']);
Route::post('/login', [AuthC::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [AuthC::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('/crud', crudc::class);
});
