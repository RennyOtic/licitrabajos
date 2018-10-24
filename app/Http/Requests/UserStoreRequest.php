<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->iCan('user', 'store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'correo' => 'required|email|min:8|max:35|unique:usuario',
            'apellido' => 'required|alpha_space|min:3|max:15',
            'nombre' => 'required|alpha_space|min:3|max:15',
            'identificacion' => 'required|numeric|digits_between:6,8|exr_ced|unique:usuario',
            'password' => 'required|string|min:6|max:20|confirmed',
            'roles' => 'nullable|array|min:1|max:2'
        ];
    }

    /**
     * mensajes personalizados.
     *
     * @return array
     */
    public function messages()
    {
        return ['correo.required' => 'El campo :attribute es requerido.'];
    }

    /**
     * Cambio de nombres de los atributos.
     *
     * @return array
     */
    public function attributes()
    {
        return ['password' => 'contraseña', 'identificacion' => 'identificación'];
    }
}
