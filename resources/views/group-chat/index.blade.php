@extends('layouts.app')

@section('content')
<div class="container-fluid h-100">
    <div class="row justify-content-center h-100">
        <div class="col-md-10 col-lg-10">
            <div class="card shadow-lg border-0" style="height: 85vh; border-radius: 20px; overflow: hidden;">
                <!-- Header -->
                <div class="card-header text-white" style="background: #2C3E50; border-radius: 20px 20px 0 0; padding: 20px 25px; border: none;">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle p-2 me-3" style="background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(10px);">
                            <i class="fas fa-users" style="font-size: 1.3rem;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">💬 Discussion Générale</h5>
                            <small class="opacity-90" style="font-size: 0.85rem;">Espace commun pour tous</small>
                        </div>
                        <div class="ms-auto">
                            <span class="badge" style="background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px);" id="online-count">
                                <i class="fas fa-circle text-success" style="font-size: 8px;"></i> Session active
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Messages Container -->
                <div class="card-body p-0" style="height: calc(85vh - 140px); overflow-y: auto; background: #ffffff;" id="messages-container">
                    <div class="p-3" id="messages-list">
                        @php $lastDate = null; @endphp
                        @forelse($messages as $message)
                            @php 
                                $currentDate = $message->created_at->format('Y-m-d');
                            @endphp
                            @if($lastDate !== $currentDate)
                                <div class="text-center my-3">
                                    <span class="badge" style="background: rgba(44, 62, 80, 0.1); color: #2C3E50; font-weight: 500; padding: 6px 12px; border-radius: 12px;">
                                        {{ $message->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                                @php $lastDate = $currentDate; @endphp
                            @endif
                            @include('group-chat.partials.message', ['message' => $message])
                        @empty
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-comments fa-3x mb-3 opacity-25"></i>
                                <p>Aucun message pour le moment.</p>
                                <p class="small">Soyez le premier à envoyer un message ! 👋</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Message Input -->
                <div class="card-footer border-0" style="background: #ffffff; border-radius: 0 0 20px 20px; padding: 15px 20px; box-shadow: 0 -2px 10px rgba(0,0,0,0.05);">
                    <form id="message-form" action="{{ route('group-chat.store') }}" method="POST">
                        @csrf
                        <div class="input-group" style="gap: 8px;">
                            <button type="button" class="btn border-0" style="background: #2C3E50; color: white; width: 45px; border-radius: 12px;" title="Emoji">
                                <i class="far fa-smile"></i>
                            </button>
                            <input type="text" 
                                   name="message" 
                                   id="message-input" 
                                   class="form-control border-0" 
                                   style="background: #f8f9fa; border-radius: 12px; padding: 12px 18px; font-size: 0.95rem;"
                                   placeholder="Tapez votre message ici..." 
                                   required
                                   autocomplete="off"
                                   maxlength="5000">
                            <button type="submit" class="btn" style="background: #2C3E50; color: white; border-radius: 12px; padding: 0 20px; font-weight: 500;" id="send-btn">
                                <i class="fas fa-paper-plane me-1"></i> Envoyer
                            </button>
                        </div>
                    </form>
                    <div class="text-muted small mt-2 text-center" style="font-size: 0.8rem;">
                        <i class="fas fa-lock"></i> Visible par tout le personnel et les élèves
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    #messages-container {
        scroll-behavior: smooth;
    }

    #messages-container::-webkit-scrollbar {
        width: 6px;
    }

    #messages-container::-webkit-scrollbar-track {
        background: transparent;
    }

    #messages-container::-webkit-scrollbar-thumb {
        background: #2C3E50;
        border-radius: 10px;
    }

    #messages-container::-webkit-scrollbar-thumb:hover {
        background: #34495E;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(15px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .message-bubble {
        animation: slideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    #message-input:focus {
        box-shadow: 0 0 0 3px rgba(44, 62, 80, 0.15);
        border-color: transparent;
        outline: none;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(44, 62, 80, 0.3);
        transition: all 0.3s ease;
    }

    .btn:active {
        transform: translateY(0);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    const messagesList = document.getElementById('messages-list');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const sendBtn = document.getElementById('send-btn');
    let lastMessageId = {{ $messages->last()->id ?? 0 }};
    let isScrolledToBottom = true;

    scrollToBottom();

    messagesContainer.addEventListener('scroll', function() {
        const threshold = 100;
        isScrolledToBottom = messagesContainer.scrollHeight - messagesContainer.scrollTop - messagesContainer.clientHeight < threshold;
    });

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;

        messageInput.disabled = true;
        sendBtn.disabled = true;

        fetch('{{ route('group-chat.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messagesList.insertAdjacentHTML('beforeend', data.html);
                lastMessageId = data.message.id;
                messageInput.value = '';
                scrollToBottom();
                const emptyState = messagesList.querySelector('.text-center.text-muted');
                if (emptyState) emptyState.remove();
            }
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            messageInput.disabled = false;
            sendBtn.disabled = false;
            messageInput.focus();
        });
    });

    setInterval(function() {
        fetch(`{{ route('group-chat.new-messages') }}?last_id=${lastMessageId}`, {
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.count > 0) {
                messagesList.insertAdjacentHTML('beforeend', data.html);
                lastMessageId = data.messages[data.messages.length - 1].id;
                const emptyState = messagesList.querySelector('.text-center.text-muted');
                if (emptyState) emptyState.remove();
                if (isScrolledToBottom) scrollToBottom();
            }
        })
        .catch(error => console.error('Error polling:', error));
    }, 3000);

    messageInput.focus();

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-message-btn') || e.target.closest('.delete-message-btn')) {
            const btn = e.target.classList.contains('delete-message-btn') ? e.target : e.target.closest('.delete-message-btn');
            const messageId = btn.dataset.messageId;
            if (confirm('Voulez-vous vraiment supprimer ce message ?')) {
                fetch(`/group-chat/${messageId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const messageElement = btn.closest('.message-bubble');
                        if (messageElement) messageElement.remove();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    });
});
</script>
@endpush
@endsection
