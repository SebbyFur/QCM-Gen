<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteExamRequest extends FormRequest
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
            'id' => ['required'],
            'remove_mcq' => ['nullable']
        ];
    }

    public function messages() {
        return [
            'id.required' => "Il faut donner un ID d'examen !",
        ];
    }

    public function attributes() {
        return [
            'id' => 'id',
        ];
    }
}