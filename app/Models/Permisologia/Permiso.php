<?php

namespace App\Models\Permisologia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Permiso extends Model
{
	use SoftDeletes, ModelsTrait;

    protected $table = 'permiso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'modulo',
        'accion',
        'descripcion'
    ];

	/**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at', 'deleted_at'
    ];

    /**
     * Obtener los roles que posee el permiso.
     */
    public function roles()
    {
        return $this->belongsToMany(Rol::class);
    }

    /**
     * Obtener los usuario que posee el permiso.
     */
    public function usuarios()
    {
        return $this->belongsToMany(\App\Usuario::class);
    }
}
