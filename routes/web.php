<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\Grade2Controller;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Middleware\CheckLogin;
use Illuminate\Support\Facades\Route;

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

//Authenticate
Route::get('/', [LoginController::class, 'login'])->name('login');
Route::post('/login-process', [LoginController::class, 'process'])->name('login-process');


//Dashboard
Route::middleware([CheckLogin::class])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    //CRUD Class
    Route::resource('class', ClassroomController::class);

    Route::resource('major', MajorController::class);

    Route::resource('subject', SubjectController::class);

    Route::resource('student', StudentController::class);

    Route::resource('grade', GradeController::class);

    Route::prefix('grade')->name('grade.')->group(function () {
        Route::get('/', [GradeController::class, 'index'])->name('index');
        Route::get('/get-students/{id}', [GradeController::class, 'getStudentsByIDClass'])->name('get-students');
        Route::get('/get-subject/{id}', [GradeController::class, 'getSubjectByIdClass'])->name('get-subject');
    });
});
