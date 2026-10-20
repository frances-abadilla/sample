<?php

namespace App\Http\Requests\API;

use Illuminate\Validation\Rule;

/** PUT /api/stores/{id} */
class UpdateStoreRequest extends ApiRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'max:50', Rule::unique('stores', 'code')->ignore($this->route('id'))],
            'address' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
        ];
    }
}
