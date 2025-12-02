<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - ConnectCat</title>
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
                        <a class="nav-link" href="{{ route('feed') }}">
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
                        <a class="nav-link active" href="{{ route('profile.edit') }}">
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
            <!-- Contenido Principal del Perfil -->
            <div class="col-12">
                <!-- Portada y Avatar -->
                <div class="card mb-4 shadow-sm border-0 overflow-hidden">
                    <!-- Banner de portada -->
                    @if(Auth::user()->foto_portada)
                        <div style="height: 200px; background: url('{{ asset('storage/' . Auth::user()->foto_portada) }}') center/cover;">
                        </div>
                    @else
                        <div style="height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);"></div>
                    @endif
                    
                    <div class="card-body">
                        @php
                            $fullName = trim(Auth::user()->nombre . ' ' . (Auth::user()->apellido1 ?? '') . ' ' . (Auth::user()->apellido2 ?? ''));
                            $username = Auth::user()->usuario ?? strtolower(str_replace(' ', '.', $fullName));
                        @endphp
                        
                        <div class="d-flex justify-content-between align-items-start" style="margin-top: -100px; position: relative; z-index: 10;">
                            @if(Auth::user()->foto_perfil)
                                <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" 
                                     alt="{{ $fullName }}" class="rounded-circle border border-4 border-white" width="128" height="128" style="object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($fullName) }}&background=random&size=128" 
                                     alt="{{ $fullName }}" class="rounded-circle border border-4 border-white" width="128" height="128">
                            @endif
                            @if(Auth::id() === $user->id_usuario)
                                <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary rounded-pill">
                                    <i class="bi bi-pencil"></i> Editar perfil
                                </a>
                            @else
                                <x-follow-button :user="$user" />
                            @endif
                        </div>

                        <div class="mt-3">
                            <h2 class="mb-0 fw-bold">{{ $fullName }}</h2>
                            <p class="text-muted mb-3">@{{ $username }}</p>
                            
                            <p class="mb-3">
                                @if(isset(Auth::user()->location) && Auth::user()->location)
                                    <i class="bi bi-geo-alt"></i> {{ Auth::user()->location }}
                                    <span class="mx-2">•</span>
                                @endif
                                @if(isset(Auth::user()->website) && Auth::user()->website)
                                    <i class="bi bi-link-45deg"></i> 
                                    <a href="{{ Auth::user()->website }}" class="text-decoration-none" target="_blank">{{ parse_url(Auth::user()->website, PHP_URL_HOST) ?? Auth::user()->website }}</a>
                                    <span class="mx-2">•</span>
                                @endif
                                <i class="bi bi-calendar3"></i> Se unió en {{ Auth::user()->created_at ? Auth::user()->created_at->locale('es')->isoFormat('MMMM [de] YYYY') : 'Noviembre de 2024' }}
                            </p>

                            <p class="text-muted">
                                {{ Auth::user()->bio ?? 'Este usuario aún no ha agregado una biografía.' }}
                            </p>

                            <div class="d-flex gap-4 mb-3">
                                <div>
                                    <strong>{{ Auth::user()->seguidos_count ?? 0 }}</strong>
                                    <div class="text-muted small">Siguiendo</div>
                                </div>
                                <div>
                                    <strong>{{ Auth::user()->seguidores_count ?? 0 }}</strong>
                                    <div class="text-muted small">Seguidores</div>
                                </div>
                                <div>
                                    <strong>{{ $publicaciones->total() ?? 0 }}</strong>
                                    <div class="text-muted small">Publicaciones</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestañas de contenido -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-0">
                        <ul class="nav nav-underline" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts" type="button" role="tab" aria-controls="posts" aria-selected="true">
                                    <i class="bi bi-chat-left-text"></i> Publicaciones
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="replies-tab" data-bs-toggle="tab" data-bs-target="#replies" type="button" role="tab" aria-controls="replies" aria-selected="false">
                                    <i class="bi bi-reply"></i> Respuestas
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="likes-tab" data-bs-toggle="tab" data-bs-target="#likes" type="button" role="tab" aria-controls="likes" aria-selected="false">
                                    <i class="bi bi-heart"></i> Me gusta
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="media-tab" data-bs-toggle="tab" data-bs-target="#media" type="button" role="tab" aria-controls="media" aria-selected="false">
                                    <i class="bi bi-images"></i> Media
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Contenido de Pestañas -->
                <div class="tab-content">
                    <!-- Publicaciones -->
                    <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                        @forelse($publicaciones as $publicacion)
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex gap-3 mb-3">
                                        <x-user-avatar size="48" />
                                        <div class="flex-grow-1">
                                            <strong>{{ $fullName }}</strong>
                                            <small class="text-muted d-block">@{{ $username }} • {{ $publicacion->fecha->diffForHumans() }}</small>
                                        </div>
                                        <button class="btn btn-sm btn-light">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                    </div>
                                    <p class="card-text mb-3">{{ $publicacion->texto }}</p>
                                    @if($publicacion->multimedia)
                                        <div class="ratio ratio-16x9 mb-3 bg-secondary rounded" 
                                             style="background: url('{{ asset('storage/' . $publicacion->multimedia) }}') center/cover;">
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-between text-muted small">
                                        <button class="btn btn-sm btn-light text-muted">
                                            <i class="bi bi-heart"></i> {{ $publicacion->likes_count ?? 0 }}
                                        </button>
                                        <button class="btn btn-sm btn-light text-muted">
                                            <i class="bi bi-chat"></i> {{ $publicacion->comentarios_count ?? 0 }}
                                        </button>
                                        <button class="btn btn-sm btn-light text-muted">
                                            <i class="bi bi-share"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center py-5">
                                <i class="bi bi-info-circle display-6"></i>
                                <p class="mt-3 mb-0">No has publicado nada aún</p>
                            </div>
                        @endforelse
                        
                        <div class="mt-4">
                            {{ $publicaciones->links() }}
                        </div>
                    </div>

                    <!-- Respuestas -->
                    <div class="tab-pane fade" id="replies" role="tabpanel" aria-labelledby="replies-tab">
                        @forelse($commentedPosts as $commentedPost)
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-body">
                                    <!-- Original Post -->
                                    <div class="d-flex gap-3 mb-3">
                                        <x-user-avatar :user="$commentedPost->usuario" size="48" />
                                        <div class="flex-grow-1">
                                            <strong>{{ $commentedPost->usuario->name }}</strong>
                                            <small class="text-muted d-block">@{{ $commentedPost->usuario->usuario }} • {{ $commentedPost->fecha->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <p class="card-text mb-3">{{ $commentedPost->texto }}</p>
                                    @if($commentedPost->multimedia)
                                        <div class="ratio ratio-16x9 mb-3 bg-secondary rounded" 
                                             style="background: url('{{ asset('storage/' . $commentedPost->multimedia) }}') center/cover;">
                                        </div>
                                    @endif
                                    
                                    <!-- User's Comment Highlighted -->
                                    @if($commentedPost->user_comment)
                                        <div class="border-start border-primary border-3 ps-3 bg-light rounded p-3 mb-3">
                                            <div class="d-flex gap-2 align-items-start">
                                                <i class="bi bi-reply-fill text-primary"></i>
                                                <div class="flex-grow-1">
                                                    <small class="text-muted d-block mb-1">Tu respuesta:</small>
                                                    <p class="mb-0">{{ $commentedPost->user_comment->comentario }}</p>
                                                    <small class="text-muted">{{ $commentedPost->user_comment->fecha->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="d-flex justify-content-between text-muted small">
                                        <span>
                                            <i class="bi bi-heart"></i> {{ $commentedPost->likes_count }}
                                        </span>
                                        <span>
                                            <i class="bi bi-chat"></i> {{ $commentedPost->comentarios_count }}
                                        </span>
                                        <span>
                                            <i class="bi bi-share"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center py-5">
                                <i class="bi bi-chat-left display-6"></i>
                                <p class="mt-3 mb-0">No has comentado en ninguna publicación aún</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Me gusta -->
                    <div class="tab-pane fade" id="likes" role="tabpanel" aria-labelledby="likes-tab">
                        @forelse($likedPosts as $likedPost)
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-body">
                                    <div class="d-flex gap-3 mb-3">
                                        <x-user-avatar :user="$likedPost->usuario" size="48" />
                                        <div class="flex-grow-1">
                                            <strong>{{ $likedPost->usuario->name }}</strong>
                                            <small class="text-muted d-block">@{{ $likedPost->usuario->usuario }} • {{ $likedPost->fecha->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <p class="card-text mb-3">{{ $likedPost->texto }}</p>
                                    @if($likedPost->multimedia)
                                        <div class="ratio ratio-16x9 mb-3 bg-secondary rounded" 
                                             style="background: url('{{ asset('storage/' . $likedPost->multimedia) }}') center/cover;">
                                        </div>
                                    @endif
                                    <div class="d-flex justify-content-between text-muted small">
                                        <form action="{{ route('posts.like', $likedPost->id_publicacion) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-light text-danger">
                                                <i class="bi bi-heart-fill"></i> {{ $likedPost->likes_count }}
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-light text-muted">
                                            <i class="bi bi-chat"></i> {{ $likedPost->comentarios_count }}
                                        </button>
                                        <button class="btn btn-sm btn-light text-muted">
                                            <i class="bi bi-share"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center py-5">
                                <i class="bi bi-heart display-6"></i>
                                <p class="mt-3 mb-0">No has dado like a ninguna publicación aún</p>
                            </div>
                        @endforelse
                        
                        @if($likedPosts->hasPages())
                            <div class="mt-4">
                                {{ $likedPosts->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Media -->
                    <div class="tab-pane fade" id="media" role="tabpanel" aria-labelledby="media-tab">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=300" alt="Imagen" class="img-fluid rounded shadow-sm">
                            </div>
                            <div class="col-md-6">
                                <img src="https://images.unsplash.com/photo-1633356122544-f134324ef6db?w=300" alt="Imagen" class="img-fluid rounded shadow-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
</body>

</html>
