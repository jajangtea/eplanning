<?php

namespace App\Controllers\Renstra;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\Renstra\RenstraKebijakanModel;

class RenstraKebijakanController extends Controller {
     /**
     * Membuat sebuah objek
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth']);
    }
    /**
     * collect data from resources for index view
     *
     * @return resources
     */
    public function populateData ($currentpage=1) 
    {        
        $columns=['*'];       
        //if (!$this->checkStateIsExistSession('renstrakebijakan','orderby')) 
        //{            
        //    $this->putControllerStateSession('renstrakebijakan','orderby',['column_name'=>'replace_it','order'=>'asc']);
        //}
        //$column_order=$this->getControllerStateSession('renstrakebijakan.orderby','column_name'); 
        //$direction=$this->getControllerStateSession('renstrakebijakan.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');        
        if ($this->checkStateIsExistSession('renstrakebijakan','search')) 
        {
            $search=$this->getControllerStateSession('renstrakebijakan','search');
            switch ($search['kriteria']) 
            {
                case 'replaceit' :
                    $data = RenstraKebijakanModel::where(['replaceit'=>$search['isikriteria']])->orderBy($column_order,$direction); 
                break;
                case 'replaceit' :
                    $data = RenstraKebijakanModel::where('replaceit', 'ilike', '%' . $search['isikriteria'] . '%')->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = RenstraKebijakanModel::orderBy($column_order,$direction)->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
        }        
        $data->setPath(route('renstrakebijakan.index'));
        return $data;
    }
    /**
     * digunakan untuk mengganti jumlah record per halaman
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changenumberrecordperpage (Request $request) 
    {
        $theme = \Auth::user()->theme;

        $numberRecordPerPage = $request->input('numberRecordPerPage');
        $this->putControllerStateSession('global_controller','numberRecordPerPage',$numberRecordPerPage);
        
        $this->setCurrentPageInsideSession('renstrakebijakan',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.renstra.renstrakebijakan.datatable")->with(['page_active'=>'renstrakebijakan',
                                                                                'search'=>$this->getControllerStateSession('renstrakebijakan','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('renstrakebijakan.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('renstrakebijakan.orderby','order'),
                                                                                'data'=>$data])->render();      
        return response()->json(['success'=>true,'datatable'=>$datatable],200);
    }
    /**
     * digunakan untuk mengurutkan record 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function orderby (Request $request) 
    {
        $theme = \Auth::user()->theme;

        $orderby = $request->input('orderby') == 'asc'?'desc':'asc';
        $column=$request->input('column_name');
        switch($column) 
        {
            case 'replace_it' :
                $column_name = 'replace_it';
            break;           
            default :
                $column_name = 'replace_it';
        }
        $this->putControllerStateSession('renstrakebijakan','orderby',['column_name'=>$column_name,'order'=>$orderby]);        

        $data=$this->populateData();

        $datatable = view("pages.$theme.renstra.renstrakebijakan.datatable")->with(['page_active'=>'renstrakebijakan',
                                                            'search'=>$this->getControllerStateSession('renstrakebijakan','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('renstrakebijakan.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstrakebijakan.orderby','order'),
                                                            'data'=>$data])->render();     

        return response()->json(['success'=>true,'datatable'=>$datatable],200);
    }
    /**
     * paginate resource in storage called by ajax
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paginate ($id) 
    {
        $theme = \Auth::user()->theme;

        $this->setCurrentPageInsideSession('renstrakebijakan',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.renstra.renstrakebijakan.datatable")->with(['page_active'=>'renstrakebijakan',
                                                                            'search'=>$this->getControllerStateSession('renstrakebijakan','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('renstrakebijakan.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('renstrakebijakan.orderby','order'),
                                                                            'data'=>$data])->render(); 

        return response()->json(['success'=>true,'datatable'=>$datatable],200);        
    }
    /**
     * search resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search (Request $request) 
    {
        $theme = \Auth::user()->theme;

        $action = $request->input('action');
        if ($action == 'reset') 
        {
            $this->destroyControllerStateSession('renstrakebijakan','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('renstrakebijakan','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('renstrakebijakan',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.renstra.renstrakebijakan.datatable")->with(['page_active'=>'renstrakebijakan',                                                            
                                                            'search'=>$this->getControllerStateSession('renstrakebijakan','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('renstrakebijakan.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstrakebijakan.orderby','order'),
                                                            'data'=>$data])->render();      
        
        return response()->json(['success'=>true,'datatable'=>$datatable],200);        
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {                
        $theme = \Auth::user()->theme;

        $search=$this->getControllerStateSession('renstrakebijakan','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('renstrakebijakan'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('renstrakebijakan',$data->currentPage());
        
        return view("pages.$theme.renstra.renstrakebijakan.index")->with(['page_active'=>'renstrakebijakan',
                                                'search'=>$this->getControllerStateSession('renstrakebijakan','search'),
                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                'column_order'=>$this->getControllerStateSession('renstrakebijakan.orderby','column_name'),
                                                'direction'=>$this->getControllerStateSession('renstrakebijakan.orderby','order'),
                                                'data'=>$data]);               
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $theme = \Auth::user()->theme;

        return view("pages.$theme.renstra.renstrakebijakan.create")->with(['page_active'=>'renstrakebijakan',
                                                                    
                                                ]);  
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'replaceit'=>'required',
        ]);
        
        $renstrakebijakan = RenstraKebijakanModel::create([
            'replaceit' => $request->input('replaceit'),
        ]);        
        
        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route('renstrakebijakan.index'))->with('success','Data ini telah berhasil disimpan.');
        }

    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $theme = \Auth::user()->theme;

        $data = RenstraKebijakanModel::findOrFail($id);
        if (!is_null($data) )  
        {
            return view("pages.$theme.renstra.renstrakebijakan.show")->with(['page_active'=>'renstrakebijakan',
                                                    'data'=>$data
                                                    ]);
        }        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $theme = \Auth::user()->theme;
        
        $data = RenstraKebijakanModel::findOrFail($id);
        if (!is_null($data) ) 
        {
            return view("pages.$theme.renstra.renstrakebijakan.edit")->with(['page_active'=>'renstrakebijakan',
                                                    'data'=>$data
                                                    ]);
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $renstrakebijakan = RenstraKebijakanModel::find($id);
        
        $this->validate($request, [
            'replaceit'=>'required',
        ]);
        
        $renstrakebijakan->replaceit = $request->input('replaceit');
        $renstrakebijakan->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route('renstrakebijakan.index'))->with('success',"Data dengan id ($id) telah berhasil diubah.");
        }
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $theme = \Auth::user()->theme;
        
        $renstrakebijakan = RenstraKebijakanModel::find($id);
        $result=$renstrakebijakan->delete();
        if ($request->ajax()) 
        {
            $currentpage=$this->getCurrentPageInsideSession('renstrakebijakan'); 
            $data=$this->populateData($currentpage);
            if ($currentpage > $data->lastPage())
            {            
                $data = $this->populateData($data->lastPage());
            }
            $datatable = view("pages.$theme.renstra.renstrakebijakan.datatable")->with(['page_active'=>'renstrakebijakan',
                                                            'search'=>$this->getControllerStateSession('renstrakebijakan','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                            'column_order'=>$this->getControllerStateSession('renstrakebijakan.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstrakebijakan.orderby','order'),
                                                            'data'=>$data])->render();      
            
            return response()->json(['success'=>true,'datatable'=>$datatable],200); 
        }
        else
        {
            return redirect(route('renstrakebijakan.index'))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
        }        
    }
}