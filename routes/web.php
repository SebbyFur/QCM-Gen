<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\AnswersController;
use App\Http\Controllers\QuestionsTagsController;
use App\Http\Controllers\QATController;
use App\Http\Controllers\GroupsController;

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

Route::get('/question/{id}', [QATController::class, 'read'])->name('editquestion');

Route::get('/questions/menu', [QATController::class, 'readAll'])->name('qatmenu');

Route::get('/students/menu', function() {
    return view('students.menu');
})->name('studentsmenu');

Route::get('/groups/menu', [GroupsController::class, 'read'])->name('groupsmenu');

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
    Route::post('/post/group/create', 'create')->name("creategroup");
    Route::post('/post/group/update', 'update')->name("updategroup");
    Route::post('/post/group/delete', 'delete')->name("deletegroup");
});
