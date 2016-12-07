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
        if(Auth::guard('admin')->user()->id === 1){
            return $next($request);
        }

        $previousUrl = URL::previous();
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
                return response()->view('admin.errors.403', compact('previousUrl'));
            }
        }

        return $next($request);
    }
}
