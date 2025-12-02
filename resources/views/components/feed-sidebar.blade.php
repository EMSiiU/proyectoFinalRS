{{-- Sidebar para la página del feed --}}
<aside class="col-lg-4">
    {{-- Búsqueda --}}
    <div class="card mb-3 shadow-sm">
        <div class="card-body">
            <div class="position-relative">
                <div class="input-group">
                    <input type="text" 
                           id="userSearchInput" 
                           class="form-control rounded-3" 
                           placeholder="Buscar usuarios..." 
                           aria-label="Buscar"
                           autocomplete="off">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
                
                {{-- Dropdown de resultados --}}
                <div id="searchResults" 
                     class="position-absolute w-100 mt-2 bg-white border rounded-3 shadow-lg" 
                     style="display: none; z-index: 1000; max-height: 400px; overflow-y: auto;">
                    <div id="searchResultsContent"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #searchResults .search-result-item {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        
        #searchResults .search-result-item:last-child {
            border-bottom: none;
        }
        
        #searchResults .search-result-item:hover {
            background-color: #f8f9fa;
        }
        
        .search-loading {
            padding: 20px;
            text-align: center;
            color: #6c757d;
        }
        
        .search-empty {
            padding: 20px;
            text-align: center;
            color: #6c757d;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('userSearchInput');
            const searchResults = document.getElementById('searchResults');
            const searchResultsContent = document.getElementById('searchResultsContent');
            let debounceTimer;

            // Debounce function for search
            function debounce(func, wait) {
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(debounceTimer);
                        func(...args);
                    };
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(later, wait);
                };
            }

            // Perform search
            async function performSearch(query) {
                if (query.length < 2) {
                    searchResults.style.display = 'none';
                    return;
                }

                // Show loading state
                searchResults.style.display = 'block';
                searchResultsContent.innerHTML = '<div class="search-loading"><i class="bi bi-hourglass-split"></i> Buscando...</div>';

                try {
                    const response = await fetch(`{{ route('users.search') }}?q=${encodeURIComponent(query)}`);
                    const data = await response.json();

                    if (data.users.length === 0) {
                        searchResultsContent.innerHTML = `
                            <div class="search-empty">
                                <i class="bi bi-person-x fs-4 d-block mb-2"></i>
                                <small>No se encontraron usuarios</small>
                            </div>
                        `;
                    } else {
                        let html = '';
                        data.users.forEach(user => {
                            const avatarUrl = user.foto_perfil 
                                ? `{{ asset('storage/') }}/${user.foto_perfil}`
                                : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random&size=40`;
                            
                            const followButton = user.is_following
                                ? `<form action="{{ url('/users') }}/${user.id}/unfollow" method="POST" class="d-inline">
                                       @csrf
                                       @method('DELETE')
                                       <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                           <i class="bi bi-person-dash"></i> Dejar
                                       </button>
                                   </form>`
                                : `<form action="{{ url('/users') }}/${user.id}/follow" method="POST" class="d-inline">
                                       @csrf
                                       <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">
                                           <i class="bi bi-person-plus"></i> Seguir
                                       </button>
                                   </form>`;

                            html += `
                                <div class="search-result-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center flex-grow-1">
                                            <img src="${avatarUrl}" 
                                                 alt="${user.name}" 
                                                 class="rounded-circle me-3" 
                                                 width="40" 
                                                 height="40"
                                                 style="object-fit: cover;">
                                            <div>
                                                <strong class="d-block">${user.name}</strong>
                                                <small class="text-muted">@${user.usuario}</small>
                                            </div>
                                        </div>
                                        <div>
                                            ${followButton}
                                        </div>
                                    </div>
                                </div>
                            `;
                        });
                        searchResultsContent.innerHTML = html;
                    }
                } catch (error) {
                    console.error('Error searching users:', error);
                    searchResultsContent.innerHTML = `
                        <div class="search-empty text-danger">
                            <i class="bi bi-exclamation-triangle fs-4 d-block mb-2"></i>
                            <small>Error al buscar usuarios</small>
                        </div>
                    `;
                }
            }

            // Add event listener with debounce
            searchInput.addEventListener('input', debounce((e) => {
                performSearch(e.target.value.trim());
            }, 300));

            // Close results when clicking outside
            document.addEventListener('click', (e) => {
                if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                    searchResults.style.display = 'none';
                }
            });

            // Show results when clicking on input
            searchInput.addEventListener('focus', (e) => {
                if (e.target.value.trim().length >= 2) {
                    searchResults.style.display = 'block';
                }
            });
        });
    </script>

    {{-- Información del usuario --}}
    @auth
        <div class="card mb-3 shadow-sm">
            <div class="card-body text-center">
                <x-user-avatar size="80" class="mb-3" />
                <h5 class="card-title mb-1">{{ Auth::user()->name }}</h5>
                <div class="row text-center small mb-3">
                    <div class="col">
                        <strong>{{ Auth::user()->publicaciones()->count() }}</strong>
                        <div class="text-muted">Publicaciones</div>
                    </div>
                    <div class="col">
                        <strong>{{ Auth::user()->seguidores()->count() }}</strong>
                        <div class="text-muted">Seguidores</div>
                    </div>
                    <div class="col">
                        <strong>{{ Auth::user()->seguidos()->count() }}</strong>
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
                                    <span class="text-muted">@{{ $user->usuario }}</span>
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
