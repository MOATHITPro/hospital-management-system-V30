<?php

namespace App\Services\Signup;

use App\Models\User;

class UserService
{
    public function registerUser(array $userData): User
    {
        return User::create($userData);
    }

    public function validateUserData(array $data): array
    {
        return validator($data, [
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'username'      => 'required|string|max:255|unique:users',
            'email'         => 'required|string|email|max:255|unique:users',
            'password'      => 'required|string|min:8|confirmed',
            'date_of_birth' => 'required|date|before:today',
            'id_number'     => 'required|string|max:20|unique:users',
            'city_id'       => 'required|exists:cities,id',
            'district_id'   => 'required|exists:districts,id',
        ])->validate();
    }
}
