<?php

use App\Http\Controllers\AnswerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\QuizController;

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

Route::middleware(['auth:sanctum', 'verified'])->get(
    '/dashboard',
    function () {
        return Inertia\Inertia::render('Dashboard');
    }
)->name('dashboard');

// quiz
Route::middleware('auth:sanctum')->group(
    function () {
        Route::get('/quiz', [QuizController::class, 'index']);

        Route::get(
            '/quiz/result',
            [QuizController::class, 'result']
        )->name('result');

        Route::get(
            '/quiz/{question}/{qsession}',
            [QuizController::class, 'next']
        )->name('next');

        Route::post(
            '/answer',
            [AnswerController::class, 'store']
        )->name('answer.store');
    }
);


// admin
Route::middleware('auth:sanctum')->group(
    function () {
        Route::get(
            '/admin/questions',
            [AdminController::class, 'showQuestion']
        )->name('admin.questions');

        Route::post(
            '/admin/questions',
            [AdminController::class, 'storeQuestion']
        )->name('admin.questions.store');

        Route::delete(
            '/admin/questions/{id}',
            [AdminController::class, 'deleteQuestion']
        )->name('admin.questions.delete');
    }
);
