<?php

namespace App\Controllers\API\v1\RPJMD;

use Illuminate\Http\Request;
use App\Controllers\Controller;

class IndikatorKinerjaController extends Controller {
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
            $data = \DB::table('trIndikatorKinerja AS a')
                        ->select(\DB::raw('
                            k."KgtID",
                            CASE WHEN d."Kd_Urusan" IS NULL THEN 
                                                \'0\'
                                        ELSE
                                                d."Kd_Urusan"
                            END AS "Kd_Urusan", 
                            d."Nm_Urusan",
                            CASE WHEN c."Kd_Bidang" IS NULL THEN 
                                                \'0\'
                                        ELSE
                                                c."Kd_Bidang"
                            END AS "Kd_Bidang", 
                            c."Nm_Bidang",
                            a."Kd_Prog",
                            a."PrgNm",
                            a."Jns",
                            k."Kd_Keg",
                            k."KgtNm",
                            k."TA" 
                        '))
                        ->join('tmUrs AS b',\DB::raw('b."UrsID"'),'=',\DB::raw('a."UrsID"'))
                        ->join('tmKUrs AS ku',\DB::raw('ku."KUrsID"'),'=',\DB::raw('b."KUrsID"'))
                        ->join('tmPrg AS c',\DB::raw('c."PrgID"'),'=',\DB::raw('a."PrgID"'))
                        ->leftJoin('trUrsPrg AS c1',\DB::raw('c1."PrgID"'),'=',\DB::raw('c."PrgID"'))
                        ->leftJoin('tmUrs AS c2',\DB::raw('c1."PrgID"'),'=',\DB::raw('c."PrgID"'))                        
                        ->where('k.TA',$ta)
                        ->orderBy('k.Kd_Keg','ASC')
                        ->get();
            $data_indikator = []; 
            foreach ($data as $v)
            {
                $data_indikator[]=['KgtID'=>$v->KgtID,
                                    'Kd_Urusan'=>$v->Kd_Urusan,
                                    'Nm_Urusan'=>$v->Nm_Urusan,
                                    'Kd_Bidang'=>$v->Kd_Bidang, 
                                    'Nm_Bidang'=>$v->Nm_Bidang, 
                                    'Kd_Prog'=>$v->Kd_Prog,
                                    'PrgNm'=>$v->KgtNm,                                    
                                    'Jns'=>$v->Jns,
                                    'Kd_Keg'=>$v->Kd_Keg,
                                    'KgtNm'=>$v->KgtNm,
                                    'TA'=>$v->TA 
                                ];
            }
            return response()->json(['status'=>1,
                                    'data'=>$data_indikator],200); 
        }
        else
        {
            $data = \DB::table('tmKgt AS k')
                        ->select(\DB::raw('
                            k."KgtID",
                            CASE WHEN d."Kd_Urusan" IS NULL THEN 
                                                \'0\'
                                        ELSE
                                                d."Kd_Urusan"
                            END AS "Kd_Urusan", 
                            d."Nm_Urusan",
                            CASE WHEN c."Kd_Bidang" IS NULL THEN 
                                                \'0\'
                                        ELSE
                                                c."Kd_Bidang"
                            END AS "Kd_Bidang", 
                            c."Nm_Bidang",
                            a."Kd_Prog",
                            a."PrgNm",
                            a."Jns",
                            k."Kd_Keg",
                            k."KgtNm",
                            k."TA" 
                        '))
                        ->join('tmPrg AS a',\DB::raw('k."PrgID"'),'=',\DB::raw('a."PrgID"'))
                        ->leftJoin('trUrsPrg AS b',\DB::raw('b."PrgID"'),'=',\DB::raw('a."PrgID"'))
                        ->leftJoin('tmUrs AS c',\DB::raw('c."UrsID"'),'=',\DB::raw('b."UrsID"'))
                        ->leftJoin('tmKUrs AS d',\DB::raw('d."KUrsID"'),'=',\DB::raw('c."KUrsID"'))
                        ->where('k.TA',$ta)
                        ->orderBy('k.Kd_Keg','ASC')
                        ->paginate($numberRecordPerPage, $columns, 'page', $currentpage); 
            $data_indikator = []; 
            foreach ($data as $v)
            {
                $data_indikator[]=['KgtID'=>$v->KgtID,
                                    'Kd_Urusan'=>$v->Kd_Urusan,
                                    'Nm_Urusan'=>$v->Nm_Urusan,
                                    'Kd_Bidang'=>$v->Kd_Bidang, 
                                    'Nm_Bidang'=>$v->Nm_Bidang, 
                                    'Kd_Prog'=>$v->Kd_Prog,
                                    'PrgNm'=>$v->KgtNm,                                    
                                    'Jns'=>$v->Jns,
                                    'Kd_Keg'=>$v->Kd_Keg,
                                    'KgtNm'=>$v->KgtNm,
                                    'TA'=>$v->TA 
                                ];
            }
            return response()->json(['status'=>1,
                                    'per_page'=> $data->perPage(),
                                    'current_page'=>$data->currentPage(),
                                    'last_page'=>$data->lastPage(),
                                    'total'=>$data->total(),
                                    'data'=>$data_indikator],200); 
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
        $data =\DB::table('tmKgt AS k')
                    ->select(\DB::raw('
                        k."KgtID",
                        CASE WHEN d."Kd_Urusan" IS NULL THEN 
                                            \'0\'
                                    ELSE
                                            d."Kd_Urusan"
                        END AS "Kd_Urusan", 
                        d."Nm_Urusan",
                        CASE WHEN c."Kd_Bidang" IS NULL THEN 
                                            \'0\'
                                    ELSE
                                            c."Kd_Bidang"
                        END AS "Kd_Bidang", 
                        c."Nm_Bidang",
                        a."Kd_Prog",
                        a."PrgNm",
                        a."Jns",
                        k."Kd_Keg",
                        k."KgtNm",
                        k."TA" 
                    '))
                    ->join('tmPrg AS a',\DB::raw('k."PrgID"'),'=',\DB::raw('a."PrgID"'))
                    ->leftJoin('trUrsPrg AS b',\DB::raw('b."PrgID"'),'=',\DB::raw('a."PrgID"'))
                    ->leftJoin('tmUrs AS c',\DB::raw('c."UrsID"'),'=',\DB::raw('b."UrsID"'))
                    ->leftJoin('tmKUrs AS d',\DB::raw('d."KUrsID"'),'=',\DB::raw('c."KUrsID"'))
                    ->where('k.KgtID',$id)
                    ->first();
        $data_indikator=[];
        if (!is_null($data) )  
        {
            $data_indikator=['KgtID'=>$data->KgtID,
                            'Kd_Urusan'=>$data->Kd_Urusan,
                            'Nm_Urusan'=>$data->Nm_Urusan,
                            'Kd_Bidang'=>$data->Kd_Bidang, 
                            'Nm_Bidang'=>$data->Nm_Bidang, 
                            'Kd_Prog'=>$data->Kd_Prog,
                            'PrgNm'=>$data->KgtNm,                                    
                            'Jns'=>$data->Jns,
                            'Kd_Keg'=>$data->Kd_Keg,
                            'KgtNm'=>$data->KgtNm,
                            'TA'=>$data->TA 
                        ];
        }
        return response()->json(['status'=>1,                                    
                                'data'=>$data_indikator],200); 
    }   
}