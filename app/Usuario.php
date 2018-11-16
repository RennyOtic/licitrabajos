<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\ { ModelsTrait, PermissionTrait };

class Usuario extends Authenticatable
{
    use Notifiable, ModelsTrait, PermissionTrait, SoftDeletes;

    protected $table = 'usuario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'identificacion',
        'correo',
        'password',
        'pais',
        'municipio',
        'sector',
        'calle_avenida',
        'codigo_postal',
        'notificaciones',
        'longitude',
        'latitude',
    ];

    /**
     * Los atruburos que seran instancia de carbon por ser tipo fecha.
     *
     * @var array
     */
    // protected $dates = ['deleted_at'];

    /**
     * Los atributos que deberían estar ocultos para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Obtener los roles que posee el usuario.
     */
    public function rol()
    {
        // pertenece a muchas
        return $this->belongsToMany(Models\Permisologia\Rol::class);
    }

    /**
     * Obtener los permisos que posee el usuario.
     */
    public function permisos()
    {
        return $this->belongsToMany(Models\Permisologia\Permiso::class);
    }

    /**
     * Obtener los permisos que posee el usuario.
     */
    public function servicios()
    {
        return $this->belongsToMany(Models\Servicio::class);
    }

    public function licitaciones()
    {
        return $this->hasMany(Models\Licitacion::class, 'persona_id');
    }

    public function licitaciones2()
    {
        return $this->hasMany(Models\Licitacion::class, 'empresa_id');
    }
}
