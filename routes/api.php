<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\CourseController;



Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function() {
    Route::get('profile', [UserController::class, 'profile']);
    Route::get('logout', [UserController::class, 'logout']);

    Route::post('course-enrollment', [CourseController::class, 'courseEnrollment']);
    Route::get('total-courses', [CourseController::class, 'totalCourses']);
    Route::delete('delete-course/{id}', [CourseController::class, 'deleteCourse']);
});