<?php

namespace App\Controllers\RKPD;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\RKPD\VerifikasiRenjaModel;
use App\Models\RKPD\RenjaModel;
use App\Models\RKPD\RenjaRincianModel;
use App\Models\RKPD\RenjaIndikatorModel;
use App\Models\RKPD\RKPDModel;

class VerifikasiRenjaController extends Controller {
     /**
     * Membuat sebuah objek
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth','role:superadmin|opd']);
    }
    private function populateRincianKegiatan($RenjaID)
    {
        $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc"."RenjaRincID","trRenjaRinc"."RenjaID","trRenjaRinc"."RenjaID","trRenjaRinc"."UsulanKecID","Nm_Kecamatan","trRenjaRinc"."Uraian","trRenjaRinc"."No","trRenjaRinc"."Sasaran_Angka5","trRenjaRinc"."Sasaran_Uraian5","trRenjaRinc"."Target5","trRenjaRinc"."Jumlah5","trRenjaRinc"."Status","trRenjaRinc"."Privilege","trRenjaRinc"."Prioritas","isSKPD","isReses","isReses_Uraian","trRenjaRinc"."Descr"'))
                                    ->leftJoin('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc.PmKecamatanID')
                                    ->leftJoin('trPokPir','trPokPir.PokPirID','trRenjaRinc.PokPirID')
                                    ->leftJoin('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')
                                    ->where('trRenjaRinc.EntryLvl',4)
                                    ->where('RenjaID',$RenjaID)
                                    ->orderBy('Prioritas','ASC')
                                    ->get();
        
        return $data;
    }
    private function populateIndikatorKegiatan($RenjaID)
    {
      
        $data = RenjaIndikatorModel::join('trIndikatorKinerja','trIndikatorKinerja.IndikatorKinerjaID','trRenjaIndikator.IndikatorKinerjaID')
                                                            ->where('RenjaID',$RenjaID)
                                                            ->get();

        return $data;
    }
    /**
     * collect data from resources for index view
     *
     * @return resources
     */
    public function populateData ($currentpage=1) 
    {        
        $columns=['*'];       
        if (!$this->checkStateIsExistSession('verifikasirenja','orderby')) 
        {            
           $this->putControllerStateSession('verifikasirenja','orderby',['column_name'=>'kode_kegiatan','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession('verifikasirenja.orderby','column_name'); 
        $direction=$this->getControllerStateSession('verifikasirenja.orderby','order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');
        
        //filter
        if (!$this->checkStateIsExistSession('verifikasirenja','filters')) 
        {            
            $this->putControllerStateSession('verifikasirenja','filters',[
                                                                            'OrgID'=>'none',
                                                                            'SOrgID'=>'none',
                                                                            ]);
        }        
        $SOrgID= $this->getControllerStateSession('verifikasirenja.filters','SOrgID');        

        if ($this->checkStateIsExistSession('verifikasirenja','search')) 
        {
            $search=$this->getControllerStateSession('verifikasirenja','search');
            switch ($search['kriteria']) 
            {
                case 'kode_kegiatan' :
                    $data = VerifikasiRenjaModel::where(['kode_kegiatan'=>$search['isikriteria']])                                                    
                                                    ->where('SOrgID',$SOrgID)
                                                    ->whereNotNull('RenjaRincID')
                                                    ->where('TA', config('globalsettings.tahun_perencanaan'))
                                                    ->orderBy('Prioritas','ASC')
                                                    ->orderBy($column_order,$direction); 
                break;
                case 'KgtNm' :
                    $data = VerifikasiRenjaModel::where('KgtNm', 'ilike', '%' . $search['isikriteria'] . '%')                                                    
                                                    ->where('SOrgID',$SOrgID)
                                                    ->whereNotNull('RenjaRincID')
                                                    ->where('TA', config('globalsettings.tahun_perencanaan'))
                                                    ->orderBy('Prioritas','ASC')
                                                    ->orderBy('Privilege','DESC')
                                                    ->orderBy('status','DESC')
                                                    ->orderBy($column_order,$direction);                                        
                break;
                case 'Uraian' :
                    $data = VerifikasiRenjaModel::where('Uraian', 'ilike', '%' . $search['isikriteria'] . '%')                                                    
                                                    ->where('SOrgID',$SOrgID)
                                                    ->whereNotNull('RenjaRincID')
                                                    ->where('TA', config('globalsettings.tahun_perencanaan'))
                                                    ->orderBy('Prioritas','ASC')
                                                    ->orderBy('Privilege','DESC')
                                                    ->orderBy('status','DESC')
                                                    ->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = VerifikasiRenjaModel::where('SOrgID',$SOrgID)                                     
                                            ->whereNotNull('RenjaRincID')       
                                            ->where('TA', config('globalsettings.tahun_perencanaan'))                                            
                                            ->orderBy('Prioritas','ASC')
                                            ->orderBy('Privilege','DESC')
                                            ->orderBy('Status','DESC')
                                            ->orderBy($column_order,$direction)                                            
                                            ->paginate($numberRecordPerPage, $columns, 'page', $currentpage);             
        }        
        $data->setPath(route('verifikasirenja.index'));          
        
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
        
        $this->setCurrentPageInsideSession('verifikasirenja',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rkpd.verifikasirenja.datatable")->with(['page_active'=>'verifikasirenja',
                                                                                'label_transfer'=>'RKPD',
                                                                                'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
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
            case 'col-kode_kegiatan' :
                $column_name = 'kode_kegiatan';
            break;    
            case 'col-KgtNm' :
                $column_name = 'KgtNm';
            break;    
            case 'col-Uraian' :
                $column_name = 'Uraian';
            break;    
            case 'col-Sasaran_Angka4' :
                $column_name = 'Sasaran_Angka4';
            break;  
            case 'col-Jumlah4' :
                $column_name = 'Jumlah4';
            break;
            default :
                $column_name = 'kode_kegiatan';
        }
        $this->putControllerStateSession('verifikasirenja','orderby',['column_name'=>$column_name,'order'=>$orderby]);      

        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('verifikasirenja');         
        $data=$this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        
        $datatable = view("pages.$theme.rkpd.verifikasirenja.datatable")->with(['page_active'=>'verifikasirenja',
                                                                                    'label_transfer'=>'RKPD',
                                                                                    'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                                    'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                    'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                                    'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
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

        $this->setCurrentPageInsideSession('verifikasirenja',$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.rkpd.verifikasirenja.datatable")->with(['page_active'=>'verifikasirenja',
                                                                            'label_transfer'=>'RKPD',
                                                                            'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                            'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
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
            $this->destroyControllerStateSession('verifikasirenja','search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession('verifikasirenja','search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession('verifikasirenja',1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rkpd.verifikasirenja.datatable")->with(['page_active'=>'verifikasirenja',   
                                                                                'label_transfer'=>'RKPD',                                                         
                                                                                'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
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

        $filters=$this->getControllerStateSession('verifikasirenja','filters');
        $daftar_unitkerja=[];
        $json_data = [];

        // //index
        if ($request->exists('OrgID'))
        {
            $OrgID = $request->input('OrgID')==''?'none':$request->input('OrgID');
            $filters['OrgID']=$OrgID;
            $filters['SOrgID']='none';
            $daftar_unitkerja=\App\Models\DMaster\SubOrganisasiModel::getDaftarUnitKerja(config('globalsettings.tahun_perencanaan'),false,$OrgID);  
            
            $this->putControllerStateSession('verifikasirenja','filters',$filters);

            $data = [];

            $datatable = view("pages.$theme.rkpd.verifikasirenja.datatable")->with(['page_active'=>'verifikasirenja',                                                            
                                                                                    'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                                    'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                    'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                                    'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
                                                                                    'data'=>$data])->render();

            $json_data = ['success'=>true,'daftar_unitkerja'=>$daftar_unitkerja,'datatable'=>$datatable];
        } 
        //index
        if ($request->exists('SOrgID'))
        {
            $SOrgID = $request->input('SOrgID')==''?'none':$request->input('SOrgID');
            $filters['SOrgID']=$SOrgID;
            $this->putControllerStateSession('verifikasirenja','filters',$filters);
            $this->setCurrentPageInsideSession('verifikasirenja',1);

            $data = $this->populateData();

            $datatable = view("pages.$theme.rkpd.verifikasirenja.datatable")->with(['page_active'=>'verifikasirenja',            
                                                                                    'label_transfer'=>'RKPD',                                                
                                                                                    'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                                    'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                    'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                                    'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
                                                                                    'data'=>$data])->render();                                                                                       
                                                                                    
            $json_data = ['success'=>true,'datatable'=>$datatable];    
        }
        return $json_data;
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

        $filters=$this->getControllerStateSession('verifikasirenja','filters');
        $roles=$auth->getRoleNames();        
        switch ($roles[0])
        {
            case 'superadmin' :                 
                $daftar_opd=\App\Models\DMaster\OrganisasiModel::getDaftarOPD(config('globalsettings.tahun_perencanaan'),false);  
                $daftar_unitkerja=array();           
                if ($filters['OrgID'] != 'none'&&$filters['OrgID'] != ''&&$filters['OrgID'] != null)
                {
                    $daftar_unitkerja=\App\Models\DMaster\SubOrganisasiModel::getDaftarUnitKerja(config('globalsettings.tahun_perencanaan'),false,$filters['OrgID']);        
                }    
            break;
            case 'opd' :
                $daftar_opd=\App\Models\DMaster\OrganisasiModel::getDaftarOPD(config('globalsettings.tahun_perencanaan'),false,NULL,$auth->OrgID);  
                $filters['OrgID']=$auth->OrgID;                
                if (empty($auth->SOrgID)) 
                {
                    $daftar_unitkerja=\App\Models\DMaster\SubOrganisasiModel::getDaftarUnitKerja(config('globalsettings.tahun_perencanaan'),false,$auth->OrgID);  
                    $filters['SOrgID']=empty($filters['SOrgID'])?'':$filters['SOrgID'];                    
                }   
                else
                {
                    $daftar_unitkerja=\App\Models\DMaster\SubOrganisasiModel::getDaftarUnitKerja(config('globalsettings.tahun_perencanaan'),false,$auth->OrgID,$auth->SOrgID);
                    $filters['SOrgID']=$auth->SOrgID;
                }                
                $this->putControllerStateSession('verifikasirenja','filters',$filters);
            break;
        }

        $search=$this->getControllerStateSession('verifikasirenja','search');
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession('verifikasirenja'); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession('verifikasirenja',$data->currentPage());

        return view("pages.$theme.rkpd.verifikasirenja.index")->with(['page_active'=>'verifikasirenja',
                                                                        'label_transfer'=>'RKPD',
                                                                        'daftar_opd'=>$daftar_opd,
                                                                        'daftar_unitkerja'=>$daftar_unitkerja,
                                                                        'filters'=>$filters,
                                                                        'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                        'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                        'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                        'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
                                                                        'data'=>$data]);               
                     
    }
    /**
     * Edit the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $theme = \Auth::user()->theme;

        $data = RenjaRincianModel::findOrFail($id);
        if (!is_null($data) )  
        {
            return view("pages.$theme.rkpd.verifikasirenja.edit")->with(['page_active'=>'verifikasirenja',
                                                                        'renja'=>$data
                                                                    ]);
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

        $renja = RenjaModel::select(\DB::raw('"trRenja"."RenjaID",
                            "trRKPD"."RKPDID",
                            "v_program_kegiatan"."Kd_Urusan",
                            "v_program_kegiatan"."Nm_Urusan",
                            "v_program_kegiatan"."Kd_Bidang",
                            "v_program_kegiatan"."Nm_Bidang",
                            "v_program_kegiatan"."Kd_Prog",
                            "v_program_kegiatan"."PrgNm",
                            "v_program_kegiatan"."kode_kegiatan",
                            "v_program_kegiatan"."KgtNm",
                            "trRenja"."Sasaran_Angka5",
                            "trRenja"."Sasaran_Uraian5",
                            "trRenja"."Sasaran_AngkaSetelah",
                            "trRenja"."Sasaran_UraianSetelah",
                            "trRenja"."Target5",
                            "trRenja"."NilaiSebelum",
                            "trRenja"."NilaiUsulan5",
                            "trRenja"."NilaiSetelah",
                            "trRenja"."NamaIndikator",
                            "tmSumberDana"."Nm_SumberDana",
                            "trRenja"."created_at",
                            "trRenja"."updated_at"'))
                            ->join('v_program_kegiatan','v_program_kegiatan.KgtID','trRenja.KgtID')     
                            ->join('tmSumberDana','tmSumberDana.SumberDanaID','trRenja.SumberDanaID')   
                            ->leftJoin('trRKPD','trRKPD.RKPDID','trRenja.RenjaID')   
                            ->findOrFail($id);            
        if (!is_null($renja) )  
        {
            $datarinciankegiatan = $this->populateRincianKegiatan($id);
            return view("pages.$theme.rkpd.verifikasirenja.show")->with(['page_active'=>'verifikasirenja',
                                                                        'renja'=>$renja,
                                                                        'datarinciankegiatan'=>$datarinciankegiatan
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
        $theme = \Auth::user()->theme;
        $verifikasirenja = RenjaRincianModel::find($id);   
        
        if ($request->ajax()) 
        {
            $verifikasirenja->Status=$request->input('Status');            
        }
        else
        {
            $this->validate($request, [
                'Uraian'=>'required',
                'Sasaran_Angka5'=>'required',
                'Sasaran_Uraian5'=>'required',
                'Target5'=>'required',
                'Jumlah5'=>'required'           
            ]);    
            $verifikasirenja->Uraian = $request->input('Uraian');
            $verifikasirenja->Sasaran_Angka5 = $request->input('Sasaran_Angka5'); 
            $verifikasirenja->Sasaran_Uraian5 = $request->input('Sasaran_Uraian5');
            $verifikasirenja->Target5 = $request->input('Target5');
            $verifikasirenja->Jumlah5 = $request->input('Jumlah5');  
            $verifikasirenja->Descr = $request->input('Descr');            
            $verifikasirenja->Status=$request->input('cmbStatus');                        
        }        
        $verifikasirenja->save();        
        
        if ($request->ajax()) 
        {            
            $data = $this->populateData();
            
            $datatable = view("pages.$theme.rkpd.verifikasirenja.datatable")->with(['page_active'=>'verifikasirenja',                                                            
                                                                                'label_transfer'=>'RKPD',
                                                                                'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
                                                                                'data'=>$data])->render();
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.',
                'datatable'=>$datatable,
                'rincian_kegiatan'=>$verifikasirenja                
            ],200);
        }
        else
        {
            return redirect(route('verifikasirenja.index'))->with('success',"Data rincian kegiatan dengan id ($id) telah berhasil.");
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request,$id)
    {
        $theme = \Auth::user()->theme;

        $RenjaRincID=$id; 
        $data = RenjaRincianModel::find($RenjaRincID); 

        if ($data == null)
        {
            if ($request->ajax()) 
            {
                return response()->json([
                    'success'=>0,
                    'message'=>'Data ini gagal di transfer.'
                ],200);
            }
            else
            {
                return redirect(route('verifikasirenja.error'))->with('error','Data ini gagal ditransfer.');
            }        
        }
        else
        {
            $rincian_kegiatan=\DB::transaction(function () use ($data) {
                $tanggal_posting=\Carbon\Carbon::now();
                #new rkpd
                $renja=RenjaModel::find($data->RenjaID);  
                $RKPDID=$renja->RenjaID;
                
                RKPDModel::firstOrCreate([
                    'RKPDID'=>$RKPDID,   
                    'OrgID'=>$renja->OrgID,
                    'SOrgID'=>$renja->SOrgID,
                    'KgtID'=>$renja->KgtID,
                    'SumberDanaID'=>$renja->SumberDanaID,
                    'NamaIndikator'=>$renja->NamaIndikator,
                    'Sasaran_Uraian1'=>$renja->Sasaran_Uraian5,                    
                    'Sasaran_Angka1'=>$renja->Sasaran_Angka5,                    
                    'NilaiUsulan1'=>$renja->NilaiUsulan5,                    
                    'Target1'=>$renja->Target5,                    
                    'Sasaran_AngkaSetelah'=>$renja->Sasaran_AngkaSetelah,
                    'Sasaran_UraianSetelah'=>$renja->Sasaran_UraianSetelah,
                    'Tgl_Posting'=>$tanggal_posting,
                    'Descr'=>$renja->Descr,
                    'TA'=>$renja->TA,
                    'status'=>1,
                    'EntryLvl'=>5,
                    'Privilege'=>1,                                    
                ]);
                
                $str_rincianrenja = '
                    INSERT INTO "trRKPDRinc" (
                        "RKPDRincID",
                        "RKPDID", 
                        "PMProvID",
                        "PmKotaID",
                        "PmKecamatanID",
                        "PmDesaID",
                        "UsulanKecID",
                        "PokPirID",
                        "Uraian",
                        "No",
                        "Sasaran_Uraian1",
                        "Sasaran_Angka1",                        
                        "NilaiUsulan1",                        
                        "Target1",                        
                        "Tgl_Posting",                         
                        "isReses",
                        "isReses_Uraian",
                        "isSKPD",
                        "Descr",
                        "TA",
                        "status",
                        "EntryLvl",
                        "Privilege",                   
                        "created_at", 
                        "updated_at"
                    ) 
                    SELECT 
                        "RenjaRincID" AS "RKPDRincID",
                        \''.$RKPDID.'\' AS "RKPDID",
                        "PMProvID",
                        "PmKotaID",
                        "PmKecamatanID",
                        "PmDesaID",
                        "UsulanKecID",
                        "PokPirID",
                        "Uraian",
                        "No",
                        "Sasaran_Uraian5" AS "Sasaran_Uraian1",
                        "Sasaran_Angka5" AS "Sasaran_Angka1",        
                        "Jumlah5" AS "NilaiUsulan1",        
                        "Target5" AS "Target1",                                              
                        \''.$tanggal_posting.'\' AS Tgl_Posting,
                        "isReses",
                        "isReses_Uraian",
                        "isSKPD",
                        "Descr",
                        "TA",
                        1 AS "status",
                        5 AS "EntryLvl",
                        "Privilege",                        
                        NOW() AS created_at,
                        NOW() AS updated_at
                    FROM 
                        "trRenjaRinc" 
                    WHERE "RenjaRincID"=\''.$data->RenjaRincID.'\' AND
                        ("Status"=1 OR "Status"=2) AND
                        "Privilege"=0  
                ';

                \DB::statement($str_rincianrenja); 
                
                $str_kinerja='
                    INSERT INTO "trRKPDIndikator" (
                        "RKPDIndikatorID", 
                        "RKPDID",
                        "IndikatorKinerjaID",                        
                        "Target_Angka",
                        "Target_Uraian",  
                        "Tahun",      
                        "Descr",
                        "TA",
                        "Privilege",
                        "created_at", 
                        "updated_at"
                    )
                    SELECT 
                        REPLACE(SUBSTRING(CONCAT(\'uid\',uuid_in(md5(random()::text || clock_timestamp()::text)::cstring)) from 1 for 16),\'-\',\'\') AS "RKPDIndikatorID",
                        \''.$RKPDID.'\' AS "RKPDID",
                        "IndikatorKinerjaID",                        
                        "Target_Angka",
                        "Target_Uraian",
                        "Tahun",
                        "Descr",
                        1 AS "Privilege",                        
                        "TA",
                        NOW() AS created_at,
                        NOW() AS updated_at
                    FROM 
                        "trRenjaIndikator" 
                    WHERE 
                        "RenjaID"=\''.$renja->RenjaID.'\' AND 
                        "Privilege"=0
                ';

                \DB::statement($str_kinerja);
                
                //rincian renja finish
                $data->Privilege=1;
                $data->save();

                //renja finish
                $renja->Privilege=1;
                $renja->Status=1;
                $renja->save();
                
                return $str_rincianrenja;
            });
            if ($request->ajax()) 
            {                
                $data = $this->populateData();
            
                $datatable = view("pages.$theme.rkpd.verifikasirenja.datatable")->with(['page_active'=>'verifikasirenja',                                                            
                                                                                'label_transfer'=>'RKPD',
                                                                                'search'=>$this->getControllerStateSession('verifikasirenja','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession('verifikasirenja.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('verifikasirenja.orderby','order'),
                                                                                'data'=>$data])->render();
                return response()->json([
                    'success'=>true,
                    'message'=>'Data ini telah berhasil diubah.',
                    'datatable'=>$datatable,
                    'rincian_kegiatan'=>$rincian_kegiatan                
                ],200);
            }
            else
            {
                return redirect(route('verifikasirenja.show',['id'=>$verifikasirenja->RenjaID]))->with('success','Data ini telah berhasil disimpan.');
            }
        }//akhir check $data is null
    }
}