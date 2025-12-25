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
|-
| Web Routes
|-----
*/

        // Authentication routes
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Email Verification Routes
        Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
        Route::post('/email/verification-notification', [AuthController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.send');
        
        // Password Reset Routes
        Route::get('/password/reset', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
        Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
        Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

        // Dashboard

         Route::get('/', function () {
            return view('Dashboard.index');
                 })->name('dashboard');

        
        Route::resource('eleves', EleveController::class)->parameters(['eleves' => 'eleve']);
        Route::resource('enseignants', EnseignantController::class)->parameters(['enseignants' => 'enseignant']);

// Parents routes - using UserAccessController for now

Route::resource('parents', ParentController::class)->parameters(['parents' => 'parent']);



        Route::get('/bulletins', function () {
            return view('Bulletins.index');
        })->name('bulletins');

        // Notes
        Route::get('/notes', function () {
            return view('Notes.index');
        })->name('notes');

        // Bulletins
        Route::get('/bulletins', function () {
            return view('Bulletins.index');
        })->name('bulletins');

        Route::get('/utilisateurs', function () {
            return view('Utilisateurs.index');
        })->name('utilisateurs');