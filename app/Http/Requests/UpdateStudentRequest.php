<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
            'student_id' => ['required'],
            'first_name' => ['required'],
            'last_name' => ['required']
        ];
    }

    public function messages() {
        return [
            'student_id.required' => "Il faut donner un ID d'étudiant !",
            'first_name.required' => "Le nom ne peut pas être vide !",
            'last_name.required' => "Le prénom ne peut pas être vide !"
        ];
    }

    public function attributes() {
        return [
            'student_id' => 'student_id',
            'first_name' => 'first_name',
            'last_name' => 'last_name'
        ];
    }
}