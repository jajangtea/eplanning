@extends('layouts.limitless.l_main')
@section('page_title')
    PEMILIK BANTUAN SOSIAL DAN HIBAH
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold"> 
        PEMILIK BANTUAN SOSIAL DAN HIBAH TAHUN PERENCANAAN {{HelperKegiatan::getTahunPerencanaan()}}
    </span>     
@endsection
@section('page_info')
    @include('pages.limitless.aspirasi.pemilikbansoshibah.info')
@endsection
@section('page_breadcrumb')
    <li><a href="#">ASPIRASI</a></li>
    <li><a href="{!!route('pemilikbansoshibah.index')!!}">PEMILIK BANTUAN SOSIAL DAN HIBAH</a></li>
    <li class="active">DETAIL DATA</li>
@endsection
@section('page_content')
<div class="row">    
    <div class="col-md-12">
        <div class="panel panel-flat border-top-info border-bottom-info">
            <div class="panel-heading">
                <h5 class="panel-title"> 
                    <i class="icon-eye"></i>  DATA PEMILIK BANTUAN SOSIAL DAN HIBAH
                </h5>
                <div class="heading-elements">   
                    <a href="{{route('pemilikbansoshibah.create')}}" class="btn btn-info btn-icon heading-btn btnTambah" title="Tambah Data Pemilik Bantuan Sosial dan Hibah">
                        <i class="icon-googleplus5"></i>
                    </a>
                    <a href="{{route('pemilikbansoshibah.edit',['id'=>$data->PemilikBansosHibahID])}}" class="btn btn-primary btn-icon heading-btn btnEdit" title="Ubah Data Pemilik Bantuan Sosial dan Hibah">
                        <i class="icon-pencil7"></i>
                    </a>
                    <a href="javascript:;" title="Hapus Data Pemilik Bantuan Sosial dan Hibah" data-id="{{$data->PemilikBansosHibahID}}" data-url="{{route('pemilikbansoshibah.index')}}" class="btn btn-danger btn-icon heading-btn btnDelete">
                        <i class='icon-trash'></i>
                    </a>
                    <a href="{!!route('pemilikbansoshibah.index')!!}" class="btn btn-default btn-icon heading-btn" title="keluar">
                        <i class="icon-close2"></i>
                    </a>            
                </div>
            </div>
            <div class="panel-body">
                <div class="row">                                      
                    <div class="col-md-6">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>PemilikBansosHibahID: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->PemilikBansosHibahID}}</p>
                                </div>                            
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>KODE: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->Kd_PK}}</p>
                                </div>                            
                            </div>    
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>NAMA: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->NmPk}}</p>
                                </div>                            
                            </div>    
                        </div>                        
                    </div>
                    <div class="col-md-6">
                        <div class="form-horizontal">
                             <div class="form-group">
                                <label class="col-md-4 control-label"><strong>KETERANGAN: </strong></label>
                                <div class="col-md-8">
                                    <p class="form-control-static">{{$data->Descr}}</p>
                                </div>                            
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label"><strong>TGL. BUAT: </strong></label>
                                <div class="col-md-8"> 
                                    <p class="form-control-static">{{Helper::tanggal('d/m/Y H:m',$data->updated_at)}}</p>
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
        if (confirm('Apakah Anda ingin menghapus Data Pemilik Bantuan Sosial dan Hibah ini ?')) {
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