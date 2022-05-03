<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\QuestionsTagsController;
use App\Http\Controllers\QATController;

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
})->name('/');

Route::get('/menu', function () {
    return view('qat.menu');
})->name('qatmenu');

Route::get('/edit/{id}', [QATController::class, 'read']);

//Questions
Route::post('/post/question/create', [QuestionsController::class, 'create'])->name("createquestion");
Route::post('/post/question/update', [QuestionsController::class, 'update'])->name("updatequestion");
Route::post('/post/question/fuzzysearch', [QuestionsController::class, 'fuzzysearch'])->name("fuzzysearchquestion");

//Answers
Route::post('/post/answer/create', [AnswersController::class, 'create'])->name("createanswer");
Route::post('/post/answer/update', [AnswersController::class, 'update'])->name("updateanswer");
Route::post('/post/answer/delete', [AnswersController::class, 'delete'])->name("deleteanswer");

//Tags
Route::post('/post/tag/create', [QuestionsTagsController::class, 'create'])->name("createtag");
Route::post('/post/tag/delete', [QuestionsTagsController::class, 'delete'])->name("deletetag");

//QAT
Route::post('/post/qat/read', [QATController::class, 'read'])->name("readqat");
Route::post('/post/qat/delete', [QATController::class, 'delete'])->name("deleteqat");