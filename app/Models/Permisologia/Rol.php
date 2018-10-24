<?php

namespace App\Models\Permisologia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Rol extends Model
{
	use SoftDeletes, ModelsTrait;

    protected $table = 'rol';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'slug',
        'descripcion',
        'desde_at',
        'hasta_at',
        'especial'
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
     * Obtener los usuarios que posee el rol.
     */
    public function usuarios()
    {
        return $this->belongsToMany(\App\Usuario::class);
    }

    /**
     * Obtener los roles que posee el rol.
     */
    public function permisos()
    {
        return $this->belongsToMany(Permiso::class);
    }
}