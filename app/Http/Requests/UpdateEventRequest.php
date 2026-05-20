<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $eventId = $this->route('event')->id;

        return [
            'name' => 'required|string|max:255|min:3',
            'slug' => 'required|string|max:255|unique:events,slug,' . $eventId . '|regex:/^[a-z0-9-]+$/',
            'description' => 'nullable|string|max:5000',
            'event_date' => 'nullable|date|after_or_equal:today',
            'location' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7|regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/',
            'sort_order' => 'nullable|integer|min:0|max:999'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название события обязательно',
            'name.min' => 'Название должно содержать минимум 3 символа',
            'name.max' => 'Название не может превышать 255 символов',
            'slug.required' => 'Slug обязателен',
            'slug.unique' => 'Такой slug уже существует',
            'slug.regex' => 'Slug может содержать только латинские буквы, цифры и дефис',
            'event_date.date' => 'Введите корректную дату',
            'event_date.after_or_equal' => 'Дата события не может быть раньше сегодняшнего дня',
            'location.max' => 'Местоположение не может превышать 255 символов',
            'color.regex' => 'Цвет должен быть в формате HEX (#RRGGBB или #RGB)',
            'sort_order.integer' => 'Порядок сортировки должен быть числом'
        ];
    }
}
