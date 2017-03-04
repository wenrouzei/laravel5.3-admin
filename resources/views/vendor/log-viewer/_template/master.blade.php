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
    <script src="{{ asset('plugins') }}/chartjs/Chart.min.js"></script>
    <script>
        Chart.defaults.global.responsive      = true;
        Chart.defaults.global.scaleFontFamily = "'Source Sans Pro'";
        Chart.defaults.global.animationEasing = "easeOutQuart";
    </script>
    @yield('scripts')
@stop