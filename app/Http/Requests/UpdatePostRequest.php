<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            "title" => ['required', 'string', 'min:6', 'max:200'],
            'slug' => ['required', 'string', 'max:255'],
            'thumbnail' => ['required', 'file', 'mimes:jpg|jpeg|png'],
            'content' => ['required'],
            'is_published' => ['required', 'boolean'],
            'excerpt' => ['required', 'string']
        ];
    }
}