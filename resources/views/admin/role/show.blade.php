@extends('admin.layouts.base')

@section('title','控制面板')

@section('pageHeader','控制面板')

@section('pageDesc','DashBoard')

@section('content')
<div class="main animsition">
    <div class="container-fluid">

        <div class="row">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">编辑角色</h3>
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal" role="form" >
                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">角色名称</label>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" name="name" id="tag" value="{{ $role->name }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">角色概述</label>
                                <div class="col-md-5">
                                    <textarea name="description" class="form-control" rows="3" readonly>{{ $role->description }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">权限列表</label>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                @foreach($permissionAll as $permission)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 all-check">
                                            {{ $permission->label }}：
                                        </label>
                                        <div class="col-md-6">
                                            @if(isset($permissions[$permission->id]) && is_array($permissions[$permission->id]))
                                            @foreach($permissions[$permission->id] as $permiss)
                                            <div class="col-md-4" style="float:left;padding-left:20px;margin-top:8px;">
                                                <span class="checkbox-custom checkbox-default">
                                                    <i class="fa"></i>
                                                    <input class="form-actions" checked="" id="inputChekbox2" type="Checkbox" value="2" name="permissions[]" disabled> <label for="inputChekbox2">
                                                    {{ $permiss->label }}
                                                </label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </span>
                                            </div>
                                            @endforeach
                                            @endif
                                        </div>
                                  </div>
                                @endforeach
                             </div>
                         </div>

                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                                <a style="margin:3px;" href="{{ URL::previous() }}" class="btn btn-warning btn-md animation-shake reloadBtn"><i class="fa fa-mail-reply-all"></i> 返回
                                </a>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop