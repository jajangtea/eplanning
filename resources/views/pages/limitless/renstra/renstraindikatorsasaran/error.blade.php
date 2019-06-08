@extends('layouts.limitless.l_main')
@section('page_title')
    RENSTRA INDIKASI RENCANA PROGRAM
@endsection
@section('page_header')
    <i class="icon-strategy position-left"></i>
    <span class="text-semibold">
        RENSTRA INDIKASI RENCANA PROGRAM TAHUN {{config('eplanning.renstra_tahun_mulai')}} - {{config('eplanning.renstra_tahun_akhir')}}  
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.renstra.renstraindikatorkinerja.info')
@endsection
@section('page_breadcrumb')
    <li><a href="#">RENSTRA</a></li>
    <li><a href="{!!route('renstraindikatorkinerja.index')!!}">INDIKASI RENCANA PROGRAM</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('renstraindikatorkinerja.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection