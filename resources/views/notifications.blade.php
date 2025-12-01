<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificaciones - ConnectCat</title>
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
                        <a class="nav-link active" href="{{ route('notifications') }}">
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
            <!-- Notificaciones -->
            <div class="col-lg-8">
                <!-- Encabezado de notificaciones -->
                <div class="card mb-4 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h2 class="card-title mb-0">🔔 Notificaciones</h2>
                            <div class="btn-group" role="group" aria-label="Filtro de notificaciones">
                                <input type="radio" class="btn-check" name="notifFilter" id="filterAll" checked>
                                <label class="btn btn-sm btn-outline-primary" for="filterAll">Todas</label>
                                
                                <input type="radio" class="btn-check" name="notifFilter" id="filterMentions">
                                <label class="btn btn-sm btn-outline-primary" for="filterMentions">Menciones</label>
                                
                                <input type="radio" class="btn-check" name="notifFilter" id="filterLikes">
                                <label class="btn btn-sm btn-outline-primary" for="filterLikes">Me gusta</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificación: Nuevo seguidor -->
                <div class="card mb-3 shadow-sm border-0 border-start border-primary border-5">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Juan+Carlos&background=random" 
                                 alt="Juan Carlos" class="rounded-circle flex-shrink-0" width="48" height="48">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>Juan Carlos</strong>
                                        <span class="text-muted ms-2">@juan.carlos</span>
                                        <div class="small text-muted">Comenzó a seguirte</div>
                                    </div>
                                    <small class="text-muted">Hace 5 minutos</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-primary rounded-pill">Seguir</button>
                                    <button class="btn btn-sm btn-light text-muted">Descartar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificación: Me gusta en publicación -->
                <div class="card mb-3 shadow-sm border-0 border-start border-success border-5">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=María+López&background=random" 
                                 alt="María López" class="rounded-circle flex-shrink-0" width="48" height="48">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>María López</strong>
                                        <span class="text-muted ms-2">@maria.lopez</span>
                                        <div class="small text-muted">Le gustó tu publicación</div>
                                    </div>
                                    <small class="text-muted">Hace 23 minutos</small>
                                </div>
                                <div class="bg-light p-3 rounded mb-2">
                                    <small class="text-muted"><i class="bi bi-quote"></i> "Acabo de terminar un proyecto increíble con Laravel. ¡Los componentes de Blade son fantásticos! 🚀"</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light">
                                        <i class="bi bi-heart-fill text-danger"></i> 234 me gusta
                                    </button>
                                    <button class="btn btn-sm btn-light text-muted">Descartar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificación: Comentario en publicación -->
                <div class="card mb-3 shadow-sm border-0 border-start border-info border-5">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Pedro+García&background=random" 
                                 alt="Pedro García" class="rounded-circle flex-shrink-0" width="48" height="48">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>Pedro García</strong>
                                        <span class="text-muted ms-2">@pedro.garcia</span>
                                        <div class="small text-muted">Comentó en tu publicación</div>
                                    </div>
                                    <small class="text-muted">Hace 1 hora</small>
                                </div>
                                <div class="bg-light p-3 rounded mb-2">
                                    <small class="text-muted"><i class="bi bi-chat-left-text"></i> <strong>Su comentario:</strong> "¡Excelente trabajo! Blade es realmente potente para crear componentes reutilizables."</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light">Ver publicación</button>
                                    <button class="btn btn-sm btn-light text-muted">Descartar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificación: Mención -->
                <div class="card mb-3 shadow-sm border-0 border-start border-warning border-5">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Ana+Martínez&background=random" 
                                 alt="Ana Martínez" class="rounded-circle flex-shrink-0" width="48" height="48">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>Ana Martínez</strong>
                                        <span class="text-muted ms-2">@ana.martinez</span>
                                        <div class="small text-muted">Te mencionó en una publicación</div>
                                    </div>
                                    <small class="text-muted">Hace 2 horas</small>
                                </div>
                                <div class="bg-light p-3 rounded mb-2">
                                    <small class="text-muted"><i class="bi bi-at"></i> "¿Qué opinan @juan.carlos y @usuario sobre el nuevo framework de CSS?"</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light">Ver publicación</button>
                                    <button class="btn btn-sm btn-light text-muted">Descartar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificación: Nuevo seguidor -->
                <div class="card mb-3 shadow-sm border-0 border-start border-primary border-5">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Carlos+López&background=random" 
                                 alt="Carlos López" class="rounded-circle flex-shrink-0" width="48" height="48">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>Carlos López</strong>
                                        <span class="text-muted ms-2">@carlos.lopez</span>
                                        <div class="small text-muted">Comenzó a seguirte</div>
                                    </div>
                                    <small class="text-muted">Hace 3 horas</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-primary rounded-pill">Seguir</button>
                                    <button class="btn btn-sm btn-light text-muted">Descartar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificación: Compartieron tu publicación -->
                <div class="card mb-3 shadow-sm border-0 border-start border-danger border-5">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Sofia+Ruiz&background=random" 
                                 alt="Sofía Ruiz" class="rounded-circle flex-shrink-0" width="48" height="48">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>Sofía Ruiz</strong>
                                        <span class="text-muted ms-2">@sofia.ruiz</span>
                                        <div class="small text-muted">Compartió tu publicación</div>
                                    </div>
                                    <small class="text-muted">Hace 4 horas</small>
                                </div>
                                <div class="bg-light p-3 rounded mb-2">
                                    <small class="text-muted"><i class="bi bi-share"></i> "Tips para optimizar tu CSS y mejorar el rendimiento de tu sitio web. #WebDevelopment #CSS #Performance"</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light">Ver publicación</button>
                                    <button class="btn btn-sm btn-light text-muted">Descartar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notificación antigua -->
                <div class="card mb-3 shadow-sm border-0 border-start border-secondary border-5 opacity-75">
                    <div class="card-body">
                        <div class="d-flex gap-3">
                            <img src="https://ui-avatars.com/api/?name=Luis+Fernández&background=random" 
                                 alt="Luis Fernández" class="rounded-circle flex-shrink-0" width="48" height="48">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <strong>Luis Fernández</strong>
                                        <span class="text-muted ms-2">@luis.fernandez</span>
                                        <div class="small text-muted">Te mencionó en una publicación</div>
                                    </div>
                                    <small class="text-muted">Hace 1 día</small>
                                </div>
                                <div class="bg-light p-3 rounded mb-2">
                                    <small class="text-muted"><i class="bi bi-at"></i> "@usuario ¿Cuál es tu herramienta favorita para desarrollo web?"</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-light">Ver publicación</button>
                                    <button class="btn btn-sm btn-light text-muted">Descartar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            @include('components.feed-sidebar')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
