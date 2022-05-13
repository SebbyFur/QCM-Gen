<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\QuestionsTagsController;
use App\Http\Controllers\MCQGeneratorController;
use App\Http\Controllers\QATController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\StudentsController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/questions/menu', [QATController::class, 'readAll'])->name('qatmenu');
Route::get('/question/{id}', [QATController::class, 'read'])->name('editquestion');

Route::get('/mcqs/menu', [MCQGeneratorController::class, 'menuView'])->name('mcqmenu');
Route::get('/mcq/{id}', [MCQGeneratorController::class, 'read'])->name('editmcq');

Route::get('/groups/menu', [GroupsController::class, 'menuView'])->name('groupsmenu');

//Questions
Route::controller(QuestionsController::class)->group(function () {
    Route::post('/post/question/create', 'create')->name("createquestion");
    Route::post('/post/question/update', 'update')->name("updatequestion");
    Route::post('/post/question/fuzzysearch', 'fuzzysearch')->name("fuzzysearchquestion");
});

//Answers
Route::controller(AnswersController::class)->group(function () {
    Route::post('/post/answer/create', 'create')->name("createanswer");
    Route::post('/post/answer/update', 'update')->name("updateanswer");
    Route::post('/post/answer/delete', 'delete')->name("deleteanswer");
});

//Tags
Route::controller(QuestionsTagsController::class)->group(function () {
    Route::post('/post/tag/create', 'create')->name("createtag");
    Route::post('/post/tag/delete', 'delete')->name("deletetag");
});

//QAT
Route::controller(QATController::class)->group(function () {
    Route::post('/post/qat/read', 'read')->name("readqat");
    Route::post('/post/qat/delete', 'delete')->name("deleteqat");
});

//Groups
Route::controller(GroupsController::class)->group(function () {
    Route::get('/get/group/read', 'read')->name("readgroup");
    Route::post('/post/group/create', 'create')->name("creategroup");
    Route::post('/post/group/update', 'update')->name("updategroup");
    Route::post('/post/group/delete', 'delete')->name("deletegroup");
});

//Students
Route::controller(StudentsController::class)->group(function () {
    Route::get('/get/students/read/{group_id}', 'readFromGroup')->name("readstudents");
    Route::post('/post/student/create', 'create')->name("createstudent");
    Route::post('/post/student/update', 'update')->name("updatestudent");
    Route::post('/post/student/delete', 'delete')->name("deletestudent");
});

//MCQGenerator
Route::controller(MCQGeneratorController::class)->group(function () {
    Route::post('/post/mcqgenerator/create', 'create')->name("createmcqgenerator");
    Route::post('/post/mcqgenerator/delete', 'delete')->name("deletemcqgenerator");
});