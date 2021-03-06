@extends('layouts.limitless.l_main')
@section('page_title')
    USULAN FORUM OPD/SKPD
@endsection
@section('page_header')
    <i class="icon-price-tag position-left"></i>
    <span class="text-semibold"> 
        USULAN FORUM OPD/SKPD TAHUN PERENCANAAN {{config('globalsettings.tahun_perencanaan')}}
    </span>     
@endsection
@section('page_info')
    @include('pages.limitless.rkpd.usulanrakorbidang.info')
@endsection
@section('page_breadcrumb')
    <li><a href="#">PERENCANAAN</a></li>
    <li><a href="#">ASPIRASI / USULAN</a></li>
    <li><a href="{!!route('usulanrakorbidang.index')!!}">USULAN FORUM OPD/SKPD</a></li>
    <li class="active">UBAH DATA</li>
@endsection
@section('page_content')
<div class="content">
    <div class="panel panel-flat">
        <div class="panel-heading">
            <h5 class="panel-title">
                <i class="icon-pencil7 position-left"></i> 
                UBAH DATA
            </h5>
            <div class="heading-elements">
                <ul class="icons-list">                    
                    <li>
                        <a href="{!!route('usulanrakorbidang.index')!!}" data-action="closeredirect" title="keluar"></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="panel-body">
            {!! Form::open(['action'=>['RKPD\UsulanRAKORBidangController@update',$renja->RenjaID],'method'=>'post','class'=>'form-horizontal','id'=>'frmdata','name'=>'frmdata'])!!}        
                {{Form::hidden('_method','PUT')}}
                <div class="form-group">
                    <label class="col-md-2 control-label">POSISI ENTRI: </label>
                    <div class="col-md-10">
                        <p class="form-control-static">
                            <span class="label border-left-primary label-striped">USULAN FORUM OPD / SKPD</span>
                        </p>
                    </div>                            
                </div>
                <div class="form-group">
                    {{Form::label('UrsID','NAMA URUSAN',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        <p class="form-control-static">{{$renja->Nm_Bidang}}</p>           
                    </div>
                </div> 
                <div class="form-group">
                    {{Form::label('PrgID','NAMA PROGRAM',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        <p class="form-control-static">{{$renja->PrgNm}}</p>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('KgtID','NAMA KEGIATAN',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        <p class="form-control-static">{{$renja->KgtNm}}</p>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('Sasaran_Angka2','SASARAN KEGIATAN',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                {{Form::text('Sasaran_Angka2',Helper::formatAngka($renja['Sasaran_Angka2']),['class'=>'form-control','placeholder'=>'ANGKA SASARAN'])}}
                            </div>
                            <div class="col-md-6">
                                {{Form::textarea('Sasaran_Uraian2',$renja['Sasaran_Uraian2'],['rows'=>3,'class'=>'form-control','placeholder'=>'URAIAN SASARAN'])}}
                            </div>
                        </div>                        
                    </div>                   
                </div>                
                <div class="form-group">
                    {{Form::label('Sasaran_AngkaSetelah','SASARAN KEGIATAN (N+1)',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-6">
                                {{Form::text('Sasaran_AngkaSetelah',Helper::formatAngka($renja['Sasaran_AngkaSetelah']),['class'=>'form-control','placeholder'=>'ANGKA SASARAN (N+1)'])}}
                            </div>
                            <div class="col-md-6">
                                {{Form::textarea('Sasaran_UraianSetelah',$renja['Sasaran_UraianSetelah'],['rows'=>3,'class'=>'form-control','placeholder'=>'URAIAN SASARAN (N+1)'])}}
                            </div>
                        </div>                        
                    </div>
                </div>                
                <div class="form-group">
                    {{Form::label('Target2','TARGET (%)',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        {{Form::text('Target2',Helper::formatAngka($renja['Target2']),['class'=>'form-control','placeholder'=>'PERSENTASE TARGET KEGIATAN'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('NilaiSebelum','NILAI',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-4">
                                {{Form::text('NilaiSebelum',Helper::formatUang($renja['NilaiSebelum']),['class'=>'form-control','placeholder'=>'NILAI (TA-1)'])}}
                            </div>
                            <div class="col-md-4">
                                {{Form::text('NilaiUsulan2',Helper::formatUang($renja['NilaiUsulan2']),['class'=>'form-control','placeholder'=>'NILAI USULAN (TA)','id'=>'NilaiUsulan2'])}}
                            </div> 
                            <div class="col-md-4">
                                {{Form::text('NilaiSetelah',Helper::formatUang($renja['NilaiSetelah']),['class'=>'form-control','placeholder'=>'NILAI (TA+1)','id'=>'NilaiSetelah'])}}
                            </div>       
                        </div>                                         
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('NamaIndikator','INDIKATOR KEGIATAN',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        {{Form::textarea('NamaIndikator',$renja['NamaIndikator'],['rows'=>3,'class'=>'form-control','placeholder'=>'INDIKATOR KEGIATAN'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('SumberDanaID','SUMBER DANA',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        {{Form::select('SumberDanaID', $sumber_dana, $renja['SumberDanaID'],['class'=>'form-control','id'=>'SumberDanaID'])}}
                    </div>
                </div>                
                <div class="form-group">
                    {{Form::label('Descr','KETERANGAN / CATATAN PENTING',['class'=>'control-label col-md-2'])}}
                    <div class="col-md-10">
                        {{Form::textarea('Descr',$renja['Descr'],['rows'=>3,'class'=>'form-control','placeholder'=>'KETERANGAN'])}}
                    </div>
                </div> 
                <div class="form-group">            
                    <div class="col-md-10 col-md-offset-2">                        
                        {{ Form::button('<b><i class="icon-floppy-disk "></i></b> SIMPAN', ['type' => 'submit', 'class' => 'btn btn-info btn-labeled btn-xs'] )  }}                        
                    </div>
                </div>
            {!! Form::close()!!}
        </div>
    </div>
</div>  
@endsection
@section('page_asset_js')
<script src="{!!asset('themes/limitless/assets/js/jquery-validation/jquery.validate.min.js')!!}"></script>
<script src="{!!asset('themes/limitless/assets/js/jquery-validation/additional-methods.min.js')!!}"></script>
<script src="{!!asset('themes/limitless/assets/js/select2.min.js')!!}"></script>
<script src="{!!asset('themes/limitless/assets/js/autoNumeric.min.js')!!}"></script>
@endsection
@section('page_custom_js')
<script type="text/javascript">
$(document).ready(function () {
    AutoNumeric.multiple(['#Sasaran_Angka2','#Sasaran_AngkaSetelah'], {
                                            allowDecimalPadding: false,
                                            minimumValue:0,
                                            maximumValue:99999999999,
                                            numericPos:true,
                                            decimalPlaces : 0,
                                            digitGroupSeparator : '',
                                            showWarnings:false,
                                            unformatOnSubmit: true,
                                            modifyValueOnWheel:false
                                        });
    AutoNumeric.multiple(['#Target2'], {
                                            allowDecimalPadding: false,
                                            minimumValue:0.00,
                                            maximumValue:100.00,
                                            numericPos:true,
                                            decimalPlaces : 2,
                                            digitGroupSeparator : '',
                                            showWarnings:false,
                                            unformatOnSubmit: true,
                                            modifyValueOnWheel:false
                                        });

    AutoNumeric.multiple(['#NilaiSebelum','#NilaiUsulan2','#NilaiSetelah'],{
                                            allowDecimalPadding: false,
                                            decimalCharacter: ",",
                                            digitGroupSeparator: ".",
                                            unformatOnSubmit: true,
                                            showWarnings:false,
                                            modifyValueOnWheel:false
                                        });
                                        $('#frmdata').validate({
        ignore:[],
        rules: {
            UrsID : {
                required: true
            },  
            PrgID : {
                required: true
            },
            KgtID : {
                required: true
            },         
            Sasaran_Angka2 : {
                required: true,
            },
            Sasaran_Uraian2 : {
                required: true
            },
            Sasaran_AngkaSetelah : {
                required: true
            },
            Sasaran_UraianSetelah : {
                required: true
            },
            Target2 : {
                required: true
            },
            NilaiSebelum : {
                required: true
            },
            NilaiUsulan2 : {
                required: true
            },
            NilaiSetelah : {
                required: true
            },
            NamaIndikator : {
                required: true,                
            },
            SumberDanaID : {
                valueNotEquals: 'none'
            }         
        },
        messages : {
            UrsID : {
                required: "Mohon untuk di pilih urusan untuk kegiatan ini.",                
            },            
            PrgID : {
                required: "Mohon untuk di pilih program nama kegiatan.",                
            },
            KgtID : {
                required: "Mohon untuk di pilih nama kegiatan.",                
            },
            Sasaran_Angka2 : {
                required: "Mohon untuk di isi angka sasaran kegiatan.",                
            },
            Sasaran_Uraian2 : {
                required: "Mohon untuk di isi uraian sasaran kegiatan.",                
            },
            Sasaran_AngkaSetelah : {
                required: "Mohon untuk di isi angka sasaran kegiatan (N+1).",                
            },
            Sasaran_UraianSetelah : {
                required: "Mohon untuk di isi uraian sasaran kegiatan (N+1).",                
            },
            Target2 : {
                required: "Mohon untuk di isi persentase target kegiatan.",                
            },
            NilaiSebelum : {
                required: "Mohon untuk di isi nilai (TA-1).",                
            },
            NilaiUsulan2 : {
                required: "Mohon untuk di isi nilai (TA).",                
            },
            NilaiSetelah : {
                required: "Mohon untuk di isi nilai (TA+1).",                
            },
            NamaIndikator : {
                required: "Mohon untuk di isi indikator kegiatan.",                
            },
            SumberDanaID : {
                valueNotEquals: "Mohon untuk di pilih sumber dana untuk kegiatan ini."                
            }

        }      
    });  
});
</script>
@endsection