<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            // プロフィール画像（jpeg / png のみ・任意）
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpeg,png',
            ],

            // ユーザー名：必須・20文字以内
            'name' => [
                'required',
                'string',
                'max:20',
            ],

            // 郵便番号：必須・ハイフンあり8文字（例: 123-4567）
            'postcode' => [
                'required',
                'regex:/^\d{3}-\d{4}$/',
            ],

            // 住所：必須
            'address' => [
                'required',
                'string',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_image.image' => '画像ファイルを選択してください。',
            'profile_image.mimes' => 'プロフィール画像はjpegまたはpng形式のみです。',

            'name.required' => 'ユーザー名は必須です。',
            'name.max' => 'ユーザー名は20文字以内で入力してください。',

            'postcode.required' => '郵便番号は必須です。',
            'postcode.regex' => '郵便番号は「123-4567」の形式で入力してください。',

            'address.required' => '住所は必須です。',
        ];
    }
}
