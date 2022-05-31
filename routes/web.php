<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\QuestionsTagsController;
use App\Http\Controllers\MCQModelController;
use App\Http\Controllers\MCQModelDataController;
use App\Http\Controllers\MCQController;
use App\Http\Controllers\QATController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\CorrectionController;

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

//Questions
Route::controller(QuestionsController::class)->group(function () {
    Route::get('/questions/menu', 'readAllView')->name('qatmenu');
    Route::get('/questions', 'readAll')->name('qatall');
    Route::get('/questions', 'readOuterJoin')->name('qatouterjoin');
    Route::post('/post/question/create', 'create')->name("createquestion");
    Route::post('/post/question/update', 'update')->name("updatequestion");
    Route::get('/post/question/fuzzysearch', 'fuzzysearch')->name("fuzzysearchquestion");
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
    Route::get('/get/tag/questions/{id}', 'countTagQuestions')->name("counttagquestions"); 
});

//QAT
Route::controller(QATController::class)->group(function () {
    Route::get('/question/{id}', 'read')->name('editquestion');
    Route::post('/post/qat/delete', 'delete')->name("deleteqat");
});

//Groups
Route::controller(GroupsController::class)->group(function () {
    Route::get('/get/group/read', 'read')->name("readgroup");
    Route::get('/groups/menu', 'menuView')->name('groupsmenu');
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

//MCQModel
Route::controller(MCQModelController::class)->group(function () {
    Route::get('/models/menu', 'menuView')->name('modelmenu');
    Route::get('/model/{id}', 'readView')->name('editmodel');
    Route::post('/post/model/create', 'create')->name("createmcqmodel");
    Route::post('/post/model/delete', 'delete')->name("deletemcqmodel");
    Route::get('/get/model/specifics/{id}', 'countMCQQuestions')->name("countmcqquestions");
});

//MCQModelData
Route::controller(MCQModelDataController::class)->group(function () {
    Route::post('/post/modeldata/create', 'create')->name("createmcqmodeldata");
    Route::post('/post/modeldata/delete', 'delete')->name("deletemcqmodeldata");
});

//Exam
Route::controller(ExamController::class)->group(function () {
    Route::post('/post/exam/create', 'create')->name("createexam");
    Route::post('/post/exam/delete', 'delete')->name("deleteexam");
    Route::get('/exams', 'menuView')->name('exammenu');
    Route::get('/exam/{id}', 'examView')->name('examview');
});

//Correction
Route::controller(CorrectionController::class)->group(function () {
    Route::post('/post/correction/create', 'create')->name("createcorrection");
    Route::post('/post/correction/delete', 'delete')->name("deletecorrection");
    Route::get('/mcq/correction/{id}', 'watchView')->name('correctionwatch');
});

//MCQ
Route::controller(MCQController::class)->group(function () {
    Route::get('/mcqs/menu', 'menuView')->name('mcqmenu');
    Route::get('/mcq/create', 'createView')->name('mcqcreate');
    Route::get('/mcq/pdf/{id}', 'getPdf')->name('mcqpdf');
    Route::post('/post/mcq/create', 'create')->name('createmcq');
    Route::post('/post/mcq/update', 'update')->name('updatemcq');
    Route::post('/post/mcq/deleteAll', 'deleteAll')->name('deleteallmcq');
    Route::post('/post/mcq/delete', 'delete')->name('deletemcq');
});