<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensaje';
    protected $primaryKey = 'id_mensaje';
    public $timestamps = false;

    protected $fillable = [
        'id_emisor',
        'id_receptor',
        'mensaje',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function emisor()
    {
        return $this->belongsTo(User::class, 'id_emisor', 'id_usuario');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'id_receptor', 'id_usuario');
    }
}
