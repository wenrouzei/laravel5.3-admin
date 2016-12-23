@extends('admin.layouts.base')

@section('title','添加用户')

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
                            <h3 class="panel-title">添加用户</h3>
                        </div>
                        <div class="panel-body">

                            @include('admin.partials.errors')
                            @include('admin.partials.success')

                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/admin/user') }}">
                                {{ csrf_field() }}
                                @include('admin.user._form', ['formSubmitButtonText'=>'添加'])
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop