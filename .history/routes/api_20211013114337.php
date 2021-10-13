<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::resource('user', UserController::class);

Route::middleware(['auth:api' , 'isAdmin'])->group(function () {
    Route::get('allTasks',[TaskController::class, 'ShowAll']);
   // Route::put('EditLogin/{id?}',[UserTasks::class, 'updateLogin']);
  // Route::put('EditLogout/{id?}',[UserTasks::class, 'updateLogout']);

});


Route::middleware(['auth:api' , 'isEmployee'])->group(function () {
    Route::post('AaddTask',[TaskController::class, 'create']);
    Route::put('EditTask/{id?}',[TaskController::class, 'update']);
    Route::delete('deleteTask/{id?}',[TaskController::class, 'delete']);

    Route::post('AddlOgoutTimeYesterday' ,[AuthController::class, 'AddlogoutTimeYesterday']);
    Route::post('logoutInAbsence' ,[AuthController::class, 'logoutInAbsence']);
   // Route::post('AddAbsenceLogout' ,[AuthController::class, 'AddAbsenceDate']);


});
