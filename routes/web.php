<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TarefasController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('tarefas/pdf', [TarefasController::class, 'gerarPdf'])->name('tarefas.pdf');
Route::resource('tarefas', TarefasController::class);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/compose-email', 'hmmm@compose')->name('compose.email');
Route::get('/enviar-email-simulado/{id}', 'EmailController@simularEnvio')->name('email.simulado');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
