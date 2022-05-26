<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMCQRequest extends FormRequest
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
            'id_model' => ['nullable'],
            'id_tag' => ['nullable'],
            'is_random' => ['nullable'],
            'questions_count' => ['required', 'integer', 'min:1'],
            'student_ids' => ['required', 'array'],
            'student_ids.*' => ['integer'],
        ];
    }

    public function messages() {
        return [
            'questions_count.required' => "Le nombre de questions est nécessaire !",
            'student_ids.required' => "Il faut donner un tableau d'étudiants pour qui créer le QCM !"
        ];
    }

    public function attributes() {
        return [
            'id_model' => 'id_model',
            'id_tag' => 'id_tag',
            'is_random' => 'is_random',
            'questions_count' => 'questions_count',
            'student_ids' => 'student_ids'
        ];
    }
}
