@extends('layouts.limitless.l_main')
@section('page_title')
    REKAPRKPDPERUBAHANOPD
@endsection
@section('page_header')
    <i class="icon-database-refresh position-left"></i>
    <span class="text-semibold">
        REKAPRKPDPERUBAHANOPD TAHUN PERENCANAAN {{config('eplanning.tahun_perencanaan')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.report.rekaprkpdperubahanopd.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('rekaprkpdperubahanopd.index')!!}">REKAPRKPDPERUBAHANOPD</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('rekaprkpdperubahanopd.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection