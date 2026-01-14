<ul>
    {{-- Tableau de bord (Commun) --}}
    <li class="{{ request()->is('/') || request()->is('dashboard*') ? 'active' : '' }}">
        <a href="{{ route('dashboard') }}">
            <i class="fa-solid fa-house"></i> Tableau de bord
        </a>
    </li>

    {{-- Menu Administration & Gestion (Admin & Secrétaire) --}}
    @if(Auth::check() && in_array(Auth::user()->role, ['admin', 'secretaire']))
        <li class="{{ request()->is('eleves*') ? 'active' : '' }}">
            <a href="{{ route('eleves.index') }}">
                <i class="fa-solid fa-user-graduate"></i> Élèves
            </a>
        </li>
        <li class="{{ request()->is('enseignants*') ? 'active' : '' }}">
            <a href="{{ route('enseignants.index') }}">
                <i class="fa-solid fa-chalkboard-user"></i> Enseignants
            </a>
        </li>
        <li class="{{ request()->is('parents*') ? 'active' : '' }}">
            <a href="{{ route('parents.index') }}">
                <i class="fa-solid fa-users"></i> Parents
            </a>
        </li>
        <li class="{{ request()->is('paiements*') ? 'active' : '' }}">
            <a href="{{ route('paiements.index') }}">
                <i class="fa-solid fa-credit-card"></i> Paiements
            </a>
        </li>
        <li class="{{ request()->is('matieres*') ? 'active' : '' }}">
            <a href="{{ route('matieres.index') }}">
                <i class="fa-solid fa-book-open"></i> Matières
            </a>
        </li>
        <li class="{{ request()->is('classes*') ? 'active' : '' }}">
            <a href="{{ route('classes.index') }}">
                <i class="fa-solid fa-chalkboard"></i> Classes
            </a>
        </li>
        <li class="{{ request()->is('notes*') ? 'active' : '' }}">
            <a href="{{ route('notes.index') }}">
                <i class="fa-solid fa-pen-to-square"></i> Notes & Évaluations
            </a>
        </li>
        <li class="{{ request()->is('bulletins*') ? 'active' : '' }}">
            <a href="{{ route('bulletins.index') }}">
                <i class="fa-solid fa-file-lines"></i> Gestion Bulletins
            </a>
        </li>
        
        @if(Auth::user()->role === 'admin')
            <li class="{{ request()->is('utilisateurs*') ? 'active' : '' }}">
                <a href="{{ route('utilisateurs.index') }}">
                    <i class="fa-solid fa-user-shield"></i> Administration
                </a>
            </li>
        @endif
    @endif

    {{-- Menu Enseignant (Spécifique) --}}
    @if(Auth::check() && Auth::user()->role === 'enseignant')
        <li class="{{ request()->is('notes*') ? 'active' : '' }}">
            <a href="{{ route('notes.index') }}">
                <i class="fa-solid fa-pen-to-square"></i> Mes Notes
            </a>
        </li>
        <li class="{{ request()->is('bulletins*') ? 'active' : '' }}">
            <a href="{{ route('bulletins.index') }}">
                <i class="fa-solid fa-file-lines"></i> Bulletins
            </a>
        </li>
    @endif

    {{-- Menu Parent (Spécifique) --}}
    @if(Auth::check() && Auth::user()->role === 'parent')
        <li class="{{ request()->is('bulletins*') ? 'active' : '' }}">
            <a href="{{ route('bulletins.index') }}">
                <i class="fa-solid fa-file-lines"></i> Bulletins Enfants
            </a>
        </li>
        <li class="{{ request()->is('paiements*') ? 'active' : '' }}">
            <a href="{{ route('paiements.index') }}">
                <i class="fa-solid fa-money-bill-wave"></i> Factures
            </a>
        </li>
    @endif

    {{-- Menu Élève (Spécifique) --}}
    @if(Auth::check() && Auth::user()->role === 'eleve')
        <li class="{{ request()->is('notes*') ? 'active' : '' }}">
            <a href="{{ route('notes.index') }}">
                <i class="fa-solid fa-book"></i> Mes Notes
            </a>
        </li>
        <li class="{{ request()->is('bulletins*') ? 'active' : '' }}">
            <a href="{{ route('bulletins.index') }}">
                <i class="fa-solid fa-file"></i> Mon Bulletin
            </a>
        </li>
    @endif

    {{-- Déconnexion --}}
    <li>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background:none; border:none; color:white; padding: 0; display: flex; align-items: center; cursor: pointer; width: 100%;">
                <i class="fa-solid fa-right-from-bracket" style="margin-right: 10px; width: 20px; text-align: center;"></i> Déconnexion
            </button>
        </form>
    </li>
</ul>
