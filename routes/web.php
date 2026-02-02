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
// use App\Http\Controllers\EmploiDuTempsController;
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
Route::get('/logout', [AuthController::class, 'logout']);

// 🔹 Password Reset
Route::get('/password/reset', [PasswordResetController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password.update');

// 🔹 Dashboard Redirection & Data
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

// 🔹 Legal Pages
Route::get('/politique-de-confidentialite', function () {
    return view('legal.privacy');
})->name('privacy');

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
    Route::get('/notes/batch', [NoteController::class, 'createBatch'])->name('notes.batch');
    Route::post('/notes/batch', [NoteController::class, 'storeBatch'])->name('notes.batch.store');
    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::get('/notes/{note}', [NoteController::class, 'show'])->name('notes.show');
    Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');

    // Présences
    Route::get('/presences', [PresenceController::class, 'index'])->name('presences.index');
    Route::post('/presences', [PresenceController::class, 'store'])->name('presences.store');
    Route::get('/eleves/{eleve}/presence', [PresenceController::class, 'stats'])->name('eleves.presence.stats');
    Route::post('/eleves/{eleve}/presence', [PresenceController::class, 'storeForEleve'])->name('eleves.presence.store');

    // Bulletins (PDF, Calcul)
    Route::get('/bulletins', [BulletinController::class, 'index'])->name('bulletins.index');
    Route::get('/bulletins/summary', [BulletinController::class, 'classSummary'])->name('bulletins.summary');
    Route::get('/bulletins/{eleve}/{periode}', [BulletinController::class, 'show'])->name('bulletins.show');
    Route::get('/bulletins/{eleve}/{periode}/pdf', [BulletinController::class, 'exportPdf'])->name('bulletins.exportPdf');
    Route::get('/bulletins-batch/pdf', [BulletinController::class, 'exportClassPdf'])->name('bulletins.exportClassPdf');
    Route::delete('/bulletins/{bulletin}', [BulletinController::class, 'destroy'])->name('bulletins.destroy')->middleware('role:admin,secretaire');
    
    // Emplois du temps (Désactivé)
    // Route::get('/emplois-du-temps', [EmploiDuTempsController::class, 'index'])->name('emplois.index');
    // Route::middleware('role:admin')->post('/emplois-du-temps', [EmploiDuTempsController::class, 'store'])->name('emplois.store');

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

    // Annonces
    Route::resource('annonces', \App\Http\Controllers\AnnonceController::class);

    // Messagerie
    Route::get('/messages', [\App\Http\Controllers\MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{user}', [\App\Http\Controllers\MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages', [\App\Http\Controllers\MessageController::class, 'store'])->name('messages.store');

    // Paiements
    Route::get('/paiements/{paiement}/download', [\App\Http\Controllers\PaiementController::class, 'downloadReceipt'])->name('paiements.download');
    Route::resource('paiements', \App\Http\Controllers\PaiementController::class);

    // Profile Access for all roles
    Route::get('/mon-profil/eleve', [EleveController::class, 'profile'])->name('eleves.profile');
    Route::get('/mon-profil/enseignant', [EnseignantController::class, 'profile'])->name('enseignants.profile');
    Route::get('/mon-profil/parent', [ParentController::class, 'profile'])->name('parents.profile');
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