@extends('layouts.limitless.l_main')
@section('page_title')
    PEMILIKPOKOKPIKIRAN
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        PEMILIKPOKOKPIKIRAN TAHUN PERENCANAAN {{config('globalsettings.tahun_perencanaan')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.dmaster.pemilikpokokpikiran.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('pemilikpokokpikiran.index')!!}">PEMILIKPOKOKPIKIRAN</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('kelompokurusan.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection