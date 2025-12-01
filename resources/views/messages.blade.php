<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes - ConnectCat</title>
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .messages-container {
            display: flex;
            height: calc(100vh - 120px);
        }
        .conversations-list {
            flex: 0 0 35%;
            border-right: 1px solid #e5e7eb;
            overflow-y: auto;
        }
        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
        }
        .chat-header {
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .message-group {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .message-group.sent {
            justify-content: flex-end;
        }
        .message-group.received {
            justify-content: flex-start;
        }
        .message-bubble {
            padding: 0.75rem 1rem;
            border-radius: 18px;
            max-width: 60%;
            word-wrap: break-word;
        }
        .message-bubble.sent {
            background-color: #1d9bf0;
            color: white;
        }
        .message-bubble.received {
            background-color: #eff3f4;
            color: #0f1419;
        }
        .message-time {
            font-size: 0.75rem;
            color: #657786;
            margin-top: 0.25rem;
        }
        .chat-input-area {
            border-top: 1px solid #e5e7eb;
            padding: 1rem;
        }
        .conversation-item {
            padding: 1rem;
            border-bottom: 1px solid #e5e7eb;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .conversation-item:hover {
            background-color: #f7f9fa;
        }
        .conversation-item.active {
            background-color: #f0f9ff;
            border-left: 4px solid #1d9bf0;
        }
        .no-conversation {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #657786;
        }
        @media (max-width: 768px) {
            .conversations-list {
                flex: 0 0 100%;
                display: none;
            }
            .conversations-list.active {
                display: block;
                flex: 0 0 100%;
            }
            .chat-window {
                flex: 1;
            }
            .message-bubble {
                max-width: 85%;
            }
        }
    </style>
</head>
<body class="bg-light">
    <!-- Barra de Navegación -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm sticky-top">
        <div class="container-fluid">
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
                        <a class="nav-link active" href="{{ route('messages') }}">
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

    <div class="container-fluid messages-container">
        <!-- Lista de Conversaciones -->
        <div class="conversations-list bg-white">
            <!-- Encabezado de mensajes -->
            <div class="p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">✉️ Mensajes</h5>
                    <button class="btn btn-sm btn-light">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control bg-light border-0" placeholder="Buscar conversaciones...">
                </div>
            </div>

            <!-- Conversaciones -->
            @forelse($seguidos as $seguido)
                <div class="conversation-item {{ (isset($selectedUser) && $selectedUser->id_usuario == $seguido->id_usuario) ? 'active' : '' }}" 
                     onclick="window.location.href='{{ route('messages', ['id' => $seguido->id_usuario]) }}'">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3 flex-grow-1">
                            <x-user-avatar :user="$seguido" size="48" />
                            <div class="flex-grow-1 min-width-0">
                                <div class="d-flex justify-content-between">
                                    <strong class="d-block">{{ $seguido->name }}</strong>
                                    <small class="text-muted">
                                        {{-- Mostrar hora del último mensaje si existiera --}}
                                    </small>
                                </div>
                                <small class="text-muted text-truncate d-block">
                                    {{-- Mostrar último mensaje si existiera --}}
                                    Haz clic para ver la conversación
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="no-conversation p-4 text-center">
                    <i class="bi bi-people display-4 mb-3"></i>
                    <p>No sigues a nadie aún.</p>
                    <a href="{{ route('feed') }}" class="btn btn-primary btn-sm">Buscar personas</a>
                </div>
            @endforelse
        </div>

        <!-- Ventana de Chat -->
        <div class="chat-window">
            <!-- Encabezado del Chat -->
            <div class="chat-header d-flex justify-content-between align-items-center">
                @if($selectedUser)
                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-sm btn-light d-lg-none" onclick="toggleConversationsList()">
                            <i class="bi bi-arrow-left"></i>
                        </button>
                        <x-user-avatar :user="$selectedUser" size="40" />
                        <div>
                            <h6 class="mb-0">{{ $selectedUser->name }}</h6>
                            <small class="text-muted">@ {{ $selectedUser->usuario }}</small>
                        </div>
                    </div>
                    <div class="btn-group" role="group">
                        <button class="btn btn-sm btn-light">
                            <i class="bi bi-info-circle"></i>
                        </button>
                    </div>
                @else
                    <div class="d-flex align-items-center gap-3">
                        <h6 class="mb-0">Selecciona una conversación</h6>
                    </div>
                @endif
            </div>

            <!-- Mensajes -->
            <div class="chat-messages">
                @if($selectedUser)
                    @forelse($messages as $mensaje)
                        <div class="message-group {{ $mensaje->id_emisor == Auth::id() ? 'sent' : 'received' }}">
                            <div>
                                <div class="message-bubble {{ $mensaje->id_emisor == Auth::id() ? 'sent' : 'received' }}">
                                    {{ $mensaje->mensaje }}
                                </div>
                                <div class="message-time text-end">
                                    {{ $mensaje->fecha ? $mensaje->fecha->format('H:i') : '' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted mt-5">
                            <i class="bi bi-chat-dots display-4"></i>
                            <p class="mt-3">No hay mensajes aún. ¡Saluda!</p>
                        </div>
                    @endforelse
                @else
                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                        <i class="bi bi-chat-square-text display-1 mb-3"></i>
                        <h4>Tus Mensajes</h4>
                        <p>Selecciona una conversación para comenzar a chatear</p>
                    </div>
                @endif
            </div>

            <!-- Área de Entrada -->
            <div class="chat-input-area">
                @if($selectedUser)
                    <form action="{{ route('messages.store') }}" method="POST" class="input-group">
                        @csrf
                        <input type="hidden" name="id_receptor" value="{{ $selectedUser->id_usuario }}">
                        
                        <button class="btn btn-light" type="button">
                            <i class="bi bi-paperclip"></i>
                        </button>
                        <input type="text" name="mensaje" class="form-control border" placeholder="Escribe un mensaje..." required autocomplete="off">
                        <button class="btn btn-light" type="button">
                            <i class="bi bi-emoji-smile"></i>
                        </button>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                @else
                    <div class="input-group">
                        <button class="btn btn-light" type="button" disabled>
                            <i class="bi bi-paperclip"></i>
                        </button>
                        <input type="text" class="form-control border" placeholder="Selecciona una conversación para escribir..." disabled>
                        <button class="btn btn-light" type="button" disabled>
                            <i class="bi bi-emoji-smile"></i>
                        </button>
                        <button class="btn btn-primary" type="button" disabled>
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        function selectConversation(element) {
            // Remover clase active de todos
            document.querySelectorAll('.conversation-item').forEach(item => {
                item.classList.remove('active');
            });
            // Agregar clase active al elemento clickeado
            element.classList.add('active');
            
            // En mobile, ocultar lista y mostrar chat
            if (window.innerWidth < 992) {
                toggleConversationsList();
            }
        }

        function toggleConversationsList() {
            const list = document.querySelector('.conversations-list');
            list.classList.toggle('active');
        }

        // Auto-scroll al final de los mensajes
        window.addEventListener('load', () => {
            const chatMessages = document.querySelector('.chat-messages');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });
    </script>
</body>
</html>
