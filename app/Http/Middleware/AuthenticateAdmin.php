<?php
/**
 * 后台功能权限控制中间件
 */

namespace App\Http\Middleware;

use Closure;
use Route,URL,Auth,Gate;

class AuthenticateAdmin
{
    //改属性经测试没用？
    // protected $except = [
    //     'admin/index'
    // ];

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd(Route::currentRouteName());
        //超级管理员已经在AuthServiceProvider.php 通过所有权限验证，下面gate权限验证里会自动true绕过，这里不需要再验证？，不想经过下面Gate验证能节省资源能开启？
        // if(Auth::guard('admin')->user()->id === 1){
        //     return $next($request);
        // }

        //获取当前路由别名
        //Route::getCurrentRoute()->getPath();
        //Request::route()->getName();
        // dd(Route::currentRouteName(),$request->route()->getName());
        // dd(Gate::check(Route::currentRouteName()));
        if(!Gate::check(Route::currentRouteName())) {
            if($request->ajax() && ($request->getMethod() != 'GET')) {
                return response()->json([
                    'status' => -1,
                    'code' => 403,
                    'msg' => '您没有权限执行此操作'
                ]);
            } else {
                return response()->view('admin.errors.403', ['previousUrl'=>URL::previous()]);//显示没有权限，传递上一页链接
            }
        }

        return $next($request);
    }
}
