<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteMCQModelDataRequest extends FormRequest
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
            'id_mcqdata' => ['required'],
        ];
    }

    public function messages() {
        return [
            'id_mcqdata.required' => "L'identifiant de donnée du modèle est requis !",
        ];
    }

    public function attributes() {
        return [
            'id_mcqdata' => 'id_mcqdata',
        ];
    }
}