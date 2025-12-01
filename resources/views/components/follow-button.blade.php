@props(['user', 'small' => false])

@php
    $isFollowing = Auth::user()->seguidos()->where('id_seguido', $user->id_usuario)->exists();
    $isSelf = Auth::id() === $user->id_usuario;
    $btnClass = $small ? 'btn-sm px-3' : 'px-4';
    $iconClass = $small ? '' : 'me-1';
@endphp

@unless($isSelf)
    @if($isFollowing)
        <form action="{{ route('users.unfollow', $user->id_usuario) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger rounded-pill {{ $btnClass }}">
                <i class="bi bi-person-dash {{ $iconClass }}"></i> {{ $small ? 'Dejar' : 'Dejar de seguir' }}
            </button>
        </form>
    @else
        <form action="{{ route('users.follow', $user->id_usuario) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary rounded-pill {{ $btnClass }}">
                <i class="bi bi-person-plus {{ $iconClass }}"></i> {{ $small ? 'Seguir' : 'Seguir' }}
            </button>
        </form>
    @endif
@endunless
