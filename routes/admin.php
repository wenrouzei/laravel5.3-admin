<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('login', 'LoginController@showLoginForm')->name('admin.login');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');


//自定义后台首页
Route::group(['as'=>'admin.index','middleware'=>['auth:admin','menu']], function() {
    Route::get('index', 'IndexController@index');
    Route::get('/', 'IndexController@index');
});

//后台首页默认跳转到日志管理页？
// Route::group(['as'=>'admin.index'], function() {
//     //
//     Route::get('index', function () {
//         return redirect('/admin/log-viewer');
//     });

//     Route::get('/', function () {
//         return redirect('/admin/log-viewer');
//     });
// });


Route::group(['middleware' => ['auth:admin', 'menu', 'authAdmin']], function () {

    //权限管理路由
    Route::get('permission/{cid}/create', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@create']);
    Route::get('permission/{cid?}', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    Route::post('permission/index', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']); //查询
    //RESTful 资源控制器
    Route::resource('permission', 'PermissionController',
        ['names' => 
            [
                'edit' => 'admin.permission.edit',
                'update' => 'admin.permission.edit', 
                'create' => 'admin.permission.create', 
                'store' => 'admin.permission.create',
                'destroy' => 'admin.permission.destroy'
            ],
            'except' => ['show']//限制访问路由
        ]
    );


    //角色管理路由
    Route::get('role/{id?}', ['as' => 'admin.role.index', 'uses' => 'RoleController@show'])->where('id','[0-9]+');//详情页
    Route::match(['get', 'post'], 'role/index',['as' => 'admin.role.index', 'uses' => 'RoleController@index']);//post为ajax请求用到
    //RESTful 资源控制器
    Route::resource('role', 'RoleController',
        ['names' => 
            [
                'edit' => 'admin.role.edit',
                'update' => 'admin.role.edit', 
                'create' => 'admin.role.create', 
                'store' => 'admin.role.create',
                'destroy' => 'admin.role.destroy'
            ]
        ]
    );


    //用户管理路由
    Route::match(['get', 'post'], 'user/index',['as' => 'admin.user.index', 'uses' => 'UserController@index']);//post为ajax请求用到
    //RESTful 资源控制器
    Route::resource('user', 'UserController',
        ['names' => 
            [
                'edit' => 'admin.user.edit',
                'update' => 'admin.user.edit', 
                'create' => 'admin.user.create', 
                'store' => 'admin.user.create',
                'destroy' => 'admin.user.destroy'
            ],
         'except' => ['show']//限制访问路由
        ]
    );

    Route::get('article/index', ['as'=>'admin.article.index', 'uses' => 'ArticleController@index']);//文章管理

    Route::get('student/index', ['as'=>'admin.student.index', 'uses' => 'StudentController@index']);//文章管理

});

