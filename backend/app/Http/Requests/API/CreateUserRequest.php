<?php

namespace App\Http\Requests\API;

/** POST /api/users */
class CreateUserRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'nullable|in:admin,driver',
        ];
    }
}
