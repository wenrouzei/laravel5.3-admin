<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoleCreateRequest extends Request
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
            'name'=>'required|unique:admin_roles|max:255',
        ];
    }

    public function messages(){
        return [
            'name.required' => '角色名称不能为空',  
            'name.unique' => '角色名称不能重复', 
            'name.max' => '角色名称长度不能大于255字节',                      
        ];
    }
}
