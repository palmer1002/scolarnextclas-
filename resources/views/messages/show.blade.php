@extends('layouts.app')

@section('title', 'Discussion avec ' . $correspondant->name)

@section('content')
<div class="container-fluid animate__animated animate__fadeIn" style="height: calc(100vh - 100px);">
    <div class="card shadow border-0 radius-15 h-100">
        <!-- En-tête du chat -->
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
            <div class="d-flex align-items-center">
                <a href="{{ route('messages.index') }}" class="btn btn-light btn-sm rounded-circle me-3"><i class="fas fa-arrow-left"></i></a>
                <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center me-3" style="width: 45px; height: 45px; font-size: 1.2rem;">
                    {{ strtoupper(substr($correspondant->name, 0, 1)) }}
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">{{ $correspondant->name }}</h5>
                    <small class="text-muted"><i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> En ligne</small>
                </div>
            </div>
        </div>

        <!-- Corps du chat (Messages) -->
        <div class="card-body overflow-auto bg-light" id="chat-box" style="scroll-behavior: smooth;">
            @foreach($conversation as $msg)
                <div class="d-flex {{ $msg->expediteur_id == auth()->id() ? 'justify-content-end' : 'justify-content-start' }} mb-3">
                    <div class="d-flex flex-column {{ $msg->expediteur_id == auth()->id() ? 'align-items-end' : 'align-items-start' }}" style="max-width: 70%;">
                        <div class="p-3 shadow-sm {{ $msg->expediteur_id == auth()->id() ? 'bg-primary text-white rounded-start-top-0' : 'bg-white text-dark rounded-end-top-0' }}" style="border-radius: 15px;">
                            <p class="mb-0">{{ $msg->contenu }}</p>
                        </div>
                        <small class="text-muted mt-1" style="font-size: 0.75rem;">
                            {{ $msg->created_at->format('H:i') }}
                            @if($msg->expediteur_id == auth()->id())
                                <i class="fas {{ $msg->lu_a ? 'fa-check-double text-primary' : 'fa-check' }}"></i>
                            @endif
                        </small>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pied de page (Formulaire d'envoi) -->
        <div class="card-footer bg-white py-3 border-top">
            <form action="{{ route('messages.store') }}" method="POST" class="d-flex align-items-center">
                @csrf
                <input type="hidden" name="destinataire_id" value="{{ $correspondant->id }}">
                <div class="input-group">
                    <input type="text" name="contenu" class="form-control border-0 bg-light rounded-pill px-4 py-2" placeholder="Écrivez votre message..." required autofocus autocomplete="off">
                    <button class="btn btn-primary rounded-circle ms-2 shadow-sm" type="submit" style="width: 45px; height: 45px;">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Scroller automatiquement vers le bas
    document.addEventListener("DOMContentLoaded", function() {
        var chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
    });
</script>
@endsection
