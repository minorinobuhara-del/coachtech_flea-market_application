<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
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
            'name' => 'required|string',
            'description' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png',
            'category' => 'required|string',
            'condition' => 'required|string',
            'price' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名は必須です',
            'description.required' => '商品説明は必須です',
            'description.max' => '商品説明は255文字以内で入力してください',
            'image.required' => '商品画像は必須です',
            'image.image' => '画像ファイルをアップロードしてください',
            'image.mimes' => '画像はjpegまたはpng形式のみです',
            'category.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品価格は必須です',
            'price.integer' => '商品価格は数値で入力してください',
            'price.min' => '商品価格は0円以上で入力してください',
        ];
    }
}
