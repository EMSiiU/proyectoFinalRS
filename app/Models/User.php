<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'usuario',
        'email',
        'contrasena',
        'nombre',
        'apellido1',
        'apellido2',
        'fecha_nacimiento',
        'foto_perfil',
        'foto_portada',
        'seguidores_count',
        'seguidos_count',
    ];

    protected $hidden = [
        'contrasena',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */


    /**
     * Get the password for authentication.
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }



    /**
     * Password accessor - Laravel expects 'password' attribute.
     */
    public function getPasswordAttribute()
    {
        return $this->contrasena;
    }

    /**
     * Password mutator - ensure hashing when setting password.
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['contrasena'] = bcrypt($value);
    }

    /**
     * Name accessor - combine nombre, apellido1, apellido2.
     */
    public function getNameAttribute()
    {
        return trim("{$this->nombre} {$this->apellido1} {$this->apellido2}");
    }


    /**
     * Relación con publicaciones del usuario
     */
    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'id_usuario', 'id_usuario')->orderBy('fecha', 'desc');
    }

    /**
     * Relación con comentarios del usuario
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con likes del usuario
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con mensajes enviados
     */
    public function mensajesEnviados()
    {
        return $this->hasMany(Mensaje::class, 'id_emisor', 'id_usuario');
    }

    /**
     * Relación con mensajes recibidos
     */
    public function mensajesRecibidos()
    {
        return $this->hasMany(Mensaje::class, 'id_receptor', 'id_usuario');
    }

    /**
     * Usuarios que siguen a este usuario
     */
    public function seguidores()
    {
        return $this->belongsToMany(User::class, 'seguimiento', 'id_seguido', 'id_seguidor')
                    ->withPivot('fecha');
    }

    /**
     * Usuarios que este usuario sigue
     */
    public function seguidos()
    {
        return $this->belongsToMany(User::class, 'seguimiento', 'id_seguidor', 'id_seguido')
                    ->withPivot('fecha');
    }

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'contrasena' => 'hashed',
            'fecha_nacimiento' => 'date',
            'seguidores_count' => 'integer',
            'seguidos_count' => 'integer',
        ];
    }
}
