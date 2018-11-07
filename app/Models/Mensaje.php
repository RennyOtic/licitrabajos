<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Mensaje extends Model
{
	use SoftDeletes, ModelsTrait;

    protected $table = 'mensaje';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'chat_id',
    	'usuario_id',
    	'mensaje',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at' , 'updated_at', 'deleted_at'
    ];

    public function usuario()
    {
        return $this->belongsTo(\App\Usuario::class);
    }
}
