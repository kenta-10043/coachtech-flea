<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'item_name' => 'required',
            'description' => 'required|max:255',
            'item_image' => 'required|mimes:png,jpeg',
            'category' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'item_name.required' => '商品名を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',
            'description.required' => '商品説明を入力してください',
            'item_image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'item_image.required' => '商品画像をアップロードしてください',
            'category.required' => 'カテゴリーを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.numeric' => '商品価格を数値形式で入力してください',
            'price.min' => '商品価格を０円以上で入力してください',

        ];
    }
}
