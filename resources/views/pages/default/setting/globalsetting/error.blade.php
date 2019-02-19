@extends('layouts.default.l_main')
@section('page_title')
    GLOBALSETTING
@endsection
@section('page_header')
    <i class="fa fa-lock"></i> 
    GLOBALSETTING
@endsection
@section('page-info')
    @include('pages.default.setting.globalsetting.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('globalsetting.index')!!}">GLOBALSETTING</a></li>
    <li class="active">ERROR</li>
@endsection
@section('page_content')
<div class="alert alert-danger">
    <button type="button" class="close" onclick="location.href='{{route('globalsetting.index')}}'">×</button>
    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
    {{$errormessage}}
</div>
@endsection