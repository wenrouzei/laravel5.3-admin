<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PermissionUpdateRequest extends Request
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
     * 更新操作 unique唯一规则 强制一个唯一规则来忽略给定ID,可以传递ID作为第三个参数 $this->get('id') 如果你的数据表使用主键字段不是id，可以指定第四个输入参数
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required|unique:admin_permissions,name,'.$this->get('id').'|max:255',
            'label'=>'required|unique:admin_permissions,label,'.$this->get('id').'|max:255',
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
