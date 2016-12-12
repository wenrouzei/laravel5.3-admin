<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PermissionCreateRequest extends Request
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
            'name'=>'required|unique:admin_permissions|max:255',
            'label'=>'required|unique:admin_permissions|max:255',
            'cid'=>'required|integer',
        ];
    }

    public function messages(){
        return [
            'name.required' => '权限规则不能为空',  
            'name.unique' => '权限规则不能重复',  
            'name.max' => '权限规则长度不能大于255字节',  
            'label.required' => '权限名称不能为空',  
            'label.unique' => '权限名称不能重复',  
            'label.max' => '权限名称长度不能大于255字节',                        
            'cid.required' => '发生未知错误，请返回上一层刷新再进行',                        
            'cid.integer' => '发生未知错误，请返回上一层刷新再进行',                        
        ];
    }
}
