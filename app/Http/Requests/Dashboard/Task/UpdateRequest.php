<?php

namespace App\Http\Requests\Dashboard\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name'        => 'required|string',
            'description' => 'required|string',
            'employee_id' => 'required|integer|exists:users,id,roles_name,Employee',
        ];
    }


    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required'        => trans('validation.required'),
            'name.string'          => trans('validation.string'),
            'description.required' => trans('validation.required'),
            'description.string'   => trans('validation.string'),
            'employee_id.required' => trans('validation.required'),
            'employee_id.integer'  => trans('validation.integer'),
            'employee_id.exists'   => trans('validation.exists'),
        ];
    }
}
