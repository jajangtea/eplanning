@extends('layouts.limitless.l_main')
@section('page_title')
    PEMBAHASAN PRA RENJA OPD
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        PEMBAHASAN PRA RENJA OPD TAHUN PERENCANAAN {{config('globalsettings.tahun_perencanaan')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.rkpd.pembahasanrenjaopd.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('pembahasanrenjaopd.index')!!}">PEMBAHASAN PRA RENJA OPD</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('pembahasanrenjaopd.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection