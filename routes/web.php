<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WizardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientProgressController;
use App\Models\User; 
// Rota inicial


Route::get('/', [HomeController::class, 'index']);





// Rota para o formulário de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

Route::post('/register', [RegisterController::class, 'register']);

// Rotas do Wizard
Route::get('/wizard/step2', [WizardController::class, 'step2'])->name('wizard.step2');

Route::post('/wizard/step2', [WizardController::class, 'step2']); // Verifique se esse método está adequado

Route::get('/wizard/confirm', [WizardController::class, 'confirm'])->name('wizard.confirm');

Route::post('/wizard/submit', [WizardController::class, 'submit'])->name('wizard.submit');

Route::get('/api/check-cpf/{cpf}', function ($cpf) {
    $user = User::where('cpf', $cpf)->first();
    return response()->json(['exists' => $user ? true : false]);
});



// Rotas de autenticação
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::resource('clients', ClientController::class);



// Rota da página inicial
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');




// Protegendo rotas com o middleware 'auth'
Route::middleware(['auth'])->group(function () {
    Route::resource('clients', ClientController::class);
    Route::get('/clientes', [ClientController::class, 'index'])->name('clientes.index');
});