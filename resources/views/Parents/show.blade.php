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

    <!-- Page de détails -->
    <div class="container">
        <section class="card detail-card">
            <div class="detail-header">
                <h2 class="card-title"><i class="fas fa-user"></i> Détails du parent</h2>
                <div>
                    <a href="{{ route('parents.index') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Modifier
                    </a>
                </div>
            </div>

            <div id="parentDetails">
                <div class="detail-row">
                    <div class="detail-label">Nom complet:</div>
                    <div class="detail-value"><strong>{{ $parent->name }}</strong></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Téléphone:</div>
                    <div class="detail-value">{{ $parent->phone }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value">{{ $parent->email ?: 'Non renseigné' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Adresse:</div>
                    <div class="detail-value">{{ $parent->address ?: 'Non renseignée' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Relation:</div>
                    <div class="detail-value">{{ $parent->relation }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Statut:</div>
                    <div class="detail-value">
                        <span class="{{ $parent->status === 'active' ? 'status-active' : 'status-inactive' }}">
                            {{ $parent->status === 'active' ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Élève(s) associé(s):</div>
                    <div class="detail-value">
                        <div class="students-list">
                            @foreach($parent->students as $student)
                                <span class="badge">{{ $student->first_name }} {{ $student->last_name }} ({{ $student->student_code }})</span>
                            @endforeach
                        </div>
                    </div>
                </div>
                @if($parent->notes)
                <div class="detail-row">
                    <div class="detail-label">Notes:</div>
                    <div class="detail-value">{{ $parent->notes }}</div>
                </div>
                @endif
                <div class="detail-row">
                    <div class="detail-label">Date d'inscription:</div>
                    <div class="detail-value">{{ $parent->created_at->format('d/m/Y') }}</div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection