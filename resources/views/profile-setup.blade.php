<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completa tu perfil - ConnectCat</title>
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
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="card-title">Bienvenido, {{ Auth::user()->nombre ?? Auth::user()->usuario }}!</h3>
                        <p class="text-muted">Antes de continuar, completa tu perfil para que otros usuarios puedan encontrarte.</p>

                        <form action="{{ route('profile.setup.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Usuario (handle)</label>
                                    <input type="text" name="usuario" class="form-control" value="{{ old('usuario', Auth::user()->usuario) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', Auth::user()->nombre) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Apellido paterno</label>
                                    <input type="text" name="apellido1" class="form-control" value="{{ old('apellido1', Auth::user()->apellido1) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Apellido materno</label>
                                    <input type="text" name="apellido2" class="form-control" value="{{ old('apellido2', Auth::user()->apellido2) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Fecha de nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', Auth::user()->fecha_nacimiento) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Biografía</label>
                                    <textarea name="bio" class="form-control" rows="3" placeholder="Cuéntanos sobre ti...">{{ old('bio') }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Ubicación</label>
                                    <input type="text" name="location" class="form-control" value="{{ old('location') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Sitio web</label>
                                    <input type="url" name="website" class="form-control" value="{{ old('website') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Foto de perfil</label>
                                    <input type="file" name="foto_perfil" id="foto_perfil" class="form-control" accept="image/*">
                                    <div class="mt-2" id="preview_perfil" style="display: none;">
                                        <img src="" alt="Preview" class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Foto de portada</label>
                                    <input type="file" name="foto_portada" id="foto_portada" class="form-control" accept="image/*">
                                    <div class="mt-2" id="preview_portada" style="display: none;">
                                        <img src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 100px;">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 d-flex justify-content-between">
                                <a href="{{ route('feed') }}" class="btn btn-light">Omitir por ahora</a>
                                <button class="btn btn-primary" type="submit">Guardar y continuar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3 text-muted small">
                    Puedes editar esta información más tarde en Configuración → Cuenta.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview de foto de perfil
        document.getElementById('foto_perfil').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview_perfil');
                    preview.querySelector('img').src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Preview de foto de portada
        document.getElementById('foto_portada').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview_portada');
                    preview.querySelector('img').src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
