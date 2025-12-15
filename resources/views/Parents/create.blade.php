@extends('layouts.app')

@section('content')
<div class="content">
    <!-- Navbar -->
    <div class="navbar">
        <div>
            <h1><i class="fas fa-users"></i> Gestion des Parents</h1>
            <p>Administrez les informations des parents et tuteurs des élèves</p>
        </div>
        <div style="display: flex; gap: 15px;">
            <span style="padding: 5px 15px; border: 1px solid #ddd; background: #f0f0f0; font-size: 0.9rem; cursor: pointer;">
                Année 2025-2026
            </span>
        </div>
    </div>

    <!-- Page de création -->
    <div class="container">
        <section class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="fas fa-user-plus"></i> Ajouter un nouveau parent</h2>
                <a href="{{ route('parents.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Retour à la liste
                </a>
            </div>

            <div class="form-container">
                <form action="{{ route('parents.store') }}" method="POST">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nom complet *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Téléphone *</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="address">Adresse</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}">
                            @error('address')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="relation">Relation *</label>
                            <select id="relation" name="relation" required>
                                <option value="">Sélectionner</option>
                                <option value="Père" {{ old('relation') == 'Père' ? 'selected' : '' }}>Père</option>
                                <option value="Mère" {{ old('relation') == 'Mère' ? 'selected' : '' }}>Mère</option>
                                <option value="Tuteur" {{ old('relation') == 'Tuteur' ? 'selected' : '' }}>Tuteur</option>
                                <option value="Autre" {{ old('relation') == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('relation')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Statut</label>
                            <select id="status" name="status">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                            </select>
                            @error('status')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group full-width">
                            <label for="students">Élève(s) associé(s) *</label>
                            <select id="students" name="students[]" multiple required style="height: 120px;">
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}" {{ in_array($student->id, old('students', [])) ? 'selected' : '' }}>
                                        {{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_code }})
                                    </option>
                                @endforeach
                            </select>
                            <small style="color: #6c757d; display: block; margin-top: 5px;">
                                Maintenez Ctrl (Cmd sur Mac) pour sélectionner plusieurs élèves
                            </small>
                            @error('students')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group full-width">
                            <label for="notes">Notes supplémentaires</label>
                            <textarea id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="text-danger" style="margin-top: 5px;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div style="display: flex; gap: 15px; margin-top: 30px;">
                        <a href="{{ route('parents.index') }}" class="btn btn-outline">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer le parent
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection