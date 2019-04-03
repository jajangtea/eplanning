<?php

namespace App\Controllers\RKPD;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\RKPD\UsulanPraRenjaOPDModel;
use App\Models\DMaster\OrganisasiModel;
use App\Models\DMaster\SubOrganisasiModel;

class UsulanPraRenjaOPDController extends Controller {
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
        if (!$this->checkStateIsExistSession('usulanprarenjaopd','orderby')) 
        {            
           $this->putControllerStateSession('usulanprarenjaopd','orderby',['column_name'=>'SOrgNm','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'); 
        $direction=$this->getControllerStateSession('usulanprarenjaopd.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');
        
        //filter
        if (!$this->checkStateIsExistSession('usulanprarenjaopd','filters')) 
        {            
            $this->putControllerStateSession('usulanprarenjaopd','filters',[
                                                                            'OrgID'=>'none',
                                                                            'SOrgID'=>'none',
                                                                            ]);
        }        
        $SOrgID= $this->getControllerStateSession('usulanprarenjaopd.filters','SOrgID');        

        if ($this->checkStateIsExistSession('usulanprarenjaopd','search')) 
        {
            $search=$this->getControllerStateSession('usulanprarenjaopd','search');
            switch ($search['kriteria']) 
            {
                case 'replaceit' :
                    $data = UsulanPraRenjaOPDModel::where(['replaceit'=>$search['isikriteria']])->orderBy($column_order,$direction); 
                break;
                case 'replaceit' :
                    $data = UsulanPraRenjaOPDModel::where('replaceit', 'like', '%' . $search['isikriteria'] . '%')->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = UsulanPraRenjaOPDModel::orderBy($column_order,$direction)
                                            ->where('SOrgID',$SOrgID)
                                            ->where('TA', config('globalsettings.tahun_perencanaan'))
                                            ->orderBy('KgtNm','ASC')
                                            ->orderBy('Uraian','ASC')                                            
                                            ->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
        }        
        $data->setPath(route('usulanprarenjaopd.index'));
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
        
        $this->setCurrentPageInsideSession('usulanprarenjaopd',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rkpd.usulanprarenjaopd.datatable")->with(['page_active'=>'usulanprarenjaopd',
                                                                                'search'=>$this->getControllerStateSession('usulanprarenjaopd','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','order'),
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
            case 'col-SOrgNm' :
                $column_name = 'SOrgNm';
            break;           
            default :
                $column_name = 'SOrgNm';
        }
        $this->putControllerStateSession('usulanprarenjaopd','orderby',['column_name'=>$column_name,'order'=>$orderby]);        

        $data=$this->populateData();

        $datatable = view("pages.$theme.rkpd.usulanprarenjaopd.datatable")->with(['page_active'=>'usulanprarenjaopd',
                                                            'search'=>$this->getControllerStateSession('usulanprarenjaopd','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','order'),
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

        $this->setCurrentPageInsideSession('usulanprarenjaopd',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.rkpd.usulanprarenjaopd.datatable")->with(['page_active'=>'usulanprarenjaopd',
                                                                            'search'=>$this->getControllerStateSession('usulanprarenjaopd','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','order'),
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
            $this->destroyControllerStateSession('usulanprarenjaopd','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('usulanprarenjaopd','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('usulanprarenjaopd',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rkpd.usulanprarenjaopd.datatable")->with(['page_active'=>'usulanprarenjaopd',                                                            
                                                                                'search'=>$this->getControllerStateSession('usulanprarenjaopd','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','order'),
                                                                                'data'=>$data])->render();      
        
        return response()->json(['success'=>true,'datatable'=>$datatable],200);        
    }
    /**
     * filter resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter (Request $request) 
    {
        $theme = \Auth::user()->theme;

        $filters=$this->getControllerStateSession('usulanprarenjaopd','filters');
        $daftar_unitkerja=[];
        if ($request->exists('OrgID'))
        {
            $OrgID = $request->input('OrgID')==''?'none':$request->input('OrgID');
            $filters['OrgID']=$OrgID;
            $daftar_unitkerja=SubOrganisasiModel::getDaftarUnitKerja(config('globalsettings.tahun_perencanaan'),false,$OrgID);  
            
            $this->putControllerStateSession('usulanprarenjaopd','filters',$filters);

            return response()->json(['success'=>true,'daftar_unitkerja'=>$daftar_unitkerja],200);   
        } 
        
        if ($request->exists('SOrgID'))
        {
            $SOrgID = $request->input('SOrgID')==''?'none':$request->input('SOrgID');
            $filters['SOrgID']=$SOrgID;
            $this->putControllerStateSession('usulanprarenjaopd','filters',$filters);
            $this->setCurrentPageInsideSession('usulanprarenjaopd',1);

            $datatable = view("pages.$theme.rkpd.usulanprarenjaopd.datatable")->with(['page_active'=>'usulanprarenjaopd',                                                            
                                                                                    'search'=>$this->getControllerStateSession('usulanprarenjaopd','search'),
                                                                                    'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                    'column_order'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'),
                                                                                    'direction'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','order'),
                                                                                    'data'=>$data])->render();      
        
            return response()->json(['success'=>true,'datatable'=>$datatable],200);  
        } 
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {                
        $theme = \Auth::user()->theme;

        $search=$this->getControllerStateSession('usulanprarenjaopd','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('usulanprarenjaopd'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('usulanprarenjaopd',$data->currentPage());
        
        $filters=$this->getControllerStateSession('usulanprarenjaopd','filters'); 
         
        $daftar_opd=OrganisasiModel::getDaftarOPD(config('globalsettings.tahun_perencanaan'),false);      
        $daftar_unitkerja=array();           
        if ($filters['OrgID'] != 'none'&&$filters['OrgID'] != ''&&$filters['OrgID'] != null)
        {
            $daftar_unitkerja=SubOrganisasiModel::getDaftarUnitKerja(config('globalsettings.tahun_perencanaan'),false,$filters['OrgID']);        
        }        
        return view("pages.$theme.rkpd.usulanprarenjaopd.index")->with(['page_active'=>'usulanprarenjaopd',
                                                                        'daftar_opd'=>$daftar_opd,
                                                                        'daftar_unitkerja'=>$daftar_unitkerja,
                                                                        'filters'=>$filters,
                                                                        'search'=>$this->getControllerStateSession('usulanprarenjaopd','search'),
                                                                        'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                        'column_order'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'),
                                                                        'direction'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','order'),
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

        return view("pages.$theme.rkpd.usulanprarenjaopd.create")->with(['page_active'=>'usulanprarenjaopd',
                                                                    
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
        
        $usulanprarenjaopd = UsulanPraRenjaOPDModel::create([
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
            return redirect(route('usulanprarenjaopd.show',['id'=>$usulanprarenjaopd->replaceit]))->with('success','Data ini telah berhasil disimpan.');
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

        $data = UsulanPraRenjaOPDModel::findOrFail($id);
        if (!is_null($data) )  
        {
            return view("pages.$theme.rkpd.usulanprarenjaopd.show")->with(['page_active'=>'usulanprarenjaopd',
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
        
        $data = UsulanPraRenjaOPDModel::findOrFail($id);
        if (!is_null($data) ) 
        {
            return view("pages.$theme.rkpd.usulanprarenjaopd.edit")->with(['page_active'=>'usulanprarenjaopd',
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
        $usulanprarenjaopd = UsulanPraRenjaOPDModel::find($id);
        
        $this->validate($request, [
            'replaceit'=>'required',
        ]);
        
        $usulanprarenjaopd->replaceit = $request->input('replaceit');
        $usulanprarenjaopd->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route('usulanprarenjaopd.show',['id'=>$usulanprarenjaopd->replaceit]))->with('success','Data ini telah berhasil disimpan.');
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
        
        $usulanprarenjaopd = UsulanPraRenjaOPDModel::find($id);
        $result=$usulanprarenjaopd->delete();
        if ($request->ajax()) 
        {
            $currentpage=$this->getCurrentPageInsideSession('usulanprarenjaopd'); 
            $data=$this->populateData($currentpage);
            if ($currentpage > $data->lastPage())
            {            
                $data = $this->populateData($data->lastPage());
            }
            $datatable = view("pages.$theme.rkpd.usulanprarenjaopd.datatable")->with(['page_active'=>'usulanprarenjaopd',
                                                            'search'=>$this->getControllerStateSession('usulanprarenjaopd','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                            'column_order'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','order'),
                                                            'data'=>$data])->render();      
            
            return response()->json(['success'=>true,'datatable'=>$datatable],200); 
        }
        else
        {
            return redirect(route('usulanprarenjaopd.index'))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
        }        
    }
}