<div class="panel panel-flat border-top-lg border-top-info border-bottom-info">
    <div class="panel-heading">
        <div class="panel-title">
            <h6 class="panel-title">&nbsp;</h6>
        </div>
        <div class="heading-elements">
            {!! Form::open(['url'=>'#','method'=>'post','class'=>'heading-form','id'=>'frmheading','name'=>'frmheading'])!!} 
                <div class="form-group">
                    {!!Form::select('numberRecordPerPage',['1'=>1,'5'=>5,'10'=>10,'15'=>15,'30'=>30,'50'=>50],$numberRecordPerPage,['id'=>'numberRecordPerPage','class'=>'form-control','style'=>'width:70px'])!!}                        
                </div> 
                <div class="form-group">
                    <a href="{!!route('aspirasimusrenkecamatan.pilihusulankegiatan')!!}" class="btn btn-info btn-xs" title="Tambah Usulan Kegiatan">
                        <i class="icon-googleplus5"></i>
                    </a>
                </div>
            {!! Form::close()!!}                      
        </div>
    </div>
    @if (count($data) > 0)
    <div class="table-responsive"> 
        <table id="data" class="table table-striped table-hover">
            <thead>
                <tr class="bg-teal-700">
                    <th width="55">
                        <a class="column-sort text-white" id="col-No_usulan" data-order="{{$direction}}" href="#">
                            KODE  
                        </a>                                             
                    </th> 
                    <th width="180">
                        <a class="column-sort text-white" id="col-Nm_Desa" data-order="{{$direction}}" href="#">
                            DESA/KELURAHAN  
                        </a>                                             
                    </th> 
                    <th width="210">
                        <a class="column-sort text-white" id="col-Nm_Kecamatan" data-order="{{$direction}}" href="#">
                            KECAMATAN  
                        </a>                                             
                    </th> 
                    <th>
                        <a class="column-sort text-white" id="col-NamaKegiatan" data-order="{{$direction}}" href="#">
                            NAMA KEGIATAN  
                        </a>                                             
                    </th> 
                    <th width="200">                        
                        OUTPUT                        
                    </th> 
                    <th width="120">
                        <a class="column-sort text-white" id="col-NilaiUsulan" data-order="{{$direction}}" href="#">
                            NILAI
                        </a>                                             
                    </th> 
                    <th width="150">                        
                        VOLUME                        
                    </th> 
                    <th width="55">                        
                        PRIORITAS                        
                    </th> 
                    <th width="55">                        
                        STATUS                        
                    </th> 
                    <th width="100">AKSI</th>
                </tr>
            </thead>
            <tbody>                    
            @foreach ($data as $key=>$item)
            <tr>                  
                <td>{{$item->No_usulan}}</td>
                <td>
                    @if (empty($item->Nm_Desa))
                    <span class="label label-flat border-default text-grey-600">
                        USULAN KEC.
                    </span>  
                    @else
                    {{$item->Nm_Desa}}
                    @endif                        
                </td>
                <td>{{$item->Nm_Kecamatan}}</td>
                <td>
                    {{$item->NamaKegiatan}}<br />
                    <span class="label label-flat border-primary text-primary-600">{{$item->Jeniskeg == 1 ? 'FISIK' : 'NON-FISIK'}}</span>
                </td>
                <td>{{$item->Output}}</td>
                <td>{{Helper::formatUang($item->NilaiUsulan)}}</td>
                <td>{{$item->Target_Angka}} {{$item->Target_Uraian}}</td>
                <td>
                    <span class="label label-flat border-success text-success-600">
                        {{HelperKegiatan::getNamaPrioritas($item->Prioritas)}}
                    </span>                        
                </td>
                <td>
                    @if (isset($daftar_usulan_kec_id[$item->UsulanKecID]))
                    <span class="label label-success label-flat border-success text-success-600">
                        TRANSFERED
                    </span>
                    @elseif($item->Privilege==1)
                    <span class="label label-success label-flat border-success text-success-600">
                        ACC
                    </span>
                    @else
                    <span class="label label-default label-flat border-default text-grey-600">
                        DUM
                    </span>
                    @endif
                </td>
                <td>
                    <ul class="icons-list">
                        <li class="text-primary-600">
                            <a class="btnShow" href="{{route('aspirasimusrenkecamatan.show',['uuid'=>$item->UsulanKecID])}}" title="Detail Data Kegiatan">
                                <i class='icon-eye'></i>
                            </a>  
                        </li>
                        @if (!isset($daftar_usulan_kec_id[$item->UsulanKecID]))
                        <li class="text-primary-600">
                            <a class="btnEdit" href="{{route('aspirasimusrenkecamatan.edit',['uuid'=>$item->UsulanKecID])}}" title="Ubah Data Kegiatan">
                                <i class='icon-pencil7'></i>
                            </a>  
                        </li>
                        @if($item->Privilege==0)
                        <li class="text-danger-600">
                            <a class="btnDelete" href="javascript:;" title="Hapus Data Kegiatan" data-id="{{$item->UsulanKecID}}" data-url="{{route('aspirasimusrenkecamatan.index')}}">
                                <i class='icon-trash'></i>
                            </a> 
                        </li>
                        @endif 
                        @endif  
                    </ul>
                </td>
            </tr>
            <tr class="text-center info">
                <td colspan="10">
                    <span class="label label-warning label-rounded" style="text-transform: none">
                        <strong>USULANKECID:</strong>
                        {{$item->UsulanKecID}}
                    </span>
                    <span class="label label-warning label-rounded">
                        <strong>OPD/SKPD:</strong>
                        {{$item->OrgNm}}
                    </span>
                    <span class="label label-warning label-rounded">
                        <strong>TA:</strong>
                        {{$item->TA}}
                    </span>
                    <span class="label label-warning label-rounded">
                        <strong>KET:</strong>
                        {{empty($item->Descr)?'-':$item->Descr}}
                    </span>
                </td>
            </tr>
            @endforeach                    
            </tbody>
        </table>               
    </div>
    <div class="panel-body border-top-info text-center" id="paginations">
        {{$data->links('layouts.limitless.l_pagination')}}               
    </div>
    @else
    <div class="panel-body">
        <div class="alert alert-info alert-styled-left alert-bordered">
            <span class="text-semibold">Info!</span>
            Belum ada data yang bisa ditampilkan.
        </div>
    </div>   
    @endif            
</div>
