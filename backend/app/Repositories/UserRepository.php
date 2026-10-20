<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function getAllUsers()
    {
        return User::orderBy('name')->get();
    }

    public function getUser($id)
    {
        return User::find($id);
    }

    public function getUserByUsername($username)
    {
        return User::where('username', $username)->first();
    }

    public function getUserByToken($hashedToken)
    {
        return User::where('api_token', $hashedToken)->first();
    }

    public function createUser(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'username' => $data['username'],
            'password' => $data['password'],
            'role'     => $data['role'] ?? 'driver',
        ]);
    }

    public function setToken(User $user, $hashedToken)
    {
        $user->forceFill(['api_token' => $hashedToken])->save();
    }

    public function deleteUser($id)
    {
        return (bool) User::whereKey($id)->delete();
    }
}
