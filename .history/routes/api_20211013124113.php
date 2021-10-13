<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\EditLogController;
use App\Http\Controllers\AdminController;


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');


Route::middleware(['auth:api' , 'isAdmin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::get('allTasks',[TaskController::class, 'ShowAll']);
    Route::put('EditLogin/{id?}',[EditLogController::class, 'updateLogin']);
    Route::put('EditLogout/{id?}',[EditLogController::class, 'updateLogout']);

    Route::get('allTasks',[TaskController::class, 'UserDetailsInCurrentMonth']);


});


Route::middleware(['auth:api' , 'isEmployee'])->group(function () {
    Route::post('AaddTask',[TaskController::class, 'create']);
    Route::put('EditTask/{id?}',[TaskController::class, 'update']);
    Route::delete('deleteTask/{id?}',[TaskController::class, 'delete']);

    Route::post('AddlOgoutTimeYesterday' ,[AuthController::class, 'AddlogoutTimeYesterday']);
    Route::post('lOgoutInAbsence' ,[AuthController::class, 'logoutInAbsence']);
    Route::post('AddAbsence' ,[AuthController::class, 'AddAbsenceDate']);
});
