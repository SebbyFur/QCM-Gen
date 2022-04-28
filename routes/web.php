<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;
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
});

Route::get('/questionnaire', function () {
    return view('remplir');
});

Route::post('/post/question/add', [QuestionsController::class, 'store'])->name("addquestion");
Route::post('/post/question/fuzzysearch', [QuestionsController::class, 'fuzzysearch'])->name("fuzzysearchquestion");
Route::post('/post/qat/get', [QATController::class, 'get'])->name("getqat");