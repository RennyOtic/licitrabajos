<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Licitacion extends Model
{
	use SoftDeletes, ModelsTrait;

    protected $table = 'licitacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'descripcion',
        'slug',
        'status_id',
        'persona_id',
        'empresa_id',
        'servicio_id',
        'tiempo',
        'imagen',
        'nombre',
        'precio_minimo',
        'precio_maximo',
        'comentario',
        'evaluacion',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at', 'deleted_at'
    ];

    public function status()
    {
        return $this->belongsTo(Estatus::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function empresa()
    {
        return $this->belongsTo(\App\Usuario::class);
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }
}
