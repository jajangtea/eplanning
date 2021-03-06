<div class="panel panel-flat border-top-md border-top-info border-bottom-info">
    <div class="panel-heading">
        <div class="panel-title" style="width:70px">
            {!!Form::select('numberRecordPerPage',['1'=>1,'5'=>5,'10'=>10,'15'=>15,'30'=>30,'50'=>50],$numberRecordPerPage,['id'=>'numberRecordPerPage','class'=>'form-control'])!!}            
        </div>
        <div class="heading-elements">
            <div class="heading-btn">
                @can('add_kelompokurusan')
                <a href="{!!route('kelompokurusan.create')!!}" class="btn btn-info btn-xs" title="Tambah Kelompok Urusan">
                    <i class="icon-googleplus5"></i>
                </a>
                @endcan
            </div>
        </div>        
    </div>
    @if (count($data) > 0)
    <div class="table-responsive"> 
        <table id="data" class="table table-striped table-hover">
            <thead>
                <tr class="bg-teal-700">
                    <th width="55">NO</th>
                    <th width="190">
                        <a class="column-sort text-white" id="col-Kd_Urusan" data-order="{{$direction}}" href="#">
                            KODE KELOMPOK URUSAN  
                        </a>                                             
                    </th> 
                    <th>
                        <a class="column-sort text-white" id="col-Nm_Urusan" data-order="{{$direction}}" href="#">
                            NAMA KELOMPOK URUSAN  
                        </a>                                             
                    </th> 
                    <th>
                        KETERANGAN                                            
                    </th> 
                    <th width="100">AKSI</th>
                </tr>
            </thead>
            <tbody>                    
            @foreach ($data as $key=>$item)
                <tr>
                    <td>
                        {{ ($data->currentpage()-1) * $data->perpage() + $key + 1 }}    
                    </td>                  
                    <td>{{$item->Kd_Urusan}}</td>
                    <td>{{$item->Nm_Urusan}}</td>
                    <td>{{$item->Descr}}</td>
                    <td>
                        <ul class="icons-list">
                            @can('show_kelompokurusan')
                            <li class="text-primary-600">
                                <a class="btnShow" href="{{route('kelompokurusan.show',['id'=>$item->KUrsID])}}" title="Detail Data Kelompok Urusan">
                                    <i class='icon-eye'></i>
                                </a>  
                            </li>
                            @endcan              
                            @can('edit_kelompokurusan')                                         
                            <li class="text-primary-600">
                                <a class="btnEdit" href="{{route('kelompokurusan.edit',['id'=>$item->KUrsID])}}" title="Ubah Data Kelompok Urusan">
                                    <i class='icon-pencil7'></i>
                                </a> 
                            </li>
                            @endcan      
                            @can('delete_kelompokurusan')                                         
                            <li class="text-danger-600">
                                <a class="btnDelete" href="javascript:;" title="Hapus Data Kelompok Urusan" data-id="{{$item->KUrsID}}" data-url="{{route('kelompokurusan.index')}}">
                                    <i class='icon-trash'></i>
                                </a> 
                            </li>
                            @endcan              
                        </ul>
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
