<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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
            'name'=>'required|unique:user,name',
            'email'=>'required|email|unique:user,email',
            'pass'=>'required|between:6,15'
        ];
    }

    public function messages(){
        return [
            'name.required'=>'名称不能为空',
            'name.unique'=>'名称已存在',
            'email.required'=>'邮箱不能为空',
            'email.email'=>'邮箱格式不正确',
            'email.unique'=>'邮箱已存在',
            'pass.required'=>'密码不能为空',
            'pass.between'=>'密码长度不正确'
        ];
    }
}
