<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:locations,name,'.$this->location->id],
            'floor' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'capacity' => ['required', 'integer', 'min:1', 'max:10'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nöbet yeri adı zorunludur.',
            'name.unique' => 'Bu isimde bir nöbet yeri zaten mevcut.',
            'capacity.required' => 'Kapasite alanı zorunludur.',
            'capacity.min' => 'Kapasite en az 1 olmalıdır.',
        ];
    }
}
