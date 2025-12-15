@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 style="color:#170B9DFF;">
                        <i class="fas fa-user-plus me-2"></i> Ajouter un enseignant
                    </h4>
                    <a href="{{ route('teachers.index') }}" class="btn btn-sm btn-secondary">
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

                    {{-- Formulaire --}}
                    <form action="{{ route('teachers.store') }}" method="POST">
                        @csrf

                        {{-- Titre --}}
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <select name="title" class="form-select" required>
                                <option value="">-- Choisir --</option>
                                <option value="M.">M.</option>
                                <option value="Mme">Mme</option>
                                <option value="Mlle">Mlle</option>
                            </select>
                        </div>

                        {{-- Nom --}}
                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        </div>

                        {{-- Prénom --}}
                        <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        </div>

                        {{-- Matière --}}
                        <div class="mb-3">
                            <label class="form-label">Matière</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                        </div>

                        {{-- Téléphone --}}
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                        </div>

                        {{-- Statut --}}
                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select">
                                <option value="Permanent">Permanent</option>
                                <option value="Vacataire">Vacataire</option>
                            </select>
                        </div>

                        {{-- Boutons --}}
                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-outline-secondary">
                                Annuler
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Enregistrer
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
