<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCorrectionRequest extends FormRequest
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
            'id_mcq_data' => ['required']
        ];
    }

    public function messages() {
        return [
            'id_mcq_data.required' => "Le champ id ne peut pas être vide !",
        ];
    }

    public function attributes() {
        return [
            'id_mcq_data' => 'id_mcq_data',
        ];
    }
}
