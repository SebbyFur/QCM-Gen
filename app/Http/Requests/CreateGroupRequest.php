<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateGroupRequest extends FormRequest
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
            'name_group' => ['required']
        ];
    }

    public function messages() {
        return [
            'name_group.required' => "Le groupe de classe doit avoir un nom !",
        ];
    }

    public function attributes() {
        return [
            'name_group' => 'name_group',
        ];
    }
}