<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMCQModelRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:1', 'max:20'],
            'id' => ['required']
        ];
    }

    public function messages() {
        return [
            'title.required' => "Le QCM doit avoir un nom !",
            'id.required' => "Il faut donner un identifiant de QCM dans la requête !"
        ];
    }

    public function attributes() {
        return [
            'title' => 'title',
            'id' => 'id'
        ];
    }
}
