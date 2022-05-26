<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteQuestionsTagsRequest extends FormRequest
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
            'id_tag' => ['required'],
            'id_question' => ['required']
        ];
    }

    public function messages() {
        return [
            'id_tag.required' => "Entrez un id de tag !",
            'id_question.required' => "Entrez un id de question !"
        ];
    }

    public function attributes() {
        return [
            'id_tag' => 'id_tag',
            'id_question'  => 'id_question'
        ];
    }
}