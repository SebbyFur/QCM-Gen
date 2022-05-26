<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAnswerRequest extends FormRequest
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
            'id_answer' => ['required']
        ];
    }

    public function messages() {
        return [
            'id_answer.required' => "Entrez un id de réponse !"
        ];
    }

    public function attributes() {
        return [
            'id_answer' => 'id_answer'
        ];
    }
}