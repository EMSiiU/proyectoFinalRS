<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model
{
    use HasFactory;

    protected $table = 'publicacion';
    protected $primaryKey = 'id_publicacion';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'texto',
        'multimedia',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    /**
     * Relación con el usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id_usuario');
    }

    /**
     * Relación con comentarios
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'id_publicacion', 'id_publicacion');
    }

    /**
     * Relación con likes
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'id_publicacion', 'id_publicacion');
    }
}
