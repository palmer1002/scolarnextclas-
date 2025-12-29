<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAccessController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PasswordResetController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

        // Authentication routes
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Password Reset Routes
        Route::get('/password/reset', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

        // Dashboard

         Route::get('/', function () {
            if (auth()->check() && auth()->user()->role === 'admin') {
                return redirect('/dashboard/admin');
            }
            return view('Dashboard.index');
                 })->name('dashboard');

        
        Route::resource('eleves', EleveController::class)->parameters(['eleves' => 'eleve']);
        Route::resource('enseignants', EnseignantController::class)->parameters(['enseignants' => 'enseignant']);

// Parents routes - using UserAccessController for now

Route::resource('parents', ParentController::class)->parameters(['parents' => 'parent']);


// Paiements routes
Route::resource('paiements', PaiementController::class)->parameters(['paiements' => 'paiement']);

        Route::get('/bulletins', function () {
            return view('Bulletins.index');
        })->name('bulletins');

        // Notes
        Route::get('/notes', function () {
            return view('Notes.index');
        })->name('notes');

        use App\Http\Controllers\BulletinController; Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletins.index'); Route::get('/bulletins/{eleve}', [BulletinController::class, 'show'])->name('bulletins.show'); Route::get('/bulletins/{eleve}/pdf', [BulletinController::class, 'exportPdf'])->name
        // Utilisateurs routes
        Route::resource('utilisateurs', UserAccessController::class)->parameters(['utilisateurs' => 'utilisateur']);

        // Role-specific dashboards
        Route::get('/dashboard/admin', function () {
            return view('Dashboard.admin.index');
        })->name('dashboard.admin');
        
        Route::get('/dashboard/enseignant', function () {
            return view('Dashboard.enseignant.index');
        })->name('dashboard.enseignant');
        
        Route::get('/dashboard/parent', function () {
            return view('Dashboard.parent.index');
        })->name('dashboard.parent');
        
        Route::get('/dashboard/eleve', function () {
            return view('Dashboard.eleve.index');
        })->name('dashboard.eleve');