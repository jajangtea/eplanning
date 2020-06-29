@extends('layouts.limitless.l_main')
@section('page_title')
    REKENINGOBYEK
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        REKENINGOBYEK TAHUN PERENCANAAN {{HelperKegiatan::getTahunPerencanaan()}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.dmaster.rekeningobyek.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('rekeningobyek.index')!!}">REKENINGOBYEK</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('kelompokurusan.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection