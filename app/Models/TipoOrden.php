<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoOrden extends Model
{
    protected $table = 'tipos_ordenes';
    protected $fillable = ['nombre'];

    public function ordenes()
    {
        return $this->hasMany(Orden::class, 'tipo_orden_id');
    }
}
