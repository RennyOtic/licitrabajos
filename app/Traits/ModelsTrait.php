<?php

namespace App\Traits;

use App\Models\Permisologia\Rol;

trait ModelsTrait
{

	/**
	 * ruta de la imagen del usuario.
	 * @model User
	 * @return string
	 */
	public function getLogoPath()
	{
		$path = public_path('storage\users\image\\') . $this->id . '.';
		$ext = ['jpg', 'jpeg', 'png'];

		foreach ($ext as $e) {
			if (is_readable($path . $e)) {
				return asset('storage\users\image\\') . $this->id . '.' . $e;
			}
		}
		return "\adminlte\img\icon-avatar-default.png";
	}

	/**
	 * Nombre completo del usuario.
	 * @model User
	 * @return string
	 */
	public function fullName()
	{
		$name = explode(' ', $this->nombre);
		$last_name = explode(' ', $this->apellido);
		return ucfirst($name[0]) . ' ' . ucfirst($last_name[0]);
	}

	/**
	 * Asigna los permisos de la tabla permission_user de un solo usuario.
	 * @model User
	 * @return Bool
	 */
	public function assignPermissionsOneUser($roles)
	{
		$permissions = [];
		foreach ($roles as $rol) {
			$permissionsOfRol = Rol::findOrFail($rol)->permisos->pluck('id')->toArray();
			$permissions = array_merge($permissions, $permissionsOfRol);
		}
		return $this->update_pivot(array_unique($permissions), 'permisos', 'permiso_id');
	}

	/**
	 * Devuelve todos los permisos que posee el usuario.
	 * @model User
	 * @return $this
	 */
	public function permissionsOfUser()
	{
		// if ($this->id == 1) return 'all-access';
		// foreach ($this->roles as $rol) {
		// 	if ($rol->special == 'all-access') return $rol->special;
		// 	if ($rol->special == 'no-access') return [];
		// }
		$all = [];
		foreach ($this->permisos as $p) {
			$all[] = $p->modulo . '.' . $p->accion;
		}
		return $all;
	}

	/**
	 * Actualiza las tablas pivot quitando o agregando nuevos valores.
	 * @model Role || User
	 * @return $this
	 */
	public function update_pivot(Array $values = [], $relation, $campo = 'id')
	{
		$user_roles = $this->$relation()->pluck($campo)->toArray();
		$add    = array_diff($values, $user_roles);
		$delete = array_diff($user_roles, $values);
		if(!empty($add)) $this->$relation()->attach($add);
		if (!empty($delete)) $this->$relation()->detach($delete);
		return $this;
	}

	/**
	 * Actualiza las tablas pivot de user_permission.
	 * @model Role
	 * @return $this
	 */
	public function assignPermissionsAllUser()
	{
		$permisos = $this->permisos->pluck('id')->toArray();
		foreach ($this->usuarios as $user) {
			$user->update_pivot($permisos, 'permisos', 'permiso_id');
		}
		return $this;
	}

	/**
	 * Se ordenan los datos para la paginación de la tabla.
	 * @model All
	 * @return Object
	 */
	public static function dataForPaginate($select = ['*'], $changes = null)
	{
		$data = Self::orderBy(request()->order?:(($select == ['*']) ? 'id' : $select[0]), request()->dir?:'ASC')
		->search(request()->search)
		->select($select)
		->paginate(request()->num?:10);

		if ($changes != null) $data->each(function ($d) use ($changes) {$changes($d); });

		return $data;
	}

	/**
	 * Realiza una busqueda por palabras al campo fillable.
	 * @model All
	 * @return Object
	 */
	public function scopeSearch($query, $keyword = '')
	{
		if (empty($keyword)) return $query;

		$words = explode(' ', $keyword);
		foreach ($this->fillable as $column) {
			foreach ($words as $word) {
				$query->orWhere($column, 'like', "%{$word}%");
			}
		}
		return $query;
	}
}