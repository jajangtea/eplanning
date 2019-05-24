@extends('layouts.limitless.l_main')
@section('page_title')
    REKENINGRINCIANOBYEKBELANJAMODAL
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        REKENINGRINCIANOBYEKBELANJAMODAL TAHUN PERENCANAAN {{config('eplanning.tahun_perencanaan')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.dmaster.rekeningrincianobyekbelanjamodal.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('rekeningrincianobyekbelanjamodal.index')!!}">REKENINGRINCIANOBYEKBELANJAMODAL</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('kelompokurusan.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection