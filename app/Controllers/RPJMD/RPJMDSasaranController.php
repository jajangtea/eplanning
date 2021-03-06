<?php

namespace App\Controllers\RPJMD;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\RPJMD\RPJMDSasaranModel;

class RPJMDSasaranController extends Controller {
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
        if (!$this->checkStateIsExistSession('rpjmdsasaran','orderby')) 
        {            
           $this->putControllerStateSession('rpjmdsasaran','orderby',['column_name'=>'Nm_Sasaran','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession('rpjmdsasaran.orderby','column_name'); 
        $direction=$this->getControllerStateSession('rpjmdsasaran.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');        
        if ($this->checkStateIsExistSession('rpjmdsasaran','search')) 
        {
            $search=$this->getControllerStateSession('rpjmdsasaran','search');
            switch ($search['kriteria']) 
            {
                case 'Kd_Sasaran' :
                    $data = RPJMDSasaranModel::where(['Kd_Sasaran'=>$search['isikriteria']])->orderBy($column_order,$direction); 
                break;
                case 'Nm_Sasaran' :
                    $data = RPJMDSasaranModel::where('Nm_Sasaran', 'ilike', '%' . $search['isikriteria'] . '%')->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = RPJMDSasaranModel::orderBy($column_order,$direction)->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
        }        
        $data->setPath(route('rpjmdsasaran.index'));
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
        
        $this->setCurrentPageInsideSession('rpjmdsasaran',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rpjmd.rpjmdsasaran.datatable")->with(['page_active'=>'rpjmdsasaran',
                                                                                'search'=>$this->getControllerStateSession('rpjmdsasaran','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('rpjmdsasaran.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('rpjmdsasaran.orderby','order'),
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
            case 'Nm_Sasaran' :
                $column_name = 'Nm_Sasaran';
            break;           
            default :
                $column_name = 'Nm_Sasaran';
        }
        $this->putControllerStateSession('rpjmdsasaran','orderby',['column_name'=>$column_name,'order'=>$orderby]);        

        $data=$this->populateData();

        $datatable = view("pages.$theme.rpjmd.rpjmdsasaran.datatable")->with(['page_active'=>'rpjmdsasaran',
                                                            'search'=>$this->getControllerStateSession('rpjmdsasaran','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('rpjmdsasaran.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('rpjmdsasaran.orderby','order'),
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

        $this->setCurrentPageInsideSession('rpjmdsasaran',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.rpjmd.rpjmdsasaran.datatable")->with(['page_active'=>'rpjmdsasaran',
                                                                            'search'=>$this->getControllerStateSession('rpjmdsasaran','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('rpjmdsasaran.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('rpjmdsasaran.orderby','order'),
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
            $this->destroyControllerStateSession('rpjmdsasaran','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('rpjmdsasaran','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('rpjmdsasaran',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rpjmd.rpjmdsasaran.datatable")->with(['page_active'=>'rpjmdsasaran',                                                            
                                                            'search'=>$this->getControllerStateSession('rpjmdsasaran','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('rpjmdsasaran.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('rpjmdsasaran.orderby','order'),
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

        $search=$this->getControllerStateSession('rpjmdsasaran','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('rpjmdsasaran'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('rpjmdsasaran',$data->currentPage());
        
        return view("pages.$theme.rpjmd.rpjmdsasaran.index")->with(['page_active'=>'rpjmdsasaran',
                                                'search'=>$this->getControllerStateSession('rpjmdsasaran','search'),
                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                'column_order'=>$this->getControllerStateSession('rpjmdsasaran.orderby','column_name'),
                                                'direction'=>$this->getControllerStateSession('rpjmdsasaran.orderby','order'),
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

        return view("pages.$theme.rpjmd.rpjmdsasaran.create")->with(['page_active'=>'rpjmdsasaran',
                                                                    
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
        
        $rpjmdsasaran = RPJMDSasaranModel::create([
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
            return redirect(route('rpjmdsasaran.index'))->with('success','Data ini telah berhasil disimpan.');
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

        $data = RPJMDSasaranModel::findOrFail($id);
        if (!is_null($data) )  
        {
            return view("pages.$theme.rpjmd.rpjmdsasaran.show")->with(['page_active'=>'rpjmdsasaran',
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
        
        $data = RPJMDSasaranModel::findOrFail($id);
        if (!is_null($data) ) 
        {
            return view("pages.$theme.rpjmd.rpjmdsasaran.edit")->with(['page_active'=>'rpjmdsasaran',
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
        $rpjmdsasaran = RPJMDSasaranModel::find($id);
        
        $this->validate($request, [
            'replaceit'=>'required',
        ]);
        
        $rpjmdsasaran->replaceit = $request->input('replaceit');
        $rpjmdsasaran->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route('rpjmdsasaran.index'))->with('success',"Data dengan id ($id) telah berhasil diubah.");
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
        
        $rpjmdsasaran = RPJMDSasaranModel::find($id);
        $result=$rpjmdsasaran->delete();
        if ($request->ajax()) 
        {
            $currentpage=$this->getCurrentPageInsideSession('rpjmdsasaran'); 
            $data=$this->populateData($currentpage);
            if ($currentpage > $data->lastPage())
            {            
                $data = $this->populateData($data->lastPage());
            }
            $datatable = view("pages.$theme.rpjmd.rpjmdsasaran.datatable")->with(['page_active'=>'rpjmdsasaran',
                                                            'search'=>$this->getControllerStateSession('rpjmdsasaran','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                            'column_order'=>$this->getControllerStateSession('rpjmdsasaran.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('rpjmdsasaran.orderby','order'),
                                                            'data'=>$data])->render();      
            
            return response()->json(['success'=>true,'datatable'=>$datatable],200); 
        }
        else
        {
            return redirect(route('rpjmdsasaran.index'))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
        }        
    }
}
