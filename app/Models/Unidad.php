<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unidad extends Model
{
    use HasFactory; // Agrega este trait

    protected $table = 'unidades';
    protected $fillable = ['nombre', 'municipio_id', 'observaciones', 'estado_de_fuerza', 'vehiculos', 'encargado_id'];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function elementos()
    {
        return $this->hasMany(Elemento::class, 'id_unidad');
    }

    public function encargado()
    {
        return $this->belongsTo(Elemento::class, 'encargado_id');
    }
}
