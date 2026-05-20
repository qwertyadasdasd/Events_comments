<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:3|max:1000',
            'is_approved' => 'nullable|boolean',
            'rating' => 'nullable|integer|min:1|max:5'
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Текст комментария обязателен',
            'content.min' => 'Комментарий должен содержать минимум 3 символа',
            'content.max' => 'Комментарий не может превышать 1000 символов',
            'rating.min' => 'Рейтинг должен быть не менее 1',
            'rating.max' => 'Рейтинг должен быть не более 5'
        ];
    }
}
