<ul class="nav flex-column">

    {{-- Lien commun à tous --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fa-solid fa-house"></i> Tableau de bord
        </a>
    </li>

    {{-- Menu Admin --}}
    @if(Auth::check() && Auth::user()->role === 'admin')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('eleves.index') }}">
                <i class="fa-solid fa-user-graduate"></i> Gestion des élèves
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('enseignants.index') }}">
                <i class="fa-solid fa-chalkboard-user"></i> Gestion des enseignants
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('utilisateurs.index') }}">
                <i class="fa-solid fa-users"></i> Utilisateurs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('paiements.index') }}">
                <i class="fa-solid fa-credit-card"></i> Paiements
            </a>
        </li>
    @endif

    {{-- Menu Enseignant --}}
    @if(Auth::check() && Auth::user()->role === 'enseignant')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('notes.index') }}">
                <i class="fa-solid fa-pen-to-square"></i> Notes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('bulletins.index') }}">
                <i class="fa-solid fa-file-lines"></i> Bulletins
            </a>
        </li>
    @endif

    {{-- Menu Parent --}}
    @if(Auth::check() && Auth::user()->role === 'parent')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('bulletins.index') }}">
                <i class="fa-solid fa-file-lines"></i> Bulletins de mon enfant
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('paiements.index') }}">
                <i class="fa-solid fa-money-bill-wave"></i> Paiements
            </a>
        </li>
    @endif

    {{-- Menu Élève --}}
    @if(Auth::check() && Auth::user()->role === 'eleve')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('notes.index') }}">
                <i class="fa-solid fa-book"></i> Mes notes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('bulletins.index') }}">
                <i class="fa-solid fa-file"></i> Mon bulletin
            </a>
        </li>
    @endif

    {{-- Déconnexion --}}
    @if(Auth::check())
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-link nav-link">
                    <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
                </button>
            </form>
        </li>
    @endif

</ul>
