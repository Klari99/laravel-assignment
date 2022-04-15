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
    return view('site/menu');
})->name('menu')->middleware(['auth']);

Route::get('/create-form', [CreateFormController::class, 'show'])->name('create-form')->middleware(['auth']);
Route::post('/create-form', [CreateFormController::class, 'store'])->name('forms.create')->middleware(['auth']);

Route::get('/forms', [FormsController::class, 'show'])->name('forms')->middleware(['auth']);
Route::get('/forms/{id}', [FormsController::class, 'get'])->name('forms.get');
Route::post('/forms/{id}', [FormsController::class, 'store'])->name('forms.store');
Route::get('/forms/{id}/modify', [FormController::class, 'showModificationSite'])->name('form.modify')->middleware(['auth']);
Route::post('/forms/{id}/modify', [FormController::class, 'update'])->name('form.update')->middleware(['auth']);

require __DIR__.'/auth.php';
