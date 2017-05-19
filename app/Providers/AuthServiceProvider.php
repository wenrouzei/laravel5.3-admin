<?php

namespace App\Providers;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Log;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * 可定义策略类，可结合model使用
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];




    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // if(!empty($_SERVER['SCRIPT_NAME']) && strtolower($_SERVER['SCRIPT_NAME']) ==='artisan' ){
        //     return false;
        // }

        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if ($user->is_admin && $user->is_super_admin) {//超级管理员绕过gate验证
                return true;
            }
        });

        try{
            $permissions = \App\Models\Admin\Permission::with('roles')->get();

            foreach ($permissions as $permission) {
                Gate::define($permission->name, function ($user) use ($permission) {
                    if($user->is_admin) {//后台登录用户才进行gate权限授权 区分前台登录用户 用户模型getIsAdminAttribute添加方法返回值识别
                        return $user->hasRole($permission->roles);
                        //return $user->hasPermission($permission);
                    }else{
                        return false;
                    }
                });
            }
        }catch (QueryException $e){
            Log::warning('为避免迁移时候初始化gate授权，而不存在该permission权限表时报错，故做捕获错误处理：'.$e->getMessage().'('.$e->getCode().') SQL'.$e->getSql());
        }


    }


}
