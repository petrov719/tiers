<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\TierlistController;
use App\Http\Controllers\TierlistItemController;
use App\Http\Controllers\TierlistingController;
use App\Http\Controllers\AuthController;

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
// Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['middleware' => 'auth:sanctum'], function() {
  Route::get('/user', function (Request $request) {return $request->user();});
  Route::post('/logout', [AuthController::class, 'logout']);
  Route::prefix('tierlist')->group(function()
  {
    Route::post('/index',[TierlistController::class, 'index']);
    Route::post('/index_with_items',[TierlistController::class, 'index_with_items']);
    Route::post('/create',[TierlistController::class, 'create']);
    Route::post('/get',[TierlistController::class, 'get']);
    Route::post('/edit',[TierlistController::class, 'edit']);
    Route::post('/xd',[TierlistController::class, 'xd']);
    });
  Route::prefix('tierlist_item')->group(function()
  {
    Route::post('/index',[TierlistItemController::class, 'index']);
    Route::post('/create',[TierlistItemController::class, 'create']);
    Route::post('/get',[TierlistItemController::class, 'get']);
    Route::post('/edit',[TierlistItemController::class, 'edit']);
    Route::post('/clone',[TierlistItemController::class, 'clone']);
  }); 
  Route::prefix('tierlisting')->group(function()
  {
    Route::post('/index',[TierlistingController::class, 'index']);
    Route::post('/create',[TierlistingController::class, 'create']);
    Route::post('/edit',[TierlistingController::class, 'edit']);
    Route::post('/get_by_user_id',[TierlistingController::class, 'get_by_user_id']);
  });
});