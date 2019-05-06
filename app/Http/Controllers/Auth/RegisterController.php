<?php

namespace App\Http\Controllers\Auth;

use App\User;
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
    protected $redirectTo = '/home';

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
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'f_name' => ['required', 'string', 'max:191'],
            'l_name' => ['required', 'string', 'max:191'],
            'phone_1' => ['required', 'regex:/^[0-9]{10}$/'],
            'phone_2' => ['nullable', 'regex:/^[0-9]{10}$/'],
            'p_address' => ['required', 'string', 'max:191'],
            't_address' => ['required', 'string', 'max:191'],
            'date_of_birth' => ['required', 'date'],
            'date_of_join' => ['required', 'date'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
        return User::create([
            'f_name' => ucwords($data['f_name']),
            'l_name' => ucwords($data['l_name']),
            'phone_1' => $data['phone_1'],
            'phone_2' => $data['phone_2'],
            'p_address' => ucwords($data['p_address']),
            't_address' => ucwords($data['t_address']),
            'date_of_birth' => $data['date_of_birth'],
            'date_of_join' => $data['date_of_join'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
