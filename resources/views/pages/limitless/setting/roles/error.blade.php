@extends('layouts.limitless.l_main')
@section('page_title')
    ROLES
@endsection
@section('page_header')
    <i class="icon-user-tie position-left"></i>
    <span class="text-semibold">
        ROLES TAHUN PERENCANAAN {{config('globalsettings.tahun_perencanaan')}}
    </span>
@endsection
@section('page_info')
    @include('pages.limitless.setting.roles.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('roles.index')!!}">ROLES</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger alert-styled-left alert-bordered">
    <button type="button" class="close" onclick="location.href='{{route('kelompokurusan.index')}}'">×</button>
    {{$errormessage}}
</div>
@endsection