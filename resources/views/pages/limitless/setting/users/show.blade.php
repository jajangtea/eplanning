@extends('layouts.limitless.l_main')
@section('page_title')
    USERS BAPELITBANG (SUPER ADMIN)
@endsection 
@section('page_header')
    <i class="icon-users position-left"></i>
    <span class="text-semibold"> 
        USERS BAPELITBANG (SUPER ADMIN)
    </span>     
@endsection
@section('page_info')
    @include('pages.limitless.setting.users.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('users.index')!!}">USERS BAPELITBANG (SUPER ADMIN)</a></li>
    <li class="active">DETAIL DATA</li>
@endsection
@section('page_content')
<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-flat border-top-info border-bottom-info">
            <div class="panel-heading">
                <h5 class="panel-title"> 
                    <i class="icon-eye"></i>  DATA USER
                </h5>
                <div class="heading-elements">   
                    <a href="{{route('users.edit',['id'=>$data->id])}}" class="btn btn-primary btn-icon heading-btn btnEdit" title="Ubah Data User">
                        <i class="icon-pencil7"></i>
                    </a>
                    @if ($data->isdeleted)   
                    <a href="javascript:;" title="Hapus Data User" data-id="{{$data->id}}" data-url="{{route('users.index')}}" class="btn btn-danger btn-icon heading-btn btnDelete">
                        <i class='icon-trash'></i>
                    </a>
                    @endif
                    <a href="{!!route('users.index')!!}" class="btn btn-default btn-icon heading-btn" title="keluar">
                        <i class="icon-close2"></i>
                    </a>            
                </div>
            </div>
            <div class="panel-body">
                <div class="row">                                      
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><strong>ID: </strong></label>
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{$data->id}}</p>
                                    </div>                            
                                </div>    
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><strong>USERNAME: </strong></label>
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{$data->username}}</p>
                                    </div>                            
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-4 control-label"><strong>NAMA: </strong></label>
                                    <div class="col-md-8">
                                        <p class="form-control-static">{{$data->name}}</p>
                                    </div>                            
                                </div>  
                            </div>  
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>EMAIL: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->email}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TGL. BUAT: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::tanggal('d/m/Y H:m',$data->created_at)}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TGL. UBAH: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::tanggal('d/m/Y H:m',$data->updated_at)}}</p>
                                </div>                            
                            </div>                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection
@section('page_custom_js')
<script type="text/javascript">
$(document).ready(function () {
    $(".btnDelete").click(function(ev) {
        if (confirm('Apakah Anda ingin menghapus Data Users ini ?')) {
            let url_ = $(this).attr("data-url");
            let id = $(this).attr("data-id");
            let token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({            
                type:'post',
                url:url_+'/'+id,
                dataType: 'json',
                data: {
                    "_method": 'DELETE',
                    "_token": token,
                    "id": id,
                },
                success:function(data){ 
                    window.location.replace(url_);                        
                },
                error:function(xhr, status, error){
                    console.log('ERROR');
                    console.log(parseMessageAjaxEror(xhr, status, error));                           
                },
            });
        }
    });
    
});
</script>
@endsection