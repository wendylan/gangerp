<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('auth', ['except' => ['excel']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
 
        return view('companyInfo');
    }


    public function excel(Request $request)
    {
        $odata=$request->input('edata');
        
        if (empty($odata)) {
            return "input something";
        }

        $adata=explode("\r\n",$odata);

        foreach ($adata as $key => $value) {
            $t=explode("\t",$value);

                $lt=count($t);
                if ($lt > 9) {
                   $t[8]=(string)$t[8]." ".(string)$t[9];
                   unset($t[9]);
                }

            $adata[$key]=$t;
        }


        foreach ($adata as $k => $v) {
            $end=end($v);
            $ea=explode(" ",$end);
            $lv=count($v);
            $tl=count($ea);
            if ($tl>3) {
                $start_ea=array_slice($ea,0,2);
                $tea=array_slice($ea,2);
                $stea=implode('',$tea);
                $stea=array($stea);   
                $okend=array_merge($start_ea,$stea);
                unset($v[$lv-1]);
                $adata[$k]=array_merge($v,$okend);
            }else {
                $end=end($v);
                $ea=explode(" ",$end);
                unset($v[$lv-1]);
                $adata[$k]=array_merge($v,$ea);
            }
        }

        $head=array('产地','品名','规格','材质','数量','单价','金额','仓库','车牌','司机','身份证');
        
        $newcell=array();
        $ladata=count($adata);
        $newcell[0]=$head;
        for ($i=0; $i < $ladata; $i++) { 
            $newcell[$i+1]=$adata[$i];
        }

        Excel::create('广钢采购单',function($excel) use ($newcell){
            $excel->sheet('广钢', function($sheet) use ($newcell){
                // $sheet->setColumnFormat(array(
                //     'K' => '0',
                // ));
                $sheet->setWidth(array(
                    'A'     =>  10,
                    'B'     =>  10,
                    'H'     =>  10,
                    'I'     =>  16,
                    'J'     =>  10,
                    'k'     =>  25,
                ));
                $sheet->rows($newcell);
            });
        })->export('xls');
    }
}
