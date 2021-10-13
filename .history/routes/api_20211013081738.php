<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::get('allTasks',[TaskController::class, 'ShowAll']);
Route::middleware(['auth:api' , 'isAdmin'])->group(function () {
    Route::resource('user', UserController::class);

  //
   // Route::put('EditLogin/{id?}',[UserTasks::class, 'updateLogin']);
  // Route::put('EditLogout/{id?}',[UserTasks::class, 'updateLogout']);

});


Route::middleware(['auth:api' , 'isEmployee'])->group(function () {


   /* Route::post('AddLOgoutTime' ,[AuthController::class, 'AddlogoutTime']);
    Route::post('logoutInAbsence' ,[AuthController::class, 'logoutInAbsence']);
    Route::post('AddAbsenceLogout' ,[AuthController::class, 'AddAbsenceDate']);*/


});
