<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'profile_image' => ['nullable', 'file', 'mimes:jpeg,png', 'max:2048'],
            'name'          => ['required', 'string', 'max:20'],
            'postal_code'   => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address'       => ['required', 'string', 'max:255'],
            'building'      => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_image.mimes'  => 'プロフィール画像はjpegまたはpng形式でアップロードしてください',
            'name.required'        => 'ユーザー名を入力してください',
            'name.max'             => 'ユーザー名は20文字以内で入力してください',
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex'    => '郵便番号はハイフンありの8文字で入力してください（例：123-4567）',
            'address.required'     => '住所を入力してください',
        ];
    }
}
