@extends('layouts.limitless.l_main')
@section('page_title')
    USERS DESA / KELURAHAN
@endsection
@section('page_header')
    <i class="icon-users position-left"></i>
    <span class="text-semibold"> 
        USERS DESA / KELURAHAN
    </span>     
@endsection
@section('page_info')
    @include('pages.limitless.setting.usersdesa.info')
@endsection
@section('page_breadcrumb')
    <li><a href="{!!route('usersdesa.index')!!}">USERS DESA / KELURAHAN</a></li>
    <li class="active">DETAIL DATA</li>
@endsection
@section('page_content')
<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-flat border-top-info border-bottom-info">
            <div class="panel-heading">
                <h5 class="panel-title"> 
                    <i class="icon-eye"></i>  DATA USERS DESA / KELURAHAN
                </h5>
                <div class="heading-elements">   
                    <a href="{!!route('usersdesa.create')!!}" class="btn btn-info btn-icon heading-btn btnAdd" title="Tambah USERS DESA / KELURAHAN">
                        <i class="icon-googleplus5"></i>
                    </a>
                    <a href="{{route('usersdesa.edit',['id'=>$data->usersdesa_id])}}" class="btn btn-primary btn-icon heading-btn btnEdit" title="Ubah Data UsersDesa">
                        <i class="icon-pencil7"></i>
                    </a>
                    <a href="javascript:;" title="Hapus Data UsersDesa" data-id="{{$data->usersdesa_id}}" data-url="{{route('usersdesa.index')}}" class="btn btn-danger btn-icon heading-btn btnDelete">
                        <i class='icon-trash'></i>
                    </a>
                    <a href="{!!route('usersdesa.index')!!}" class="btn btn-default btn-icon heading-btn" title="keluar">
                        <i class="icon-close2"></i>
                    </a>            
                </div>
            </div>
            <div class="panel-body">
                <div class="row">                                      
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>usersdesa id: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->usersdesa_id}}</p>
                                </div>                            
                            </div>                            
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TGL. BUAT: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{Helper::tanggal('d/m/Y H:m',$data->created_at)}}</p>
                                </div>                            
                            </div>
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>replaceit: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">replaceit</p>
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
        if (confirm('Apakah Anda ingin menghapus Data UsersDesa ini ?')) {
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