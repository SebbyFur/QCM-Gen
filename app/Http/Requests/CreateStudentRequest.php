<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateStudentRequest extends FormRequest
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
            'first_name' => ['required'],
            'last_name' => ['required'],
            'group_id' => ['nullable'],
        ];
    }

    public function messages() {
        return [
            'first_name.required' => "L'étudiant doit avoir un nom !",
            'last_name.required' => "L'étudiant doit avoir un prénom !",
        ];
    }

    public function attributes() {
        return [
            'first_name' => 'first_name',
            'last_name' => 'last_name',
        ];
    }
}