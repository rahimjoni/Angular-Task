<?php

namespace Api\v1\Employee\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            //
        ];
    }

    /**
     * attributes can be changed here like the following
     * 'user_name'=>'User Name', or 'user_name'=>trnas('your_translation_file.user_name')
     * @return [type] [description]
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * form validation messages can be changed and translated by this method like the following
     * 'user_name.required'=>'Please provide user name' or 'user_name.required'=>trans('your_translation_file.user_name_msg')
     * @return [type] [description]
     */
    public function messages()
    {
        return [
            //
        ];
    }

}
