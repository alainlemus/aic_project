<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Elemento extends Model
{
    use HasFactory; // Agrega este trait

    protected $table = 'elementos';
    protected $fillable = [
        'no_empleado',
        'cargo',
        'apellido_paterno',
        'apellido_materno',
        'nombre',
        'id_unidad',
        'observaciones',
        'status',
    ];

    protected $casts = [
        'status' => 'string', // Para el ENUM
    ];

    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad');
    }

    public function ordenes()
    {
        return $this->hasMany(Orden::class, 'elemento_id');
    }
}
