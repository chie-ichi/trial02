<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
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
            'name' => ['required','string','max:255'],
            'area_id' => ['required'],
            'category_id' => ['required'],
            'photo_file' => ['required','image','mimes:jpeg,png,jpg,gif','max:1024'],
            'description' => ['required','max:500']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名は必須です。',
            'name.string' => '店舗名は文字列で入力してください。',
            'name.max' => '店舗名は255文字以内で入力してください。',
            'area_id.required' => 'エリアを選択してください',
            'category_id.required' => 'ジャンルを選択してください',
            'photo_file.required' => '写真は必須です。',
            'photo_file.image' => '画像ファイルを指定してください。',
            'photo_file.mimes' => 'JPEG、PNG、JPG、GIFのいずれかの形式のファイルを指定してください。',
            'photo_file.max' => '1MB以下のファイルを指定してください。',
            'description.required' => '説明文は必須です。',
            'description.max' => '説明文は500文字以内で入力してください。',
        ];
    }
}
