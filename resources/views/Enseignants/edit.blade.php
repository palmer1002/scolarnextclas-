@extends('layouts.app')

@section('title', 'Modifier un enseignant')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 style="color:#170B9DFF;">
                        <i class="fas fa-user-edit me-2"></i> Modifier l'enseignant
                    </h4>
                    <a href="{{ route('enseignants.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                </div>

                <div class="card-body">
                    {{-- Messages d'erreur --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Formulaire de modification --}}
                    <form action="{{ route('enseignants.update', $teacher->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Titre --}}
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <select name="title" class="form-select" required>
                                <option value="">-- Choisir --</option>
                                <option value="M." {{ $teacher->title == 'M.' ? 'selected' : '' }}>M.</option>
                                <option value="Mme" {{ $teacher->title == 'Mme' ? 'selected' : '' }}>Mme</option>
                                <option value="Mlle" {{ $teacher->title == 'Mlle' ? 'selected' : '' }}>Mlle</option>
                            </select>
                        </div>

                        {{-- Nom --}}
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="last_name" class="form-control"
                                   value="{{ old('last_name', $teacher->last_name) }}" required>
                        </div>

                        {{-- Prénom --}}
                        <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="first_name" class="form-control"
                                   value="{{ old('first_name', $teacher->first_name) }}" required>
                        </div>

                        {{-- Matière --}}
                        <div class="mb-3">
                            <label class="form-label">Matière</label>
                            <input type="text" name="subject" class="form-control"
                                   value="{{ old('subject', $teacher->subject) }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ old('email', $teacher->email) }}">
                        </div>

                        {{-- Téléphone --}}
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $teacher->phone) }}">
                        </div>

                        {{-- Statut --}}
                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select">
                                <option value="Permanent" {{ $teacher->status == 'Permanent' ? 'selected' : '' }}>
                                    Permanent
                                </option>
                                <option value="Vacataire" {{ $teacher->status == 'Vacataire' ? 'selected' : '' }}>
                                    Vacataire
                                </option>
                            </select>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary">
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Mettre à jour
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection