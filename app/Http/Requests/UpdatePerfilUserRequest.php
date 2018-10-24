<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerfilUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'correo' => 'required|email|unique1:usuario,email',
            'apellido' => 'required|alpha_space|min:3|max:20',
            'nombre' => 'required|alpha_space|min:3|max:20',
            'identificacion' => 'required|numeric|exr_ced|unique1:usuario,num_id'
        ];
    }
}
