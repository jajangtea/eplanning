<?php

namespace App\Controllers\Setting;

use Illuminate\Http\Request;
use App\Controllers\Controller;

class CopyDataController extends Controller 
{
     /**
     * Membuat sebuah objek
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth','role:superadmin']);
    }
    /**
     * collect data from resources for index view
     *
     * @return resources
     */
    public function populateData ($currentpage=1) 
    {        
        if (!$this->checkStateIsExistSession('copydata','filters')) 
        {            
            $this->putControllerStateSession('copydata','filters',['TA'=>\HelperKegiatan::getTahunPerencanaan()]);
        }
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

        $TA = $request->input('TACd')==''?\HelperKegiatan::getTahunPerencanaan():$request->input('TACd');
        $filters=$this->getControllerStateSession('copydata','filters');
        $filters['TA']=$TA;
        
        $this->putControllerStateSession('copydata','filters',$filters);

        return response()->json(['TA'=>$TA,'filters'=>$filters],200);  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {                
        $theme = \Auth::user()->theme;
        $this->populateData();
        $TA= $this->getControllerStateSession('copydata.filters','TA'); 
        return view("pages.$theme.setting.copydata.index")->with(['page_active'=>'copydata',
                                                                'TA'=>$TA           
                                                                ]);               
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request,$id)
    {
        switch($id)
        {
            case 1 ://copy wilayah
                $this->copywilayah();
            break;  
        }
    }
    private function copywilayah ()
    {
        $dari_ta= $this->getControllerStateSession('copydata.filters','TA'); 
        $ke_ta=\HelperKegiatan::getTahunPerencanaan();
        
        //copy provinsi
        echo "Hapus Data Provinsi TA = $ke_ta <br>";

        \App\Models\DMaster\ProvinsiModel::where('TA',$ke_ta)
                                            ->delete();
        echo "--> OK<br>";
        echo "Salin data provinsi dari TA $dari_ta KE $ke_ta <br>";
        $str_prov = '
                    INSERT INTO "tmPMProv" (
                        "PMProvID", 
                        "Kd_Prov",
                        "Nm_Prov",                        
                        "Descr",
                        "TA",  
                        "PMProvID_Src",
                        "Locked",
                        "created_at", 
                        "updated_at"
                    )
                    SELECT 
                        REPLACE(SUBSTRING(CONCAT(\'uid\',uuid_in(md5(random()::text || clock_timestamp()::text)::cstring)) from 1 for 16),\'-\',\'\') AS "PMProvID",
                        "Kd_Prov",
                        "Nm_Prov",                        
                        "Descr",
                        \''.$ke_ta.'\' AS "TA",
                        "PMProvID" AS "PMProvID_Src",
                        "Locked",
                        NOW() AS created_at,
                        NOW() AS updated_at
                    FROM
                        "tmPMProv" 
                    WHERE 
                        "TA"=\''.$dari_ta.'\'
                    ';
                    \DB::statement($str_prov);
                    echo "--> OK<br>";
    }
}