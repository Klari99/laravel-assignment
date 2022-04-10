<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\FormsController;
use App\Http\Controllers\CreateFormController;

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
    //return view('welcome');
    return view('site/menu');
})->name('menu')->middleware(['auth']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware(['auth']);

Route::get('/create-form', [CreateFormController::class, 'show'])->name('create-form');

Route::get('/forms', [FormsController::class, 'show'])->name('forms');

Route::get('/forms/{id}', [FormsController::class, 'get'])->name('forms.get');

Route::get('/forms/{id}', [FormsController::class, 'getWithAuth'])
->name('forms.getWithAuth')->middleware(['auth']);

require __DIR__.'/auth.php';
