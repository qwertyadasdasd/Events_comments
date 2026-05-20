<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:3|max:1000',
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
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
            'user_id.required' => 'ID пользователя обязателен',
            'user_id.exists' => 'Выбранный пользователь не существует',
            'post_id.required' => 'ID поста обязателен',
            'post_id.exists' => 'Выбранный пост не существует',
            'parent_id.exists' => 'Родительский комментарий не существует',
            'rating.min' => 'Рейтинг должен быть не менее 1',
            'rating.max' => 'Рейтинг должен быть не более 5'
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->parent_id === '') {
            $this->merge([
                'parent_id' => null
            ]);
        }

        if (!$this->has('is_approved')) {
            $this->merge([
                'is_approved' => false
            ]);
        }
    }
}
