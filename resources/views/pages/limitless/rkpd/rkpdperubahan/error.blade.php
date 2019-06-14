@extends('layouts.limitless.l_main')
@section('page_title')
    RKPD PERUBAHAN
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        RKPD PERUBAHAN TAHUN PERENCANAAN {{config('eplanning.tahun_perencanaan')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.rkpdperubahan.rkpd.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('rkpdperubahan.index')!!}">RKPD PERUBAHAN</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('rkpdperubahan.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection