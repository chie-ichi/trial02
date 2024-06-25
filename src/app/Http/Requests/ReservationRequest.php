<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'date' => ['required','after:today'],
            'time' => ['required'],
            'number' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付は必須です。',
            'date.after' => '明日以降の日付を指定してください。',
            'time.required' => '時間は必須です。',
            'number.required' => '人数は必須です。',
        ];
    }
}
