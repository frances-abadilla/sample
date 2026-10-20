<?php

namespace App\Http\Requests\API;

/** POST /api/stores */
class CreateStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:stores,code',
            'address' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
