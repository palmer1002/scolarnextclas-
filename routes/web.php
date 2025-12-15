<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Dashboard.index');   // Page Dashboard
})->name('dashboard');

Route::get('/eleves', function () {
    return view('eleves.index');      // Page Élèves
})->name('eleves');
Route::get('/notes', function () {
        return view('notes.index');      // Page Notes
    })->name('notes');
    Route::get('/bulletins', function () {
        return view('bulletins.index');      // Page Bulletin
    })->name('bulletins');
     Route::get('/enseignants', function () {
        return view('enseignants.index');      // Page Enseignants
    })->name('enseignants');
     Route::get('/parents', function () {
        return view('parents.index');      // Page Parents
    })->name('parents');
         Route::get('/evenements', function () {
        return view('evenements.index');      // Page evenements
    })->name('evenements');