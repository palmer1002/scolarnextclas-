@php 
    $extraClass = $class ?? ''; 
    $imgClass = trim(($imgClass ?? '') . ' ' . $extraClass);
    $width = $width ?? (Auth::check() ? '60px' : '180px');
    $height = $height ?? (Auth::check() ? '60px' : '180px');
@endphp

@if(Auth::check())
<a href="{{ route('dashboard') }}" class="login-logo {{ $extraClass }}" title="Mon compte" style="display:inline-flex;align-items:center;color:inherit;text-decoration:none;">
    <img src="{{ asset('images/Logo.png') }}" alt="ScolarNextClas" style="width:{{ $width }};height:{{ $height }};object-fit:contain;" class="{{ $imgClass }}" />
</a>
@else
<a href="{{ route('login') }}" class="login-logo {{ $extraClass }}" title="Se connecter" style="display:inline-flex;align-items:center;color:inherit;text-decoration:none;">
    <img src="{{ asset('images/Logo.png') }}" alt="ScolarNextClas" style="width:{{ $width }};height:{{ $height }};object-fit:contain;" class="{{ $imgClass }}" />
</a>
@endif
