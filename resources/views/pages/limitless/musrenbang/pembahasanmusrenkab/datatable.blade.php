<div class="panel panel-flat border-top-lg border-top-info border-bottom-info">
    <div class="panel-heading">
        <div class="panel-title">
            <div class="row">
                <div class="col-md-1">                    		
					{!!Form::select('numberRecordPerPage',['1'=>1,'5'=>5,'10'=>10,'15'=>15,'30'=>30,'50'=>50],$numberRecordPerPage,['id'=>'numberRecordPerPage','class'=>'form-control'])!!}                        
                </div>
            </div>
        </div>
        <div class="heading-elements">
            
        </div>
    </div>
    @if (count($data) > 0)
    <div class="table-responsive"> 
        <table id="data" class="table table-striped table-hover">
            <thead>
                <tr class="bg-teal-700">
                    <th width="50">NO</th>     
                    <th width="150">
                        <a class="column-sort text-white" id="col-kode_kegiatan" data-order="{{$direction}}" href="#">
                            KODE KEGIATAN                                                                       
                        </a>
                    </th>                
                    <th width="400">
                        <a class="column-sort text-white" id="col-KgtNm" data-order="{{$direction}}" href="#">
                            NAMA KEGIATAN                                                                       
                        </a>
                    </th> 
                    <th width="300">
                        <a class="column-sort text-white" id="col-Uraian" data-order="{{$direction}}" href="#">
                            NAMA URAIAN                                                                       
                        </a>
                    </th>
                    <th width="200">
                        <a class="column-sort text-white" id="col-Sasaran_Angka4" data-order="{{$direction}}" href="#">
                            SASARAN  
                        </a>                                             
                    </th> 
                    <th width="120">                        
                        TARGET (%)                        
                    </th> 
                    <th width="150" class="text-right">
                        <a class="column-sort text-white" id="col-Jumlah4" data-order="{{$direction}}" href="#">
                            NILAI  
                        </a>                                             
                    </th> 
                    <th width="120">                        
                        PRIORITAS                          
                    </th>          
                    <th width="70">TRANSFER</th>                            
                    <th width="150">AKSI</th>
                </tr>
            </thead>
            <tbody>                    
            @foreach ($data as $key=>$item)
                <tr>
                    <td>
                        {{ ($data->currentpage()-1) * $data->perpage() + $key + 1 }}    
                    </td>
                    <td>
                        {{$item->kode_kegiatan}}                        
                    </td>
                    <td>
                        {{ucwords($item->KgtNm)}}
                        @if (empty($item->RenjaIndikatorID))
                            <span class="label label-flat border-warning text-warning-600">
                                INDIKATOR TIDAK ADA
                            </span>
                        @endif
                    </td>
                    @if ($item->RenjaRincID=='')
                    <td colspan="6">
                        <span class="label label-flat label-block border-info text-info-600">
                            PROSES INPUT MUSRENBANG KABUPATEN BELUM SELESAI
                        </span>
                        <a href="{{route('usulanprarenjaopd.create1',['uuid'=>$item->RenjaID])}}">
                            Lanjutkan Input 
                        </a>
                    </td>
                    <td>
                        <ul class="icons-list">                            
                            <li class="text-danger-600">
                                <a class="btnDelete" href="javascript:;" title="Hapus Data Usulan Musren Kabupaten" data-id="{{$item->RenjaID}}" data-url="{{route('usulanprarenjaopd.index')}}">
                                    <i class='icon-trash'></i>
                                </a> 
                            </li>
                        </ul>
                    </td>
                    @else
                    <td>
                        {{ucwords($item->Uraian)}}<br />
                        <span class="label label-flat border-grey text-grey-600">                        
                            @if ($item->isSKPD)
                                <a href="#">
                                    <strong>Usulan dari: </strong>OPD / SKPD
                                </a> 
                            @elseif($item->isReses)
                                <a href="#">
                                    <strong>Usulan dari: </strong>POKIR [{{$item->isReses_Uraian}}]
                                </a>
                            @else
                                <a href="{{route('aspirasimusrenkecamatan.show',['id'=>$item->UsulanKecID])}}">
                                    <strong>Usulan dari: MUSREN. KEC. {{$item->Nm_Kecamatan}}
                                </a>
                            @endif
                        </span>
                    </td>
                    <td>{{Helper::formatAngka($item->Sasaran_Angka4)}} {{$item->Sasaran_Uraian4}}</td>
                    <td>{{$item->Target4}}</td>
                    <td class="text-right">{{Helper::formatuang($item->Jumlah4)}}</td>
                    <td>
                        <span class="label label-flat border-success text-success-600">
                            {{HelperKegiatan::getNamaPrioritas($item->Prioritas)}}
                        </span>
                    </td>
                    <td>
                        @if ($item->Privilege==1)
                            <i class="icon-checkmark"></i>
                        @elseif ($item->Status==1||$item->Status==2)
                            <a href="#" title="TRANSFER KE VERIFIKASI RENJA" class="btn btn-link" id="btnTransfer" data-id="{{$item->RenjaRincID}}">
                                <i class="icon-play4"></i>
                            </a>
                        @else
                            <i class="icon-cross3"></i>
                        @endif      
                    </td>
                    <td>
                        @if ($item->Privilege==0)
                            <div class="checkbox checkbox-switch">
                                {{Form::checkbox('Privilege[]',$item->RenjaRincID,$item->Status==1||$item->Status==2?'ACC':'',['class'=>'switch','data-on-text'=>'ACC','data-off-text'=>'DUM'])}}                                     
                            </div>
                        @else
                            <span class="label label-success label-flat border-success text-success-600">
                                {{HelperKegiatan::getStatusKegiatan($item->Status)}}
                            </span>
                            @if ($item->Status==2)
                                <br/>   
                                {{$item->Descr}}   
                            @endif    
                        @endif
                    </td>
                    @endif                    
                </tr>
                <tr class="text-center info">
                    <td colspan="10">
                        <span class="label label-warning label-rounded">
                            <strong>RenjaID:</strong>
                            {{$item->RenjaID}}
                        </span>
                        <span class="label label-warning label-rounded">
                            <strong>RenjaRincID:</strong>
                            {{$item->RenjaRincID}}
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
            Belum ada data yang bisa ditampilkan. Mohon pilih terlebih dahulu OPD dan Unit Kerja
        </div>
    </div>   
    @endif            
</div>