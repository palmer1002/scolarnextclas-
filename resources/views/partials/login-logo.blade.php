@php $extraClass = $class ?? ''; @endphp
@php $imgClass = trim(($imgClass ?? '') . ' ' . $extraClass); @endphp
@if(Auth::check())
<a href="{{ route('dashboard') }}" class="login-logo {{ $extraClass }}" title="Mon compte" style="display:inline-flex;align-items:center;color:inherit;text-decoration:none;">
    <img src="{{ asset('images/Logo.png') }}" alt="ScolarNextClas" style="width:50px;height:50px;object-fit:contain;" class="{{ $imgClass }}" />
</a>
@else
<a href="{{ route('login') }}" class="login-logo {{ $extraClass }}" title="Se connecter" style="display:inline-flex;align-items:center;color:inherit;text-decoration:none;">
    <img src="{{ asset('images/Logo.png') }}" alt="ScolarNextClas" style="width:150px;height:150px;object-fit:contain;" class="{{ $imgClass }}" />
</a>
@endif
