<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'municipios';
    protected $fillable = ['nombre', 'codigo_postal'];

    public function unidades()
    {
        return $this->hasMany(Unidad::class, 'municipio_id');
    }
}
