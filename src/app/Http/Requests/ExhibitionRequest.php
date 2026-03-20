<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'image'        => ['required', 'file', 'mimes:jpeg,png', 'max:2048'],
            'category_ids' => ['required', 'array', 'min:1'],
            'category_ids.*' => ['exists:categories,id'],
            'condition_id' => ['required', 'exists:conditions,id'],
            'name'         => ['required', 'string', 'max:255'],
            'brand'        => ['nullable', 'string', 'max:255'],
            'description'  => ['required', 'string', 'max:255'],
            'price'        => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required'        => '商品画像をアップロードしてください',
            'image.mimes'           => '商品画像はjpegまたはpng形式でアップロードしてください',
            'category_ids.required' => 'カテゴリを選択してください',
            'condition_id.required' => '商品の状態を選択してください',
            'name.required'         => '商品名を入力してください',
            'description.required'  => '商品の説明を入力してください',
            'description.max'       => '商品説明は255文字以内で入力してください',
            'price.required'        => '販売価格を入力してください',
            'price.integer'         => '販売価格は数値で入力してください',
            'price.min'             => '販売価格は0円以上で入力してください',
        ];
    }
}
