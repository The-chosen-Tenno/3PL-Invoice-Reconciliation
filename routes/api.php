<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectImageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProjectTagController;
use App\Http\Controllers\ProjectSubAssigneeController;
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

//Project
Route::get('/projects', [ProjectController::class, 'AllProjects']); //tested
Route::get('project/{id}', [ProjectController::class, 'ProjectById']); //tested
Route::get('/projects/user/{id}', [ProjectController::class, 'ProjectByUserId']); //tested
Route::post('/project', [ProjectController::class, 'NewProject']); //tested
Route::patch('/project/{id}', [ProjectController::class, 'UpdateProject']); //tested
Route::patch('/project/status/{id}', [ProjectController::class, 'UpdateStatus']); //tested

//Project Images
Route::get('/images/project/{id}', [ProjectImageController::class, 'ImagesByProjectId']);
Route::post('/images/project/{id}', [ProjectImageController::class, 'NewImage']);
Route::patch('/images', [ProjectImageController::class, 'UpdateImage']);

//Project Tags
Route::get('/project-tags/{id}', [ProjectTagController::class, 'AllTagByProject']); //tested
Route::post('/project-tags', [ProjectTagController::class, 'NewProjectTags']);
Route::delete('/project-tags/remove', [ProjectTagController::class, 'RemoveTags']);

//Project Sub Assignee
Route::get('/sub-assignee/project/{id}', [ProjectSubAssigneeController::class, 'AllSubAssigneeByProject']);
Route::get('/sub-assignee/user/{id}', [ProjectSubAssigneeController::class, 'AllSubAssignedProjectByUser']);
Route::post('/sub-assignee/add', [ProjectSubAssigneeController::class, 'NewSubAssignee']);
Route::patch('/sub-assignee/remove', [ProjectSubAssigneeController::class, 'RemoveSubAssignee']);

// Users
Route::get('/users', [UserController::class, 'AllUsers']); //tested
Route::get('/user/{id}', [UserController::class, 'UserById']); //tested
Route::post('/user', [UserController::class, 'NewUser']); //tested
Route::patch('/user/{id}', [UserController::class, 'UpdateUser']); //tested
Route::patch('/user/accept/{id}', [UserController::class, 'AcceptUser']); //tested
Route::patch('/user/decline/{id}', [UserController::class, 'DeclineUser']); //tested

//Auth
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/logout', [AuthController::class, 'Logout']);

//Tag
Route::get('/tags', [TagController::class, 'AllTags']); //tested
Route::post('/tags', [TagController::class, 'NewTags']); //tested