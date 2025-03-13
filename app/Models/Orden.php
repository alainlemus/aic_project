<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table = 'ordenes';
    protected $fillable = ['nombre', 'status', 'tipo_orden_id', 'elemento_id'];

    protected $casts = [
        'status' => 'string', // Para el ENUM
    ];

    public function tipoOrden()
    {
        return $this->belongsTo(TipoOrden::class, 'tipo_orden_id');
    }

    public function elemento()
    {
        return $this->belongsTo(Elemento::class, 'elemento_id');
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'orden_id');
    }
}
