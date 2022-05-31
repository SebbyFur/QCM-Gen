<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMCQRequest extends FormRequest
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
            'id_mcq' => ['required'],
            'id_exam' => ['required']
        ];
    }

    public function messages() {
        return [
            'id_mcq.required' => "Saisissez un id pour le QCM !",
            'id_exam.required' => "Saisissez un id pour l'examen !"
        ];
    }

    public function attributes() {
        return [
            'id_mcq' => 'id_mcq',
            'id_exam' => 'id_exam'
        ];
    }
}