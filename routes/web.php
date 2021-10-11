<?php

use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\EditGradeController;
use App\Http\Controllers\Grade2Controller;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ViewGradeController;
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

    //Import , export cua excel
    //Student
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/insert-by-excel', [StudentController::class, 'insertByExcel'])->name('insert-by-excel');
    });
    Route::get('/student-sample', [StudentController::class, 'StudentSample']);

    Route::post('/student-preview', [StudentController::class, 'StudentPreview']);

    Route::post('/student-confirm', [StudentController::class, 'confirmSave']);

    Route::get('/export', [ClassroomController::class, 'export']);

    Route::get('/export-by-id-class/{id}', [ClassroomController::class, 'exportByIdClass'])->name('export-by-id-class');

    //Grade
    Route::prefix('grade')->name('grade.')->group(function () {
        Route::get('/insert-by-excel', [GradeController::class, 'insertByExcel'])->name('insert-by-excel');
    });
    Route::get('/grade-sample', [GradeController::class, 'GradeSample']);

    Route::post('/grade-preview', [GradeController::class, 'GradePreview']);

    Route::post('/grade-confirm', [GradeController::class, 'confirmSave']);

    Route::prefix('grade2')->name('grade2.')->group(function () {
        Route::get('/insert-by-excel', [Grade2Controller::class, 'insertByExcel'])->name('insert-by-excel');
    });
    Route::get('/grade2-sample', [Grade2Controller::class, 'GradeSample']);

    Route::post('/grade2-preview', [Grade2Controller::class, 'GradePreview']);

    Route::post('/grade2-confirm', [Grade2Controller::class, 'confirmSave']);

    Route::get('/export-by-id-student/{id}', [Grade2Controller::class, 'exportByIdStudent'])->name('export-by-id-student');

    Route::get('/subject-by-class/{id}', [Grade2Controller::class, 'getSubjectByClass'])->name('subject-by-class');

    Route::get('/export-by-class/{idClass}/{idSub}', [Grade2Controller::class, 'exportByClass'])->name('export-by-class');

    //CRUD Class
    Route::resource('class', ClassroomController::class);

    Route::resource('major', MajorController::class);

    Route::resource('subject', SubjectController::class);

    Route::resource('student', StudentController::class,);

    Route::resource('grade', GradeController::class);

    Route::resource('grade2', Grade2Controller::class);

    Route::resource('viewgrade', ViewGradeController::class);

    Route::resource('editgrade', EditGradeController::class);

    Route::prefix('grade')->name('grade.')->group(function () {
        Route::get('/', [GradeController::class, 'index'])->name('index');
        Route::get('/get-students/{id}', [GradeController::class, 'getStudentsByIDClass'])->name('get-students');
        Route::get('/get-subject/{id}', [GradeController::class, 'getSubjectByIdClass'])->name('get-subject');
    });

    Route::prefix('grade2')->name('grade2.')->group(function () {
        Route::get('/', [Grade2Controller::class, 'index'])->name('index');
        Route::get('/get-students/{id}', [Grade2Controller::class, 'getStudentsByIDClass'])->name('get-students');
        Route::get('/get-subject/{id}', [Grade2Controller::class, 'getSubjectByIdClass'])->name('get-subject');
    });

    Route::prefix('editgrade')->name('editgrade.')->group(function () {
        Route::get('/', [EditGradeController::class, 'index'])->name('index');
        Route::get('/get-students/{id}', [EditGradeController::class, 'getStudentsByIDClass'])->name('get-students');
        Route::get('/get-subject/{id}', [EditGradeController::class, 'getSubjectByIdClass'])->name('get-subject');
    });
});
