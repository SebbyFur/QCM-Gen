<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMCQModelDataRequest extends FormRequest
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
            'id_model' => ['required'],
            'id_question' => ['required']
        ];
    }

    public function messages() {
        return [
            'id_model.required' => "L'identifiant de modèle est requis !",
            'id_question.required' => "L'identifiant de question est requis !"
        ];
    }

    public function attributes() {
        return [
            'id_model' => 'id_model',
            'id_question' => 'id_question'
        ];
    }
}