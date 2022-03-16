<?php

use Illuminate\Support\Facades\Route;
use  App\Events\OrderStatusUpdated;
use App\Events\TaskCreated;
use App\Models\Task;
use App\Http\Controllers\ProjectController;
use App\Models\Project;
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










Route::get('/projects/{id}', [ProjectController::class,'show']);


Route::post('/api/projects/{project}/tasks',function (Project  $project){

    $task=$project->tasks()->create([
        'body'=>request()['body']
    ]);

    event(
        new TaskCreated($task)
    );
    return $task;

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
