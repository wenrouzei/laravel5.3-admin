<?php

namespace App\Providers;

use App\Http\Requests\Request;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use League\Flysystem\Exception;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     * 可定义策略类，可结合model使用
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];




    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        if(!empty($_SERVER['SCRIPT_NAME']) && strtolower($_SERVER['SCRIPT_NAME']) ==='artisan' ){
            return false;
        }
        
        $this->registerPolicies($gate);
        
        $gate->before(function ($user, $ability) {
            if ($user->id === 1) {//超级管理员绕过gate验证
                return true;
            }
        });


        $permissions = \App\Models\Admin\Permission::with('roles')->get();

        foreach ($permissions as $permission) {
            $gate->define($permission->name, function ($user) use ($permission) {
                return $user->hasPermission($permission);
            });
        }
    }


}
