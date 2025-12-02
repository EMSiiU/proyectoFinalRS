<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - ConnectCat</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('feed') }}">
                <img src="{{ asset('images/logo.png') }}" alt="ConnectCat" class="d-inline-block" style="height: 32px; margin-right: 8px;"> ConnectCat
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('feed') }}">
                            <i class="bi bi-house-fill"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="bi bi-search"></i> Explorar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('notifications') }}">
                            <i class="bi bi-bell-fill"></i> Notificaciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messages') }}">
                            <i class="bi bi-envelope-fill"></i> Mensajes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">
                            <i class="bi bi-person-fill"></i> Perfil
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-gear-fill"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><span class="dropdown-item-text">{{ Auth::user()->name }}</span></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person"></i> Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('settings') }}">
                                    <i class="bi bi-gear"></i> Configuración
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-4">
        <div class="row">
            <!-- Publicaciones del feed -->
            <div class="col-lg-8">
                <!-- Encabezado del feed -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <h2 class="card-title mb-0">🏠 Inicio</h2>
                    </div>
                </div>

                <!-- Mensajes de éxito/error -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Formulario para crear publicación -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('posts.store') }}" method="POST">
                            @csrf
                            <div class="d-flex gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                                     alt="{{ Auth::user()->name }}" class="rounded-circle flex-shrink-0" width="48" height="48">
                                <div class="flex-grow-1">
                                    <textarea name="texto" 
                                              class="form-control form-control-lg border-0 ps-0 @error('texto') is-invalid @enderror" 
                                              placeholder="¿En qué estás pensando?" 
                                              rows="3" 
                                              style="resize: none;">{{ old('texto') }}</textarea>
                                    <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top">
                                        <button type="button" class="btn btn-sm btn-light text-muted" disabled>
                                            <i class="bi bi-image"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light text-muted" disabled>
                                            <i class="bi bi-emoji-smile"></i>
                                        </button>
                                        <button type="submit" class="btn btn-primary rounded-pill px-4">Publicar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Publicaciones -->
                @forelse($publicaciones as $publicacion)
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex gap-3 mb-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($publicacion->usuario->name) }}&background=random" 
                                     alt="{{ $publicacion->usuario->name }}" class="rounded-circle flex-shrink-0" width="48" height="48">
                                <div class="flex-grow-1">
                                    <strong>{{ $publicacion->usuario->name }}</strong>
                                    <small class="text-muted d-block">@{{ $publicacion->usuario->usuario }} • {{ $publicacion->fecha->diffForHumans() }}</small>
                                </div>
                                @if($publicacion->id_usuario === Auth::id())
                                    <button class="btn btn-sm btn-light">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                @endif
                            </div>
                            <p class="card-text mb-3">{{ $publicacion->texto }}</p>
                            
                            @if($publicacion->multimedia)
                                <div class="ratio ratio-16x9 mb-3 bg-secondary rounded" style="background: url('{{ asset('storage/' . $publicacion->multimedia) }}') center/cover;"></div>
                            @endif
                            
                            <div class="d-flex justify-content-between text-muted small">
                                <form action="{{ route('posts.like', $publicacion->id_publicacion) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light {{ $publicacion->user_has_liked ? 'text-danger' : 'text-muted' }}">
                                        <i class="bi {{ $publicacion->user_has_liked ? 'bi-heart-fill' : 'bi-heart' }}"></i> {{ $publicacion->likes->count() }}
                                    </button>
                                </form>
                                <button class="btn btn-sm btn-light text-muted">
                                    <i class="bi bi-chat"></i> {{ $publicacion->comentarios->count() }}
                                </button>
                                <button class="btn btn-sm btn-light text-muted">
                                    <i class="bi bi-share"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted d-block mb-3"></i>
                            <h5 class="text-muted">No hay publicaciones aún</h5>
                            <p class="text-muted mb-0">¡Sé el primero en publicar algo o sigue a otros usuarios para ver sus publicaciones!</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Sidebar (componente dedicado) -->
            @include('components.feed-sidebar')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
