<ul class="nav flex-column">
    {{-- Tableau de bord (Commun) --}}
    <li class="nav-item {{ request()->is('/') || request()->is('dashboard*') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fa-solid fa-house"></i> Tableau de bord
        </a>
    </li>

    {{-- Menu Administration & Gestion (Admin & Secrétaire) --}}
    @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'secretaire']))
        <li class="nav-item {{ request()->is('eleves*') ? 'active' : '' }}">
            <a href="{{ route('eleves.index') }}" class="nav-link">
                <i class="fa-solid fa-user-graduate"></i> Élèves
            </a>
        </li>
        <li class="nav-item {{ request()->is('enseignants*') ? 'active' : '' }}">
            <a href="{{ route('enseignants.index') }}" class="nav-link">
                <i class="fa-solid fa-chalkboard-user"></i> Enseignants
            </a>
        </li>
        <li class="nav-item {{ request()->is('parents*') ? 'active' : '' }}">
            <a href="{{ route('parents.index') }}" class="nav-link">
                <i class="fa-solid fa-users"></i> Parents
            </a>
        </li>
        <li class="nav-item {{ request()->is('paiements*') ? 'active' : '' }}">
            <a href="{{ route('paiements.index') }}" class="nav-link">
                <i class="fa-solid fa-credit-card"></i> Paiements
            </a>
        </li>
        <li class="nav-item {{ request()->is('matieres*') ? 'active' : '' }}">
            <a href="{{ route('matieres.index') }}" class="nav-link">
                <i class="fa-solid fa-book-open"></i> Matières
            </a>
        </li>
        <li class="nav-item {{ request()->is('classes*') ? 'active' : '' }}">
            <a href="{{ route('classes.index') }}" class="nav-link">
                <i class="fa-solid fa-chalkboard"></i> Classes
            </a>
        </li>
        <li class="nav-item {{ request()->is('notes*') ? 'active' : '' }}">
            <a href="{{ route('notes.index') }}" class="nav-link">
                <i class="fa-solid fa-pen-to-square"></i> Notes & Évaluations
            </a>
        </li>
        <li class="nav-item {{ request()->is('bulletins*') ? 'active' : '' }}">
            <a href="{{ route('bulletins.index') }}" class="nav-link">
                <i class="fa-solid fa-file-lines"></i> Gestion Bulletins
            </a>
        </li>
        
        @if(Auth::user()->role === 'admin')
            <li class="nav-item {{ request()->is('utilisateurs*') ? 'active' : '' }}">
                <a href="{{ route('utilisateurs.index') }}" class="nav-link">
                    <i class="fa-solid fa-user-shield"></i> Administration
                </a>
            </li>
        @endif
    @endif

    {{-- Menu Enseignant (Spécifique) --}}
    @if(Auth::check() && Auth::user()->role === 'enseignant')
        <li class="nav-item {{ request()->is('mon-profil*') ? 'active' : '' }}">
            <a href="{{ route('enseignants.profile') }}" class="nav-link">
                <i class="fa-solid fa-user-tie"></i> Mon Profil
            </a>
        </li>
        <li class="nav-item {{ request()->is('notes') ? 'active' : '' }}">
            <a href="{{ route('notes.index') }}" class="nav-link">
                <i class="fa-solid fa-list"></i> Mes Notes
            </a>
        </li>
        <li class="nav-item {{ request()->is('notes/batch') ? 'active' : '' }}">
            <a href="{{ route('notes.batch') }}" class="nav-link">
                <i class="fa-solid fa-table-list"></i> Saisie Rapide (Grid)
            </a>
        </li>
        <li class="nav-item {{ request()->is('bulletins*') ? 'active' : '' }}">
            <a href="{{ route('bulletins.index') }}" class="nav-link">
                <i class="fa-solid fa-file-lines"></i> Bulletins
            </a>
        </li>
    @endif

    {{-- Menu Parent (Spécifique) --}}
    @if(Auth::check() && Auth::user()->role === 'parent')
        <li class="nav-item {{ request()->is('mon-profil*') ? 'active' : '' }}">
            <a href="{{ route('parents.profile') }}" class="nav-link">
                <i class="fa-solid fa-user-tie"></i> Mon Profil
            </a>
        </li>
        <li class="nav-item {{ request()->is('bulletins*') ? 'active' : '' }}">
            <a href="{{ route('bulletins.index') }}" class="nav-link">
                <i class="fa-solid fa-file-lines"></i> Bulletins Enfants
            </a>
        </li>
        <li class="nav-item {{ request()->is('paiements*') ? 'active' : '' }}">
            <a href="{{ route('paiements.index') }}" class="nav-link">
                <i class="fa-solid fa-money-bill-wave"></i> Factures
            </a>
        </li>
    @endif

    {{-- Menu Élève (Spécifique) --}}
    @if(Auth::check() && Auth::user()->role === 'eleve')
        <li class="nav-item {{ request()->is('mon-profil*') ? 'active' : '' }}">
            <a href="{{ route('eleves.profile') }}" class="nav-link">
                <i class="fa-solid fa-user-graduate"></i> Mon Profil
            </a>
        </li>
        <li class="nav-item {{ request()->is('notes*') ? 'active' : '' }}">
            <a href="{{ route('notes.index') }}" class="nav-link">
                <i class="fa-solid fa-book"></i> Mes Notes
            </a>
        </li>
        <li class="nav-item {{ request()->is('bulletins*') ? 'active' : '' }}">
            <a href="{{ route('bulletins.index') }}" class="nav-link">
                <i class="fa-solid fa-file"></i> Mon Bulletin
            </a>
        </li>
    @endif

    {{-- Liens Communs (Annonces & Messagerie) --}}
    <li class="nav-item mt-4 border-top pt-2 {{ request()->is('annonces*') ? 'active' : '' }}">
        <a href="{{ route('annonces.index') }}" class="nav-link">
            <i class="fa-solid fa-bullhorn"></i> Annonces
        </a>
    </li>
    <li class="nav-item {{ request()->is('messages*') ? 'active' : '' }}">
        <a href="{{ route('messages.index') }}" class="nav-link">
            <i class="fa-solid fa-comments"></i> Messagerie
        </a>
    </li>

    <li class="nav-item border-top pt-2">
        <a href="{{ route('privacy') }}" class="nav-link" style="color: rgba(255,255,255,0.7); font-size: 0.8rem;">
            <i class="fa-solid fa-shield-halved"></i> Confidentialité
        </a>
    </li>

    {{-- Déconnexion --}}
    <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-start w-100 ps-3">
                <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
            </button>
        </form>
    </li>
</ul>
