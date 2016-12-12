<?php

namespace App\Http\Controllers\Admin;

use App\Events\PermChangeEvent;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Permission;
use Cache, Event;
use App\Events\AdminActionEvent;

class PermissionController extends Controller
{
    protected $fields = [
        'name' => '',
        'label' => '',
        'description' => '',
        'cid' => 0,
        'icon' => '',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $cid = 0)
    {
        $cid = (int)$cid;
        if ($request->ajax()) {
            $data = array();
            $data['draw'] = $request->input('draw');
            $start = $request->input('start');
            $length = $request->input('length');
            $order = $request->input('order');
            $columns = $request->input('columns');
            $search = $request->input('search');
            $cid = $request->input('cid', 0);
            $data['recordsTotal'] = Permission::where('cid', $cid)->count();
            if (strlen($search['value']) > 0) {
                $data['recordsFiltered'] = Permission::where('cid', $cid)->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%')
                        ->orWhere('label', 'like', '%' . $search['value'] . '%');
                })->count();
                $data['data'] = Permission::where('cid', $cid)->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', '%' . $search['value'] . '%')
                        ->orWhere('description', 'like', '%' . $search['value'] . '%')
                        ->orWhere('label', 'like', '%' . $search['value'] . '%');
                })
                    ->skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            } else {
                $data['recordsFiltered'] = Permission::where('cid', $cid)->count();
                $data['data'] = Permission::where('cid', $cid)->
                skip($start)->take($length)
                    ->orderBy($columns[$order[0]['column']]['data'], $order[0]['dir'])
                    ->get();
            }
            return response()->json($data);
        }
        $datas['cid'] = $cid;
        if ($cid > 0) {
            $datas['data'] = Permission::find($cid);
        }
        return view('admin.permission.index', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(int $cid)
    {
        $data = [];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $data['cid'] = $cid;
        return view('admin.permission.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PremissionCreateRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionCreateRequest $request)
    {
        $permission = new Permission();
        foreach ($this->fields as $field=>$default) {
            $permission->$field = $request->input($field, $default);
        }
        if($permission->save()){
            Event::fire(new PermChangeEvent());
            event(new AdminActionEvent('添加了权限:' . $permission->name . '(' . $permission->label . ')'));
            return redirect('/admin/permission/' . $permission->cid)->withSuccess('添加成功！');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::find($id);
        if (!$permission) return redirect('/admin/permission')->withErrors("找不到该权限!");
        $data = ['id' => $id];
        foreach ($this->fields as $field => $default) {
            $data[$field] = old($field, $permission->$field);
        }
        return view('admin.permission.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PermissionUpdateRequest|Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $permission = Permission::find($id);
        foreach ($this->fields as $field => $default) {
            $permission->$field = $request->input($field, $default);
        }

        if($permission->save()){
            Event::fire(new PermChangeEvent());
            event(new AdminActionEvent('修改了权限:' . $permission->name . '(' . $permission->label . ')'));
            return redirect('admin/permission/' . $permission->cid)->withSuccess('修改成功！');
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
    public function destroy($id)
    {
        $child = Permission::where('cid', $id)->first();

        if ($child) {
            return redirect()->back()->withErrors("请先将该权限的子权限删除后再做删除操作!");
        }

        $permission = Permission::find($id);
        foreach ($permission->roles as $v){
            $permission->roles()->detach($v->id);
        }
        if ($permission->delete()) {
            Event::fire(new PermChangeEvent());
            event(new AdminActionEvent('删除了权限:' . $permission->name . '(' . $permission->label . ')'));
            return redirect()->back()->withSuccess("删除成功");
        } else {
            return redirect()->back()->withErrors("删除失败！");
        }
    }
}
