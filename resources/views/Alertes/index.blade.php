@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Mes Alertes</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="list-group">
        @forelse($alertes as $alerte)
            <div class="list-group-item list-group-item-action flex-column align-items-start {{ !$alerte->lu ? 'active' : '' }}">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">
                        @if($alerte->niveau == 'warning') <i class="fas fa-exclamation-triangle text-warning"></i>
                        @elseif($alerte->niveau == 'danger') <i class="fas fa-exclamation-circle text-danger"></i>
                        @else <i class="fas fa-info-circle text-info"></i>
                        @endif
                        {{ $alerte->titre }}
                    </h5>
                    <small>{{ $alerte->created_at->diffForHumans() }}</small>
                </div>
                <p class="mb-1">{{ $alerte->message }}</p>
                
                @if(!$alerte->lu)
                <form action="{{ route('alertes.read', $alerte->id) }}" method="POST" class="mt-2">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-light text-dark">Marquer comme lu</button>
                </form>
                @endif
            </div>
        @empty
            <div class="alert alert-info">Aucune alerte pour le moment.</div>
        @endforelse
    </div>
    
    <div class="mt-3">
        {{ $alertes->links() }}
    </div>
</div>
@endsection
