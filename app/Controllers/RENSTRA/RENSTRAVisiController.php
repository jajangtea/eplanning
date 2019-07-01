<?php

namespace App\Controllers\RENSTRA;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\RENSTRA\RENSTRAVisiModel;
use App\Rules\CheckRecordIsExistValidation;
use App\Rules\IgnoreIfDataIsEqualValidation;

class RENSTRAVisiController extends Controller {
     /**
     * Membuat sebuah objek
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth','role:superadmin|bapelitbang|opd']);
    }
    /**
     * collect data from resources for index view
     *
     * @return resources
     */
    public function populateData ($currentpage=1) 
    {        
        $columns=['*'];       
        if (!$this->checkStateIsExistSession('renstravisi','Nm_RenstraVisi')) 
        {            
           $this->putControllerStateSession('renstravisi','orderby',['column_name'=>'Kd_RenstraVisi','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession('renstravisi.orderby','column_name'); 
        $direction=$this->getControllerStateSession('renstravisi.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');       
        
        //filter
        if (!$this->checkStateIsExistSession('renstravisi','filters')) 
        {            
            $this->putControllerStateSession('renstravisi','filters',[
                                                                    'OrgID'=>'none'
                                                                    ]);
        }        
        $OrgID= $this->getControllerStateSession('renstravisi','filters.OrgID');        

        if ($this->checkStateIsExistSession('renstravisi','search')) 
        {
            $search=$this->getControllerStateSession('renstravisi','search');
            switch ($search['kriteria']) 
            {
                case 'Kd_RenstraVisi' :
                    $data = RENSTRAVisiModel::where('OrgID',$OrgID)
                                            ->where(['Kd_RenstraVisi'=>$search['isikriteria']])
                                            ->orderBy($column_order,$direction); 
                break;
                case 'Nm_RenstraVisi' :
                    $data = RENSTRAVisiModel::where('OrgID',$OrgID)
                                            ->where('Nm_RenstraVisi', 'ilike', '%' . $search['isikriteria'] . '%')
                                            ->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = RENSTRAVisiModel::where('OrgID',$OrgID)
                                    ->orderBy($column_order,$direction)
                                    ->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
        }        
        $data->setPath(route('renstravisi.index'));
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
        
        $this->setCurrentPageInsideSession('renstravisi',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.renstra.renstravisi.datatable")->with(['page_active'=>'renstravisi',
                                                                                'search'=>$this->getControllerStateSession('renstravisi','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('renstravisi.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('renstravisi.orderby','order'),
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
            case 'col-Nm_RenstraVisi' :
                $column_name = 'Nm_RenstraVisi';
            break;           
            default :
                $column_name = 'Nm_RenstraVisi';
        }
        $this->putControllerStateSession('renstravisi','orderby',['column_name'=>$column_name,'order'=>$orderby]);        

        $data=$this->populateData();

        $datatable = view("pages.$theme.renstra.renstravisi.datatable")->with(['page_active'=>'renstravisi',
                                                            'search'=>$this->getControllerStateSession('renstravisi','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('renstravisi.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstravisi.orderby','order'),
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

        $this->setCurrentPageInsideSession('renstravisi',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.renstra.renstravisi.datatable")->with(['page_active'=>'renstravisi',
                                                                            'search'=>$this->getControllerStateSession('renstravisi','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('renstravisi.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('renstravisi.orderby','order'),
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
            $this->destroyControllerStateSession('renstravisi','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('renstravisi','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('renstravisi',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.renstra.renstravisi.datatable")->with(['page_active'=>'renstravisi',                                                            
                                                            'search'=>$this->getControllerStateSession('renstravisi','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                            'column_order'=>$this->getControllerStateSession('renstravisi.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstravisi.orderby','order'),
                                                            'data'=>$data])->render();      
        
        return response()->json(['success'=>true,'datatable'=>$datatable],200);        
    }
    /**
     * filter resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request) 
    {
        $auth = \Auth::user();    
        $theme = $auth->theme;

        $filters=$this->getControllerStateSession('renstravisi','filters');
        $json_data = [];

        //index
        if ($request->exists('OrgID'))
        {
            $OrgID = $request->input('OrgID')==''?'none':$request->input('OrgID');
            $filters['OrgID']=$OrgID;            
            $this->putControllerStateSession('renstravisi','filters',$filters);
            
            $data = $this->populateData();

            $datatable = view("pages.$theme.renstra.renstravisi.datatable")->with(['page_active'=>'renstravisi',                                                                               
                                                                            'search'=>$this->getControllerStateSession('renstravisi','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                            'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
                                                                            'data'=>$data])->render();

            
            $json_data = ['success'=>true,'datatable'=>$datatable];
        } 
        return response()->json($json_data,200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {                
        $auth = \Auth::user();    
        $theme = $auth->theme;
        
        $filters=$this->getControllerStateSession('renstravisi','filters');
        $roles=$auth->getRoleNames();       
        switch ($roles[0])
        {
            case 'superadmin' :     
            case 'bapelitbang' :     
            case 'tapd' :     
                $daftar_opd=\App\Models\DMaster\OrganisasiModel::getDaftarOPD(\HelperKegiatan::getTahunPerencanaan(),false);   
            break;
            case 'opd' :               
                $daftar_opd=\App\Models\UserOPD::getOPD();                      
                if (!(count($daftar_opd) > 0))
                {  
                    return view("pages.$theme.renstra.renstravisi.error")->with(['page_active'=>'renstravisi', 
                                                                        'page_title'=>\HelperKegiatan::getPageTitle('renstravisi'),
                                                                        'errormessage'=>'Anda Tidak Diperkenankan Mengakses Halaman ini, karena Sudah dikunci oleh BAPELITBANG',
                                                                        ]);
                }          
            break;
        }
        $search=$this->getControllerStateSession('renstravisi','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('renstravisi'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('renstravisi',$data->currentPage());        
        
        return view("pages.$theme.renstra.renstravisi.index")->with(['page_active'=>'renstravisi',
                                                                    'daftar_opd'=>$daftar_opd,
                                                                    'search'=>$this->getControllerStateSession('renstravisi','search'),
                                                                    'filters'=>$filters,
                                                                    'daftar_opd'=>$daftar_opd,
                                                                    'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                    'column_order'=>$this->getControllerStateSession('renstravisi.orderby','column_name'),
                                                                    'direction'=>$this->getControllerStateSession('renstravisi.orderby','order'),
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
        $filters=$this->getControllerStateSession('renstravisi','filters');               
        if ($filters['OrgID'] != 'none'&&$filters['OrgID'] != ''&&$filters['OrgID'] != null)
        {
            return view("pages.$theme.renstra.renstravisi.create")->with(['page_active'=>'renstravisi',
                                                                        
                                                                        ]);  
        }
        else
        {
            return view("pages.$theme.renstra.renstravisi.error")->with(['page_active'=>'renstravisi',
                                                                    'errormessage'=>'Mohon OPD / SKPD untuk di pilih terlebih dahulu.'
                                                                ]);  
        }
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
            'Kd_RenstraVisi'=>[new CheckRecordIsExistValidation('tmRenstraVisi',['where'=>['TA','=',\HelperKegiatan::getTahunPerencanaan()]]),
                        'required'
                    ],
            'Nm_RenstraVisi'=>'required',
        ]);
        
        $renstravisi = RENSTRAVisiModel::create([
            'RenstraVisiID'=> uniqid ('uid'),
            'OrgID' => $this->getControllerStateSession('renstravisi','filters.OrgID'),
            'Kd_RenstraVisi' => $request->input('Kd_RenstraVisi'),
            'Nm_RenstraVisi' => $request->input('Nm_RenstraVisi'),
            'Descr' => $request->input('Descr'),
            'TA' => \HelperKegiatan::getTahunPerencanaan()
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
            return redirect(route('renstravisi.show',['id'=>$renstravisi->RenstraVisiID]))->with('success','Data ini telah berhasil disimpan.');
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

        $data = RENSTRAVisiModel::findOrFail($id);
        if (!is_null($data) )  
        {
            return view("pages.$theme.renstra.renstravisi.show")->with(['page_active'=>'renstravisi',
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
        
        $data = RENSTRAVisiModel::findOrFail($id);
        if (!is_null($data) ) 
        {
            return view("pages.$theme.renstra.renstravisi.edit")->with(['page_active'=>'renstravisi',
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
        $renstravisi = RENSTRAVisiModel::find($id);
        
        $this->validate($request, [
            'Kd_RenstraVisi'=>[new IgnoreIfDataIsEqualValidation('tmRenstraVisi',$renstravisi->Kd_RenstraVisi,['where'=>['TA','=',\HelperKegiatan::getTahunPerencanaan()]]),
                        'required'
                    ],
            'Nm_RenstraVisi'=>'required|min:2'
        ]);
        
        $renstravisi->Kd_RenstraVisi = $request->input('Kd_RenstraVisi');
        $renstravisi->Nm_RenstraVisi = $request->input('Nm_RenstraVisi');
        $renstravisi->Descr = $request->input('Descr');
        $renstravisi->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route('renstravisi.show',['id'=>$renstravisi->RenstraVisiID]))->with('success',"Data dengan id ($id) telah berhasil diubah.");
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
        
        $renstravisi = RENSTRAVisiModel::find($id);
        $result=$renstravisi->delete();
        if ($request->ajax()) 
        {
            $currentpage=$this->getCurrentPageInsideSession('renstravisi'); 
            $data=$this->populateData($currentpage);
            if ($currentpage > $data->lastPage())
            {            
                $data = $this->populateData($data->lastPage());
            }
            $datatable = view("pages.$theme.renstra.renstravisi.datatable")->with(['page_active'=>'renstravisi',
                                                            'search'=>$this->getControllerStateSession('renstravisi','search'),
                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                            'column_order'=>$this->getControllerStateSession('renstravisi.orderby','column_name'),
                                                            'direction'=>$this->getControllerStateSession('renstravisi.orderby','order'),
                                                            'data'=>$data])->render();      
            
            return response()->json(['success'=>true,'datatable'=>$datatable],200); 
        }
        else
        {
            return redirect(route('renstravisi.index'))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
        }        
    }
}
