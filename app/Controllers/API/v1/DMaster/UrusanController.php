<?php

namespace App\Controllers\API\v1\DMaster;

use Illuminate\Http\Request;
use App\Controllers\Controller;
use App\Models\DMaster\UrusanModel;

class UrusanController extends Controller {
     /**
     * Membuat sebuah objek
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware(['auth:api']);
    }
   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {               
        $columns=['*'];        
        $currentpage=1;
        if ($request->exists('page'))
        {
            $currentpage = $request->input('page');
        }
        $numberRecordPerPage=10;
        if ($request->exists('numberrecordperpage'))
        {
            $numberRecordPerPage = $request->input('numberrecordperpage');
        }
        $ta=config('globalsettings.tahun_perencanaan');
        if ($request->exists('ta'))
        {
            $ta = $request->input('ta');
        }
        if ($currentpage == 'all')
        {
            $data = \DB::table('v_urusan')
                        ->where('TA',$ta)
                        ->orderBy('Kode_Bidang','ASC')
                        ->get();
            $daftar_urusan = []; 
            foreach ($data as $v)
            {
                $daftar_urusan[]=['UrsID'=>$v->UrsID,
                                'Kd_Urusan'=>$v->Kd_Urusan,
                                'Nm_Urusan'=>$v->Nm_Urusan,
                                'Kd_Bidang'=>$v->Kd_Bidang, 
                                'Kode_Bidang'=>$v->Kode_Bidang,                                
                                'Nm_Bidang'=>$v->Nm_Bidang, 
                                'TA'=>$v->TA
                                ];
            }
            return response()->json(['status'=>1,
                                    'data'=>$daftar_urusan],200); 
        }
        else
        {
            $data = \DB::table('v_urusan')
                        ->where('TA',$ta)
                        ->orderBy('Kode_Bidang','ASC')
                        ->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
            $daftar_urusan = []; 
            foreach ($data as $v)
            {
                $daftar_urusan[]=['UrsID'=>$v->UrsID,
                                'Kd_Urusan'=>$v->Kd_Urusan,
                                'Nm_Urusan'=>$v->Nm_Urusan,
                                'Kd_Bidang'=>$v->Kd_Bidang, 
                                'Kode_Bidang'=>$v->Kode_Bidang,                                
                                'Nm_Bidang'=>$v->Nm_Bidang, 
                                'TA'=>$v->TA
                                ];
            }
            return response()->json(['status'=>1,
                                    'per_page'=> $data->perPage(),
                                    'current_page'=>$data->currentPage(),
                                    'last_page'=>$data->lastPage(),
                                    'total'=>$data->total(),
                                    'data'=>$daftar_urusan],200); 
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
        $data = \DB::table('v_urusan')
                            ->where('UrsID',$id)
                            ->first();
        $daftar_urusan=[];
        if (!is_null($data) )  
        {
            $daftar_urusan=['UrsID'=>$data->UrsID,
                            'Kd_Urusan'=>$data->Kd_Urusan,
                            'Nm_Urusan'=>$data->Nm_Urusan,
                            'Kd_Bidang'=>$data->Kd_Bidang, 
                            'Kode_Bidang'=>$data->Kode_Bidang,    
                            'Nm_Bidang'=>$data->Nm_Bidang,                         
                            'TA'=>$data->TA
                        ];
        }
        return response()->json(['status'=>1,                                    
                                'data'=>$daftar_urusan],200); 
    }   
}