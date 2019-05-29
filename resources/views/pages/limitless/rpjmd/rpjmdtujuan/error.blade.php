@extends('layouts.limitless.l_main')
@section('page_title')
    RPJMD TUJUAN
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold">
        RPJMD TUJUAN  TAHUN {{config('eplanning.rpjmd_tahun_mulai')}} - {{config('eplanning.rpjmd_tahun_akhir')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.rpjmd.rpjmdtujuan.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('rpjmdtujuan.index')!!}">RPJMD TUJUAN</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('rpjmdtujuan.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection