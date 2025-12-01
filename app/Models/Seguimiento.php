<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model
{
    use HasFactory;

    protected $table = 'seguimiento';
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null; // Composite key (id_seguidor, id_seguido)

    protected $fillable = [
        'id_seguidor',
        'id_seguido',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    public function seguidor()
    {
        return $this->belongsTo(User::class, 'id_seguidor', 'id_usuario');
    }

    public function seguido()
    {
        return $this->belongsTo(User::class, 'id_seguido', 'id_usuario');
    }
}
