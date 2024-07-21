<?php

namespace App\Http\Requests\Dashboard\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
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
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => 'required|email|unique:users,email',
            'mobile'        => 'required|numeric|unique:users,mobile',
            'password'      => ['required','same:confirm-password',Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised(),],
            'status'        => 'required|in:0,1',
            'roles_name'    => 'required',
            'salary'        => 'required_if:roles_name,Employee|numeric|gte:0',
            'department_id' => 'required_if:roles_name,Employee|integer|exists:departments,id',
            'photo'         => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg',
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
            'first_name.required'       => trans('validation.required'),
            'first_name.string'         => trans('validation.string'),
            'last_name.required'        => trans('validation.required'),
            'last_name.string'          => trans('validation.string'),
            'email.required'            => trans('validation.required'),
            'email.email'               => trans('validation.email'),
            'email.unique'              => trans('validation.unique'),
            'password.required'         => trans('validation.required'),
            'password.same'             => trans('validation.same'),
            'password.min'              => trans('validation.min'),
            'password.mixedCase'        => trans('validation.mixedCase'),
            'password.letters'          => trans('validation.letters'),
            'password.numbers'          => trans('validation.numbers'),
            'password.symbols'          => trans('validation.symbols'),
            'password.uncompromised'    => trans('validation.uncompromised'),
            'mobile.required'           => trans('validation.required'),
            'mobile.numeric'            => trans('validation.numeric'),
            'mobile.unique'             => trans('validation.unique'),
            'status.required'           => trans('validation.required'),
            'status.in'                 => trans('validation.in'),
            'roles.required'            => trans('validation.required'),
            'salary.required_if'        => trans('validation.required_if'),
            'salary.numeric'            => trans('validation.numeric'),
            'salary.gte'                => trans('validation.gte'),
            'department_id.required_if' => trans('validation.required_if'),
            'department_id.integer'     => trans('validation.integer'),
            'department_id.exists'      => trans('validation.exists'),
            'photo.nullable'            => trans('validation.nullable'),
            'photo.image'               => trans('validation.image'),
            'photo.mimes'               => trans('validation.mimes'),
        ];
    }
}
