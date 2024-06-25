<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'stars' => ['required'],
            'comment' => ['required','max:500'],
        ];
    }

    public function messages()
    {
        return [
            'stars.required' => '評価は必須です。',
            'comment.required' => 'コメントは必須です。',
            'comment.max' => 'コメントは500文字以内で入力してください。',
        ];
    }
}
