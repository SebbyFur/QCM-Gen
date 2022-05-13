<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMCQGeneratorRequest extends FormRequest
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
            'title' => ['required']
        ];
    }

    public function messages() {
        return [
            'title.required' => "Le champ titre ne peut pas être vide !",
        ];
    }

    public function attributes() {
        return [
            'title' => 'title',
        ];
    }
}