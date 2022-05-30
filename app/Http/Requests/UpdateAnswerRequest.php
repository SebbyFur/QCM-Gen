<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnswerRequest extends FormRequest
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
            'id_answer' => ['required'],
            'answer' => ['nullable', 'string', 'min:1', 'max:256'],
            'is_correct' => ['nullable']
        ];
    }

    public function messages() {
        return [
            'id_answer.required' => "Entrez un id de réponse !"
        ];
    }

    public function attributes() {
        return [
            'id_answer' => 'id_answer',
            'answer' => 'answer',
            'is_correct' => 'is_correct'
        ];
    }
}