-- Agregar campos de foto de perfil, portada, y contadores de seguidores a la tabla usuario
-- Ejecuta este SQL en tu base de datos connectcat

ALTER TABLE usuario
    ADD COLUMN foto_perfil VARCHAR(255) NULL COMMENT 'Ruta de la foto de perfil',
    ADD COLUMN foto_portada VARCHAR(255) NULL COMMENT 'Ruta de la foto de portada',
    ADD COLUMN seguidores_count INT DEFAULT 0 NOT NULL COMMENT 'Cantidad de seguidores',
    ADD COLUMN seguidos_count INT DEFAULT 0 NOT NULL COMMENT 'Cantidad de usuarios seguidos';

-- Nota: Los campos foto_perfil y foto_portada son NULL para permitir usuarios sin foto
-- Los contadores inician en 0 y se actualizarán automáticamente con triggers o desde la aplicación
