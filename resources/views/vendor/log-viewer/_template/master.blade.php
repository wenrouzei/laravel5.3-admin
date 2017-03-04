@extends('admin.layouts.base')
@section('css')
    @include('log-viewer::_template.style')
@stop

@section('content')
    @include('log-viewer::_template.navigation')

    <div class="container-fluid">
        @yield('content-log-viewer')
    </div>
@stop

@section('js')
    @yield('scripts')
@stop