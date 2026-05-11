<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        "comment" => "required|string|max:1000",
        "parent_id" => "nullable|exists:comments,id",
        "photos" => "nullable|array|max:3",
        "photos.*" => "image|mimes:jpg,jpeg,png,gif|max:2048"
        ];
    }
}
