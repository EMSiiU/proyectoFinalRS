@props(['user' => null, 'size' => '48', 'class' => ''])

@php
    $user = $user ?? Auth::user();
    $fullName = trim(($user->nombre ?? '') . ' ' . ($user->apellido1 ?? '') . ' ' . ($user->apellido2 ?? ''));
    if (empty($fullName)) {
        $fullName = $user->usuario ?? $user->email ?? 'Usuario';
    }
@endphp

@if($user && $user->foto_perfil)
    <img src="{{ asset('storage/' . $user->foto_perfil) }}" 
         alt="{{ $fullName }}" 
         width="{{ $size }}" 
         height="{{ $size }}" 
         {{ $attributes->merge(['class' => 'rounded-circle ' . $class]) }}
         style="object-fit: cover;">
@else
    <img src="https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background=random&size={{ $size }}" 
         alt="{{ $fullName }}" 
         width="{{ $size }}" 
         height="{{ $size }}" 
         {{ $attributes->merge(['class' => 'rounded-circle ' . $class]) }}>
@endif
