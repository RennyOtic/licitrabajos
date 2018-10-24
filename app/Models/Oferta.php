<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Oferta extends Model
{
	use SoftDeletes, ModelsTrait;

	protected $table = 'oferta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'licitacion_id',
    	'usuario_id',
    	'descripcion',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at' , 'updated_at', 'deleted_at'
    ];
}
