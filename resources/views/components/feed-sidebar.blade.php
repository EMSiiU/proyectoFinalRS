{{-- Sidebar para la página del feed --}}
<aside class="col-lg-4">
    {{-- Búsqueda --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="input-group">
                <input type="text" class="form-control rounded-3" placeholder="Buscar usuarios, posts..." aria-label="Buscar">
                <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Información del usuario --}}
    @auth
        <div class="card mb-3 shadow-sm">
            <div class="card-body text-center">
                <x-user-avatar size="80" class="mb-3" />
                <h5 class="card-title mb-1">{{ Auth::user()->name }}</h5>
                <p class="text-muted small mb-3">@{{ Auth::user()->usuario ?? strtolower(str_replace(' ', '.', Auth::user()->name)) }}</p>
                <div class="row text-center small mb-3">
                    <div class="col">
                        <strong>24</strong>
                        <div class="text-muted">Publicaciones</div>
                    </div>
                    <div class="col">
                        <strong>156</strong>
                        <div class="text-muted">Seguidores</div>
                    </div>
                    <div class="col">
                        <strong>89</strong>
                        <div class="text-muted">Siguiendo</div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-primary w-100">
                    Ver perfil
                </a>
            </div>
        </div>
    @endauth

    {{-- Usuarios sugeridos --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-header bg-light">
            <h6 class="mb-0">👥 Usuarios sugeridos</h6>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                @foreach($suggestedUsers as $user)
                    <div class="list-group-item px-3 py-2 border-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex align-items-center">
                                <x-user-avatar :user="$user" size="32" class="me-2" />
                                <div class="small">
                                    <strong class="d-block">{{ $user->name }}</strong>
                                    <span class="text-muted">@ {{ $user->usuario }}</span>
                                </div>
                            </div>
                            <x-follow-button :user="$user" :small="true" />
                        </div>
                        <small class="text-muted">{{ $user->bio ?? 'Sin biografía' }}</small>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</aside>
