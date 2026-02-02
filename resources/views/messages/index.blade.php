@extends('layouts.app')

@section('title', 'Messagerie')

@section('content')
<div class="container-fluid animate__animated animate__fadeIn">
    <h1 class="h3 mb-4 text-gray-800 fw-bold"><i class="fa-solid fa-comments text-primary me-2"></i>Messagerie</h1>

    <div class="row">
        <!-- Liste des conversations -->
        <div class="col-md-4">
            <div class="card shadow mb-4 border-0 radius-15" style="height: 75vh;">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary">Conversations</h6>
                    <button class="btn btn-sm btn-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#newMsgModal">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="card-body p-0 overflow-auto">
                    <div class="list-group list-group-flush">
                        @foreach($messages as $conversationId => $msgs)
                            @php
                                $lastMsg = $msgs->first();
                                $contact = $lastMsg->expediteur_id == auth()->id() ? $lastMsg->destinataire : $lastMsg->expediteur;
                                $unreadCount = $msgs->where('destinataire_id', auth()->id())->whereNull('lu_a')->count();
                            @endphp
                            <a href="{{ route('messages.show', $contact->id) }}" class="list-group-item list-group-item-action border-0 py-3 {{ $unreadCount > 0 ? 'bg-light fw-bold' : '' }}">
                                <div class="d-flex w-100 justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px; font-size: 1.2rem;">
                                            {{ strtoupper(substr($contact->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-dark">{{ $contact->name }}</h6>
                                            <small class="text-muted text-truncate" style="max-width: 150px; display: inline-block;">
                                                {{ $lastMsg->expediteur_id == auth()->id() ? 'Vous : ' : '' }}{{ Str::limit($lastMsg->contenu, 25) }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block">{{ $lastMsg->created_at->format('H:i') }}</small>
                                        @if($unreadCount > 0)
                                            <span class="badge bg-danger rounded-pill">{{ $unreadCount }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        
                        @if($messages->isEmpty())
                        <div class="text-center p-4">
                            <p class="text-muted">Aucune conversation.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de sélection (vide par défaut) -->
        <div class="col-md-8 d-none d-md-block">
            <div class="card shadow mb-4 border-0 radius-15" style="height: 75vh;">
                <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                    <div class="bg-light rounded-circle p-5 mb-4">
                        <i class="fas fa-paper-plane fa-4x text-primary opacity-50"></i>
                    </div>
                    <h4 class="fw-bold text-gray-800">Sélectionnez une conversation</h4>
                    <p class="text-muted">Cliquez sur un contact à gauche pour afficher l'historique des échanges.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal Nouveau Message -->
<div class="modal fade" id="newMsgModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('messages.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-edit text-primary me-2"></i>Nouveau Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Destinataire</label>
                        <select name="destinataire_id" class="form-select" required>
                            <option value="">-- Sélectionner une personne --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} 
                                    ({{ ucfirst($user->role) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Message</label>
                        <textarea name="contenu" class="form-control" rows="4" required placeholder="Bonjour..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Envoyer</button>
                </div>
            </div>
        </form>
    </div>
</div>
