<?php

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

Route::middleware('api')->get('/tasks', 'TaskController@listTasks');
Route::middleware('api')->get('/tasks/{idOrUuid}', 'TaskController@task');
