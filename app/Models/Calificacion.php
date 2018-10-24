<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Calificacion extends Model
{
	use SoftDeletes, ModelsTrait;

	protected $table = 'calificacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'valoracion_id',
    	'licitacion_id',
    	'comentario',
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
