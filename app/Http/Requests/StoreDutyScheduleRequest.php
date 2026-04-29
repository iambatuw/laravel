<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDutyScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'after_or_equal:today', 'unique:duty_schedules,date'],
            'title' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => 'Tarih alanı zorunludur.',
            'date.after_or_equal' => 'Tarih bugün veya daha ileri bir tarih olmalıdır.',
            'date.unique' => 'Bu tarih için zaten bir nöbet çizelgesi mevcut.',
        ];
    }
}
