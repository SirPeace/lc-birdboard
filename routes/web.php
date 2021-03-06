<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectInvitationsController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::permanentRedirect('/', '/projects');

Route::middleware('auth')->group(function () {
    Route::resource('projects', ProjectController::class)->except(['create', 'edit']);

    Route::post('/projects/{project}/tasks', [TaskController::class, 'store']);
    Route::patch('/tasks/{task}', [TaskController::class, 'update']);

    Route::post('projects/{project}/invitations', [ProjectInvitationsController::class, 'store']);

    Route::patch('/user', [UserController::class, 'update']);
});

require __DIR__.'/auth.php';
