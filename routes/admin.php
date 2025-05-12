<?php

use App\Http\Controllers\Api\Status\StatusController;
use App\Http\Controllers\Api\Task\TaskController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;


############################### Admin Only Register########################################
Route::post('register',[AuthController::class,'register'])
->name('register')->middleware('register');

####################################### Admin and User #####################################


Route::post('login',[AuthController::class,'login'])
->name('login');

Route::middleware('auth:api')
->post('logout',[AuthController::class,'logout'])
->name('logout');

####################################### Only Admin#########################################################

Route::prefix('admin')->middleware(['managerTask'])->group(function(){
    Route::post('make/task',[TaskController::class,'store'])->name('task.store');
    Route::post('update/task/{task}',[TaskController::class,'update'])->name('task.update');
    Route::delete('delete/task/{task}',[TaskController::class,'destroy'])->name('task.destroy');
     Route::put('tasks/{task}/restore', [TaskController::class, 'restoreTask'])->name('tasks.restore');
     Route::delete('force/delete/task/{taskId}',[TaskController::class,'forceDeleteTask'])->name('task.forceDelete');
     ################################################################################# Statuses################################
     Route::get('get/all/statuses',[StatusController::class,'index'])->name('status.index');
     Route::get('get/statuses/to/task/{task}',[StatusController::class,'getTaskStatus'])->name('statuses.task');
     Route::get('get/status/{id}',[StatusController::class,'show'])->name('statuses.show');
     Route::delete('delete/status/{id}',[StatusController::class,'destroy'])->name('status.destroy');
     Route::put('restore/statuse/{id}',[StatusController::class,'restoreStatus'])->name('status.restore');
     Route::delete('force/delete/status/{id}',[StatusController::class,'forceDeleteStatus'])->name('status.forceDelete');
     ############################################################################################################################



});
