<?php

namespace App\Http\Controllers\Auth;

use App\Usuario;
use App\Models\Permisologia\Rol;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $roles = Rol::whereIn('id', [2, 3])->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'correo'     => 'required|email|min:8|max:35|unique:usuario',
            'apellido' => 'required|alpha_space|min:3|max:15',
            'nombre'      => 'required|alpha_space|min:3|max:15',
            'identificacion'    => 'required|string|unique:usuario',
            'password'  => 'required|string|min:6|max:20|confirmed',
            'calle_avenida' => 'required|string|min:3|max:100',
            'codigo_postal' => 'required|numeric|digits:7',
            'municipio' => 'required|string|min:3|max:100',
            'pais' => 'required|string|min:3|max:30',
            'sector' => 'required|string|min:3|max:100',
            'longitude' => 'nullable',
            'latitude' => 'nullable',
        ],[],[
            'password' => 'contraseña',
            'identificacion' => 'identificación'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = Usuario::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'identificacion' => $data['identificacion'],
            'correo' => $data['correo'],
            'password' => Hash::make($data['password']),
            'calle_avenida' => $data['calle_avenida'],
            'codigo_postal' => $data['codigo_postal'],
            'municipio' => $data['municipio'],
            'pais' => $data['pais'],
            'sector' => $data['sector'],
        ]);
        $user->rol()->attach($data['rol']);
        $user->assignPermissionsOneUser([$data['rol']]);
        if ($data['longitude']) {
            $user->update(['longitude' => $data['longitude']]);
        }
        if ($data['latitude']) {
            $user->update(['latitude' => $data['latitude']]);
        }
        \Mail::to($user->correo)->send(new \App\Mail\Bienvenida($user));
        return $user;
    }
}