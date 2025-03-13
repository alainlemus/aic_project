<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $table = 'archivos';
    protected $fillable = ['nombre', 'url'];

    public function archivo()
    {
        return $this->belongsTo(Orden::class, 'orden_id');
    }

}
