@extends('admin.layouts.base')

@section('title','首页')

@section('pageHeader','首页')

@section('pageDesc','首页')

@section('content')

    <style>
        .page-content {
            height: 100%;
        }

        .page-content {
            margin: 0;
            padding: 0;
            width: 100%;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 120px;
        }
    </style>

    <div class="container">
        <div class="content">
            <div class="title">Index</div>
        </div>
    </div>


@stop

@section('js')
