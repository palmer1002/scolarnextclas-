<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BulletinController;
use App\Http\Controllers\EleveController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\UserAccessController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔹 Authentication (protégé par guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

// 🔹 Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 Password Reset
Route::get('/password/reset', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// 🔹 Dashboard (page d’accueil)
Route::get('/', function () {
    if (auth()->check()) {
        switch (auth()->user()->role) {
            case 'admin': return redirect()->route('dashboard.admin');
            case 'enseignant': return redirect()->route('dashboard.enseignant');
            case 'parent': return redirect()->route('dashboard.parent');
            case 'eleve': return redirect()->route('dashboard.eleve');
            default: return redirect()->route('dashboard');
        }
    }

    return view('Dashboard.index');
})->name('dashboard');

// 🔹 Dashboards par rôle
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('Dashboard.admin.index');
    })->name('dashboard.admin');

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    // Routes admin pour gérer les élèves
    Route::get('/eleves', [EleveController::class, 'index'])->name('eleves.index');
    Route::get('/enseignants', [EnseignantController::class, 'index'])->name('enseignants.index');
    Route::get('/parents', [ParentController::class, 'index'])->name('parents.index');
});

// 🔹 Ou si ce sont des ressources :
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('eleves', EleveController::class)
        ->parameters(['eleves' => 'eleve']);
    Route::resource('enseignants', EnseignantController::class)
        ->parameters(['enseignants' => 'enseignant']);
    Route::resource('parents', ParentController::class)
        ->parameters(['parents' => 'parent']);

    // Bulletins (création par admin)
    Route::get('/bulletins/create', [\App\Http\Controllers\BulletinController::class, 'create'])->name('bulletins.create');
    Route::post('/bulletins', [\App\Http\Controllers\BulletinController::class, 'store'])->name('bulletins.store');

    // Gestion des utilisateurs (admin)
    Route::patch('/utilisateurs/{utilisateur}/activate', [\App\Http\Controllers\UserAccessController::class, 'activate'])->name('utilisateurs.activate');
    Route::patch('/utilisateurs/{utilisateur}/deactivate', [\App\Http\Controllers\UserAccessController::class, 'deactivate'])->name('utilisateurs.deactivate');
    Route::resource('utilisateurs', UserAccessController::class);
});

Route::middleware(['auth', 'role:enseignant'])->group(function () {
    Route::get('/dashboard/enseignant', function () {
        return view('Dashboard.enseignant.index');
    })->name('dashboard.enseignant');
});

Route::middleware(['auth', 'role:parent'])->group(function () {
    Route::get('/dashboard/parent', function () {
        return view('Dashboard.parent.index');
    })->name('dashboard.parent');
});

Route::middleware(['auth', 'role:eleve'])->group(function () {
    Route::get('/dashboard/eleve', function () {
        return view('Dashboard.eleve.index');
    })->name('dashboard.eleve');
});

// 🔹 Notes
Route::middleware('auth')->get('/notes', [NoteController::class, 'index'])->name('notes.index');

// 🔹 Présences (par élève)
// Routes minimales: affichage de la page de présence et enregistrement (placeholder)
Route::middleware('auth')->get('/eleves/{eleve}/presence', [EleveController::class, 'presence'])->name('eleves.presence');
Route::middleware('auth')->post('/eleves/{eleve}/presence', [EleveController::class, 'storePresence'])->name('eleves.presence.store');

// 🔹 Bulletins
Route::middleware('auth')->group(function () {
    Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletins.index');
    Route::get('/bulletins/{eleve}/{periode}', [BulletinController::class, 'show'])->name('bulletins.show');
    Route::get('/bulletins/{eleve}/{periode}/pdf', [BulletinController::class, 'exportPdf'])->name('bulletins.exportPdf');

    // Paiements (vues statiques pour l'instant)
    Route::prefix('paiements')->name('paiements.')->group(function () {
        Route::get('/', function () {
            return view('Paiements.index');
        })->name('index');

        Route::get('/create', function () {
            return view('Paiements.create');
        })->name('create');

        Route::get('/{id}', function ($id) {
            return view('Paiements.show', ['id' => $id]);
        })->name('show');

        Route::get('/{id}/edit', function ($id) {
            return view('Paiements.edit', ['id' => $id]);
        })->name('edit');
    });
});

// 🔹 Matieres
Route::resource('matieres', MatiereController::class)
    ->parameters(['matieres' => 'matiere'])
    ->middleware('auth');