<?php
/**
 * 后台左侧菜单栏中间件
 */
namespace App\Http\Middleware;

use Closure;
use Cache, Request, Gate;

class GetMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->attributes->set('comData_menu', $this->getMenu());
        return $next($request);
    }

    /**
     * 获取左边菜单栏 规定一级菜单（cid==0）跟 二级菜单(权限规则.index结尾)
     * @return array
     */
    function getMenu()
    {
        $openArr = [];//获取正在操作的菜单id
        $data = [];
        $data['top'] = [];//保存有二级菜单的一级菜单
        
        //查找并拼接出地址的路由别名值
        $path_arr = explode('/', Request::path());
        if (isset($path_arr[1])) {
            $urlPath = $path_arr[0] . '.' . $path_arr[1] . '.index';
        } else {
            $urlPath = $path_arr[0] . '.index';
        }
        
        //查找出所有的地址 name包含index为菜单 cid==0为一级菜单
        $table = Cache::store('file')->rememberForever('menus', function () {
            return \App\Models\Admin\Permission::where('name', 'LIKE', '%.index')
                ->orWhere('cid', '==', 0)
                ->get();
        });

        foreach ($table as $v) {
            if ($v->cid == 0 || Gate::check($v->name)) {//获取所有的一级菜单||有权限的二级菜单
                if ($v->name == $urlPath) {
                    $openArr[] = $v->id;//获取正在操作的二级菜单
                    $openArr[] = $v->cid;//获取正在操作的一级菜单
                }
                $data[$v->cid][] = $v->toarray();
            }
        }

        foreach ($data[0] as $v) {//循环所有的一级菜单
            if (isset($data[$v['id']]) && is_array($data[$v['id']]) && count($data[$v['id']]) > 0) {//判断一级菜单下是否有二级菜单
                $data['top'][] = $v;//只获取有二级菜单的一级菜单
            }
        }

        unset($data[0]);
        //ation open 可以在函数中计算给他
        $data['openarr'] = array_unique($openArr);
        return $data;

    }
}
