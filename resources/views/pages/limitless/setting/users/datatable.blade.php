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
                <a href="{!!route('users.create')!!}" class="btn btn-info btn-xs" title="Tambah USERS">
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
                    <th width="55"></th>
                    <th width="100">
                        <a class="column-sort text-white" id="col-id" data-order="{{$direction}}" href="#">
                            ID  
                        </a>                                             
                    </th> 
                    <th width="200">
                        <a class="column-sort text-white" id="col-username" data-order="{{$direction}}" href="#">
                            USERNAME  
                        </a>                                             
                    </th> 
                    <th>
                        <a class="column-sort text-white" id="col-username" data-order="{{$direction}}" href="#">
                            NAME  
                        </a>                                             
                    </th>
                    <th>
                        <a class="column-sort text-white" id="col-email" data-order="{{$direction}}" href="#">
                            EMAIL  
                        </a>                                             
                    </th>
                    <th width="70">                        
                        THEME                                                                       
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
                    <th><img src="{!!asset($item->foto)!!}" alt="{{$item->username}}" height="50"></th>
                    <td>{{$item->id}}</td>
                    <td>{{$item->username}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->theme}}</td>
                    <td>
                        <ul class="icons-list">
                            <li class="text-primary-600">
                                <a class="btnShow" href="{{route('users.show',['id'=>$item->id])}}" title="Detail Data User">
                                    <i class='icon-eye'></i>
                                </a>  
                            </li>
                            <li class="text-primary-600">
                                <a class="btnEdit" href="{{route('users.edit',['id'=>$item->id])}}" title="Ubah Data User">
                                    <i class='icon-pencil7'></i>
                                </a>  
                            </li>
                            @if ($item->isdeleted)                            
                            <li class="text-danger-600">
                                <a class="btnDelete" href="javascript:;" title="Hapus Data User" data-id="{{$item->id}}" data-url="{{route('users.index')}}">
                                    <i class='icon-trash'></i>
                                </a> 
                            </li>
                            @endif                            
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
