@extends('admin.layouts.base')

@section('title','修改用户')

@section('pageHeader','控制面板')

@section('pageDesc','DashBoard')

@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row page-title-row" style="margin:5px;">
                <div class="btn-group pull-right" style="margin-right: 10px">
                    <a href="{{ Url('/admin/user') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i>&nbsp;用户列表</a>
                </div>
            </div>

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">编辑用户(修改密码则填写密码)</h3>
                        </div>
                        <div class="panel-body">

                            @include('admin.partials.errors')
                            @include('admin.partials.success')
                            
                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user/'. $id) }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="id" value="{{ $id }}">
                                @include('admin.user._form', ['formSubmitButtonText'=>'修改'])
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop