<?php
/**
 * 后台功能控制中间件
 */

namespace App\Http\Middleware;

use Closure;
use Route,URL,Auth,Gate;

class AuthenticateAdmin
{

    protected $except = [
        'admin/index'
    ];

    /**
     * Handle an incoming request.
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //超级管理员已经在AuthServiceProvider.php 通过所有权限验证，故不需要再验证
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
