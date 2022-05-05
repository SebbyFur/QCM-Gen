<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteGroupRequest extends FormRequest
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
            'id_group' => ['required']
        ];
    }

    public function messages() {
        return [
            'id_group.required' => "Il faut donner un identifiant de groupe dans la requête !",
        ];
    }

    public function attributes() {
        return [
            'id_group' => 'id_group',
        ];
    }
}