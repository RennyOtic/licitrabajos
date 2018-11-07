<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ModelsTrait;

class Chat extends Model
{
	use SoftDeletes, ModelsTrait;

	protected $table = 'chat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'licitacion_id',
    	'persona_id',
    	'empresa_id',
    ];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
    	'created_at' , 'updated_at', 'deleted_at'
    ];

    public function empresa()
    {
        return $this->belongsTo(\App\Usuario::class);
    }

    public function persona()
    {
        return $this->belongsTo(\App\Usuario::class);
    }

    public function mensaje()
    {
        return $this->hasMany(Mensaje::class);
    }

}
