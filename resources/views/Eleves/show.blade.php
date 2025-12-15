@extends('layouts.app')

@section('title', $eleve->nom_complet . ' - Détails - ScolarNextClas')

@section('content')
<div class="container">
    <section class="card detail-card">
        <div class="detail-header">
            <h2 class="card-title"><i class="fas fa-user"></i> Détails de l'élève</h2>
            <div>
                <a href="{{ route('eleves.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Retour
                </a>
                <a href="{{ route('eleves.edit', $eleve->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Modifier
                </a>
            </div>
        </div>

        <div class="student-info">
            <div class="student-avatar">
                {{ substr($eleve->prenom, 0, 1) . substr($eleve->nom, 0, 1) }}
            </div>
            <div>
                <h3 style="margin: 0 0 10px 0;">{{ $eleve->nom_complet }}</h3>
                <p style="margin: 0 0 5px 0; color: #666;">
                    <i class="fas fa-id-card me-1"></i> {{ $eleve->matricule }}
                </p>
                <p style="margin: 0;">
                    <span class="{{ $eleve->statut == 'actif' ? 'status-active' : 'status-inactive' }}">
                        {{ ucfirst($eleve->statut) }}
                    </span>
                </p>
            </div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Informations personnelles:</div>
            <div class="detail-value">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <p style="margin: 0 0 10px 0;">
                            <strong>Date de naissance:</strong><br>
                            {{ \Carbon\Carbon::parse($eleve->date_naissance)->translatedFormat('d F Y') }}
                            ({{ $eleve->age }} ans)
                        </p>
                        <p style="margin: 0 0 10px 0;">
                            <strong>Genre:</strong><br>
                            <span class="gender-icon">
                                <i class="fas {{ $eleve->genre == 'Féminin' ? 'fa-venus' : 'fa-mars' }}" 
                                   style="color: {{ $eleve->genre == 'Féminin' ? '#d63384' : '#0d6efd' }};"></i>
                                {{ $eleve->genre }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p style="margin: 0 0 10px 0;">
                            <strong>Classe:</strong><br>
                            {{ $eleve->classe->nom ?? 'Non assigné' }}
                        </p>
                        <p style="margin: 0;">
                            <strong>Date d'inscription:</strong><br>
                            {{ \Carbon\Carbon::parse($eleve->created_at)->translatedFormat('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Contact:</div>
            <div class="detail-value">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                    <div>
                        <p style="margin: 0 0 10px 0;">
                            <strong>Adresse:</strong><br>
                            {{ $eleve->adresse ?? 'Non renseignée' }}
                        </p>
                        <p style="margin: 0 0 10px 0;">
                            <strong>Email élève:</strong><br>
                            {{ $eleve->email ?? 'Non renseigné' }}
                        </p>
                        <p style="margin: 0;">
                            <strong>Téléphone élève:</strong><br>
                            {{ $eleve->telephone ?? 'Non renseigné' }}
                        </p>
                    </div>
                    <div>
                        <p style="margin: 0 0 10px 0;">
                            <strong>Parent/Tuteur:</strong><br>
                            {{ $eleve->parent_nom }} ({{ $eleve->parent_relation }})
                        </p>
                        <p style="margin: 0 0 10px 0;">
                            <strong>Email parent:</strong><br>
                            {{ $eleve->parent_email ?? 'Non renseigné' }}
                        </p>
                        <p style="margin: 0;">
                            <strong>Téléphone parent:</strong><br>
                            {{ $eleve->parent_telephone }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        @if($eleve->notes)
        <div class="detail-row">
            <div class="detail-label">Notes:</div>
            <div class="detail-value">
                <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-left: 4px solid #170B9D;">
                    {{ $eleve->notes }}
                </div>
            </div>
        </div>
        @endif
    </section>
</div>
@endsection

@section('styles')
<style>
    .detail-card {
        max-width: 900px;
        margin: 0 auto;
    }
    .detail-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }
    .detail-row {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }
    .detail-label {
        flex: 0 0 200px;
        font-weight: 600;
        color: #555;
    }
    .detail-value {
        flex: 1;
        color: #333;
    }
    .student-avatar {
        width: 100px;
        height: 100px;
        background: linear-gradient(135deg, #170B9D, #7d6ae8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .student-info {
        display: flex;
        align-items: center;
        gap: 30px;
        margin-bottom: 30px;
    }
    .status-active {
        background-color: #d4edda;
        color: #155724;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-block;
    }
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-block;
    }
    .gender-icon {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    @media (max-width: 768px) {
        .detail-row {
            flex-direction: column;
            gap: 10px;
        }
        .detail-label {
            flex: none;
        }
        .student-info {
            flex-direction: column;
            text-align: center;
        }
    }
</style>
@endsection