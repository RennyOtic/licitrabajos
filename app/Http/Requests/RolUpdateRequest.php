<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->iCan('rol', 'update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'descripcion' => 'nullable|string',
            'desde_at' => 'nullable|hour_corret',
            'nombre' => 'required|min:3|max:25',
            'permisos' => 'nullable|array',
            'slug' => 'required|min:3|max:25|unique1:rol',
            'especial' => 'required_without:permisos',
            'hasta_at' => 'nullable|hour_corret'
        ];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'descripcion' => 'descripción',
            'desde_at' => 'desde',
            'nombre' => 'nombre',
            'permisos' => 'permisos',
            'slug' => 'alias',
            'especial' => 'especial',
            'hasta_at' => 'hasta'
        ];
    }
}
