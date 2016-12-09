<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Permission;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use App\Events\AdminActionEvent;

class RoleController extends Controller
{
    protected $fields = [
        'name' => '',
        'description' => '',
        'permissions' => [],
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $order = $request->input('order');
            $columns = $request->input('columns');
            $search = $request->input('search');
            $data['recordsTotal'] = Role::count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Role::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = Role::where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = Role::count();
                $data['data'] = Role::
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }
        return view('admin.role.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        $arr = Permission::all();
        foreach ($arr as $v) {
            $data['permissionAll'][$v->cid][] = $v;
        }
        return view('admin.role.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleCreateRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        $role = new Role();
        foreach ($this->fields as $field=>$default) {
            if($field != 'permissions')$role->$field = $request->input($field);
        }
        
        if($role->save()){
            if (is_array($request->input('permissions'))) {
                $role->givePermissionsTo($request->input('permissions'));
            }

            event(new AdminActionEvent("添加角色".$role->name."{".$role->id."}"));
            return redirect('/admin/role/index')->withSuccess('添加成功！');
        }else{
            return redirect()->back()->withInput()->withErrors('添加失败！');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        $permissions = $permissionAll = [];
        if ($role->permissions) {
            foreach ($role->permissions as $v) {
                $permissions[$v->cid][] = $v;
            }
        }

        $arr = Permission::all();
        foreach ($arr as $v) {
            if($v->cid==0 && isset($permissions[$v->id])){
                $permissionAll[] = $v;
            }
        }

        return view('admin.role.show',compact('role','permissions','permissionAll'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        $permissions = [];
        if ($role->permissions) {
            foreach ($role->permissions as $v) {
                $permissions[] = $v->id;
            }
        }

        $role->permissions = $permissions;

        $arr = Permission::all();
        foreach ($arr as $v) {
            $permissionAll[$v->cid][] = $v;
        }

        return view('admin.role.edit', compact('role', 'permissionAll'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionUpdateRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //验证id
        $validator = \Validator::make(['id'=>$id], 
            [
                'id' => 'required|integer'
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors(trans('role.unKnowError'));
        }

        $role = Role::findOrFail($id);
        foreach ($this->fields as $field=>$default) {
            if($field != 'permissions')$role->$field = $request->input($field);
        }

        if($role->save()){
            $role->givePermissionsTo($request->input('permissions',[]));
            event(new AdminActionEvent("修改角色".$role->name."{".$role->id."}"));
            return redirect('/admin/role/index')->withSuccess('修改成功！');
        }else{
            return redirect()->back()->withInput()->withErrors('修改失败！');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //验证id
        $validator = \Validator::make(['id'=>$id], 
            [
                'id' => 'required|integer'
            ]
        );

        if ($validator->fails()) 
        {
            return redirect()->back()->withErrors(trans('role.unKnowError'));
        }

        $role = Role::findOrFail($id);

        foreach ($role->users as $v){
            $role->users()->detach($v);
        }

        foreach ($role->permissions as $v){
            $role->permissions()->detach($v);
        }

        if ($role->delete()) {
            event(new AdminActionEvent("删除角色".$role->name."{".$role->id."}"));
            return redirect()->back()->withSuccess("删除成功");
        } else {
            return redirect()->back()->withErrors("删除失败！");
        }
    }
}
