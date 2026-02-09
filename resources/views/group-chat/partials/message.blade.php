@php
    $isMyMessage = $message->user_id === auth()->id();
@endphp

<div class="message-bubble mb-3 d-flex {{ $isMyMessage ? 'justify-content-end' : 'justify-content-start' }}" data-message-id="{{ $message->id }}">
    <div style="max-width: 70%;">
        <div class="d-flex align-items-end {{ $isMyMessage ? 'flex-row-reverse' : '' }} gap-2">
            <!-- Avatar -->
            @if(!$isMyMessage)
            <div class="flex-shrink-0">
                <div class="rounded-circle text-white d-flex align-items-center justify-content-center" 
                     style="width: 38px; height: 38px; font-size: 14px; font-weight: 600; background: #198754; box-shadow: 0 2px 8px rgba(25, 135, 84, 0.3);"
                     title="{{ $message->user->name }}">
                    {{ strtoupper(substr($message->user->name, 0, 1)) }}
                </div>
            </div>
            @endif

            <!-- Message Content -->
            <div class="{{ $isMyMessage ? 'text-white' : 'bg-white' }} rounded-3 p-3 position-relative"
                 style="{{ $isMyMessage ? 'background: #198754;' : 'background: #ffffff;' }} border-radius: {{ $isMyMessage ? '18px 18px 4px 18px' : '18px 18px 18px 4px' }} !important; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                
                <!-- Sender Name (for other users) -->
                @if(!$isMyMessage)
                <div class="fw-bold mb-1" style="font-size: 0.85rem; color: #198754;">
                    {{ $message->user->name }}
                    @if($message->user->role)
                        <span class="badge" style="font-size: 0.7rem; background: #198754; color: white;">
                            {{ ucfirst($message->user->role) }}
                        </span>
                    @endif
                </div>
                @endif

                <!-- Message Text -->
                <div class="message-text" style="word-wrap: break-word; white-space: pre-wrap;">
                    {{ $message->message }}
                </div>

                <!-- Time and Status -->
                <div class="d-flex align-items-center justify-content-end gap-2 mt-2" 
                     style="font-size: 0.7rem; opacity: 0.8;">
                    <span>{{ $message->created_at->format('H:i') }}</span>
                    @if($isMyMessage)
                        <i class="fas fa-check-double"></i>
                    @endif
                </div>

                <!-- Delete button (only for own messages) -->
                @if($isMyMessage || (auth()->user() && auth()->user()->role === 'admin'))
                <button type="button" 
                        class="btn btn-sm btn-link text-white delete-message-btn position-absolute" 
                        style="top: 5px; right: 5px; font-size: 0.7rem; opacity: 0.6; padding: 0;"
                        data-message-id="{{ $message->id }}"
                        title="Supprimer">
                    <i class="fas fa-times"></i>
                </button>
                @endif
            </div>

            <!-- My Avatar -->
            @if($isMyMessage)
            <div class="flex-shrink-0">
                <div class="rounded-circle text-white d-flex align-items-center justify-content-center" 
                     style="width: 38px; height: 38px; font-size: 14px; font-weight: 600; background: #198754; box-shadow: 0 2px 8px rgba(25, 135, 84, 0.3);"
                     title="Vous">
                    {{ strtoupper(substr($message->user->name, 0, 1)) }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
