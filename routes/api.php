<?php

use App\Http\Controllers\Api\Comment\CommentController;
use App\Http\Controllers\Api\Task\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


############################################ User and Admin #############################################
Route::middleware(['auth:api'])->group(function () {

    Route::get('get/all/tasks',[TaskController::class,'index'])->name('tasks.indx');
    Route::get('get/task/{task}',[TaskController::class,'show'])->name('tasks.show');
    Route::get('search/tasks/by/priority',[TaskController::class,'searchByPriority'])->name('task.search');
    ############################################ Comment################################################
    Route::post('add/comment',[CommentController::class,'store'])->name('comment.store');
    Route::post('make/replay',[CommentController::class,'makeReplay'])->name('comment.makeReplay');
    Route::post('update/comment/{id}',[CommentController::class,'uodateCommentt'])->name('comment.update');
    Route::delete('delete/comment/{id}',[CommentController::class,'destroy'])->name('comment.delete');
    Route::get('get/all/comments',[CommentController::class,'index'])->name('comment.index');
    Route::get('get/comment/{id}',[CommentController::class,'show'])->name('comment.show');


});




require_once __DIR__ .'\admin.php';
