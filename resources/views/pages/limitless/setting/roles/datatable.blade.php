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
            <div class="heading-btn">
                <a href="{!!route('roles.create')!!}" class="btn btn-info btn-xs" title="Tambah ROLES">
                    <i class="icon-googleplus5"></i>
                </a>
            </div>            
        </div>
    </div>
    @if (count($data) > 0)
    <div class="table-responsive"> 
        <table id="data" class="table table-striped table-hover">
            <thead>
                <tr class="bg-teal-700">
                    <th width="55">NO</th>
                    <th width="100">
                        <a class="column-sort text-white" id="col-id" data-order="{{$direction}}" href="#">
                            ID
                        </a>
                    </th>
                    <th>
                        <a class="column-sort text-white" id="col-name" data-order="{{$direction}}" href="#">
                            NAMA ROLE
                        </a>
                    </th>   
                    <th width="150">
                        <a class="column-sort text-white" id="col-guard" data-order="{{$direction}}" href="#">
                            GUARD                            
                        </a>                        
                    </th>
                    <th>
                        <a class="column-sort text-white" id="col-jumlah" data-order="{{$direction}}" href="#">
                            JUMLAH USER
                        </a>
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
                    <td>{{$item->id}}</td>   
                    <td>{{$item->name}}</td>
                    <td>{{$item->guard_name}}</td>
                    <td>{{$item->jumlah}}</td>   
                    <td>
                        <ul class="icons-list">
                            <li class="text-primary-600">
                                <a class="btnShow" href="{{route('roles.show',['id'=>$item->id])}}" title="Detail Data Role">
                                    <i class='icon-eye'></i>
                                </a>  
                            </li>
                            <li class="text-primary-600">
                                <a class="btnEdit" href="{{route('roles.edit',['id'=>$item->id])}}" title="Ubah Data Role">
                                    <i class='icon-pencil7'></i>
                                </a>  
                            </li>
                            <li class="text-danger-600">
                                <a class="btnDelete" href="javascript:;" title="Hapus Data Role" data-id="{{$item->id}}" data-url="{{route('roles.index')}}">
                                    <i class='icon-trash'></i>
                                </a> 
                            </li>
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
