@extends('layouts.app')

@section('title', 'Gestion des Élèves - ScolarNextClas')

@section('content')
<div class="navbar">
    <div>
        <h1><i class="fas fa-user-graduate"></i> Gestion des Élèves</h1>
        <p>Administrez les élèves inscrits dans l'établissement</p>
    </div>
    <div>
        <span class="badge bg-light text-dark">Année 2025-2026</span>
    </div>
</div>

<div class="container">
    <section class="card">
        <div class="card-header">
            <h2 class="card-title"><i class="fas fa-list"></i> Liste des Élèves</h2>
            <a href="{{ route('eleves.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajouter un élève
            </a>
        </div>

        <div class="search-filter">
            <form action="{{ route('eleves.index') }}" method="GET">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           placeholder="Rechercher un élève...">
                </div>
                <select name="classe" class="form-control">
                    <option value="">Toutes les classes</option>
                        @foreach($classes as $classe)
                        <option value="{{ $classe->id }}" {{ request('classe') == $classe->id ? 'selected' : '' }}>
                            {{ $classe->nom }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">Filtrer</button>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Matricule</th>
                        <th>Nom & Prénom</th>
                        <th>Classe</th>
                        <th>Genre</th>
                        <th>Parent/Tuteur</th>
                        <th>Téléphone Parent</th>
                        <th>Date d'inscription</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eleves as $eleve)
                    <tr>
                        <td><strong>{{ $eleve->matricule }}</strong></td>
                        <td>
                            <strong>{{ $eleve->nom_complet }}</strong>
                            <div class="text-muted small">{{ $eleve->age }} ans</div>
                        </td>
                        <td>{{ $eleve->classe->nom ?? '-' }}</td>
                        <td>
                            <span class="gender-icon">
                                <i class="fas {{ $eleve->genre == 'Féminin' ? 'fa-venus' : 'fa-mars' }}" 
                                   style="color: {{ $eleve->genre == 'Féminin' ? '#d63384' : '#0d6efd' }};"></i>
                                {{ $eleve->genre }}
                            </span>
                        </td>
                        <td>{{ $eleve->parent_nom }}<br>
                            <small style="color: #666;">{{ $eleve->parent_relation }}</small>
                        </td>
                        <td>{{ $eleve->parent_telephone }}</td>
                        <td>{{ $eleve->date_inscription->format('d/m/Y') }}</td>
                        <td>
                            <span class="status-{{ $eleve->statut }}">
                                {{ ucfirst($eleve->statut) }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('eleves.show', $eleve) }}" class="action-btn" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('eleves.edit', $eleve) }}" class="action-btn" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('eleves.destroy', $eleve) }}" method="POST" 
                                      style="display: inline;" onsubmit="return confirm('Êtes-vous sûr ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $eleves->links() }}
        </div>
    </section>
</div>
@endsection