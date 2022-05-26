<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAnswerRequest extends FormRequest
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
            'id_question' => ['required'],
            'answer' => ['nullable']
        ];
    }

    public function messages() {
        return [
            'id_question.required' => "Il faut lier la réponse à une question. Entrez un id de question !",
        ];
    }

    public function attributes() {
        return [
            'id_question' => 'id_question',
            'answer' => 'answer'
        ];
    }
}
