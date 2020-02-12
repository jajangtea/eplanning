<?php

namespace App\Controllers\RKPD;

use Illuminate\Http\Request;
use App\Controllers\Controller;

use App\Models\RKPD\RenjaIndikatorModel;
use App\Models\RKPD\RenjaModel;
use App\Models\RKPD\RenjaRincianModel;


class UsulanRenjaController extends Controller 
{    
    /**
     * Membuat sebuah objek
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth','role:superadmin|bapelitbang|opd']);
        //set nama session 
        $this->SessionName=$this->getNameForSession();      
        //set nama halaman saat ini
        $this->NameOfPage = \Helper::getNameOfPage();
    }    
    private function populateRincianKegiatan($RenjaID)
    {
        switch ($this->NameOfPage) 
        {
            case 'usulanprarenjaopd' :
                $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                            "trRenjaRinc90"."RenjaID",
                                                            "trRenjaRinc90"."UsulanKecID",
                                                            "Nm_Kecamatan",
                                                            "trRenjaRinc90"."Uraian",
                                                            "trRenjaRinc90"."No",
                                                            "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                            "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                            "trRenjaRinc90"."Target1" AS "Target",
                                                            "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                            "trRenjaRinc90"."Status",
                                                            "trRenjaRinc90"."Privilege",
                                                            "trRenjaRinc90"."Prioritas",
                                                            "isSKPD",
                                                            "isReses",
                                                            "isReses_Uraian",
                                                            "trRenjaRinc90"."Descr"'))
                                        ->where('trRenjaRinc90.EntryLvl',\HelperKegiatan::getLevelEntriByName($this->NameOfPage));
            break;
            case 'usulanrakorbidang' :
                $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                            "trRenjaRinc90"."RenjaID",
                                                            "trRenjaRinc90"."UsulanKecID",
                                                            "Nm_Kecamatan",
                                                            "trRenjaRinc90"."Uraian",
                                                            "trRenjaRinc90"."No",
                                                            "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                            "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                            "trRenjaRinc90"."Target2" AS "Target",
                                                            "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                            "trRenjaRinc90"."Status",
                                                            "trRenjaRinc90"."Privilege",
                                                            "trRenjaRinc90"."Prioritas",
                                                            "isSKPD",
                                                            "isReses",
                                                            "isReses_Uraian",
                                                            "trRenjaRinc90"."Descr"'))
                                        ->where('trRenjaRinc90.EntryLvl',\HelperKegiatan::getLevelEntriByName($this->NameOfPage));  
            break;
            case 'usulanforumopd' :
                $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                            "trRenjaRinc90"."RenjaID",
                                                            "trRenjaRinc90"."UsulanKecID",
                                                            "Nm_Kecamatan",
                                                            "trRenjaRinc90"."Uraian",
                                                            "trRenjaRinc90"."No",
                                                            "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                            "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                            "trRenjaRinc90"."Target3" AS "Target",
                                                            "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                            "trRenjaRinc90"."Status",
                                                            "trRenjaRinc90"."Privilege",
                                                            "trRenjaRinc90"."Prioritas",
                                                            "isSKPD",
                                                            "isReses",
                                                            "isReses_Uraian",
                                                            "trRenjaRinc90"."Descr"'))
                                        ->where('trRenjaRinc90.EntryLvl',\HelperKegiatan::getLevelEntriByName($this->NameOfPage));  
            break;
            case 'usulanmusrenkab' :
                 $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                            "trRenjaRinc90"."RenjaID",
                                                            "trRenjaRinc90"."UsulanKecID",
                                                            "Nm_Kecamatan",
                                                            "trRenjaRinc90"."Uraian",
                                                            "trRenjaRinc90"."No",
                                                            "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                            "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                            "trRenjaRinc90"."Target4" AS "Target",
                                                            "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                            "trRenjaRinc90"."Status",
                                                            "trRenjaRinc90"."Privilege",
                                                            "trRenjaRinc90"."Prioritas",
                                                            "isSKPD",
                                                            "isReses",
                                                            "isReses_Uraian",
                                                            "trRenjaRinc90"."Descr"'))
                                        ->where('trRenjaRinc90.EntryLvl',\HelperKegiatan::getLevelEntriByName($this->NameOfPage));  
            break;
        }
        $data = $data->leftJoin('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')
                        ->leftJoin('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                        ->leftJoin('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                        
                        ->where('RenjaID',$RenjaID)
                        ->orderBy('Prioritas','ASC')
                        ->get();
        
        return $data;
    }
    private function populateIndikatorKegiatan($RenjaID)
    {
      
        $data = RenjaIndikatorModel::select(\DB::raw('"trRenjaIndikator90"."RenjaIndikatorID","trIndikatorKinerja"."NamaIndikator","trRenjaIndikator90"."Target_Angka","trRenjaIndikator90"."Target_Uraian","trRenjaIndikator90"."TA"'))
                                    ->join('trIndikatorKinerja','trIndikatorKinerja.IndikatorKinerjaID','trRenjaIndikator90.IndikatorKinerjaID')
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
        if (!$this->checkStateIsExistSession($this->SessionName,'orderby')) 
        {            
           $this->putControllerStateSession($this->SessionName,'orderby',['column_name'=>'kode_subkegiatan','order'=>'asc']);
        }
        $column_order=$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'); 
        $direction=$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'); 

        if (!$this->checkStateIsExistSession('global_controller','numberRecordPerPage')) 
        {            
            $this->putControllerStateSession('global_controller','numberRecordPerPage',10);
        }
        $numberRecordPerPage=$this->getControllerStateSession('global_controller','numberRecordPerPage');
        
        $SOrgID= $this->getControllerStateSession(\Helper::getNameOfPage('filters'),'SOrgID');        

        if ($this->checkStateIsExistSession($this->SessionName,'search')) 
        {
            $search=$this->getControllerStateSession($this->SessionName,'search');
            switch ($search['kriteria']) 
            {
                case 'kode_subkegiatan' :
                    $data = \DB::table(\HelperKegiatan::getViewName($this->NameOfPage))
                                ->select(\HelperKegiatan::getField($this->NameOfPage))
                                ->where(['kode_subkegiatan'=>$search['isikriteria']])                                                    
                                ->where('SOrgID',$SOrgID)
                                ->where('TA', \HelperKegiatan::getTahunPerencanaan())
                                ->orderBy('Prioritas','ASC')
                                ->orderBy($column_order,$direction); 
                break;
                case 'SubKgtNm' :
                    $data = \DB::table(\HelperKegiatan::getViewName($this->NameOfPage))
                                ->select(\HelperKegiatan::getField($this->NameOfPage))
                                ->where('SubKgtNm', 'ilike', '%' . $search['isikriteria'] . '%')                                                    
                                ->where('SOrgID',$SOrgID)
                                ->where('TA', \HelperKegiatan::getTahunPerencanaan())
                                ->orderBy('Prioritas','ASC')
                                ->orderBy($column_order,$direction);                                        
                break;
                case 'Uraian' :
                    $data =  \DB::table(\HelperKegiatan::getViewName($this->NameOfPage))
                                    ->select(\HelperKegiatan::getField($this->NameOfPage))
                                    ->where('Uraian', 'ilike', '%' . $search['isikriteria'] . '%')                                                    
                                    ->where('SOrgID',$SOrgID)
                                    ->where('TA', \HelperKegiatan::getTahunPerencanaan())
                                    ->orderBy('Prioritas','ASC')
                                    ->orderBy($column_order,$direction);                                        
                break;
            }           
            $data = $data->paginate($numberRecordPerPage, $columns, 'page', $currentpage);  
        }
        else
        {
            $data = \DB::table(\HelperKegiatan::getViewName($this->NameOfPage))
                            ->select(\HelperKegiatan::getField($this->NameOfPage))
                            ->where('SOrgID',$SOrgID)                                            
                            ->where('TA', \HelperKegiatan::getTahunPerencanaan())                                            
                            ->orderBy('Prioritas','ASC')
                            ->orderBy($column_order,$direction)                                            
                            ->paginate($numberRecordPerPage, $columns, 'page', $currentpage);
        }        
        $data->setPath(route(\Helper::getNameOfPage('index')));                 
        return $data;
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
            case 'col-kode_subkegiatan' :
                $column_name = 'kode_subkegiatan';
            break;    
            case 'col-SubKgtNm' :
                $column_name = 'SubKgtNm';
            break;    
            case 'col-Uraian' :
                $column_name = 'Uraian';
            break;    
            case 'col-Sasaran_Angka' :
                $column_name = 'Sasaran_Angka';
            break;  
            case 'col-Jumlah' :
                $column_name = 'Jumlah';
            break; 
            case 'col-status' :
                $column_name = 'status';
            break;
            case 'col-Prioritas' :
                $column_name = 'Prioritas';
            break;
            default :
                $column_name = 'kode_subkegiatan';
        }
        $this->putControllerStateSession($this->SessionName,'orderby',['column_name'=>$column_name,'order'=>$orderby]);        

        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession($this->SessionName);         
        $data=$this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }

        $datatable = view("pages.$theme.rkpd.usulanrenja.datatable")->with(['page_active'=>$this->NameOfPage,
                                                                        'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),                                                                           
                                                                        'search'=>$this->getControllerStateSession($this->SessionName,'search'),
                                                                        'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                        'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                        'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
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

        $this->setCurrentPageInsideSession($this->SessionName,$id);
        $data=$this->populateData($id);
        $datatable = view("pages.$theme.rkpd.usulanrenja.datatable")->with(['page_active'=>$this->NameOfPage, 
                                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                                'label_transfer'=>$this->LabelTransfer,
                                                                                'search'=>$this->getControllerStateSession($this->SessionName,'search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                                'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
                                                                                'data'=>$data])->render(); 

        return response()->json(['success'=>true,'datatable'=>$datatable],200);        
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
        
        $this->setCurrentPageInsideSession($this->SessionName,1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rkpd.usulanrenja.datatable")->with(['page_active'=>$this->NameOfPage,
                                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),                                                                           
                                                                                'search'=>$this->getControllerStateSession($this->SessionName,'search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                                'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                                'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
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

        $filters=$this->getControllerStateSession($this->SessionName,'filters');
        $daftar_unitkerja=[];
        $json_data = [];

        //index
        if ($request->exists('OrgID'))
        {
            $OrgID = $request->input('OrgID')==''?'none':$request->input('OrgID');
            $filters['OrgID']=$OrgID;
            $filters['SOrgID']='none';
            $daftar_unitkerja=\App\Models\DMaster\SubOrganisasiModel::getDaftarUnitKerja(\HelperKegiatan::getTahunPerencanaan(),false,$OrgID);  
            
            $this->putControllerStateSession($this->SessionName,'filters',$filters);

            $data = [];

            $datatable = view("pages.$theme.rkpd.usulanrenja.datatable")->with(['page_active'=>$this->NameOfPage,   
                                                                            'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),                                                                                                                                    
                                                                            'search'=>$this->getControllerStateSession($this->SessionName,'search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                            'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
                                                                            'data'=>$data])->render();

            $totalpaguindikatifopd = RenjaRincianModel::getTotalPaguIndikatifByStatusAndOPD(\HelperKegiatan::getTahunPerencanaan(),\HelperKegiatan::getLevelEntriByName($this->NameOfPage),$filters['OrgID']);            
                  
            $totalpaguindikatifunitkerja[0]=0;
            $totalpaguindikatifunitkerja[1]=0;
            $totalpaguindikatifunitkerja[2]=0;
            $totalpaguindikatifunitkerja[3]=0;  
            
            $paguanggaranopd=\App\Models\DMaster\PaguAnggaranOPDModel::select('Jumlah1')
                                                                        ->where('OrgID',$filters['OrgID'])
                                                                        ->value('Jumlah1');

            $json_data = ['success'=>true,'paguanggaranopd'=>$paguanggaranopd,'totalpaguindikatifopd'=>$totalpaguindikatifopd,'totalpaguindikatifunitkerja'=>$totalpaguindikatifunitkerja,'daftar_unitkerja'=>$daftar_unitkerja,'datatable'=>$datatable];
        } 
        //index
        if ($request->exists('SOrgID'))
        {
            $SOrgID = $request->input('SOrgID')==''?'none':$request->input('SOrgID');
            $filters['SOrgID']=$SOrgID;
            $this->putControllerStateSession($this->SessionName,'filters',$filters);
            $this->setCurrentPageInsideSession($this->SessionName,1);

            $data = $this->populateData();            
            $datatable = view("pages.$theme.rkpd.usulanrenja.datatable")->with(['page_active'=>$this->NameOfPage,   
                                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),                                                                                                                                    
                                                                                'search'=>$this->getControllerStateSession($this->SessionName,'search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                                'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                                'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
                                                                                'data'=>$data])->render();                                                                                       
                        
            $totalpaguindikatifunitkerja = RenjaRincianModel::getTotalPaguIndikatifByStatusAndUnitKerja(\HelperKegiatan::getTahunPerencanaan(),\HelperKegiatan::getLevelEntriByName($this->NameOfPage),$filters['SOrgID']);            
            
            $json_data = ['success'=>true,'totalpaguindikatifunitkerja'=>$totalpaguindikatifunitkerja,'datatable'=>$datatable];            
        } 

        //create2
        if ($request->exists('PmKecamatanID') && $request->exists('create2') )
        {
            $PmKecamatanID = $request->input('PmKecamatanID')==''?'none':$request->input('PmKecamatanID');           
            $RenjaID = $request->input('RenjaID');
            $subquery = \DB::table('trRenjaRinc90')
                            ->select('UsulanKecID')
                            ->where('TA',\HelperKegiatan::getTahunPerencanaan());
            $data=\App\Models\Musrenbang\AspirasiMusrenKecamatanModel::select('trUsulanKec.*')
                                                                        ->leftJoinSub($subquery,'rinciankegiatan',function($join){
                                                                            $join->on('trUsulanKec.UsulanKecID','=','rinciankegiatan.UsulanKecID');
                                                                        })
                                                                        ->where('trUsulanKec.TA', \HelperKegiatan::getTahunPerencanaan())
                                                                        ->where('trUsulanKec.PmKecamatanID',$PmKecamatanID)                                                
                                                                        ->where('trUsulanKec.Privilege',1)       
                                                                        ->whereNull('rinciankegiatan.UsulanKecID')       
                                                                        ->orderBY('trUsulanKec.NamaKegiatan','ASC')
                                                                        ->get(); 
            $daftar_uraian = [];
            foreach ($data as $v)
            {
                $daftar_uraian[$v->UsulanKecID]=$v->NamaKegiatan . ' [Rp.'.\App\Helpers\Helper::formatUang($v->NilaiUsulan).']';
            }
            $json_data = ['success'=>true,'Data'=>$data,'daftar_uraian'=>$daftar_uraian];            
        } 
        //create2
        if ($request->exists('UsulanKecID') && $request->exists('create2') )
        {
            $UsulanKecID = $request->input('UsulanKecID')==''?'none':$request->input('UsulanKecID');   
            $data=\App\Models\Musrenbang\AspirasiMusrenKecamatanModel::find($UsulanKecID);

            $data_kegiatan['PmDesaID']=$data->PmDesaID;
            $data_kegiatan['Uraian']=$data->NamaKegiatan;
            $data_kegiatan['NilaiUsulan']=\App\Helpers\Helper::formatUang($data->NilaiUsulan);
            $data_kegiatan['Sasaran_Angka']=\App\Helpers\Helper::formatAngka($data->Target_Angka);
            $data_kegiatan['Sasaran_Uraian']=$data->Target_Uraian;
            $data_kegiatan['Prioritas']=$data->Prioritas > 6 ? 6 : $data->Prioritas;
            $json_data = ['success'=>true,'data_kegiatan'=>$data_kegiatan];
        }
        //create3
        if ($request->exists('PemilikPokokID') && $request->exists('create3') )
        {
            $PemilikPokokID = $request->input('PemilikPokokID')==''?'none':$request->input('PemilikPokokID');           
            $RenjaID = $request->input('RenjaID');

            $subquery = \DB::table('trRenjaRinc90')
                            ->select('PokPirID')
                            ->where('TA',\HelperKegiatan::getTahunPerencanaan());

            $data=\App\Models\Pokir\PokokPikiranModel::select('trPokPir.*')
                                                    ->leftJoinSub($subquery,'rinciankegiatan',function($join){
                                                        $join->on('trPokPir.PokPirID','=','rinciankegiatan.PokPirID');
                                                    })
                                                    ->where('trPokPir.TA', \HelperKegiatan::getTahunPerencanaan())
                                                    ->where('trPokPir.PemilikPokokID',$PemilikPokokID)                                                
                                                    ->whereNull('rinciankegiatan.PokPirID')
                                                    ->where('trPokPir.Privilege',1)  
                                                    ->where('trPokPir.OrgID',$filters['OrgID'])   
                                                    ->orderBY('trPokPir.Prioritas','ASC')
                                                    ->orderBY('NamaUsulanKegiatan','ASC')
                                                    ->get(); 
            foreach ($data as $v)
            {
                $daftar_pokir[$v->PokPirID]=$v->PokPirID.' - '.$v->NamaUsulanKegiatan;
            }

            $json_data = ['success'=>true,'daftar_pokir'=>$daftar_pokir,'message'=>'bila daftar_pokir kosong mohon dicek Privilege apakah bernilai 1'];                        
        }
        //create3
        if ($request->exists('PokPirID') && $request->exists('create3') )
        {
            $PokPirID = $request->input('PokPirID')==''?'none':$request->input('PokPirID');   
            $data=\App\Models\Pokir\PokokPikiranModel::find($PokPirID);
            
            $data_kegiatan['Uraian']=$data->NamaUsulanKegiatan;
            $data_kegiatan['NilaiUsulan']=\App\Helpers\Helper::formatUang($data->NilaiUsulan);
            $data_kegiatan['Sasaran_Angka']=\App\Helpers\Helper::formatAngka($data->Sasaran_Uraian);
            $data_kegiatan['Sasaran_Uraian']=$data->Sasaran_Uraian;
            $data_kegiatan['Prioritas']=$data->Prioritas > 6 ? 6 : $data->Prioritas;
            $json_data = ['success'=>true,'data_kegiatan'=>$data_kegiatan];
        }
        //create4
        if ($request->exists('PmKecamatanID') && $request->exists('create4') )
        {
            $PmKecamatanID = $request->input('PmKecamatanID')==''?'none':$request->input('PmKecamatanID');
            $daftar_desa=\App\Models\DMaster\DesaModel::getDaftarDesa(\HelperKegiatan::getTahunPerencanaan(),$PmKecamatanID,false);
                                                                                    
            $json_data = ['success'=>true,'daftar_desa'=>$daftar_desa];            
        } 

        return response()->json($json_data,200);  
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
            $this->destroyControllerStateSession($this->SessionName,'search');
        }
        else
        {
            $kriteria = $request->input('cmbKriteria');
            $isikriteria = $request->input('txtKriteria');
            $this->putControllerStateSession($this->SessionName,'search',['kriteria'=>$kriteria,'isikriteria'=>$isikriteria]);
        }      
        $this->setCurrentPageInsideSession($this->SessionName,1);
        $data=$this->populateData();

        $datatable = view("pages.$theme.rkpd.usulanrenja.datatable")->with(['page_active'=>$this->NameOfPage, 
                                                                            'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),                                                            
                                                                            'search'=>$this->getControllerStateSession($this->SessionName,'search'),
                                                                            'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),
                                                                            'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                            'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
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
        $auth = \Auth::user();    
        $theme = $auth->theme;
        
        //filter
        if (!$this->checkStateIsExistSession($this->SessionName,'filters')) 
        {            
            $this->putControllerStateSession($this->SessionName,'filters',[
                                                                            'OrgID'=>'none',
                                                                            'SOrgID'=>'none',
                                                                            ]);
        }        
        $filters=$this->getControllerStateSession($this->SessionName,'filters');
        $roles=$auth->getRoleNames();   
        $daftar_unitkerja=array();           
        switch ($roles[0])
        {
            case 'superadmin' :     
            case 'bapelitbang' :     
            case 'tapd' :     
                $daftar_opd=\App\Models\DMaster\OrganisasiModel::getDaftarOPD(\HelperKegiatan::getTahunPerencanaan(),false);                  
                if ($filters['OrgID'] != 'none'&&$filters['OrgID'] != ''&&$filters['OrgID'] != null)
                {
                    $daftar_unitkerja=\App\Models\DMaster\SubOrganisasiModel::getDaftarUnitKerja(\HelperKegiatan::getTahunPerencanaan(),false,$filters['OrgID']);        
                }    
            break;
            case 'opd' :               
                $daftar_opd=\App\Models\UserOPD::getOPD();                      
                if (count($daftar_opd) > 0)
                {                    
                    if ($filters['OrgID'] != 'none'&&$filters['OrgID'] != ''&&$filters['OrgID'] != null)
                    {
                        $daftar_unitkerja=\App\Models\DMaster\SubOrganisasiModel::getDaftarUnitKerja(\HelperKegiatan::getTahunPerencanaan(),false,$filters['OrgID']);        
                    }  
                }      
                else
                {
                    $filters['OrgID']='none';
                    $filters['SOrgID']='none';
                    $this->putControllerStateSession($this->SessionName,'filters',$filters);

                    return view("pages.$theme.rkpd.usulanrenja.error")->with(['page_active'=>$this->NameOfPage, 
                                                                                        'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                                        'errormessage'=>'Anda Tidak Diperkenankan Mengakses Halaman ini, karena Sudah dikunci oleh BAPELITBANG',
                                                                                        ]);
                }          
            break;
        }        
        $search=$this->getControllerStateSession($this->SessionName,'search');        
        $currentpage=$request->has('page') ? $request->get('page') : $this->getCurrentPageInsideSession($this->SessionName); 
        $data = $this->populateData($currentpage);
        if ($currentpage > $data->lastPage())
        {            
            $data = $this->populateData($data->lastPage());
        }
        $this->setCurrentPageInsideSession($this->SessionName,$data->currentPage());
        $paguanggaranopd=\App\Models\DMaster\PaguAnggaranOPDModel::select('Jumlah1')
                                                                    ->where('OrgID',$filters['OrgID'])                                                    
                                                                    ->value('Jumlah1');

        return view("pages.$theme.rkpd.usulanrenja.index")->with(['page_active'=>$this->NameOfPage, 
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'daftar_opd'=>$daftar_opd,
                                                                'daftar_unitkerja'=>$daftar_unitkerja,
                                                                'filters'=>$filters,
                                                                'search'=>$this->getControllerStateSession($this->SessionName,'search'),
                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                'column_order'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'column_name'),
                                                                'direction'=>$this->getControllerStateSession(\Helper::getNameOfPage('orderby'),'order'),
                                                                'paguanggaranopd'=>$paguanggaranopd,
                                                                'totalpaguindikatifopd'=>RenjaRincianModel::getTotalPaguIndikatifByStatusAndOPD(\HelperKegiatan::getTahunPerencanaan(),\HelperKegiatan::getLevelEntriByName($this->NameOfPage),$filters['OrgID']),
                                                                'totalpaguindikatifunitkerja' => RenjaRincianModel::getTotalPaguIndikatifByStatusAndUnitKerja(\HelperKegiatan::getTahunPerencanaan(),\HelperKegiatan::getLevelEntriByName($this->NameOfPage),$filters['SOrgID']),            
                                                                'data'=>$data]);
    }   
    public function pilihusulankegiatan(Request $request)
    {
        $json_data=[];       
        if ($request->exists('PrgID'))
        {
            $PrgID = $request->input('PrgID')==''?'none':$request->input('PrgID');
            $r=\DB::table('v_sub_kegiatan')
                    ->where('TA',\HelperKegiatan::getTahunPerencanaan())
                    ->where('PrgID',$PrgID)
                    ->WhereNotIn('SubKgtID',function($query) {
                        $OrgID=$this->getControllerStateSession($this->SessionName,'filters.OrgID');
                        $query->select('SubKgtID')
                                ->from('trRenja90')
                                ->where('TA', \HelperKegiatan::getTahunPerencanaan())
                                ->where('OrgID', $OrgID);
                    }) 
                    ->get();
            $daftar_kegiatan=[];        
            foreach ($r as $k=>$v)
            {               
                $daftar_kegiatan[$v->SubKgtID]='['.$v->kode_subkegiatan.']. '.$v->SubKgtNm;
            }            
            $json_data['success']=true;
            $json_data['PrgID']=$PrgID;
            $json_data['daftar_kegiatan']=$daftar_kegiatan;
        }
        return response()->json($json_data,200);  
    }
    public function pilihindikatorkinerja(Request $request)
    {
        $IndikatorKinerjaID = $request->input('IndikatorKinerjaID');
        $json_data=\App\Models\RPJMD\RpjmdIndikatorKinerjaModel::getIndikatorKinerjaByID($IndikatorKinerjaID,\HelperKegiatan::getTahunPerencanaan());
        if (is_null($json_data))
        {
            $json_data=[
                'NamaIndikator'=>'-',
                'TargetAngka'=>'-',
                'PaguDana'=>'-'
            ];
        }
        return response()->json($json_data,200);  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        $theme = \Auth::user()->theme;

        $filters=$this->getControllerStateSession($this->SessionName,'filters');         
        $locked=false;
        if ($filters['SOrgID'] != 'none'&&$filters['SOrgID'] != ''&&$filters['SOrgID'] != null && $locked==false)
        {
            $SOrgID=$filters['SOrgID'];            
            $OrgID=$filters['OrgID'];            

            $organisasi=\App\Models\DMaster\SubOrganisasiModel::select(\DB::raw('"v_suborganisasi"."OrgID","v_suborganisasi"."OrgIDRPJMD","v_suborganisasi"."UrsID","v_suborganisasi"."OrgNm","v_suborganisasi"."SOrgNm","v_suborganisasi"."kode_organisasi","v_suborganisasi"."kode_suborganisasi"'))
                                                            ->join('v_suborganisasi','tmSOrg.OrgID','v_suborganisasi.OrgID')
                                                            ->find($SOrgID);  
            
            $daftar_program = \App\Models\DMaster\ProgramModel::getDaftarProgramByOPD($organisasi->OrgIDRPJMD);
            $sumber_dana = \App\Models\DMaster\SumberDanaModel::getDaftarSumberDana(\HelperKegiatan::getTahunPerencanaan(),false);     
            
            return view("pages.$theme.rkpd.usulanrenja.create")->with(['page_active'=>$this->NameOfPage,
                                                                    'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                    'daftar_program'=>$daftar_program,
                                                                    'organisasi'=>$organisasi,
                                                                    'sumber_dana'=>$sumber_dana
                                                                ]);  
        }
        else
        {
            return view("pages.$theme.rkpd.usulanrenja.error")->with(['page_active'=>$this->NameOfPage,
                                                                    'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                    'errormessage'=>'Mohon unit kerja untuk di pilih terlebih dahulu. bila sudah terpilih ternyata tidak bisa, berarti saudara tidak diperkenankan menambah kegiatan karena telah dikunci.'
                                                                ]);  
        }  
    }    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create1($renjaid)
    {        
        $theme = \Auth::user()->theme;

        $filters=$this->getControllerStateSession($this->SessionName,'filters'); 
        if ($filters['SOrgID'] != 'none'&&$filters['SOrgID'] != ''&&$filters['SOrgID'] != null)
        {
            $OrgID=$filters['OrgID'];
            $SOrgID=$filters['SOrgID'];

            $renja=RenjaModel::select(\DB::raw('"RenjaID","SubKgtID","OrgIDRPJMD"'))
                                ->join('tmOrg','tmOrg.OrgID','trRenja90.OrgID')
                                ->where('trRenja90.OrgID',$OrgID)
                                ->where('trRenja90.SOrgID',$SOrgID)
                                ->where('trRenja90.Privilege',0)
                                ->where('trRenja90.Locked',false)
                                ->findOrFail($renjaid);
            
            
            $kegiatan=\App\Models\DMaster\SubKegiatanModel::select(\DB::raw('"trUrsPrg"."UrsID","trUrsPrg"."PrgID"'))
                                                                ->join('tmKgt','tmKgt.KgtID','tmSubKgt.KgtID')
                                                                ->join('trUrsPrg','trUrsPrg.PrgID','tmKgt.PrgID')
                                                                ->find($renja->SubKgtID);  
            if ($kegiatan == null)
            {
                $daftar_indikatorkinerja=[];
            }
            else
            {
                $UrsID=$kegiatan->UrsID;    
                $PrgID=$kegiatan->PrgID;          
                $daftar_indikatorkinerja = \DB::table('trIndikatorKinerja')
                                            ->where('UrsID',$UrsID)
                                            ->where('PrgID',$PrgID)
                                            ->where('OrgIDRPJMD',$renja->OrgIDRPJMD)                                           
                                            ->where('TA',\HelperKegiatan::getRPJMDTahunMulai())
                                            ->WhereNotIn('IndikatorKinerjaID',function($query) use ($renjaid){
                                                $query->select('IndikatorKinerjaID')
                                                        ->from('trRenjaIndikator90')
                                                        ->where('RenjaID', $renjaid);
                                            })
                                            ->get()
                                            ->pluck('NamaIndikator','IndikatorKinerjaID')
                                            ->toArray(); 
            }    
            
            $dataindikatorkinerja = $this->populateIndikatorKegiatan($renjaid);

            return view("pages.$theme.rkpd.usulanrenja.create1")->with(['page_active'=>$this->NameOfPage,
                                                                    'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                    'daftar_indikatorkinerja'=>$daftar_indikatorkinerja,
                                                                    'renja'=>$renja,
                                                                    'dataindikatorkinerja'=>$dataindikatorkinerja
                                                                    ]);  
        }
        else
        {
            return view("pages.$theme.rkpd.usulanrenja.error")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'errormessage'=>'Mohon unit kerja untuk di pilih terlebih dahulu.'
                                                                ]);  
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2($renjaid)
    {        
        $theme = \Auth::user()->theme;

        $filters=$this->getControllerStateSession($this->SessionName,'filters'); 
        if ($filters['SOrgID'] != 'none'&&$filters['SOrgID'] != ''&&$filters['SOrgID'] != null)
        {
            $renja=RenjaModel::where('Privilege',0)
                                ->where('Locked',false)
                                ->findOrFail($renjaid);

            $datarinciankegiatan = $this->populateRincianKegiatan($renjaid);
            
            //lokasi
            $daftar_provinsi = ['uid14f25a97c07e'=>'KEPULAUAN RIAU'];
            $daftar_kota_kab = ['uidca544f415ae2'=>'BINTAN'];        
            $daftar_kecamatan=\App\Models\DMaster\KecamatanModel::getDaftarKecamatan(\HelperKegiatan::getTahunPerencanaan(),config('eplanning.default_kota_atau_kab'),false);
            $nomor_rincian = RenjaRincianModel::where('RenjaID',$renjaid)->count('No')+1;
            return view("pages.$theme.rkpd.usulanrenja.create2")->with(['page_active'=>$this->NameOfPage,
                                                                    'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                    'renja'=>$renja,
                                                                    'datarinciankegiatan'=>$datarinciankegiatan,
                                                                    'nomor_rincian'=>$nomor_rincian,
                                                                    'daftar_provinsi'=> $daftar_provinsi,
                                                                    'daftar_kota_kab'=> $daftar_kota_kab,
                                                                    'daftar_kecamatan'=>$daftar_kecamatan
                                                                    ]);  
        }
        else
        {
            return view("pages.$theme.rkpd.usulanrenja.error")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'errormessage'=>'Mohon unit kerja untuk di pilih terlebih dahulu.'
                                                                ]);  
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create3($renjaid)
    {        
        $theme = \Auth::user()->theme;

        $filters=$this->getControllerStateSession($this->SessionName,'filters'); 
        if ($filters['SOrgID'] != 'none'&&$filters['SOrgID'] != ''&&$filters['SOrgID'] != null)
        {
            $renja=RenjaModel::where('Privilege',0)
                            ->where('Locked',false)
                            ->findOrFail($renjaid);
            
            $datarinciankegiatan = $this->populateRincianKegiatan($renjaid);

            $nomor_rincian = RenjaRincianModel::where('RenjaID',$renjaid)->count('No')+1;
            $daftar_pemilik= \App\Models\Pokir\PemilikPokokPikiranModel::where('TA',\HelperKegiatan::getTahunPerencanaan()) 
                                                                        ->select(\DB::raw('"PemilikPokokID", CONCAT("NmPk",\' [\',"Kd_PK",\']\') AS "NmPk"'))                                                                       
                                                                        ->get()
                                                                        ->pluck('NmPk','PemilikPokokID')                                                                        
                                                                        ->toArray();
            //lokasi
            $PMProvID = 'uidF1847004D8F547BF';
            $PmKotaID = 'uidE4829D1F21F44ECA';
            return view("pages.$theme.rkpd.usulanrenja.create3")->with(['page_active'=>$this->NameOfPage,
                                                                            'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                            'renja'=>$renja,
                                                                            'datarinciankegiatan'=>$datarinciankegiatan,
                                                                            'daftar_pemilik'=>$daftar_pemilik, 
                                                                            'nomor_rincian'=>$nomor_rincian,
                                                                            'PMProvID'=>$PMProvID,
                                                                            'PmKotaID'=>$PmKotaID
                                                                            ]);  
        }
        else
        {
            return view("pages.$theme.rkpd.usulanrenja.error")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'errormessage'=>'Mohon unit kerja untuk di pilih terlebih dahulu.'
                                                                ]);  
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create4($renjaid)
    {        
        $theme = \Auth::user()->theme;

        $filters=$this->getControllerStateSession($this->SessionName,'filters'); 
        if ($filters['SOrgID'] != 'none'&&$filters['SOrgID'] != ''&&$filters['SOrgID'] != null)
        {
            $renja=RenjaModel::where('Privilege',0)
                                ->where('Locked',false)
                                ->findOrFail($renjaid);            
            $datarinciankegiatan = $this->populateRincianKegiatan($renjaid);            
            //lokasi
            $daftar_provinsi = ['uidF1847004D8F547BF'=>'KEPULAUAN RIAU'];
            $daftar_kota_kab = ['uidE4829D1F21F44ECA'=>'BINTAN'];        
            $daftar_kecamatan=\App\Models\DMaster\KecamatanModel::getDaftarKecamatan(\HelperKegiatan::getTahunPerencanaan(),config('eplanning.default_kota_atau_kab'),false);
            $nomor_rincian = RenjaRincianModel::where('RenjaID',$renjaid)->count('No')+1;
            return view("pages.$theme.rkpd.usulanrenja.create4")->with(['page_active'=>$this->NameOfPage,
                                                                    'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                    'renja'=>$renja,
                                                                    'nomor_rincian'=>$nomor_rincian,
                                                                    'datarinciankegiatan'=>$datarinciankegiatan,
                                                                    'daftar_provinsi'=> $daftar_provinsi,
                                                                    'daftar_kota_kab'=> $daftar_kota_kab,
                                                                    'daftar_kecamatan'=>$daftar_kecamatan
                                                                    ]);  
        }
        else
        {
            return view("pages.$theme.rkpd.usulanrenja.error")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'errormessage'=>'Mohon unit kerja untuk di pilih terlebih dahulu.'
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
            'UrsID'=>'required',
            'PrgID'=>'required',
            'SubKgtID'=>'required',
            'SumberDanaID'=>'required',
            'Sasaran_Angka'=>'required',
            'Sasaran_Uraian' => 'required',
            'Sasaran_AngkaSetelah'=>'required',
            'Sasaran_UraianSetelah'=>'required',
            'Target'=>'required',
            'NilaiSebelum'=>'required',
            'NilaiUsulan'=>'required',
            'NilaiSetelah'=>'required',
            'NamaIndikator'=>'required'
        ]);
        $filters=$this->getControllerStateSession($this->SessionName,'filters');
        $RenjaID=uniqid ('uid');
        switch ($this->NameOfPage) 
        {            
            case 'usulanprarenjaopd' :
                $data=[            
                    'RenjaID' => $RenjaID,            
                    'OrgID' => $filters['OrgID'],
                    'SOrgID' => $filters['SOrgID'],
                    'SubKgtID' => $request->input('SubKgtID'),
                    'SumberDanaID' => $request->input('SumberDanaID'),
                    'NamaIndikator' => $request->input('NamaIndikator'), 
                    'Sasaran_Angka1' => $request->input('Sasaran_Angka'),
                    'Sasaran_Uraian1' => $request->input('Sasaran_Uraian'),
                    'Sasaran_AngkaSetelah' => $request->input('Sasaran_AngkaSetelah'),
                    'Sasaran_UraianSetelah' => $request->input('Sasaran_UraianSetelah'),
                    'Target1' => $request->input('Target'),
                    'NilaiSebelum' => $request->input('NilaiSebelum'),            
                    'NilaiUsulan1' => 0,            
                    'NilaiSetelah' => $request->input('NilaiSetelah'),                               
                    'Descr' => $request->input('Descr'),
                    'TA' => \HelperKegiatan::getTahunPerencanaan(),
                    'EntryLvl'=>0
                ];
            break;
            case 'usulanrakorbidang' :
                $data=[            
                    'RenjaID' => $RenjaID,            
                    'OrgID' => $filters['OrgID'],
                    'SOrgID' => $filters['SOrgID'],
                    'SubKgtID' => $request->input('SubKgtID'),
                    'SumberDanaID' => $request->input('SumberDanaID'),
                    'Sasaran_Angka2' => $request->input('Sasaran_Angka'),
                    'Sasaran_Uraian2' => $request->input('Sasaran_Uraian'),
                    'Sasaran_AngkaSetelah' => $request->input('Sasaran_AngkaSetelah'),
                    'Sasaran_UraianSetelah' => $request->input('Sasaran_UraianSetelah'),
                    'Target2' => $request->input('Target'),
                    'NilaiSebelum' => $request->input('NilaiSebelum'),     
                    'NilaiUsulan2' => 0,                   
                    'NilaiSetelah' => $request->input('NilaiSetelah'),
                    'NamaIndikator' => $request->input('NamaIndikator'),            
                    'Descr' => $request->input('Descr'),
                    'TA' => \HelperKegiatan::getTahunPerencanaan(),
                    'EntryLvl'=>1
                ];
            break;
            case 'usulanforumopd' :
                $data=[            
                    'RenjaID' => $RenjaID,            
                    'OrgID' => $filters['OrgID'],
                    'SOrgID' => $filters['SOrgID'],
                    'SubKgtID' => $request->input('SubKgtID'),
                    'SumberDanaID' => $request->input('SumberDanaID'),
                    'Sasaran_Angka3' => $request->input('Sasaran_Angka'),
                    'Sasaran_Uraian3' => $request->input('Sasaran_Uraian'),
                    'Sasaran_AngkaSetelah' => $request->input('Sasaran_AngkaSetelah'),
                    'Sasaran_UraianSetelah' => $request->input('Sasaran_UraianSetelah'),
                    'Target3' => $request->input('Target'),
                    'NilaiSebelum' => $request->input('NilaiSebelum'),    
                    'NilaiUsulan3' => 0,                    
                    'NilaiSetelah' => $request->input('NilaiSetelah'),
                    'NamaIndikator' => $request->input('NamaIndikator'),            
                    'Descr' => $request->input('Descr'),
                    'TA' => \HelperKegiatan::getTahunPerencanaan(),
                    'EntryLvl'=>2
                ];
            break;
            case 'usulanmusrenkab' :
               $data=[            
                    'RenjaID' => $RenjaID,            
                    'OrgID' => $filters['OrgID'],
                    'SOrgID' => $filters['SOrgID'],
                    'SubKgtID' => $request->input('SubKgtID'),
                    'SumberDanaID' => $request->input('SumberDanaID'),
                    'Sasaran_Angka4' => $request->input('Sasaran_Angka'),
                    'Sasaran_Uraian4' => $request->input('Sasaran_Uraian'),
                    'Sasaran_AngkaSetelah' => $request->input('Sasaran_AngkaSetelah'),
                    'Sasaran_UraianSetelah' => $request->input('Sasaran_UraianSetelah'),
                    'Target4' => $request->input('Target'),
                    'NilaiSebelum' => $request->input('NilaiSebelum'),          
                    'NilaiUsulan4' => 0,              
                    'NilaiSetelah' => $request->input('NilaiSetelah'),
                    'NamaIndikator' => $request->input('NamaIndikator'),            
                    'Descr' => $request->input('Descr'),
                    'TA' => \HelperKegiatan::getTahunPerencanaan(),
                    'EntryLvl'=>3
                ];
            break;
            
        }
        $usulanprarenjaopd = RenjaModel::create($data);        
        
        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('create1'),['uuid'=>$RenjaID]))->with('success','Data kegiatan telah berhasil disimpan. Selanjutnya isi Indikator Kinerja Kegiatan dari RPMJD');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Request $request)
    {
        $this->validate($request, [
            'IndikatorKinerjaID'=>'required',
            'Target_Angka'=>'required',
            'Target_Uraian'=>'required',           
        ]);
        
        $data=[  
            'RenjaIndikatorID' => uniqid ('uid'),           
            'RenjaID' => $request->input('RenjaID'),            
            'IndikatorKinerjaID' => $request->input('IndikatorKinerjaID'),           
            'Target_Angka' => $request->input('Target_Angka'),
            'Target_Uraian' => $request->input('Target_Uraian'),                       
            'Descr' => $request->input('Descr'),
            'TA' => \HelperKegiatan::getTahunPerencanaan()
        ];

        $indikatorkinerja = RenjaIndikatorModel::create($data);
        $renja = $indikatorkinerja->renja;
        $renja->Status_Indikator=RenjaIndikatorModel::where('RenjaID',$indikatorkinerja->RenjaID)->count() > 0;
        $renja->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('create1'),['uuid'=>$request->input('RenjaID')]))->with('success','Data Indikator kegiatan telah berhasil disimpan. Selanjutnya isi Rincian Kegiatan');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store2(Request $request)
    {
        $this->validate($request, [
            'No'=>'required',
            'Uraian'=>'required',
            'Sasaran_Angka'=>'required',
            'Sasaran_Uraian'=>'required',
            'Target'=>'required',
            'Jumlah'=>'required',
            'Prioritas' => 'required'            
        ]);

        \DB::transaction(function () use ($request) {        
            $renjaid=$request->input('RenjaID');
            $nomor_rincian = RenjaRincianModel::where('RenjaID',$renjaid)->count('No')+1;
            switch ($this->NameOfPage) 
            {            
                case 'usulanprarenjaopd' :
                    $data=[
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $request->input('PmKecamatanID'),  
                        'PmDesaID' => $request->input('PmDesaID'),         
                        'UsulanKecID' => $request->input('UsulanKecID'),    
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka1' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian1' => $request->input('Sasaran_Uraian'),                       
                        'Target1' => $request->input('Target'),                       
                        'Jumlah1' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),              
                        'Status' => 0,                                         
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan1=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah1');            
                    $renja->save();
                break;
                case 'usulanrakorbidang' :
                    $data=[
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $request->input('PmKecamatanID'),  
                        'PmDesaID' => $request->input('PmDesaID'),         
                        'UsulanKecID' => $request->input('UsulanKecID'),    
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka2' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian2' => $request->input('Sasaran_Uraian'),                       
                        'Target2' => $request->input('Target'),                       
                        'Jumlah2' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),              
                        'Status' => 0,  
                        'EntryLvl' => 1,                                       
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan2=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah2');            
                    $renja->save();
                break;
                case 'usulanforumopd' :                   
                    $data=[
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $request->input('PmKecamatanID'),  
                        'PmDesaID' => $request->input('PmDesaID'),         
                        'UsulanKecID' => $request->input('UsulanKecID'),    
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka3' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian3' => $request->input('Sasaran_Uraian'),                       
                        'Target3' => $request->input('Target'),                       
                        'Jumlah3' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),              
                        'Status' => 0,  
                        'EntryLvl' => 2,                                       
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan3=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah3');
                    $renja->save();
                break;
                case 'usulanmusrenkab' :
                    $data=[
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $request->input('PmKecamatanID'),  
                        'PmDesaID' => $request->input('PmDesaID'),         
                        'UsulanKecID' => $request->input('UsulanKecID'),    
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka4' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian4' => $request->input('Sasaran_Uraian'),                       
                        'Target4' => $request->input('Target'),                       
                        'Jumlah4' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),              
                        'Status' => 0,  
                        'EntryLvl' => 3,                                       
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];
                    
                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan4=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah4');
                    $renja->save();
                break;                
            }            
        });
        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('create2'),['uuid'=>$request->input('RenjaID')]))->with('success','Data Rincian kegiatan telah berhasil disimpan.');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store3(Request $request)
    {
        $this->validate($request, [
            'No'=>'required',
            'Uraian'=>'required',
            'Sasaran_Angka'=>'required',
            'Sasaran_Uraian'=>'required',
            'Target'=>'required',
            'Jumlah'=>'required',
            'Prioritas' => 'required'            
        ]);
        \DB::transaction(function () use ($request) {
            $renjaid=$request->input('RenjaID');            
            $nomor_rincian = RenjaRincianModel::where('RenjaID',$renjaid)->count('No')+1;

            $PokPirID=$request->input('PokPirID');
            
            $pokok_pikiran = \App\Models\Pokir\PokokPikiranModel::join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')
                                                                    ->where('PokPirID',$PokPirID)
                                                                    ->first(['trPokPir.PmDesaID','trPokPir.PmKecamatanID','trPokPir.PmKecamatanID','tmPemilikPokok.Kd_PK']);
            
            switch ($this->NameOfPage) 
            {            
                case 'usulanprarenjaopd' :                    
                    $data=[
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $pokok_pikiran->PmKecamatanID,           
                        'PmDesaID' => $pokok_pikiran->PmDesaID,    
                        'PokPirID' => $PokPirID, 
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka1' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian1' => $request->input('Sasaran_Uraian'),                       
                        'Target1' => $request->input('Target'),                       
                        'Jumlah1' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),  
                        'isReses' => true,     
                        'isReses_Uraian' => $pokok_pikiran->Kd_PK,
                        'Status' => 0,        
                        'EntryLvl' => 0,                                     
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan1=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah1');            
                    $renja->save();
                break;
                case 'usulanrakorbidang' :                    
                    $data=[
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $pokok_pikiran->PmKecamatanID,           
                        'PmDesaID' => $pokok_pikiran->PmDesaID,    
                        'PokPirID' => $PokPirID, 
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka2' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian2' => $request->input('Sasaran_Uraian'),                       
                        'Target2' => $request->input('Target'),                       
                        'Jumlah2' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),  
                        'isReses' => true,     
                        'isReses_Uraian' => $pokok_pikiran->Kd_PK,
                        'Status' => 0,                             
                        'EntryLvl' => 1,             
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan2=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah2');            
                    $renja->save();
                break;
                case 'usulanforumopd' :
                    $data=[
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $pokok_pikiran->PmKecamatanID,           
                        'PmDesaID' => $pokok_pikiran->PmDesaID,    
                        'PokPirID' => $PokPirID, 
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka3' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian3' => $request->input('Sasaran_Uraian'),                       
                        'Target3' => $request->input('Target'),                       
                        'Jumlah3' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),  
                        'isReses' => true,     
                        'isReses_Uraian' => $pokok_pikiran->Kd_PK,
                        'Status' => 0,                             
                        'EntryLvl' => 2,             
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan3=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah3');            
                    $renja->save();
                break;
                case 'usulanmusrenkab' :
                    $data=[
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $pokok_pikiran->PmKecamatanID,           
                        'PmDesaID' => $pokok_pikiran->PmDesaID,    
                        'PokPirID' => $PokPirID, 
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka4' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian4' => $request->input('Sasaran_Uraian'),                       
                        'Target4' => $request->input('Target'),                       
                        'Jumlah4' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),  
                        'isReses' => true,     
                        'isReses_Uraian' => $pokok_pikiran->Kd_PK,
                        'Status' => 0,                             
                        'EntryLvl' => 3,             
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan4=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah4');            
                    $renja->save();
                break;                
            }   

        });
        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('create3'),['uuid'=>$request->input('RenjaID')]))->with('success','Data Rincian kegiatan telah berhasil disimpan.');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store4(Request $request)
    {
        $this->validate($request, [
            'No'=>'required',
            'Uraian'=>'required',
            'Sasaran_Angka'=>'required',
            'Sasaran_Uraian'=>'required',
            'Target'=>'required',
            'Jumlah'=>'required',
            'Prioritas' => 'required'            
        ]);

        \DB::transaction(function () use ($request) {        
            $renjaid=$request->input('RenjaID');
            $nomor_rincian = RenjaRincianModel::where('RenjaID',$renjaid)->count('No')+1;

            switch ($this->NameOfPage) 
            {            
                case 'usulanprarenjaopd' :
                    $data = [
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $request->input('PmKecamatanID'),           
                        'PmDesaID' => $request->input('PmDesaID'),    
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka1' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian1' => $request->input('Sasaran_Uraian'),                       
                        'Target1' => $request->input('Target'),                       
                        'Jumlah1' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),  
                        'isSKPD' => true,     
                        'Status' => 0,        
                        'EntryLvl' => 0,                                 
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];
                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan1=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah1');            
                    $renja->save();
                break;
                case 'usulanrakorbidang' :
                    $data = [
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $request->input('PmKecamatanID'),           
                        'PmDesaID' => $request->input('PmDesaID'),    
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka2' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian2' => $request->input('Sasaran_Uraian'),                       
                        'Target2' => $request->input('Target'),                       
                        'Jumlah2' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),  
                        'isSKPD' => true,     
                        'Status' => 0,                               
                        'EntryLvl' => 1,           
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan2=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah2');            
                    $renja->save();
                break;
                case 'usulanforumopd' :
                    $data = [
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $request->input('PmKecamatanID'),           
                        'PmDesaID' => $request->input('PmDesaID'),    
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka3' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian3' => $request->input('Sasaran_Uraian'),                       
                        'Target3' => $request->input('Target'),                       
                        'Jumlah3' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),  
                        'isSKPD' => true,     
                        'Status' => 0,                               
                        'EntryLvl' => 2,           
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan3=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah3');            
                    $renja->save();
                break;
                case 'usulanmusrenkab' :
                    $data = [
                        'RenjaRincID' => uniqid ('uid'),           
                        'RenjaID' => $renjaid,            
                        'PMProvID' => $request->input('PMProvID'),           
                        'PmKotaID' => $request->input('PmKotaID'),           
                        'PmKecamatanID' => $request->input('PmKecamatanID'),           
                        'PmDesaID' => $request->input('PmDesaID'),    
                        'No' => $nomor_rincian,           
                        'Uraian' => $request->input('Uraian'),
                        'Sasaran_Angka4' => $request->input('Sasaran_Angka'),                       
                        'Sasaran_Uraian4' => $request->input('Sasaran_Uraian'),                       
                        'Target4' => $request->input('Target'),                       
                        'Jumlah4' => $request->input('Jumlah'),                       
                        'Prioritas' => $request->input('Prioritas'),  
                        'isSKPD' => true,     
                        'Status' => 0,                               
                        'EntryLvl' => 3,           
                        'Descr' => $request->input('Descr'),
                        'TA' => \HelperKegiatan::getTahunPerencanaan()
                    ];

                    $rinciankegiatan= RenjaRincianModel::create($data);
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan4=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah4');            
                    $renja->save();
                break;                
            }   
            
        });
        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('create4'),['uuid'=>$request->input('RenjaID')]))->with('success','Data Rincian kegiatan telah berhasil disimpan.');
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
        switch ($this->NameOfPage) 
        {            
            case 'usulanprarenjaopd' :
                $renja = RenjaModel::select(\DB::raw('"trRenja90"."RenjaID",
                                            "v_sub_kegiatan"."Kd_Urusan",
                                            "v_sub_kegiatan"."Nm_Urusan",
                                            "v_sub_kegiatan"."Kd_Bidang",
                                            "v_sub_kegiatan"."Nm_Bidang",
                                            "v_suborganisasi"."kode_organisasi",
                                            "v_suborganisasi"."OrgNm",
                                            "v_suborganisasi"."kode_suborganisasi",
                                            "v_suborganisasi"."SOrgNm",
                                            "v_sub_kegiatan"."Kd_Prog",
                                            "v_sub_kegiatan"."PrgNm",
                                            "v_sub_kegiatan"."Kd_SubKeg",
                                            "v_sub_kegiatan"."kode_subkegiatan",
                                            "v_sub_kegiatan"."SubKgtNm",
                                            "NamaIndikator",
                                            "Sasaran_Angka1" AS "Sasaran_Angka",
                                            "Sasaran_Uraian1" AS "Sasaran_Uraian",
                                            "Sasaran_AngkaSetelah",
                                            "Sasaran_UraianSetelah",
                                            "Target1" AS "Target",
                                            "NilaiSebelum",
                                            "NilaiUsulan1" AS "NilaiUsulan",
                                            "NilaiSetelah",
                                            "Nm_SumberDana",
                                            "trRenja90"."Privilege",
                                            "trRenja90"."created_at",
                                            "trRenja90"."updated_at"
                                            '))
                            ->join('v_suborganisasi','v_suborganisasi.SOrgID','trRenja90.SOrgID')  
                            ->join('v_sub_kegiatan','v_sub_kegiatan.SubKgtID','trRenja90.SubKgtID')     
                            ->join('tmSumberDana','tmSumberDana.SumberDanaID','trRenja90.SumberDanaID')                       
                            ->findOrFail($id);    
            break;
            case 'usulanrakorbidang' :
                $renja = RenjaModel::select(\DB::raw('"trRenja90"."RenjaID",
                                            "v_sub_kegiatan"."Kd_Urusan",
                                            "v_sub_kegiatan"."Nm_Urusan",
                                            "v_sub_kegiatan"."Kd_Bidang",
                                            "v_sub_kegiatan"."Nm_Bidang",
                                            "v_suborganisasi"."kode_organisasi",
                                            "v_suborganisasi"."OrgNm",
                                            "v_suborganisasi"."kode_suborganisasi",
                                            "v_suborganisasi"."SOrgNm",
                                            "v_sub_kegiatan"."Kd_Prog",
                                            "v_sub_kegiatan"."PrgNm",
                                            "v_sub_kegiatan"."Kd_SubKeg",
                                            "v_sub_kegiatan"."kode_subkegiatan",
                                            "v_sub_kegiatan"."SubKgtNm",
                                            "Sasaran_Angka2" AS "Sasaran_Angka",
                                            "Sasaran_Uraian2" AS "Sasaran_Uraian",
                                            "Sasaran_AngkaSetelah",
                                            "Sasaran_UraianSetelah",
                                            "Target2" AS "Target",
                                            "NilaiSebelum",
                                            "NilaiUsulan2" AS "NilaiUsulan",
                                            "NilaiSetelah",
                                            "Nm_SumberDana",
                                            "trRenja90"."Privilege",
                                            "trRenja90"."created_at",
                                            "trRenja90"."updated_at"
                                            '))
                            ->join('v_suborganisasi','v_suborganisasi.SOrgID','trRenja90.SOrgID')  
                            ->join('v_sub_kegiatan','v_sub_kegiatan.SubKgtID','trRenja90.SubKgtID')     
                            ->join('tmSumberDana','tmSumberDana.SumberDanaID','trRenja90.SumberDanaID')                       
                            ->findOrFail($id);
            break;
            case 'usulanforumopd' :
                $renja = RenjaModel::select(\DB::raw('"trRenja90"."RenjaID",                
                                            "v_sub_kegiatan"."Kd_Urusan",
                                            "v_sub_kegiatan"."Nm_Urusan",
                                            "v_sub_kegiatan"."Kd_Bidang",
                                            "v_sub_kegiatan"."Nm_Bidang",
                                            "v_suborganisasi"."kode_organisasi",
                                            "v_suborganisasi"."OrgNm",
                                            "v_suborganisasi"."kode_suborganisasi",
                                            "v_suborganisasi"."SOrgNm",
                                            "v_sub_kegiatan"."Kd_Prog",
                                            "v_sub_kegiatan"."PrgNm",
                                            "v_sub_kegiatan"."Kd_SubKeg",
                                            "v_sub_kegiatan"."kode_subkegiatan",
                                            "v_sub_kegiatan"."SubKgtNm",
                                            "NamaIndikator",
                                            "Sasaran_Angka3" AS "Sasaran_Angka",
                                            "Sasaran_Uraian3" AS "Sasaran_Uraian",
                                            "Sasaran_AngkaSetelah",
                                            "Sasaran_UraianSetelah",
                                            "Target3" AS "Target",
                                            "NilaiSebelum",
                                            "NilaiUsulan3" AS "NilaiUsulan",
                                            "NilaiSetelah",
                                            "Nm_SumberDana",
                                            "trRenja90"."Privilege",
                                            "trRenja90"."created_at",
                                            "trRenja90"."updated_at"
                                    '))
                            ->join('v_suborganisasi','v_suborganisasi.SOrgID','trRenja90.SOrgID')  
                            ->join('v_sub_kegiatan','v_sub_kegiatan.SubKgtID','trRenja90.SubKgtID')     
                            ->join('tmSumberDana','tmSumberDana.SumberDanaID','trRenja90.SumberDanaID')                       
                            ->findOrFail($id);
            break;
            case 'usulanmusrenkab' :
                $renja = RenjaModel::select(\DB::raw('"trRenja90"."RenjaID",
                                            "v_sub_kegiatan"."Kd_Urusan",
                                            "v_sub_kegiatan"."Nm_Urusan",
                                            "v_sub_kegiatan"."Kd_Bidang",
                                            "v_sub_kegiatan"."Nm_Bidang",
                                            "v_suborganisasi"."kode_organisasi",
                                            "v_suborganisasi"."OrgNm",
                                            "v_suborganisasi"."kode_suborganisasi",
                                            "v_suborganisasi"."SOrgNm",
                                            "v_sub_kegiatan"."Kd_Prog",
                                            "v_sub_kegiatan"."PrgNm",
                                            "v_sub_kegiatan"."Kd_SubKeg",
                                            "v_sub_kegiatan"."kode_subkegiatan",
                                            "v_sub_kegiatan"."SubKgtNm",
                                            "NamaIndikator",
                                            "Sasaran_Angka4" AS "Sasaran_Angka",
                                            "Sasaran_Uraian4" AS "Sasaran_Uraian",
                                            "Sasaran_AngkaSetelah",
                                            "Sasaran_UraianSetelah",
                                            "Target4" AS "Target",
                                            "NilaiSebelum",
                                            "NilaiUsulan4" AS "NilaiUsulan",
                                            "NilaiSetelah",
                                            "Nm_SumberDana",
                                            "trRenja90"."Privilege",
                                            "trRenja90"."created_at",
                                            "trRenja90"."updated_at"
                                            '))
                            ->join('v_suborganisasi','v_suborganisasi.SOrgID','trRenja90.SOrgID')  
                            ->join('v_sub_kegiatan','v_sub_kegiatan.SubKgtID','trRenja90.SubKgtID')     
                            ->join('tmSumberDana','tmSumberDana.SumberDanaID','trRenja90.SumberDanaID')                       
                            ->findOrFail($id);
            break;                
        }           
        if (!is_null($renja) )  
        {
            $dataindikatorkinerja = $this->populateIndikatorKegiatan($id);            
            $datarinciankegiatan = $this->populateRincianKegiatan($id);               
            return view("pages.$theme.rkpd.usulanrenja.show")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'renja'=>$renja,
                                                                'dataindikatorkinerja'=>$dataindikatorkinerja,
                                                                'datarinciankegiatan'=>$datarinciankegiatan
                                                            ]);
        }        
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showrincian($id)
    {
        $theme = \Auth::user()->theme;
        switch ($this->NameOfPage) 
        {            
            case 'usulanprarenjaopd' :
                $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",                                                            
                                                            "trRenjaRinc90"."RenjaID",
                                                            "trRenjaRinc90"."No",
                                                            "trRenjaRinc90"."Uraian",
                                                            "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                            "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                            "trRenjaRinc90"."Target1" AS "Target",
                                                            "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                            "trRenjaRinc90"."Prioritas",
                                                            "trRenjaRinc90"."Status",
                                                            "trRenjaRinc90"."Descr",
                                                            "trRenjaRinc90"."Privilege",
                                                            "trRenjaRinc90"."created_at",
                                                            "trRenjaRinc90"."updated_at"'))    
                                            ->findOrFail($id);
            break;
            case 'usulanrakorbidang' :
                $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",                                                            
                                                            "trRenjaRinc90"."RenjaID",
                                                            "trRenjaRinc90"."No",
                                                            "trRenjaRinc90"."Uraian",
                                                            "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                            "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                            "trRenjaRinc90"."Target2" AS "Target",
                                                            "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                            "trRenjaRinc90"."Prioritas",
                                                            "trRenjaRinc90"."Status",
                                                            "trRenjaRinc90"."Descr",
                                                            "trRenjaRinc90"."Privilege",
                                                            "trRenjaRinc90"."created_at",
                                                            "trRenjaRinc90"."updated_at"'))    
                                            ->findOrFail($id);
            break;
            case 'usulanforumopd' :
                $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",                                                            
                                                            "trRenjaRinc90"."RenjaID",
                                                            "trRenjaRinc90"."No",
                                                            "trRenjaRinc90"."Uraian",
                                                            "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                            "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                            "trRenjaRinc90"."Target3" AS "Target",
                                                            "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                            "trRenjaRinc90"."Prioritas",
                                                            "trRenjaRinc90"."Status",
                                                            "trRenjaRinc90"."Descr",
                                                            "trRenjaRinc90"."Privilege",
                                                            "trRenjaRinc90"."created_at",
                                                            "trRenjaRinc90"."updated_at"'))    
                                            ->findOrFail($id);
            break;
            case 'usulanmusrenkab' :
                $data = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",                                                            
                                                            "trRenjaRinc90"."RenjaID",
                                                            "trRenjaRinc90"."No",
                                                            "trRenjaRinc90"."Uraian",
                                                            "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                            "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                            "trRenjaRinc90"."Target4" AS "Target",
                                                            "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                            "trRenjaRinc90"."Prioritas",
                                                            "trRenjaRinc90"."Status",
                                                            "trRenjaRinc90"."Descr",
                                                            "trRenjaRinc90"."Privilege",
                                                            "trRenjaRinc90"."created_at",
                                                            "trRenjaRinc90"."updated_at"'))    
                                            ->findOrFail($id);
            break;                
        }        
       
        if (!is_null($data) )  
        {            
            return view("pages.$theme.rkpd.usulanrenja.showrincian")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'renja'=>$data,
                                                                'item'=>$data
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
        switch ($this->NameOfPage) 
        {            
            case 'usulanprarenjaopd' :
                $renja = RenjaModel::select(\DB::raw('"trRenja90"."RenjaID",
                                                    "trRenja90"."SOrgID",
                                                    "tmUrs"."UrsID",
                                                    "tmUrs"."Nm_Bidang",
                                                    "tmPrg"."PrgID",
                                                    "tmPrg"."PrgNm",
                                                    "tmSubKgt"."SubKgtID",
                                                    "tmSubKgt"."SubKgtNm",
                                                    "trRenja90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                    "trRenja90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                    "trRenja90"."Sasaran_AngkaSetelah",
                                                    "trRenja90"."Sasaran_UraianSetelah",
                                                    "trRenja90"."Target1" AS "Target",
                                                    "trRenja90"."NilaiSebelum",
                                                    "trRenja90"."NilaiUsulan1" AS "NilaiUsulan",
                                                    "trRenja90"."NilaiSetelah",
                                                    "trRenja90"."NamaIndikator",
                                                    "trRenja90"."SumberDanaID",
                                                    "trRenja90"."Descr"'))
                            ->join('tmSubKgt','tmSubKgt.SubKgtID','trRenja90.SubKgtID')
                            ->leftJoin('tmPrg','tmPrg.PrgID','tmSubKgt.PrgID')
                            ->leftJoin('trUrsPrg','trUrsPrg.PrgID','tmPrg.PrgID')
                            ->leftJoin('tmUrs','tmUrs.UrsID','trUrsPrg.UrsID')
                            ->findOrFail($id);        
            break;
            case 'usulanrakorbidang' :
                $renja = RenjaModel::select(\DB::raw('"trRenja90"."RenjaID",
                                                    "trRenja90"."SOrgID",
                                                    "tmUrs"."UrsID",
                                                    "tmUrs"."Nm_Bidang",
                                                    "tmPrg"."PrgID",
                                                    "tmPrg"."PrgNm",
                                                    "tmSubKgt"."SubKgtID",
                                                    "tmSubKgt"."SubKgtNm",
                                                    "trRenja90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                    "trRenja90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                    "trRenja90"."Sasaran_AngkaSetelah",
                                                    "trRenja90"."Sasaran_UraianSetelah",
                                                    "trRenja90"."Target2" AS "Target",
                                                    "trRenja90"."NilaiSebelum",
                                                    "trRenja90"."NilaiUsulan2" AS "NilaiUsulan",
                                                    "trRenja90"."NilaiSetelah",
                                                    "trRenja90"."NamaIndikator",
                                                    "trRenja90"."SumberDanaID",
                                                    "trRenja90"."Descr"'))
                            ->join('tmSubKgt','tmSubKgt.SubKgtID','trRenja90.SubKgtID')
                            ->leftJoin('tmPrg','tmPrg.PrgID','tmSubKgt.PrgID')
                            ->leftJoin('trUrsPrg','trUrsPrg.PrgID','tmPrg.PrgID')
                            ->leftJoin('tmUrs','tmUrs.UrsID','trUrsPrg.UrsID')
                            ->findOrFail($id);        
            break;
            case 'usulanforumopd' :
                $renja = RenjaModel::select(\DB::raw('"trRenja90"."RenjaID",
                                                    "trRenja90"."SOrgID",
                                                    "tmUrs"."UrsID",
                                                    "tmUrs"."Nm_Bidang",
                                                    "tmPrg"."PrgID",
                                                    "tmPrg"."PrgNm",
                                                    "tmSubKgt"."SubKgtID",
                                                    "tmSubKgt"."SubKgtNm",
                                                    "trRenja90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                    "trRenja90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                    "trRenja90"."Sasaran_AngkaSetelah",
                                                    "trRenja90"."Sasaran_UraianSetelah",
                                                    "trRenja90"."Target3" AS "Target",
                                                    "trRenja90"."NilaiSebelum",
                                                    "trRenja90"."NilaiUsulan3" AS "NilaiUsulan",
                                                    "trRenja90"."NilaiSetelah",
                                                    "trRenja90"."NamaIndikator",
                                                    "trRenja90"."SumberDanaID",
                                                    "trRenja90"."Descr"'))
                            ->join('tmSubKgt','tmSubKgt.SubKgtID','trRenja90.SubKgtID')
                            ->leftJoin('tmPrg','tmPrg.PrgID','tmSubKgt.PrgID')
                            ->leftJoin('trUrsPrg','trUrsPrg.PrgID','tmPrg.PrgID')
                            ->leftJoin('tmUrs','tmUrs.UrsID','trUrsPrg.UrsID')
                            ->findOrFail($id);        
            break;
            case 'usulanmusrenkab' :
                $renja = RenjaModel::select(\DB::raw('"trRenja90"."RenjaID",
                                                    "trRenja90"."SOrgID",
                                                    "tmUrs"."UrsID",
                                                    "tmUrs"."Nm_Bidang",
                                                    "tmPrg"."PrgID",
                                                    "tmPrg"."PrgNm",
                                                    "tmSubKgt"."SubKgtID",
                                                    "tmSubKgt"."SubKgtNm",
                                                    "trRenja90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                    "trRenja90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                    "trRenja90"."Sasaran_AngkaSetelah",
                                                    "trRenja90"."Sasaran_UraianSetelah",
                                                    "trRenja90"."Target4" AS "Target",
                                                    "trRenja90"."NilaiSebelum",
                                                    "trRenja90"."NilaiUsulan4" AS "NilaiUsulan",
                                                    "trRenja90"."NilaiSetelah",
                                                    "trRenja90"."NamaIndikator",
                                                    "trRenja90"."SumberDanaID",
                                                    "trRenja90"."Descr"'))
                            ->join('tmSubKgt','tmSubKgt.SubKgtID','trRenja90.SubKgtID')
                            ->leftJoin('tmPrg','tmPrg.PrgID','tmSubKgt.PrgID')
                            ->leftJoin('trUrsPrg','trUrsPrg.PrgID','tmPrg.PrgID')
                            ->leftJoin('tmUrs','tmUrs.UrsID','trUrsPrg.UrsID')
                            ->findOrFail($id);
            break;   
        }   
        
        if (!is_null($renja) ) 
        {
            $organisasi=\App\Models\DMaster\SubOrganisasiModel::select(\DB::raw('"v_suborganisasi"."OrgID","v_suborganisasi"."OrgIDRPJMD","v_suborganisasi"."UrsID","v_suborganisasi"."OrgNm","v_suborganisasi"."SOrgNm","v_suborganisasi"."kode_organisasi","v_suborganisasi"."kode_suborganisasi"'))
                                                            ->join('v_suborganisasi','tmSOrg.OrgID','v_suborganisasi.OrgID')
                                                            ->find($renja->SOrgID);

            $UrsID_selected=$renja->UrsID==null?'all':$renja->UrsID;
            $daftar_program = \App\Models\DMaster\ProgramModel::getDaftarProgramByOPD($organisasi->OrgIDRPJMD,false);
            $r=\DB::table('v_sub_kegiatan')
                    ->where('TA',\HelperKegiatan::getTahunPerencanaan())
                    ->where('PrgID',$renja->PrgID)                    
                    ->orderBy('Kd_SubKeg')
                    ->orderBy('kode_subkegiatan')
                    ->get();
            $daftar_kegiatan=[];        
            foreach ($r as $k=>$v)
            {
                $daftar_kegiatan[$v->KgtID]='['.$v->kode_subkegiatan.']. '.$v->SubKgtNm;                
            }            
            $sumber_dana = \App\Models\DMaster\SumberDanaModel::getDaftarSumberDana(\HelperKegiatan::getTahunPerencanaan(),false);     
            return view("pages.$theme.rkpd.usulanrenja.edit")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'renja'=>$renja,
                                                                'organisasi'=>$organisasi,
                                                                'daftar_program'=>$daftar_program,
                                                                'daftar_kegiatan'=>$daftar_kegiatan,
                                                                'UrsID_selected'=>$UrsID_selected,
                                                                'sumber_dana'=>$sumber_dana
                                                                ]);
        }        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit1($id)
    {
        $theme = \Auth::user()->theme;
        $renja = RenjaIndikatorModel::select(\DB::raw('"trRenjaIndikator90"."RenjaIndikatorID",
                                                        "trRenjaIndikator90"."IndikatorKinerjaID",
                                                        "trRenjaIndikator90"."RenjaID",
                                                        "trRenjaIndikator90"."Target_Angka",
                                                        "Target_Uraian",
                                                        "trRenjaIndikator90"."TA"'))                                   
                                    ->join('trIndikatorKinerja','trIndikatorKinerja.IndikatorKinerjaID','trRenjaIndikator90.IndikatorKinerjaID')
                                    ->findOrFail($id);        
        if (!is_null($renja) ) 
        {    
            $dataindikator_rpjmd = \App\Models\RPJMD\RpjmdIndikatorKinerjaModel::getIndikatorKinerjaByID($renja->IndikatorKinerjaID,$renja->TA);            
            $dataindikatorkinerja = $this->populateIndikatorKegiatan($renja->RenjaID);
            
            return view("pages.$theme.rkpd.usulanrenja.edit1")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'renja'=>$renja,
                                                                'dataindikator_rpjmd'=>$dataindikator_rpjmd,
                                                                'dataindikatorkinerja'=>$dataindikatorkinerja
                                                                ]);
        }        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit2($id)
    {
        $theme = \Auth::user()->theme;

        $auth=\Auth::user();
        $theme = $auth->theme;
        $roles = $auth->getRoleNames();
        
        switch ($this->NameOfPage) 
        {            
            case 'usulanprarenjaopd' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "v_usulan_pra_renja_opd90"."SubKgtNm",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target1" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                    ->join('v_usulan_pra_renja_opd90','v_usulan_pra_renja_opd90.RenjaID','trRenjaRinc90.RenjaID')
                                                    ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                    ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                    ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                    ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                    ->find($id);                                                     
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target1" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                                ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                                ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                                ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                                ->where('trRenja90.SOrgID',$SOrgID)
                                                                ->find($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target1" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                           
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                                ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                                ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                                ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->find($id);        
                    break;
                }    
            break;
            case 'usulanrakorbidang' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target2" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                    ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                    ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                    ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                    ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                    ->find($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target2" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                                ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                                ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                                ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                                ->where('trRenja90.SOrgID',$SOrgID)->find($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target2" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                   
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                                ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                                ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                                ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->find($id);        
                    break;
                }
            break;
            case 'usulanforumopd' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target3" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                    ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                    ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                    ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                    ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                    ->find($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target3" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                                ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                                ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                                ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                                ->where('trRenja90.SOrgID',$SOrgID)
                                                                ->find($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target3" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                        
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                                ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                                ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                                ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->find($id);        
                    break;
                }
            break;
            case 'usulanmusrenkab' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target4" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                    ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                    ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                    ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                    ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                    ->find($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target4" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                                ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                                ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                                ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                                ->where('trRenja90.SOrgID',$SOrgID)->find($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "tmPMProv"."Nm_Prov",
                                                                    "tmPmKota"."Nm_Kota",
                                                                    "tmPmKecamatan"."Nm_Kecamatan",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trUsulanKec"."NamaKegiatan",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target4" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                  
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trUsulanKec','trUsulanKec.UsulanKecID','trRenjaRinc90.UsulanKecID')                                                                                        
                                                                ->join('tmPMProv','tmPMProv.PMProvID','trRenjaRinc90.PMProvID')
                                                                ->join('tmPmKota','tmPmKota.PmKotaID','trRenjaRinc90.PmKotaID')
                                                                ->join('tmPmKecamatan','tmPmKecamatan.PmKecamatanID','trRenjaRinc90.PmKecamatanID')                                            
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->find($id);        
                    break;
                }
            break;                
        }           
        if (is_null($renja) )
        {
            return redirect(route(\Helper::getNameOfPage('edit4'),['uuid'=>$id]))->with('error',"Data rincian kegiatan dari musrenbang Kec dengan ID ($id)  gagal diperoleh, diarahkan menjadi rincian usulan OPD / SKPD .");
        } 
        else 
        {               
            $datarinciankegiatan = $this->populateRincianKegiatan($renja->RenjaID);

            return view("pages.$theme.rkpd.usulanrenja.edit2")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'renja'=>$renja,
                                                                'datarinciankegiatan'=>$datarinciankegiatan
                                                                ]);
        }             
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit3($id)
    {   
        $auth=\Auth::user();
        $theme = $auth->theme;
        $roles = $auth->getRoleNames();    
        
        switch ($this->NameOfPage) 
        {            
            case 'usulanprarenjaopd' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "tmPemilikPokok"."Kd_PK",
                                                                    "tmPemilikPokok"."NmPk",
                                                                    "trPokPir"."NamaUsulanKegiatan",                                                            
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target1" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                    ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                    ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                    ->find($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                    "trRenjaRinc90"."RenjaID",
                                                                                    "trRenjaRinc90"."No",
                                                                                    "tmPemilikPokok"."Kd_PK",
                                                                                    "tmPemilikPokok"."NmPk",
                                                                                    "trPokPir"."NamaUsulanKegiatan",
                                                                                    "trRenjaRinc90"."Uraian",
                                                                                    "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                                    "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                                    "trRenjaRinc90"."Target1" AS "Target",
                                                                                    "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                                    "trRenjaRinc90"."Prioritas",
                                                                                    "trRenjaRinc90"."Descr",
                                                                                    "trRenjaRinc90"."isSKPD",
                                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                                ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                                ->where('trRenja90.SOrgID',$SOrgID)->find($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                    "trRenjaRinc90"."RenjaID",
                                                                                    "trRenjaRinc90"."No",
                                                                                    "tmPemilikPokok"."Kd_PK",
                                                                                    "tmPemilikPokok"."NmPk",
                                                                                    "trPokPir"."NamaUsulanKegiatan",
                                                                                    "trRenjaRinc90"."Uraian",
                                                                                    "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                                    "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                                    "trRenjaRinc90"."Target1" AS "Target",
                                                                                    "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                                    "trRenjaRinc90"."Prioritas",
                                                                                    "trRenjaRinc90"."Descr",
                                                                                    "trRenjaRinc90"."isSKPD",
                                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                                ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->find($id);        
                    break;
                }
            break;
            case 'usulanrakorbidang' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "tmPemilikPokok"."Kd_PK",
                                                                    "tmPemilikPokok"."NmPk",
                                                                    "trPokPir"."NamaUsulanKegiatan",                                                            
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target2" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                    ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                    ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                    ->find($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                    "trRenjaRinc90"."RenjaID",
                                                                                    "trRenjaRinc90"."No",
                                                                                    "tmPemilikPokok"."Kd_PK",
                                                                                    "tmPemilikPokok"."NmPk",
                                                                                    "trPokPir"."NamaUsulanKegiatan",
                                                                                    "trRenjaRinc90"."Uraian",
                                                                                    "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                                    "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                                    "trRenjaRinc90"."Target2" AS "Target",
                                                                                    "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                                    "trRenjaRinc90"."Prioritas",
                                                                                    "trRenjaRinc90"."Descr",
                                                                                    "trRenjaRinc90"."isSKPD",
                                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                                ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                                ->where('trRenja90.SOrgID',$SOrgID)->find($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                    "trRenjaRinc90"."RenjaID",
                                                                                    "trRenjaRinc90"."No",
                                                                                    "tmPemilikPokok"."Kd_PK",
                                                                                    "tmPemilikPokok"."NmPk",
                                                                                    "trPokPir"."NamaUsulanKegiatan",
                                                                                    "trRenjaRinc90"."Uraian",
                                                                                    "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                                    "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                                    "trRenjaRinc90"."Target2" AS "Target",
                                                                                    "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                                    "trRenjaRinc90"."Prioritas",
                                                                                    "trRenjaRinc90"."Descr",
                                                                                    "trRenjaRinc90"."isSKPD",
                                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                                ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->find($id);        
                    break;
                }
            break;
            case 'usulanforumopd' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "tmPemilikPokok"."Kd_PK",
                                                                    "tmPemilikPokok"."NmPk",
                                                                    "trPokPir"."NamaUsulanKegiatan",                                                            
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target3" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                    ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                    ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                    ->find($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                    "trRenjaRinc90"."RenjaID",
                                                                                    "trRenjaRinc90"."No",
                                                                                    "tmPemilikPokok"."Kd_PK",
                                                                                    "tmPemilikPokok"."NmPk",
                                                                                    "trPokPir"."NamaUsulanKegiatan",
                                                                                    "trRenjaRinc90"."Uraian",
                                                                                    "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                                    "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                                    "trRenjaRinc90"."Target3" AS "Target",
                                                                                    "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                                    "trRenjaRinc90"."Prioritas",
                                                                                    "trRenjaRinc90"."Descr",
                                                                                    "trRenjaRinc90"."isSKPD",
                                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                                ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                                ->where('trRenja90.SOrgID',$SOrgID)->find($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                    "trRenjaRinc90"."RenjaID",
                                                                                    "trRenjaRinc90"."No",
                                                                                    "tmPemilikPokok"."Kd_PK",
                                                                                    "tmPemilikPokok"."NmPk",
                                                                                    "trPokPir"."NamaUsulanKegiatan",
                                                                                    "trRenjaRinc90"."Uraian",
                                                                                    "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                                    "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                                    "trRenjaRinc90"."Target3" AS "Target",
                                                                                    "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                                    "trRenjaRinc90"."Prioritas",
                                                                                    "trRenjaRinc90"."Descr",
                                                                                    "trRenjaRinc90"."isSKPD",
                                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                                ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->find($id);        
                    break;
                }
            break;
            case 'usulanmusrenkab' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "tmPemilikPokok"."Kd_PK",
                                                                    "tmPemilikPokok"."NmPk",
                                                                    "trPokPir"."NamaUsulanKegiatan",                                                            
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target4" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                    ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                    ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                    ->find($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                    "trRenjaRinc90"."RenjaID",
                                                                                    "trRenjaRinc90"."No",
                                                                                    "tmPemilikPokok"."Kd_PK",
                                                                                    "tmPemilikPokok"."NmPk",
                                                                                    "trPokPir"."NamaUsulanKegiatan",
                                                                                    "trRenjaRinc90"."Uraian",
                                                                                    "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                                    "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                                    "trRenjaRinc90"."Target4" AS "Target",
                                                                                    "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                                    "trRenjaRinc90"."Prioritas",
                                                                                    "trRenjaRinc90"."Descr",
                                                                                    "trRenjaRinc90"."isSKPD",
                                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                                ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                                ->where('trRenja90.SOrgID',$SOrgID)->find($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                    "trRenjaRinc90"."RenjaID",
                                                                                    "trRenjaRinc90"."No",
                                                                                    "tmPemilikPokok"."Kd_PK",
                                                                                    "tmPemilikPokok"."NmPk",
                                                                                    "trPokPir"."NamaUsulanKegiatan",
                                                                                    "trRenjaRinc90"."Uraian",
                                                                                    "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                                    "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                                    "trRenjaRinc90"."Target4" AS "Target",
                                                                                    "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                                    "trRenjaRinc90"."Prioritas",
                                                                                    "trRenjaRinc90"."Descr",
                                                                                    "trRenjaRinc90"."isSKPD",
                                                                                    "trRenjaRinc90"."isReses"'))                                            
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')
                                                                ->join('trPokPir','trPokPir.PokPirID','trRenjaRinc90.PokPirID')
                                                                ->join('tmPemilikPokok','tmPemilikPokok.PemilikPokokID','trPokPir.PemilikPokokID')                                                        
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->find($id);        
                    break;
                }
            break;       
        }
        if (is_null($renja) )
        {
            return redirect(route(\Helper::getNameOfPage('edit4'),['uuid'=>$id]))->with('error',"Data rincian kegiatan dari Pokok Pikiran Anggota dengan ID ($id)  gagal diperoleh, diarahkan menjadi rincian usulan OPD / SKPD .");
        } 
        else
        {               
            $datarinciankegiatan = $this->populateRincianKegiatan($renja->RenjaID);

            return view("pages.$theme.rkpd.usulanrenja.edit3")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'renja'=>$renja,
                                                                'datarinciankegiatan'=>$datarinciankegiatan
                                                                ]);
        }        
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit4($id)
    {   
        $auth=\Auth::user();
        $theme = $auth->theme;
        $roles = $auth->getRoleNames();   
        switch ($this->NameOfPage) 
        {            
            case 'usulanprarenjaopd' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "v_usulan_pra_renja_opd90"."kode_subkegiatan", 
                                                                    "v_usulan_pra_renja_opd90"."SubKgtNm", 
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."PmKecamatanID",
                                                                    "trRenjaRinc90"."PmDesaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target1" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))
                                                    ->join('v_usulan_pra_renja_opd90','v_usulan_pra_renja_opd90.RenjaRincID','trRenjaRinc90.RenjaRincID')
                                                    ->findOrFail($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."PmKecamatanID",
                                                                    "trRenjaRinc90"."PmDesaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target1" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')                                                        
                                                                ->where('trRenja90.SOrgID',$SOrgID)->findOrFail($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                "trRenjaRinc90"."RenjaID",
                                                                                "trRenjaRinc90"."PmKecamatanID",
                                                                                "trRenjaRinc90"."PmDesaID",
                                                                                "trRenjaRinc90"."No",
                                                                                "trRenjaRinc90"."Uraian",
                                                                                "trRenjaRinc90"."Sasaran_Angka1" AS "Sasaran_Angka",
                                                                                "trRenjaRinc90"."Sasaran_Uraian1" AS "Sasaran_Uraian",
                                                                                "trRenjaRinc90"."Target1" AS "Target",
                                                                                "trRenjaRinc90"."Jumlah1" AS "Jumlah",
                                                                                "trRenjaRinc90"."Prioritas",
                                                                                "trRenjaRinc90"."Descr",
                                                                                "trRenjaRinc90"."isSKPD",
                                                                                "trRenjaRinc90"."isReses"'))
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')                                                        
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->findOrFail($id);        
                                                                
                    break;
                }                        
            break;
            case 'usulanrakorbidang' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."PmKecamatanID",
                                                                    "trRenjaRinc90"."PmDesaID",
                                                                    "v_usulan_rakor_bidang90"."kode_subkegiatan", 
                                                                    "v_usulan_rakor_bidang90"."SubKgtNm", 
                                                                    "trRenjaRinc90"."No",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target2" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))         
                                                    ->join('v_usulan_rakor_bidang90','v_usulan_rakor_bidang90.RenjaRincID','trRenjaRinc90.RenjaRincID')
                                                    ->findOrFail($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."PmKecamatanID",
                                                                    "trRenjaRinc90"."PmDesaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target2" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')                                                        
                                                                ->where('trRenja90.SOrgID',$SOrgID)->findOrFail($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                "trRenjaRinc90"."RenjaID",
                                                                                "trRenjaRinc90"."PmKecamatanID",
                                                                                "trRenjaRinc90"."PmDesaID",
                                                                                "trRenjaRinc90"."No",
                                                                                "trRenjaRinc90"."Uraian",
                                                                                "trRenjaRinc90"."Sasaran_Angka2" AS "Sasaran_Angka",
                                                                                "trRenjaRinc90"."Sasaran_Uraian2" AS "Sasaran_Uraian",
                                                                                "trRenjaRinc90"."Target2" AS "Target",
                                                                                "trRenjaRinc90"."Jumlah2" AS "Jumlah",
                                                                                "trRenjaRinc90"."Prioritas",
                                                                                "trRenjaRinc90"."Descr",
                                                                                "trRenjaRinc90"."isSKPD",
                                                                                "trRenjaRinc90"."isReses"'))

                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')                                                        
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->findOrFail($id);        
                    break;
                }       
            break;
            case 'usulanforumopd' :
                switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."PmKecamatanID",
                                                                    "trRenjaRinc90"."PmDesaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target3" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                                                                        
                                                    ->findOrFail($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."PmKecamatanID",
                                                                    "trRenjaRinc90"."PmDesaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target3" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')                                                        
                                                                ->where('trRenja90.SOrgID',$SOrgID)->findOrFail($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                "trRenjaRinc90"."RenjaID",
                                                                                "trRenjaRinc90"."PmKecamatanID",
                                                                                "trRenjaRinc90"."PmDesaID",
                                                                                "trRenjaRinc90"."No",
                                                                                "trRenjaRinc90"."Uraian",
                                                                                "trRenjaRinc90"."Sasaran_Angka3" AS "Sasaran_Angka",
                                                                                "trRenjaRinc90"."Sasaran_Uraian3" AS "Sasaran_Uraian",
                                                                                "trRenjaRinc90"."Target3" AS "Target",
                                                                                "trRenjaRinc90"."Jumlah3" AS "Jumlah",
                                                                                "trRenjaRinc90"."Prioritas",
                                                                                "trRenjaRinc90"."Descr",
                                                                                "trRenjaRinc90"."isSKPD",
                                                                                "trRenjaRinc90"."isReses"'))

                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')                                                        
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->findOrFail($id);        
                    break;
                }
            break;
            case 'usulanmusrenkab' :
                    switch ($roles[0])
                {
                    case 'superadmin' :
                        $renja = RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."PmKecamatanID",
                                                                    "trRenjaRinc90"."PmDesaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target4" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))                                                                                        
                                                    ->findOrFail($id);        
                    break;
                    case 'opd' :
                        $filters=$this->getControllerStateSession($this->SessionName,'filters');
                        $OrgID = $filters['OrgID'];
                        $SOrgID = $filters['SOrgID'];
                        $renja = empty($SOrgID)?RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                    "trRenjaRinc90"."RenjaID",
                                                                    "trRenjaRinc90"."PmKecamatanID",
                                                                    "trRenjaRinc90"."PmDesaID",
                                                                    "trRenjaRinc90"."No",
                                                                    "trRenjaRinc90"."Uraian",
                                                                    "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                    "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                    "trRenjaRinc90"."Target4" AS "Target",
                                                                    "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                    "trRenjaRinc90"."Prioritas",
                                                                    "trRenjaRinc90"."Descr",
                                                                    "trRenjaRinc90"."isSKPD",
                                                                    "trRenjaRinc90"."isReses"'))
                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')                                                        
                                                                ->where('trRenja90.SOrgID',$SOrgID)->findOrFail($id)
                                            :RenjaRincianModel::select(\DB::raw('"trRenjaRinc90"."RenjaRincID",
                                                                                "trRenjaRinc90"."RenjaID",
                                                                                "trRenjaRinc90"."PmKecamatanID",
                                                                                "trRenjaRinc90"."PmDesaID",
                                                                                "trRenjaRinc90"."No",
                                                                                "trRenjaRinc90"."Uraian",
                                                                                "trRenjaRinc90"."Sasaran_Angka4" AS "Sasaran_Angka",
                                                                                "trRenjaRinc90"."Sasaran_Uraian4" AS "Sasaran_Uraian",
                                                                                "trRenjaRinc90"."Target4" AS "Target",
                                                                                "trRenjaRinc90"."Jumlah4" AS "Jumlah",
                                                                                "trRenjaRinc90"."Prioritas",
                                                                                "trRenjaRinc90"."Descr",
                                                                                "trRenjaRinc90"."isSKPD",
                                                                                "trRenjaRinc90"."isReses"'))

                                                                ->join('trRenja90','trRenja90.RenjaID','trRenjaRinc90.RenjaID')                                                        
                                                                ->where('trRenja90.OrgID',$OrgID)
                                                                ->findOrFail($id);        
                    break;
                }
            break;
            default :
                $dbViewName = null;
        }   
        if (!is_null($renja) ) 
        {               
            $datarinciankegiatan = $this->populateRincianKegiatan($renja->RenjaID);
            //lokasi
            $daftar_provinsi = ['uidF1847004D8F547BF'=>'KEPULAUAN RIAU'];
            $daftar_kota_kab = ['uidE4829D1F21F44ECA'=>'BINTAN'];        
            $daftar_kecamatan=\App\Models\DMaster\KecamatanModel::getDaftarKecamatan(\HelperKegiatan::getTahunPerencanaan(),$renja->PmKotaID,false);
            $daftar_desa=\App\Models\DMaster\DesaModel::getDaftarDesa(\HelperKegiatan::getTahunPerencanaan(),$renja->PmKecamatanID,false);
            return view("pages.$theme.rkpd.usulanrenja.edit4")->with(['page_active'=>$this->NameOfPage,
                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                                                'renja'=>$renja,
                                                                'datarinciankegiatan'=>$datarinciankegiatan,
                                                                'daftar_provinsi'=> $daftar_provinsi,
                                                                'daftar_kota_kab'=> $daftar_kota_kab,
                                                                'daftar_kecamatan'=>$daftar_kecamatan,
                                                                'daftar_desa'=>$daftar_desa
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
        $renja = RenjaModel::find($id);
        
        $this->validate($request, [           
            'UrsID'=>'required',
            'PrgID'=>'required',
            'SubKgtID'=>'required', 
            'SumberDanaID'=>'required',
            'Sasaran_Angka'=>'required',
            'Sasaran_Uraian' => 'required',
            'Sasaran_AngkaSetelah'=>'required',
            'Sasaran_UraianSetelah'=>'required',
            'Target'=>'required',
            'NilaiSebelum'=>'required',
            'NilaiUsulan'=>'required',
            'NilaiSetelah'=>'required',
            'NamaIndikator'=>'required'
        ]);
        
        switch ($this->NameOfPage) 
        {            
            case 'usulanprarenjaopd' :
                $renja->KgtID = $request->input('SubKgtID');
                $renja->SumberDanaID = $request->input('SumberDanaID');
                $renja->Sasaran_Angka1 = $request->input('Sasaran_Angka');
                $renja->Sasaran_Uraian1 = $request->input('Sasaran_Uraian');
                $renja->Sasaran_AngkaSetelah = $request->input('Sasaran_AngkaSetelah');
                $renja->Sasaran_UraianSetelah = $request->input('Sasaran_UraianSetelah');
                $renja->Target1 = $request->input('Target');
                $renja->NilaiSebelum = $request->input('NilaiSebelum');
                $renja->NilaiSetelah = $request->input('NilaiSetelah');
                $renja->NamaIndikator = $request->input('NamaIndikator');
                $renja->Descr = $request->input('Descr');
                $renja->save();
            break;
            case 'usulanrakorbidang' :
                $renja->KgtID = $request->input('SubKgtID');
                $renja->SumberDanaID = $request->input('SumberDanaID');
                $renja->Sasaran_Angka2 = $request->input('Sasaran_Angka');
                $renja->Sasaran_Uraian2 = $request->input('Sasaran_Uraian');
                $renja->Sasaran_AngkaSetelah = $request->input('Sasaran_AngkaSetelah');
                $renja->Sasaran_UraianSetelah = $request->input('Sasaran_UraianSetelah');
                $renja->Target2 = $request->input('Target');
                $renja->NilaiSebelum = $request->input('NilaiSebelum');
                $renja->NilaiSetelah = $request->input('NilaiSetelah');
                $renja->NamaIndikator = $request->input('NamaIndikator');
                $renja->Descr = $request->input('Descr');
                $renja->save();
            break;
            case 'usulanforumopd' :
                $renja->KgtID = $request->input('SubKgtID');
                $renja->SumberDanaID = $request->input('SumberDanaID');
                $renja->Sasaran_Angka3 = $request->input('Sasaran_Angka');
                $renja->Sasaran_Uraian3 = $request->input('Sasaran_Uraian');
                $renja->Sasaran_AngkaSetelah = $request->input('Sasaran_AngkaSetelah');
                $renja->Sasaran_UraianSetelah = $request->input('Sasaran_UraianSetelah');
                $renja->Target3 = $request->input('Target');
                $renja->NilaiSebelum = $request->input('NilaiSebelum');
                $renja->NilaiSetelah = $request->input('NilaiSetelah');
                $renja->NamaIndikator = $request->input('NamaIndikator');
                $renja->Descr = $request->input('Descr');
                $renja->save();
            break;
            case 'usulanmusrenkab' :
                $renja->KgtID = $request->input('SubKgtID');
                $renja->SumberDanaID = $request->input('SumberDanaID');
                $renja->Sasaran_Angka4 = $request->input('Sasaran_Angka');
                $renja->Sasaran_Uraian4 = $request->input('Sasaran_Uraian');
                $renja->Sasaran_AngkaSetelah = $request->input('Sasaran_AngkaSetelah');
                $renja->Sasaran_UraianSetelah = $request->input('Sasaran_UraianSetelah');
                $renja->Target4 = $request->input('Target');
                $renja->NilaiSebelum = $request->input('NilaiSebelum');
                $renja->NilaiSetelah = $request->input('NilaiSetelah');
                $renja->NamaIndikator = $request->input('NamaIndikator');
                $renja->Descr = $request->input('Descr');
                $renja->save();
            break;                
        }   

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil diubah.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('show'),['uuid'=>$renja->RenjaID]))->with('success','Data ini telah berhasil disimpan.');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update1(Request $request, $id)
    {
        $this->validate($request, [
            'Target_Angka'=>'required',
            'Target_Uraian'=>'required',           
        ]);
        
        $data=[        
            'Target_Angka' => $request->input('Target_Angka'),
            'Target_Uraian' => $request->input('Target_Uraian'),                                   
        ];

        $indikatorkinerja = RenjaIndikatorModel::find($id);
        $indikatorkinerja->Target_Angka = $request->input('Target_Angka'); 
        $indikatorkinerja->Target_Uraian = $request->input('Target_Uraian');       
        $indikatorkinerja->save();

        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('show'),['uuid'=>$indikatorkinerja->RenjaID]))->with('success','Data Indikator kegiatan telah berhasil disimpan. Selanjutnya isi Rincian Kegiatan');
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update2(Request $request, $id)
    {
        $rinciankegiatan = RenjaRincianModel::find($id);        
        $this->validate($request, [
            'No'=>'required',
            'Uraian'=>'required',
            'Sasaran_Angka'=>'required',
            'Sasaran_Uraian'=>'required',
            'Target'=>'required',
            'Jumlah'=>'required',
            'Prioritas' => 'required'            
        ]);
        
        \DB::transaction(function () use ($request,$rinciankegiatan) {
            switch ($this->NameOfPage) 
            {            
                case 'usulanprarenjaopd' :
                    $rinciankegiatan->Uraian = $request->input('Uraian');
                    $rinciankegiatan->Sasaran_Angka1 = $request->input('Sasaran_Angka'); 
                    $rinciankegiatan->Sasaran_Uraian1 = $request->input('Sasaran_Uraian');
                    $rinciankegiatan->Target1 = $request->input('Target');
                    $rinciankegiatan->Jumlah1 = $request->input('Jumlah');  
                    $rinciankegiatan->Prioritas = $request->input('Prioritas');  
                    $rinciankegiatan->Descr = $request->input('Descr');
                    $rinciankegiatan->save();

                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan1=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah1');            
                    $renja->save();
                break;
                case 'usulanrakorbidang' :
                    $rinciankegiatan->Uraian = $request->input('Uraian');
                    $rinciankegiatan->Sasaran_Angka2 = $request->input('Sasaran_Angka'); 
                    $rinciankegiatan->Sasaran_Uraian2 = $request->input('Sasaran_Uraian');
                    $rinciankegiatan->Target2 = $request->input('Target');
                    $rinciankegiatan->Jumlah2 = $request->input('Jumlah');  
                    $rinciankegiatan->Prioritas = $request->input('Prioritas');  
                    $rinciankegiatan->Descr = $request->input('Descr');
                    $rinciankegiatan->save();

                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan2=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah2');            
                    $renja->save();
                break;
                case 'usulanforumopd' :
                    $rinciankegiatan->Uraian = $request->input('Uraian');
                    $rinciankegiatan->Sasaran_Angka3 = $request->input('Sasaran_Angka'); 
                    $rinciankegiatan->Sasaran_Uraian3 = $request->input('Sasaran_Uraian');
                    $rinciankegiatan->Target3 = $request->input('Target');
                    $rinciankegiatan->Jumlah3 = $request->input('Jumlah');  
                    $rinciankegiatan->Prioritas = $request->input('Prioritas');  
                    $rinciankegiatan->Descr = $request->input('Descr');
                    $rinciankegiatan->save();

                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan3=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah3');            
                    $renja->save();
                break;
                case 'usulanmusrenkab' :
                    $rinciankegiatan->Uraian = $request->input('Uraian');
                    $rinciankegiatan->Sasaran_Angka4 = $request->input('Sasaran_Angka'); 
                    $rinciankegiatan->Sasaran_Uraian4 = $request->input('Sasaran_Uraian');
                    $rinciankegiatan->Target4 = $request->input('Target');
                    $rinciankegiatan->Jumlah4 = $request->input('Jumlah');  
                    $rinciankegiatan->Prioritas = $request->input('Prioritas');  
                    $rinciankegiatan->Descr = $request->input('Descr');
                    $rinciankegiatan->save();

                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan4=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah4');            
                    $renja->save();
                break;                
            }   
        });
        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('show'),['uuid'=>$rinciankegiatan->RenjaID]))->with('success','Data Rincian kegiatan telah berhasil disimpan.');
        } 
    }      
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update4(Request $request, $id)
    {
        $rinciankegiatan = RenjaRincianModel::find($id);        
        $this->validate($request, [
            'No'=>'required',
            'Uraian'=>'required',
            'Sasaran_Angka'=>'required',
            'Sasaran_Uraian'=>'required',
            'Target'=>'required',
            'Jumlah'=>'required',
            'Prioritas' => 'required'            
        ]);

        \DB::transaction(function () use ($request,$rinciankegiatan) { 

            switch ($this->NameOfPage) 
            {            
                case 'usulanprarenjaopd' :
                    $rinciankegiatan->PmKecamatanID = $request->input('PmKecamatanID');
                    $rinciankegiatan->PmDesaID = $request->input('PmDesaID');
                    $rinciankegiatan->Uraian = $request->input('Uraian');
                    $rinciankegiatan->Sasaran_Angka1 = $request->input('Sasaran_Angka'); 
                    $rinciankegiatan->Sasaran_Uraian1 = $request->input('Sasaran_Uraian');
                    $rinciankegiatan->Target1 = $request->input('Target');
                    $rinciankegiatan->Jumlah1 = $request->input('Jumlah');  
                    $rinciankegiatan->Prioritas = $request->input('Prioritas');  
                    $rinciankegiatan->Descr = $request->input('Descr');
                    $rinciankegiatan->save();

                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan1=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah1');            
                    $renja->save();
                break;
                case 'usulanrakorbidang' :
                    $rinciankegiatan->PmKecamatanID = $request->input('PmKecamatanID');
                    $rinciankegiatan->PmDesaID = $request->input('PmDesaID');
                    $rinciankegiatan->Uraian = $request->input('Uraian');
                    $rinciankegiatan->Sasaran_Angka2 = $request->input('Sasaran_Angka'); 
                    $rinciankegiatan->Sasaran_Uraian2 = $request->input('Sasaran_Uraian');
                    $rinciankegiatan->Target2 = $request->input('Target');
                    $rinciankegiatan->Jumlah2 = $request->input('Jumlah');  
                    $rinciankegiatan->Prioritas = $request->input('Prioritas');  
                    $rinciankegiatan->Descr = $request->input('Descr');
                    $rinciankegiatan->save();
        
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan2=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah2');            
                    $renja->save();
                break;
                case 'usulanforumopd' :
                    $rinciankegiatan->PmKecamatanID = $request->input('PmKecamatanID');
                    $rinciankegiatan->PmDesaID = $request->input('PmDesaID');
                    $rinciankegiatan->Uraian = $request->input('Uraian');
                    $rinciankegiatan->Sasaran_Angka3 = $request->input('Sasaran_Angka'); 
                    $rinciankegiatan->Sasaran_Uraian3 = $request->input('Sasaran_Uraian');
                    $rinciankegiatan->Target3 = $request->input('Target');
                    $rinciankegiatan->Jumlah3 = $request->input('Jumlah');  
                    $rinciankegiatan->Prioritas = $request->input('Prioritas');  
                    $rinciankegiatan->Descr = $request->input('Descr');
                    $rinciankegiatan->save();
        
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan3=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah3');            
                    $renja->save();
                break;
                case 'usulanmusrenkab' :
                    $rinciankegiatan->PmKecamatanID = $request->input('PmKecamatanID');
                    $rinciankegiatan->PmDesaID = $request->input('PmDesaID');
                    $rinciankegiatan->Uraian = $request->input('Uraian');
                    $rinciankegiatan->Sasaran_Angka4 = $request->input('Sasaran_Angka'); 
                    $rinciankegiatan->Sasaran_Uraian4 = $request->input('Sasaran_Uraian');
                    $rinciankegiatan->Target4 = $request->input('Target');
                    $rinciankegiatan->Jumlah4 = $request->input('Jumlah');  
                    $rinciankegiatan->Prioritas = $request->input('Prioritas');  
                    $rinciankegiatan->Descr = $request->input('Descr');
                    $rinciankegiatan->save();
        
                    $renja = $rinciankegiatan->renja;            
                    $renja->NilaiUsulan4=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah4');            
                    $renja->save();
                break;                
            }               
            
        });
        if ($request->ajax()) 
        {
            return response()->json([
                'success'=>true,
                'message'=>'Data ini telah berhasil disimpan.'
            ]);
        }
        else
        {
            return redirect(route(\Helper::getNameOfPage('show'),['uuid'=>$rinciankegiatan->RenjaID]))->with('success','Data Rincian kegiatan telah berhasil disimpan.');
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
        
        if ($request->exists('indikatorkinerja'))
        {
            $indikatorkinerja = RenjaIndikatorModel::find($id);
            $renjaid=$indikatorkinerja->RenjaID;
            $result=$indikatorkinerja->delete();
            
            $renja = $indikatorkinerja->renja;
            $renja->Status_Indikator=RenjaIndikatorModel::where('RenjaID',$indikatorkinerja->RenjaID)->count() > 0;
            $renja->save();
            
            if ($request->ajax()) 
            {
                $data = $this->populateIndikatorKegiatan($renjaid);

                $datatable = view("pages.$theme.rkpd.usulanrenja.datatableindikatorkinerja")
                                ->with([
                                    'page_active'=>$this->NameOfPage,
                                    'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                    'renja'=>$renja,
                                    'dataindikatorkinerja'=>$data])
                                ->render(); 
                
                return response()->json(['success'=>true,'datatable'=>$datatable],200); 
            }
            else
            {
                return redirect(route(\Helper::getNameOfPage('create1'),['uuid'=>$renjaid]))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
            }
        }
        elseif ($request->exists('rinciankegiatan'))
        {
            $rinciankegiatan = RenjaRincianModel::find($id);
            $renjaid=$rinciankegiatan->RenjaID;
            $renja = $rinciankegiatan->renja;
            $NilaiUsulan = \DB::transaction(function () use ($rinciankegiatan,$renja) {                                                                             
                $rinciankegiatan->delete();
                switch ($this->NameOfPage) 
                {            
                    case 'usulanprarenjaopd' :
                        $renja->NilaiUsulan1=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah1');  
                        $NilaiUsulan=$renja->NilaiUsulan1;          
                    break;
                    case 'usulanrakorbidang' :
                        $renja->NilaiUsulan2=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah2');    
                        $NilaiUsulan=$renja->NilaiUsulan2;        
                    break;
                    case 'usulanforumopd' :
                        $renja->NilaiUsulan3=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah3');            
                        $NilaiUsulan=$renja->NilaiUsulan3;
                    break;
                    case 'usulanmusrenkab' :
                        $renja->NilaiUsulan4=RenjaRincianModel::where('RenjaID',$renja->RenjaID)->sum('Jumlah4');            
                        $NilaiUsulan=$renja->NilaiUsulan4;
                    break;                
                }   
                $renja->save();
                return $NilaiUsulan;
            });
            if ($request->ajax()) 
            {
                $data = $this->populateRincianKegiatan($renjaid);
                        
                $datatable = view("pages.$theme.rkpd.usulanrenja.datatablerinciankegiatan")
                                ->with([
                                    'page_active'=>$this->NameOfPage,
                                    'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage),
                                    'renja'=>$renja,
                                    'datarinciankegiatan'=>$data])
                                ->render();     
                
                return response()->json(['success'=>true,'NilaiUsulan'=>$NilaiUsulan,'datatable'=>$datatable],200); 
            }
            else
            {
                return redirect(route(\Helper::getNameOfPage('show'),['uuid'=>$renjaid]))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
            }
        }//akhir penyeleksian kondisi bila rincian kegiatan
        else if ($request->exists('pid'))
        {

            $renja = $request->input('pid') == 'rincian' ?RenjaRincianModel::find($id) :RenjaModel::find($id);
            $result=$renja->delete();
            if ($request->ajax()) 
            {
                $currentpage=$this->getCurrentPageInsideSession('usulanprarenjaopd'); 
                $data=$this->populateData($currentpage);
               
                $datatable = view("pages.$theme.rkpd.usulanrenja.datatable")->with(['page_active'=>$this->NameOfPage,
                                                                                'page_title'=>\HelperKegiatan::getPageTitle($this->NameOfPage), 
                                                                                'search'=>$this->getControllerStateSession('usulanprarenjaopd','search'),
                                                                                'numberRecordPerPage'=>$this->getControllerStateSession('global_controller','numberRecordPerPage'),                                                                    
                                                                                'column_order'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','column_name'),
                                                                                'direction'=>$this->getControllerStateSession('usulanprarenjaopd.orderby','order'),
                                                                                'data'=>$data])->render();      
                
                return response()->json(['success'=>true,'datatable'=>$datatable],200); 
            }
            else
            {
                return redirect(route(\Helper::getNameOfPage('index')))->with('success',"Data ini dengan ($id) telah berhasil dihapus.");
            }      
        }  
    }
}