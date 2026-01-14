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
use App\Http\Controllers\PresenceController;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\EvenementController;
use App\Http\Controllers\AlerteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClasseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🔹 Authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 Password Reset
Route::get('/password/reset', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// 🔹 Dashboard Redirection
Route::get('/', function () {
    if (auth()->check()) {
        return match(auth()->user()->role) {
            'admin' => redirect()->route('dashboard.admin'),
            'enseignant' => redirect()->route('dashboard.enseignant'),
            'parent' => redirect()->route('dashboard.parent'),
            'eleve' => redirect()->route('dashboard.eleve'),
            default => redirect()->route('dashboard')
        };
    }
    return view('Dashboard.index');
})->name('dashboard');

// 🔹 Main Authenticated Routes
Route::middleware(['auth'])->group(function () {
    
    // Dashboard Views (using DashboardController for logic if needed, or simple views)
    // Providing specific routes for roles
    Route::get('/dashboard/admin', [DashboardController::class, 'index'])->name('dashboard.admin');
    Route::get('/dashboard/enseignant', [DashboardController::class, 'index'])->name('dashboard.enseignant');
    Route::get('/dashboard/parent', [DashboardController::class, 'index'])->name('dashboard.parent');
    Route::get('/dashboard/eleve', [DashboardController::class, 'index'])->name('dashboard.eleve');

    // Notes
    Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [NoteController::class, 'create'])->name('notes.create');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');

    // Présences
    Route::get('/presences', [PresenceController::class, 'index'])->name('presences.index');
    Route::post('/presences', [PresenceController::class, 'store'])->name('presences.store');
    Route::get('/eleves/{eleve}/presence', [PresenceController::class, 'stats'])->name('eleves.presence.stats');
    Route::post('/eleves/{eleve}/presence', [PresenceController::class, 'storeForEleve'])->name('eleves.presence.store');

    // Bulletins (PDF, Calcul)
    Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletins.index');
    Route::get('/bulletins/{eleve}/{periode}', [BulletinController::class, 'show'])->name('bulletins.show');
    Route::get('/bulletins/{eleve}/{periode}/pdf', [BulletinController::class, 'exportPdf'])->name('bulletins.exportPdf');
    
    // Emplois du temps
    Route::get('/emplois-du-temps', [EmploiDuTempsController::class, 'index'])->name('emplois.index');
    Route::middleware('role:admin')->post('/emplois-du-temps', [EmploiDuTempsController::class, 'store'])->name('emplois.store');

    // Événements
    Route::get('/evenements', [EvenementController::class, 'index'])->name('evenements.index');
    Route::middleware('role:admin')->post('/evenements', [EvenementController::class, 'store'])->name('evenements.store');

    // Alertes
    Route::get('/alertes', [AlerteController::class, 'index'])->name('alertes.index');
    Route::patch('/alertes/{alerte}/lu', [AlerteController::class, 'markAsRead'])->name('alertes.read');
    
    // Matières
    Route::resource('matieres', MatiereController::class)->parameters(['matieres' => 'matiere']);

    // Classes
    Route::resource('classes', ClasseController::class);

    // Paiements
    Route::get('/paiements/{paiement}/download', [\App\Http\Controllers\PaiementController::class, 'downloadReceipt'])->name('paiements.download');
    Route::resource('paiements', \App\Http\Controllers\PaiementController::class);
});

// 🔹 Admin Specific Routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('eleves', EleveController::class)->parameters(['eleves' => 'eleve']);
    Route::resource('enseignants', EnseignantController::class);
    Route::resource('parents', ParentController::class)->parameters(['parents' => 'parents']);
    
    // User Management
    Route::patch('/utilisateurs/{utilisateur}/activate', [UserAccessController::class, 'activate'])->name('utilisateurs.activate');
    Route::patch('/utilisateurs/{utilisateur}/deactivate', [UserAccessController::class, 'deactivate'])->name('utilisateurs.deactivate');
    Route::resource('utilisateurs', UserAccessController::class);

    // Bulletins Create
    Route::get('/bulletins/create', [BulletinController::class, 'create'])->name('bulletins.create');
    Route::post('/bulletins/store', [BulletinController::class, 'store'])->name('bulletins.store');
});

Route::get('/manual-sync-test', function () {
    try {
        $e = \App\Models\Enseignant::first();
        if (!$e) return "No teacher found - create one first";
        
        $c = \App\Models\Classe::first();
        if (!$c) return "No class found - create one first";

        echo "<h1>Sync Test</h1>";
        echo "Teacher: {$e->first_name} {$e->last_name} (ID: {$e->id})<br>";
        echo "Class: {$c->nom} (ID: {$c->id})<br>";

        echo "Attempting sync...<br>";
        $e->classes()->sync([$c->id]); 
        
        echo "Sync executed.<br>";
        
        $count = $e->classes()->count();
        echo "Eloquent Classes count: {$count}<br>";
        
        $dbCount = \Illuminate\Support\Facades\DB::table('classe_enseignant')->where('enseignant_id', $e->id)->count();
        echo "DB Table Count: {$dbCount}";

    } catch (\Exception $ex) {
        echo "Error: " . $ex->getMessage();
    }
});