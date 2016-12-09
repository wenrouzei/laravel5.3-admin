<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoleUpdateRequest extends Request
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
            'name'=>'required|unique:admin_roles,name,'.$this->get('id').'|max:255',
        ];
    }
}
