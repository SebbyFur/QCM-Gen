<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
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
            'id' => ['required'],
            'question' => ['nullable', 'string', 'min:1', 'max:20'],
            'answer_count' => ['nullable']
        ];
    }

    public function messages() {
        return [
            'id.required' => 'Saisissez un id !'
        ];
    }

    public function attributes() {
        return [
            'id' => 'id',
            'question' => 'question',
            'answer_count' => 'answer_count'
        ];
    }
}