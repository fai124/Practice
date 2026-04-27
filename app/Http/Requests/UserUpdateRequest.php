<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    //public function authorize(): bool
    //{
      //  return false;
    //}

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "fullname"=>"required|min:3",
            "number"=>"required|min:3",
            "email"=>"required|min:3",
            "avatar" => "nullable|image|mimes:jpg,jpeg,png|max:2048",
        ];
    }
}