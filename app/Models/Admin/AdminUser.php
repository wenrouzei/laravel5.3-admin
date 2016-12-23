<?php

namespace App\Models\Admin;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable
{
    use Notifiable;
    protected $table='admin_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    //获取模型的json或数组返回值中添加数据库字段中不存在的属性
    protected $appends = ['is_super_admin'];

    //用户角色
    public function roles()
    {
        return $this->belongsToMany(Role::class,'admin_role_user','user_id','role_id');
    }

    // 判断用户是否具有某个角色
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }

    // 判断用户是否具有某权限
    public function hasPermission($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name',$permission)->first();
            if (!$permission) return false;
        }

        return $this->hasRole($permission->roles);
    }

    // // 给用户分配角色
    // public function assignRole($role)
    // {
    //     return $this->roles()->save($role);
    // }


    // //角色整体添加与修改
    // public function giveRoleTo(array $RoleId){
    //     $this->roles()->detach();
    //     $roles=Role::whereIn('id',$RoleId)->get();
    //     foreach ($roles as $v){
    //         $this->assignRole($v);
    //     }
    //     return true;
    // }
    // 
    
    /**
     * 访问不存在属性时，通过该方法添加额外属性识别后台登录用户，区分前端登录用户
     * @return boolean [description]
     */
    public function getIsAdminAttribute()
    {
        return true;
    }

    /**
     * 访问不存在属性时，通过该方法添加额外属性识别是否是超级管理员，id==1为超级管理员账号？
     * @return [type] [description]
     */
    public function getIsSuperAdminAttribute(){
        return $this->id == 1;
    }
}
