<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/9
 * Time: 17:39
 */
namespace App\Http\Controllers;

use App\Notifications\bidderadd;
use App\Notifications\whowin;
use Backpack\NewsCRUD\app\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Steel_brands;
use Illuminate\Http\Request;
use App\Models\Bid;
use App\Models\Quote;
use App\User;
use App\project;
use Redirect;
use Validator;
use Auth;
use PDO;
use DB;
use Carbon\Carbon;

class BidsController extends Controller {



    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // get all the bids
        $bids = Bid::all();
        // load the view and pass the bids
        //dd($bids);
        return View('bids.index')
            ->with('bids', $bids);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Request $request,$type='batch')
    {
        $brands=Steel_brands::all();
        $uid=Auth::id();
        $user=Auth::user();
        // $myprojects=project::where('user_id',$uid)->get();
        $myprojects=get_company_projects($user->company_id);
        $a_projects=array();
        // foreach ($myprojects as $key => $value) {
        //     $a_projects[$value->id]['pid']=$value->id;
        //     $a_projects[$value->id]['name']=$value->name;
        //     $a_projects[$value->id]['province']=$value->province;
        //     $a_projects[$value->id]['city']=$value->city;
        //     $a_projects[$value->id]['area']=$value->area;
        //     $a_projects[$value->id]['add']=$value->add;
        //     $a_projects[$value->id]['brands']=brands_id_to_name($value->brands);
        //     $a_projects[$value->id]['m_name']=$value->m_name;
        //     $a_projects[$value->id]['c_type']=$value->c_type;
        //     $a_projects[$value->id]['amount']=$value->amount;
        //     $a_projects[$value->id]['settlement']=$value->settlement;
        //     $a_projects[$value->id]['paytype']=$value->paytype;
        //     $a_projects[$value->id]['quote_request']=$value->quote_request;
        // }
        // $companys = \App\Models\Company::all();
         $companys = DB::table('company')->pluck('name','id')->toArray();
        //  $companys =DB::select('select id,name from company');
        $q_request=explode(',',\Config::get('settings.q_request'));
        $pay_type=explode(',',\Config::get('settings.pay_type'));
        if ($type=='batch') {
            $cats=Category::All();
            $results = DB::select('select id,parent_id,name from categories');
            $oresult = array_map(function ($value) {
                            return (array)$value;
                        }, $results);
            $tree=getDataTree($oresult);

           return View('bids.create', ['companys' =>  $companys,'brands' =>  $brands,'myprojects' =>  $myprojects,'q_request' =>  $q_request,'pay_type' =>  $pay_type,'cats' =>  $tree]);

        } else {
            return View('bids.create_project', ['companys' =>  $companys,'brands' =>  $brands,'myprojects' =>  $a_projects,'q_request' =>  $q_request,'pay_type' =>  $pay_type]);
        }
        
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $rules = array(
            'project_id'       => 'required'
        );
        $validator = Validator::make($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return Redirect::to('bids/create')
                ->withErrors($validator);
                // ->withInput(Input::except('password'));
        } else {
            // store
            $cnames=$request->input('cname');
            $sizes=$request->input('size');
            $materials=$request->input('material');
            $tamounts=$request->input('tamount');
            $amounts=$request->input('amount');
            $batch_amount=$request->input('batch_amount');
            $marks=$request->input('mark');
            $items=array();
            if (!empty($cnames)) {
                foreach ($cnames as $key => $value) {
                    $items[$key][]=$value;
                    $items[$key][]=$sizes[$key];
                    $items[$key][]=$materials[$key];
                    $items[$key][]=$amounts[$key];
                    $items[$key][]=$marks[$key];
                }
            }
            // dd($items);
            $bid = new Bid;
            $bid->uid       =Auth::id();
            $bid->pid       = $request->input('project_id');
            $bid->contact_name      = $request->input('contact_name');
            $bid->contact_phone = $request->input('contact_phone');
            $bid->s_province      = $request->input('s_province');
            $bid->s_city      = $request->input('s_city');
            $bid->s_county      = $request->input('s_county');
            $bid->add      = $request->input('add');
            $bid->brands      =$request->input('brands'); //implode(',',$request->brands);
            $bid->mtype      =$request->input('mtype');
            $bid->bid_deadline      = $request->input('bid_deadline');
            $bid->bod      = $request->input('bod');
            $bid->delivery_day      = $request->input('delivery_day');
            $bid->quote_request      =  $request->input('q_request');//implode(',',$request->q_request);
            $bid->settlement      = $request->input('settlement');
            $bid->paytype      = $request->input('paytype');
            $bid->quote_list      = $items;
            $bid->deposit      = $request->input('deposit');
            $bid->deposit_account      = $request->input('deposit_account');
            $bid->deposit_bank_name      = $request->input('deposit_bank_name');
            $bid->deposit_return      = $request->input('deposit_return');
            $bid->companys      = $request->input('companys');
            $bid->qtype      = $request->input('qtype');
            $bid->type      = $request->input('type');
            // $bid->type      = 'batch';
            
            $bid->remark      = $request->input('remark');
            $bid->amount      = $request->input('tamount');
            $bid->batch_amount      = $request->input('batch_amount');
            $bid->user_company      = Auth::user()->company_id;
            
            if ($request->input('type')==2) {
                $qbrands=$request->input('qbrands');
                $qremarks=$request->input('qremark');
                foreach ($qbrands as $key => $value) {
                    $items[$key][]=get_brand_id_by_name($value);
                    $items[$key][]=$qremarks[$key];
                }
                $bid->quote_list      = $items;
            }
            //  dd($bid);
            // $bid->markPending();
            // $bid->status=0;
            if ($request->input('bid_to')=='all') {
                $bid->companys=NULL;
            }
            $bid->save();
            // $bid->markPending();

            // dd($bid);
            // redirect
            //Session::flash('message', 'Successfully created nerd!');
            return Redirect::to('tenderee/my');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        // get the nerd
        $bid = Bid::find($id);
        // show the view and pass the$bid to it
        return \View::make('bids.tender')
            ->with('$bid', $bid);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        // get the nerd
        $nerd = Bid::find($id);
        // show the edit form and pass the nerd
        return View::make('bids.edit')
            ->with('nerd', $nerd);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            'email'      => 'required|email',
            'nerd_level' => 'required|numeric'
        );
        $validator = Validator::make(Input::all(), $rules);
        // process the login
        if ($validator->fails()) {
            return Redirect::to('bids/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $nerd = Bid::find($id);
            $nerd->name       = Input::get('name');
            $nerd->email      = Input::get('email');
            $nerd->nerd_level = Input::get('nerd_level');
            $nerd->save();
            // redirect
            Session::flash('message', 'Successfully updated nerd!');
            return Redirect::to('bids');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        $nerd = Bid::find($id);
        $nerd->delete();
        // redirect
        Session::flash('message', 'Successfully deleted the nerd!');
        return Redirect::to('bids');
    }

    //投标方 招标公告
    public function bidder_list()
    {
        $bids = Bid::where('status','>', 0)->orderBy('created_at', 'desc')->get();
        return \View::make('bids.bidder.all-list')
            ->with('bids', $bids);
    }

    public function mybids()
    {
        $uid=Auth::id();
        $mybids=bidder_getbids_by_uid($uid);
        $bids = DB::table('bids')
                    ->whereIn('id', $mybids)
                    ->orderBy('id','Desc')
                    ->get();
        return \View::make('bids.bidder.my')
            ->with('bids', $bids);

    }

    public function bidder_bid($id)
    {
        $bid = Bid::find($id);
        $uid=Auth::id();
        $isin=is_enroll_bid($uid,$id);
        $company_is_in=company_enroll_bid($uid,$id);
        return view('bids.bidder.enroll', ['bid' => $bid,'isin' => $company_is_in]);
    }
    //报名
    public function bidder_bid_add(Request $request,$id)
    {   
        $uid=Auth::id();
        $bid = Bid::find($id);
        $tenderee=User::find($bid->uid);
        if(empty($bid->stage)){
            $bid->stage=2;
            $bid->save();
        }
        $record = DB::table('user_quote')->where([
                ['uid', '=', $uid],
                ['bid', '=', $id],
            ])->get();

        if($record->isEmpty()){
            DB::table('user_quote')->insert(['bid' => $id, 'uid' => $uid]);
        }
        $tenderee->notify(new bidderadd($bid,$uid));
        return Redirect::to('bidder/allbids/'.$id.'/step2');
    }

    public function bidder_bid_step2($id)
    {
        $bid = Bid::find($id);
        $uid=Auth::id();
        // $firstq=bidder_get_firstq_by_ubid($uid,$id);
        // dd($uid);
        $firstq=bidder_get_firstq_by_c_ubid($uid,$id);
        $firstq_elo=bidder_get_firstq_by_cubid_eloq($uid,$id);
        $has_quote=company_has_quote($uid,$id);
        return view('bids.bidder.bid', ['bid' => $bid,'firstq' => $firstq,'firstq_elo' => $firstq_elo,'has_quote' => $has_quote]);
    }
    public function bidder_bid_open($id)
    {
        $bid = Bid::find($id);
        $who=Auth::id();
        // $prices = DB::table('quote_prices')->where([
        //     ['who', '=', $who],
        //     ['bid', '=', $id],
        // ])->get();
        $prices=bidder_get_firstq_by_c_ubid($who,$id);
        // $insq=in_second_quote($who,$id);
        $insq=company_in_second_quote($who,$id);
        $issq=is_second_price_post($who,$id);
        $my_fqb=bidder_get_firstq_by_c_ubid($who,$id);
        if (empty($my_fqb)) {
           $my_fqb=array();
        }

        $advp=get_fq_advise_prices($id);
        $firstq_elo=bidder_get_firstq_by_cubid_eloq($who,$id);

        return view('bids.bidder.opening', ['bid' => $bid,'prices' => $prices,'insq' => $insq,'issq' => $issq,'my_fqb' => $my_fqb,'advp' => $advp,'firstq_elo' => $firstq_elo]);
    }

    function view_bidfile($bid)
    {
        $who=Auth::id();
        $file='uploads/'.get_bidfile($who,$bid);
        $bidfile=public_path().'/'.$file;
        if (file_exists(public_path($file))) {
            return response()->file($bidfile);
        } else {
            dd('文件不存在');
        }

    }

    function view_bidfile_by_uid_bid($uid,$bid)
    {
        $file='uploads/'.get_bidfile($uid,$bid);
        $bidfile=public_path().'/'.$file;
        if (file_exists(public_path($file))) {
            return response()->file($bidfile);
        } else {
            dd('文件不存在');
        }

    }


    public function bidder_bid_quote_store(Request $request,$id)
    {
        // dd($request);
        $cuser=Auth::user();
        $who=Auth::id();
        $bid = Bid::find($id);
        $has_quote=company_has_quote($who,$id);
        $qlist=$bid->quote_list;
        $prices=$request->input('price');
        // $status=$request->input('status');
        if ($cuser->hasPermissionTo('决策') || empty($cuser->id_parent)) {
            $status=1;
        } else {
            $status=0;
        }
        $bidfile_path ="";
        $qprice=array();
        if (!empty($request->file('bidfile')) && $request->file('bidfile')->isValid()) {
            $bidfile_path = $request->bidfile->store('bidfiles','uploads');
        }
        if (empty($bid->type)) {
            
            $qbrands=$request->input('brands');
            $cname_cids=$request->input('cname_cid');
            $size_cids=$request->input('size_cid');
            $material_cids=$request->input('material_cid');
            $amounts=$request->input('amount');
            $s_prices=$request->input('s_price');
            $d_prices=$request->input('d_price');
            $m_prices=$request->input('m_price');
            $u_prices=$request->input('u_price');
            $t_prices=$request->input('t_price');
            $fq_mark=$request->input('fq_mark');
            
            foreach($qlist as $k=>$v){
                $qprice[$k]['bid']=$id;
                $qprice[$k]['brand_id']=$qbrands[$k];
                $qprice[$k]['who']=$who;
                $bid=$qbrands[$k];
                $cname=get_cname_by_id($v[0]);
                $size=get_size_by_id($v[1]);
                $material=get_material_by_id($v[2]);
                $pid=get_pid_by_cids($bid,$cname,$size,$material);
                $qprice[$k]['pid']=$pid;
                $qprice[$k]['price']=$prices[$k];
                $qprice[$k]['s_price']=$s_prices[$k];
                $qprice[$k]['d_price']=$d_prices[$k];
                $qprice[$k]['m_price']=$m_prices[$k];
                $qprice[$k]['u_price']=$u_prices[$k];
                $qprice[$k]['t_price']=$t_prices[$k];
                $qprice[$k]['cname_cid']=$cname_cids[$k];
                $qprice[$k]['size_cid']=$size_cids[$k];
                $qprice[$k]['material_cid']=$material_cids[$k];
                $qprice[$k]['amount']=$amounts[$k];
                $qprice[$k]['status']=$status;
                $qprice[$k]['mark']=$fq_mark;
                $qprice[$k]['created_at']=date("Y-m-d h:i:s", time());
            }
            
            if(!$has_quote){
                DB::transaction(function () use ($qprice,$bidfile_path,$id,$who) {
                    //DB::table('quote_prices')->insert($qprice);
                    Quote::insert($qprice);
                    DB::update('update user_quote set bidfile = ? where bid = ? and uid=?', [$bidfile_path,$id,$who]);
                });
            }else{
                // dd($request);
                if ($request->review_agree==-1 || $request->decision_agree==-1) {
                $oldfq=bidder_get_firstq_by_c_ubid($who,$id);
                //  dd($oldfq);
                foreach ($oldfq as $key => $value) {
                    $old[$key]['brand_id'] = $value->brand_id;
                    $old[$key]['price'] = $value->price;
                    $old[$key]['s_price'] = $value->s_price;
                    $old[$key]['d_price'] = $value->d_price;
                    $old[$key]['m_price'] = $value->m_price;
                    $old[$key]['u_price'] = $value->u_price;
                    $old[$key]['t_price'] = $value->t_price;
                    $old[$key]['mark'] = $value->mark;
                }
                foreach ($qprice as $qpk => $qpv) {
                    $new[$qpk]['brand_id'] = $qpv['brand_id'];
                    $new[$qpk]['price'] = $qpv['price'];
                    $new[$qpk]['s_price'] = $qpv['s_price'];
                    $new[$qpk]['d_price'] = $qpv['d_price'];
                    $new[$qpk]['m_price'] = $qpv['m_price'];
                    $new[$qpk]['u_price'] = round($qpv['u_price']);
                    $new[$qpk]['t_price'] = round($qpv['t_price']);
                    $new[$qpk]['mark'] = $qpv['mark'];
                }
                foreach ($oldfq as $ok => $ov) {
                    $diff[$ok]=array_diff($new[$ok],$old[$ok]);
                }
                 //dd($diff);
                foreach ($diff as $dk => $dv) {
                    if(!empty($dv)){
                    // Quote::where('id',$oldfq[$dk]->id)->update($dv);
                    $qp= Quote::find($oldfq[$dk]->id);
                    // dd($qp);
                        foreach ($dv as $ddk=>$ddv) {
                            $qp->$ddk=$ddv;
                            // if ($cuser->hasPermissionTo('复核')) {
                            //      $qp->review_agree=-1;
                            // }elseif($cuser->hasPermissionTo('决策')) {
                            //      $qp->decision_agree=-1;
                            // }
                        }
                    // $qp->status=$status;
                     $qp->save();
                    }
                }

                bidder_update_firstq_audit_by_ubid($cuser,$id);

                }
            }
        } elseif($bid->type==1) {
            $up_down=$request->input('up_down');
            if ($up_down==0) {
               $prices=-$prices;
            }
            if(!$has_quote){
                DB::transaction(function () use ($qprice,$bidfile_path,$id,$who,$prices,$up_down,$bid) {
                DB::table('quote_prices')->insert(['bid' => $id,'who' => $who,'price' => $prices,'up_down' => $up_down,'qtype' => $bid->qtype]);
                DB::update('update user_quote set bidfile = ? where bid = ? and uid=?', [$bidfile_path,$id,$who]);
                });
            }
        }else{
            $qbrands=$request->input('brand_id');
            $up_down=$request->input('up_down');
            foreach($qlist as $k=>$v){
                $qprice[$k]['bid']=$id;
                $qprice[$k]['brand_id']=$qbrands[$k];
                $qprice[$k]['up_down']=$up_down[$k];
                $qprice[$k]['who']=$who;
                if ($up_down[$k]==0) {
                    $qprice[$k]['price']=-$prices[$k];
                } else {
                   $qprice[$k]['price']=$prices[$k];
                }
                $qprice[$k]['created_at']=date("Y-m-d h:i:s", time());
            }
            if(!$has_quote){
                DB::transaction(function () use ($qprice,$bidfile_path,$id,$who) {
                DB::table('quote_prices')->insert($qprice);
                DB::update('update user_quote set bidfile = ? where bid = ? and uid=?', [$bidfile_path,$id,$who]);
                });
            }

        }
        
        // $bid->stage=2;
        // $bid->save();
        return Redirect::to('bidder/allbids/'.$id.'/open');
    }

//二次议价保存
    public function bidder_bid_squote_store(Request $request,$id){
        $who=Auth::id();
        $bid = Bid::find($id);
        $sup_down=$request->input('sup_down');
        // dd($request);
        if (empty($request->input('second_price')[0])) {
            $tmp_fps=bidder_get_firstq_by_ubid($who,$id);
            //  dd($tmp_fps);
            if ($bid->type!=1) {
                foreach ($tmp_fps as $fk => $fv) {
                    // dd($tmp_fps);
                    $sprices[]=$fv->price;

                }
            } else {
                $sprices=$tmp_fps->first()->price;
                $sup_down=$tmp_fps->first()->up_down;
            }
            
        } else {
           $sprices=$request->input('second_price');
        }

        if (!empty($sprices)) {
            if ($bid->type==0) {
                $pids=$request->input('pid');                
                foreach($sprices as $p=>$v){
                    DB::table('quote_prices')
                    ->where([
                            ['pid', '=', $pids[$p]],
                            ['bid', '=', $id],
                            ['who', '=', $who]
                        ])
                    ->update(['second_price' => $v]);
                }

                update_user_is_post_second_price($id,$who);

            } elseif ($bid->type==1) {
                DB::table('quote_prices')
                    ->where([
                            ['bid', '=', $id],
                            ['who', '=', $who]
                        ])
                    ->update(['second_price' => $sprices,'sup_down'=> $sup_down]);
                    update_user_is_post_second_price($id,$who);
            }else {
                $brand_ids=$request->input('brand_id'); 
                foreach($sprices as $p=>$v){
                    DB::table('quote_prices')
                    ->where([
                            ['brand_id', '=', $brand_ids[$p]],
                            ['bid', '=', $id],
                            ['who', '=', $who]
                        ])
                    ->update(['second_price' => $v,'sup_down'=> $sup_down]);
                }
                update_user_is_post_second_price($id,$who);
            }
            
        }

        return Redirect::to('bidder/allbids/'.$id.'/open'); 

    }



    //招标方

    public function tenderee_my()
    {
        $uid=Auth::id();
        $parentid=Auth::user()->id_parent;
        $cuids=get_cuids_by_uid($uid);
        if (!empty($parentid)) {
            array_push($cuids,$parentid);
        }else{
            array_push($cuids,$uid);
        }
        
        // dd($cuids);
        $parents=[$uid,$parentid];
        //  dd($parents);
        // $bids = Bid::withAnyStatus()->where('uid','=', $uid)->orderBy('created_at', 'desc')->get();
        $bids = Bid::whereIn('uid', $cuids)->orderBy('created_at', 'desc')->get();
        // dd($bids);
        return \View::make('bids.tenderee.userTender')
            ->with('bids', $bids);
        

    }
    public function tenderee_my_bid($id)
    {
        $bid = Bid::find($id);
        
        //stage_redirect($bid->stage,$id);
        $firstq_cids=get_firstq_companys($id);
        return view('bids.tenderee.mybid', ['bid' => $bid,'firstq_cids' => $firstq_cids]);
    }
    public function tenderee_my_bid_edit($id)
    {
         $bid = Bid::find($id);
         $user=Auth::user();
         $brands=Steel_brands::all();
        $myprojects=get_company_projects($user->company_id);
        $companys = DB::table('company')->pluck('name','id')->toArray();

        $results = DB::select('select id,parent_id,name from categories');
        $oresult = array_map(function ($value) {
                        return (array)$value;
                    }, $results);
        $tree=getDataTree($oresult);
        // $tr=getDataTree($oresult,$id='id',$pid = 'parent_id',$child = 'child',$root=4);
        // dd($tree);
        $q_request=explode(',',\Config::get('settings.q_request'));
        $pay_type=explode(',',\Config::get('settings.pay_type'));
        $init_bid=array();
            $init_bid[$bid->pid]['pid']=$bid->pid;
            $init_bid[$bid->pid]['name']=$bid->name;
            $init_bid[$bid->pid]['province']=$bid->s_province;
            $init_bid[$bid->pid]['city']=$bid->s_city;
            $init_bid[$bid->pid]['area']=$bid->s_county;
            $init_bid[$bid->pid]['add']=$bid->add;
            $init_bid[$bid->pid]['brands']=implode(",",$bid->brands);
            $init_bid[$bid->pid]['m_name']=$bid->m_name;
            $init_bid[$bid->pid]['c_type']=$bid->mtype;
            $init_bid[$bid->pid]['amount']=$bid->amount;
            $init_bid[$bid->pid]['settlement']=$bid->settlement;
            $init_bid[$bid->pid]['paytype']=$bid->paytype;
            $init_bid[$bid->pid]['quote_request']=$bid->quote_request;
        return view('bids.tenderee.mybid_edit', ['bid' => $bid,'init_bid' => $init_bid,'myprojects' => $myprojects,'companys' =>  $companys,'brands' =>  $brands,'cats' =>  $tree,'q_request' =>  $q_request,'pay_type' =>  $pay_type]);
    }

    public function tenderee_my_bid_edit_store(Request $request,$id)
    {
            $bid = Bid::find($id);
            $user=Auth::user();

            $old=array();
            $old['pid']       = $bid->pid;
            $old['contact_name']      = $bid->contact_name;
            $old['contact_phone'] = $bid->contact_phone;
            $old['s_province']      = $bid->s_province;
            $old['s_city']      = $bid->s_city;
            $old['s_county']      = $bid->s_county;
            $old['add']      = $bid->add;
            $old['brands']      =json_encode($bid->brands); //implode(',',$request->brands);
            $old['mtype']      = $bid->mtype;
            $old['bid_deadline']      = $bid->bid_deadline;
            $old['bod']      = $bid->bod;
            $old['delivery_day']      = $bid->delivery_day;
            $old['quote_request']      =  json_encode($bid->q_request);//implode(',',$request->q_request);
            $old['settlement']      = $bid->settlement;
            $old['paytype']      = $bid->paytype;
            $old['quote_list']      = json_encode($bid->quote_list);
            $old['companys']      = json_encode($bid->companys);
            $old['qtype']      = $bid->qtype;
            $old['type']      = $bid->type;
            $old['amount']      = $bid->amount;
            $old['batch_amount']      = $bid->batch_amount;
            $old['review_reason']      = $bid->review_reason;
            $old['decision_reason']      = $bid->decision_reason;
            //要更新的值
            $updates=array();
            $cnames=$request->input('cname');
            $sizes=$request->input('size');
            $materials=$request->input('material');
            $tamounts=$request->input('tamount');
            $amounts=$request->input('amount');
            $batch_amount=$request->input('batch_amount');
            $marks=$request->input('mark');
            $items=array();
            if (!empty($cnames)) {
                foreach ($cnames as $key => $value) {
                    $items[$key][]=$value;
                    $items[$key][]=$sizes[$key];
                    $items[$key][]=$materials[$key];
                    $items[$key][]=$amounts[$key];
                    $items[$key][]=$marks[$key];
                }
            }
            // dd($items);
            $updates['pid']       = $request->input('project_id');
            $updates['contact_name']      = $request->input('contact_name');
            $updates['contact_phone'] = $request->input('contact_phone');
            $updates['s_province']      = $request->input('s_province');
            $updates['s_city']      = $request->input('s_city');
            $updates['s_county']      = $request->input('s_county');
            $updates['add']      = $request->input('add');
            $updates['brands']      =json_encode($request->input('brands')); //implode(',',$request->brands);
            $updates['mtype']      = $request->input('mtype');
            $updates['bid_deadline']      = $request->input('bid_deadline');
            $updates['bod']      = $request->input('bod');
            $updates['delivery_day']      = $request->input('delivery_day');
            $updates['quote_request']      =  json_encode($request->input('q_request'));//implode(',',$request->q_request);
            $updates['settlement']      = $request->input('settlement');
            $updates['paytype']      = $request->input('paytype');
            $updates['quote_list']      = json_encode($items);
            $updates['companys']      = json_encode($request->input('companys'));
            $updates['qtype']      = $request->input('qtype');
            $updates['type']      = $request->input('type');
            $updates['amount']      = $request->input('tamount');
            $updates['batch_amount']      = $request->input('batch_amount');
            $updates['review_reason']      = $request->input('review_reason');
            $updates['decision_reason']      = $request->input('decision_reason');

            $diff=array_diff($updates,$old);
            if(!empty($diff)){
                foreach ($diff as $key => $value) {
                    if (is_json($value)) {
                        $diff[$key]=json_decode($value);
                    }
                }
            }
            // dd($diff);
            foreach ($diff as $dk => $dv) {
                $bid->$dk=$dv;
            } 
            if ($request->input('bid_to')=='all') {
                $bid->companys=NULL;
            }
            if ($user->hasPermissionTo('复核')) {
                $bid->review_agree=-1;
            }
            if ($user->hasPermissionTo('决策')) {
                $bid->decision_agree=-1;
                $bid->status=1;
            }
            $bid->save();
            return Redirect::to('tenderee/my/'.$id);
    }

    public function tenderee_my_bid_corrections(Request $request,$id)
    {
        $bid = Bid::find($id);
        $nowTime = Carbon::now()->timestamp;
        $overTime = strtotime($bid->bid_deadline);
        if($nowTime > $overTime){
            return view("temp")->with("text","更正公告只能在截标前发布.");
        }else{
            $bid = Bid::find($id);
            $bid->corrections=$request->corrections;
            $bid->save();
            return Redirect::to('tenderee/my/'.$id);
        }
    }
    public function tenderee_my_bid_open($id)
    {
            if($this->checkStep($id) !== true){
                return $this->checkStep($id);
            }

            $bid = Bid::find($id);
//SELECT * FROM quote_prices WHERE bid=1 GROUP BY who,bid,cname_cid,size_cid,material_cid
            $company_prices=DB::table('quote_prices')
                    ->where('bid', '=', $id)
                    ->groupBy(['who','cname_cid','size_cid','material_cid'])
                    ->get();
            get_fq_advise_prices($id);     

            $lprices_tmp = DB::table('quote_prices')
                    ->select(DB::raw("*,SUBSTRING_INDEX(GROUP_CONCAT(price ORDER BY price ASC),',',1) AS lprice"))
                    ->where('bid', '=', $id);
                    if ($bid->type==2) {
                       $lprices_tmp->groupBy('brand_id');
                    } else {
                        $lprices_tmp->groupBy(['cname_cid','size_cid','material_cid']);
                    }
                    $lprices=$lprices_tmp->get();
                    //  dd($lprices);
// print_r($company_prices);exit;
            if ($bid->type==2) {
                $company_prices=DB::table('quote_prices')
                    ->where('bid', '=', $id)
                    // ->groupBy(['who','cname_cid','size_cid','material_cid'])
                    ->get();
            }

            $company_prices_a=array();
            foreach ($company_prices as $key => $value) {
                $company_prices_a[$value->who][]=$value;
            }

// 建议价
            $adv_prices=get_fq_advise_prices($id);
//参加二次议价的公司                   
            $scompanys=get_secondq_companys($id);
            $scids=array();
            if(!empty($scompanys)){
                foreach ($scompanys as $ck => $cv) {
                    $scids[]=$cv->uid;
                }
            }
            $sq_prices_t1_ok=array();
//首次比价   
            $firstq_prices=array();

            
            if ($bid->type==0) {
                     $firstq_prices=DB::table('quote_prices as a')
                     ->select(DB::raw("*,GROUP_CONCAT(tfsprice ORDER BY tfsprice) AS cprice,GROUP_CONCAT(a.who ORDER BY tfsprice) AS cids,GROUP_CONCAT(price ORDER BY tfsprice) AS fprice,GROUP_CONCAT(brand_id ORDER BY tfsprice) AS fbrands"))
                     ->leftJoin(DB::raw("(SELECT who,SUM(price) AS tfsprice FROM quote_prices GROUP BY who) AS b"),function($join){
                                    $join->on("a.who","=","b.who");
                                })
                     ->where('bid', '=', $id)
                     ->groupBy(['bid','cname_cid','size_cid','material_cid'])
                     ->orderBy('b.tfsprice')
                     ->get();
              
             }elseif ($bid->type==1) {
                $firstq_prices_t1=DB::table('quote_prices')
                                ->where('bid', '=', $id)
                                ->orderBy('price')
                                ->get();
                $firstq_prices=array();
                foreach ($firstq_prices_t1 as $key => $value) {
                    $firstq_prices[$value->who]=($value->up_down==0) ? '-'.abs($value->price) : '+'.$value->price;
                }

               asort($firstq_prices); 
               
//t1  二次比价
               $sq_prices_t1=DB::table('quote_prices')
                                ->where('bid', '=', $id)
                                ->orderBy('second_price')
                                ->whereIn('who', $scids)
                                ->get();
                foreach ($sq_prices_t1 as $key => $value) {
                     $sq_prices_t1_ok[$value->who]=($value->up_down==0) ? '-'.abs($value->second_price) : '+'.$value->second_price;
                }
               asort($sq_prices_t1_ok); 

            }else{
                $lprices = DB::table('quote_prices')
                ->select(DB::raw("*,SUBSTRING_INDEX(GROUP_CONCAT(price ORDER BY price ASC),',',1) AS lprice"))
                ->where('bid', '=', $id)
                ->groupBy('brand_id')
                ->get();
                // dd($lprices);




            }
//判读是否已经post 理想价格
            $is_wp=is_want_price_post($id);

 //首次比价  按品牌

                $order_companys=get_firstq_companys_bysum_price($id);
                // dd($order_companys);
                $firstq_prices_by_brand=array();
                $firstq_prices_by_brand=DB::table('quote_prices as a')
                     ->select(DB::raw("*,GROUP_CONCAT(tfsprice ORDER BY tfsprice) AS cprice,GROUP_CONCAT(a.who ORDER BY tfsprice) AS cids,GROUP_CONCAT(price ORDER BY tfsprice) AS fprice"))
                    ->leftJoin(DB::raw("(SELECT who,SUM(price) AS tfsprice FROM quote_prices GROUP BY who) AS b"),function($join){
                                    $join->on("a.who","=","b.who");
                                })
                     ->where('bid', '=', $id)
                     ->groupBy(['brand_id','cname_cid','size_cid','material_cid'])
                     ->orderBy('b.tfsprice')
                     ->get();

                $fqb=array();
                 if (!$firstq_prices_by_brand->isEmpty()) {
                     foreach ($firstq_prices_by_brand as $key => $value) {
                        $fqb[$value->brand_id][]=$value;
                     }
                 } 
                 

                    //  dd($fqb);


                 $second_prices_compangys=DB::table('user_quote')
                        ->select('uid')
                        ->where([
                        ['bid', '=', $id],
                        ['second_quote', '=', 1]
                        ])
                        ->get();

                    $second_prices=array();
                   if(!$second_prices_compangys->isEmpty()){
                       foreach($second_prices_compangys as $k=>$kv){
                           $second_prices[$kv->uid]=DB::table('quote_prices')
                        ->where([['bid', '=', $id],['who', '=', $kv->uid]])
                        ->get();
                       }
                   }
                //    dd($second_prices);

        //二次 总价比价
           $ttprices = DB::table('quote_prices as q')
            ->leftJoin(DB::raw("(SELECT who,SUM(second_price) AS tsprice FROM quote_prices GROUP BY who) AS b"),function($join){
                $join->on("q.who","=","b.who");
            })
            ->leftJoin(DB::raw("(SELECT pid,SUBSTRING_INDEX(GROUP_CONCAT(second_price ORDER BY second_price ASC),',',1) AS lsprice FROM quote_prices GROUP BY brand_id,cname_cid,size_cid,material_cid) AS c"),function($join2){
                $join2->on("q.pid","=","c.pid");
            })
            ->where('bid', '=', $id)
            ->groupBy(['q.who','q.cname_cid','q.size_cid','q.material_cid'])
            ->get();
            // dd($ttprices);
            $bttprices=array();
            $brand_tprices=array();
            if(!empty($ttprices)){
                foreach ($ttprices as $key => $value) {
                    $bttprices[$value->who][]=$value;
                    $brand_tprices[$value->brand_id][]=$value;
                }
            }
            //二次比价  按品牌
                $sorder_companys=get_secondq_companys_bysum_price($id);
                //  dd($order_companys);
                $sq_prices_by_brand=array();
                $sq_prices_by_brand=DB::table('quote_prices as a')
                     ->select(DB::raw("*,GROUP_CONCAT(tfsprice ORDER BY tfsprice) AS cprice,GROUP_CONCAT(a.who ORDER BY tfsprice) AS cids,GROUP_CONCAT(second_price ORDER BY tfsprice) AS fprice"))
                    ->leftJoin(DB::raw("(SELECT who,SUM(second_price) AS tfsprice FROM quote_prices GROUP BY who) AS b"),function($join){
                                    $join->on("a.who","=","b.who");
                                })
                     ->where('bid', '=', $id)
                     ->whereIn('a.who', $scids)
                     ->groupBy(['brand_id','cname_cid','size_cid','material_cid'])
                     ->orderBy('b.tfsprice')
                     ->get();
                $sqb=array();
                 if (!$sq_prices_by_brand->isEmpty()) {
                     foreach ($sq_prices_by_brand as $key => $value) {
                        $sqb[$value->brand_id][]=$value;
                     }
                 }
                //  dd($sq_prices_by_brand);

            $nowTime = Carbon::now()->timestamp;
        $overTime = strtotime($bid->bod);
                    $isTimeOut = false;
         if($overTime < $nowTime){
            $isTimeOut = true;
    }

        return view('bids.tenderee.opening', ['bid' => $bid,'lprices' => $lprices,'company_prices' => $company_prices_a,'second_prices' => $second_prices,'ttprices' => $bttprices,'brand_tprices' => $brand_tprices,'firstq_prices' => $firstq_prices,
        'order_companys' => $order_companys,'fqb' => $fqb,'sorder_companys' => $sorder_companys,'sqb' => $sqb,'is_wp' => $is_wp,'sq_prices_t1_ok'=>$sq_prices_t1_ok, "isTimeOut"=>$isTimeOut,'adv_prices'=>$adv_prices]);
    }

    public function tenderee_my_bid_open_compare($id)
    {
        if($this->checkStep($id) !== true){
            return $this->checkStep($id);
        }

                    $bid = Bid::find($id);
        //SELECT * FROM quote_prices WHERE bid=1 GROUP BY who,bid,cname_cid,size_cid,material_cid
                    $company_prices=DB::table('quote_prices')
                            ->where('bid', '=', $id)
                            ->groupBy(['who','cname_cid','size_cid','material_cid'])
                            ->get();

                    $lprices = DB::table('quote_prices')
                            ->select(DB::raw("*,SUBSTRING_INDEX(GROUP_CONCAT(price ORDER BY price ASC),',',1) AS lprice"))
                            ->where('bid', '=', $id)
                            ->groupBy(['cname_cid','size_cid','material_cid'])
                            ->get();
                            // dd($lprices);
        // print_r($company_prices);exit;
                    if ($bid->type==2) {
                        $company_prices=DB::table('quote_prices')
                            ->where('bid', '=', $id)
                            // ->groupBy(['who','cname_cid','size_cid','material_cid'])
                            ->get();
                    }

                    $company_prices_a=array();
                    foreach ($company_prices as $key => $value) {
                        $company_prices_a[$value->who][]=$value;
                    }

                    // dd($company_prices_a);
        //参加二次议价的公司                   
                    $scompanys=get_secondq_companys($id);
                    $scids=array();
                    if(!empty($scompanys)){
                        foreach ($scompanys as $ck => $cv) {
                            $scids[]=$cv->uid;
                        }
                    }
                    $sqpcompanys=get_secondq_post_companys($id);
                    $sqpcids=array();
                    if(!empty($sqpcompanys)){
                        foreach ($sqpcompanys as $ck => $cv) {
                            $sqpcids[]=$cv->uid;
                        }
                    }
                    $sq_prices_t1_ok=array();
        //首次比价   
                    $firstq_prices=array();
                    if ($bid->type==0) {
                             $firstq_prices=DB::table('quote_prices as a')
                             ->select(DB::raw("*,GROUP_CONCAT(tfsprice ORDER BY tfsprice) AS cprice,GROUP_CONCAT(DISTINCT a.who ORDER BY tfsprice) AS cids,GROUP_CONCAT(u_price ORDER BY tfsprice) AS fprice,GROUP_CONCAT(brand_id ORDER BY tfsprice) AS fbrands,GROUP_CONCAT(price ORDER BY tfsprice) AS t_rprice,GROUP_CONCAT(s_price ORDER BY tfsprice) AS ts_price,GROUP_CONCAT(d_price ORDER BY tfsprice) AS td_price,GROUP_CONCAT(m_price ORDER BY tfsprice) AS tm_price"))
                             ->leftJoin(DB::raw("(SELECT who,SUM(t_price) AS tfsprice FROM quote_prices where bid=? GROUP BY who) AS b"),function($join){
                                            $join->on("a.who","=","b.who");
                                        })
                             ->addBinding($id)
                             ->where('bid', '=', $id)
                             ->groupBy(['bid','cname_cid','size_cid','material_cid'])
                             ->orderBy('b.tfsprice')
                             ->get();
                            //   dd($firstq_prices);
                     }elseif ($bid->type==1) {
                        $firstq_prices_t1=DB::table('quote_prices')
                                        ->where('bid', '=', $id)
                                        ->orderBy('price')
                                        ->get();
                        $firstq_prices=array();
                        foreach ($firstq_prices_t1 as $key => $value) {
                            $firstq_prices[$value->who]=($value->up_down==0) ? '-'.abs($value->price) : '+'.$value->price;
                        }
                       asort($firstq_prices); 
        //t1  二次比价
                       $sq_prices_t1=DB::table('quote_prices')
                                        ->where('bid', '=', $id)
                                        ->orderBy('second_price')
                                        ->whereIn('who', $scids)
                                        ->get();
                        foreach ($sq_prices_t1 as $key => $value) {
                             $sq_prices_t1_ok[$value->who]=($value->sup_down==0) ? '-'.abs($value->second_price) : '+'.$value->second_price;
                        }
                       asort($sq_prices_t1_ok); 

                    }else{
                        $lprices = DB::table('quote_prices')
                        ->select(DB::raw("*,SUBSTRING_INDEX(GROUP_CONCAT(price ORDER BY price ASC),',',1) AS lprice"))
                        ->where('bid', '=', $id)
                        ->groupBy('brand_id')
                        ->get();
                        // dd($lprices);
                    }
        //判读是否已经post 理想价格
                    $is_wp=is_want_price_post($id);

         //首次比价  按品牌

                        $order_companys=get_firstq_companys_bysum_price($id);
                        //  dd($order_companys);
                        $firstq_prices_by_brand=array();
                        $firstq_prices_by_brand=DB::table('quote_prices as a')
                             ->select(DB::raw("*,GROUP_CONCAT(tfsprice ORDER BY tfsprice asc) AS cprice,GROUP_CONCAT(a.who ORDER BY tfsprice asc) AS cids,GROUP_CONCAT(u_price ORDER BY tfsprice asc) AS fprice"))
                            ->leftJoin(DB::raw("(SELECT who,SUM(t_price) AS tfsprice FROM quote_prices GROUP BY who) AS b"),function($join){
                                            $join->on("a.who","=","b.who");
                                        })
                             ->where('bid', '=', $id)
                             ->groupBy(['brand_id','cname_cid','size_cid','material_cid'])
                             ->orderBy('b.tfsprice','asc')
                             ->get();

                        $fqb=array();
                        $fqbcids_tmp='';
                         if (!$firstq_prices_by_brand->isEmpty()) {
                             foreach ($firstq_prices_by_brand as $key => $value) {
                                $fqb[$value->brand_id][]=$value;
                                $fqbcids_tmp=$value->cids;
                             }
                         } 
                         $fqbcids='';
                         if(!empty($fqbcids_tmp)){
                             $fqbcids=explode(',',$fqbcids_tmp);
                         }

                            //  dd($fqb);


                         $second_prices_compangys=DB::table('user_quote')
                                ->select('uid')
                                ->where([
                                ['bid', '=', $id],
                                ['second_quote', '=', 1]
                                ])
                                ->get();

                            $second_prices=array();
                           if(!$second_prices_compangys->isEmpty()){
                               foreach($second_prices_compangys as $k=>$kv){
                                   $second_prices[$kv->uid]=DB::table('quote_prices')
                                ->where([['bid', '=', $id],['who', '=', $kv->uid]])
                                ->get();
                               }
                           }
                        //    dd($second_prices);

                //二次 总价比价
                   $ttprices = DB::table('quote_prices as q')
                    ->leftJoin(DB::raw("(SELECT who,SUM(second_price) AS tsprice FROM quote_prices where bid=? GROUP BY who) AS b"),function($join){
                        $join->on("q.who","=","b.who");
                    })
                    ->leftJoin(DB::raw("(SELECT pid,SUBSTRING_INDEX(GROUP_CONCAT(second_price ORDER BY second_price ASC),',',1) AS lsprice FROM quote_prices where bid=? GROUP BY brand_id,cname_cid,size_cid,material_cid) AS c"),function($join2){
                        $join2->on("q.pid","=","c.pid");
                    })
                    ->addBinding($id)
                    ->addBinding($id)
                    ->where('bid', '=', $id)
                    ->whereIn('q.who', $scids)
                    ->groupBy(['q.who','q.cname_cid','q.size_cid','q.material_cid'])
                    ->orderby('b.tsprice','asc')
                    ->get();

                    $ttprices_wl=get_sqp_who_low_price($id);
                    // dd($ttprices_wl);
                    //  dd($ttprices);
                    $bttprices=array();
                    $brand_tprices=array();
                    if(!empty($ttprices)){
                        foreach ($ttprices as $key => $value) {
                            $bttprices[$value->who]['pics'][]=$value;
                            $bttprices[$value->who]['allprices']=empty($bttprices[$value->who]['allprices'])?0:$bttprices[$value->who]['allprices'];
                            $bttprices[$value->who]['allprices']+=$value->second_price*$value->amount;
                            $brand_tprices[$value->brand_id][]=$value;
                        }
                    }
                    // dd($bttprices);
                    //二次比价  按品牌
    
                        $sorder_companys=get_secondq_companys_bysum_price($id);
                        //   dd($sorder_companys);
                        $sq_prices_by_brand=array();
                        $sq_prices_by_brand=DB::table('quote_prices as a')
                             ->select(DB::raw("*,GROUP_CONCAT(tfsprice ORDER BY tfsprice) AS cprice,GROUP_CONCAT(a.who ORDER BY tfsprice) AS cids,GROUP_CONCAT(second_price ORDER BY tfsprice) AS fprice"))
                            ->leftJoin(DB::raw("(SELECT who,SUM(second_price) AS tfsprice FROM quote_prices where bid=? GROUP BY who order by tfsprice) AS b"),function($join){
                                            $join->on("a.who","=","b.who");
                                        })
                            ->addBinding($id)
                            // ->addBinding($id)
                             ->where('bid', '=', $id)
                             ->whereIn('a.who', $sqpcids)
                             ->groupBy(['brand_id','cname_cid','size_cid','material_cid'])
                             ->orderBy('tfsprice')
                             ->get();
                        $sqb=array();
                        $sqbcids_tmp='';
                         if (!$sq_prices_by_brand->isEmpty()) {
                             foreach ($sq_prices_by_brand as $key => $value) {
                                $sqb[$value->brand_id][]=$value;
                                $sqbcids_tmp=$value->cids;
                             }
                         }
                        $is_any_sqp=is_any_second_price_post($id);
                        $sqbcids='';
                         if(!empty($sqbcids_tmp)){
                             $sqbcids=explode(',',$sqbcids_tmp);
                         }
                        //  dd($sqb);
                         
                return view('bids.compare', ['bid' => $bid,'lprices' => $lprices,'company_prices' => $company_prices_a,'second_prices' => $second_prices,'ttprices' => $bttprices,'ttprices_wl' => $ttprices_wl,'brand_tprices' => $brand_tprices,'firstq_prices' => $firstq_prices,
                'order_companys' => $order_companys,'fqb' => $fqb,'fqbcids' => $fqbcids,'sorder_companys' => $sorder_companys,'sqb' => $sqb,'sqbcids' => $sqbcids,'is_wp' => $is_wp,'sq_prices_t1_ok'=>$sq_prices_t1_ok,'is_any_sqp'=>$is_any_sqp]);
    }
    
    public function tenderee_my_bid_want(Request $request,$id)
    {
        $bid = Bid::find($id);
        $bid->want_price=$request->want_price;
        if($bid->type==1 || $bid->type==0){
            $bid->up_down=$request->up_down;
        }elseif($bid->type==2){
            $bid->sup_down=$request->up_down;
        }
        $bid->stage=3;
        $bid->save();

        if ($bid->type==2) {
             $tprices = DB::table('quote_prices')
            ->select(DB::raw("*,SUM(price) AS tprice"))
            ->where('bid', '=', $id)
            ->groupBy('who')
            ->orderBy('tprice','asc')
            ->get();
        }elseif ($bid->type==0) {   
            $tprices = DB::table('quote_prices')
            ->select(DB::raw("*"))
            ->where('bid', '=', $id)
            ->groupBy('who')
            ->orderBy('t_price','asc')
            ->limit(3)
            ->get();
        } else {
            $tprices = DB::table('quote_prices')
            ->select(DB::raw("*,SUM(price) AS tprice"))
            ->where('bid', '=', $id)
            ->groupBy('who')
            ->orderBy('tprice','asc')
            ->limit(3)
            ->get();
        }
        
        if ($tprices->first()) {
            foreach($tprices as $v){
                DB::table('user_quote')
                ->where([
                        ['bid', '=', $v->bid],
                        ['uid', '=', $v->who],
                    ])
                ->update(['second_quote' => 1]);
            }
        } 

        return Redirect::to('tenderee/my/'.$id.'/open');
    }

    public function tenderee_projects()
    {
        $who=Auth::id();
        $projects = project::where('user_id', $who)->orderBy('id', 'desc')->get();
        // dd($projects);
        // show the view and pass the$bid to it
        return \View::make('bids.tenderee.userProject')
            ->with('projects', $projects);
          //return \View::make('bids.tender.all-list');
            // ->with('nerd', $nerd);
    }

    public function tenderee_my_bid_whowin(Request $request,$id)
    {
        //   dd($request);
        $bid = Bid::find($id);
        $company_uid=Auth::id();
        // $bid->want_price=$request->want_price;
        $bid->whowin=$request->whowin;
        $bid->stage=5;
        $bid->save();
        $bidder=User::find($request->whowin);
        $bidder->notify(new whowin($bid,$company_uid));
        return Redirect::to('tenderee/my/');
    }

        public function bid_over(Request $request,$id)
    {
        // dd($request);
        $bid = Bid::find($id);
        $who=Auth::id();
        $my_fqb=bidder_get_firstq_by_ubid($who,$id);
        if (empty($my_fqb)) {
           $my_fqb=array();
        }
        $prices = DB::table('quote_prices')->where([
            ['who', '=', $who],
            ['bid', '=', $id],
        ])->get();
        return view('bids.over-bid', ['bid' => $bid,'my_fqb' => $my_fqb,'prices' => $prices]);
    }

        public function tfile($id)
    {
        $bid = Bid::find($id);
        $project=\App\project::find($bid->pid);
        $who=Auth::id();
        // dd($bid);
        $company_info=get_company_info_by_uid($project->user_id);
        return view('bids.tfile', ['bid' => $bid,'project' => $project,'company_info' => $company_info]);
    }
        public function tpdf($id)
    {
        $bid = Bid::find($id);
        $project=\App\project::find($bid->pid);
        $who=Auth::id();
        // $prices = DB::table('quote_prices')->where([
        //     ['who', '=', $who],
        //     ['bid', '=', $id],
        // ])->get();

        // $insq=in_second_quote($who,$id);
        // $issq=in_second_quote($who,$id);
        $pdf = \PDF::loadView('bids.tfile', ['bid' => $bid,'project' => $project]);
        return $pdf->download('tfile.pdf');

        // return view('bids.tfile', ['bid' => $bid,'project' => $project]);
    }

    public function deleteBid(Request $request){
        $bidField = DB::table("bids")->where('id', $request->bid_id)->get()[0];
        if($bidField->uid && $bidField->uid==Auth::id()){
             DB::table("bids")->where('id', $request->bid_id)->update(["status"=>-1, "remove_text"=>$request->remove_text]);
             return Redirect::to('tenderee/my/');
        }else{
            return "非法操作";
        }
    }

    public function checkStep($id){
        $bid = Bid::find($id);
        $nowTime = Carbon::now()->timestamp;
        $overTime = strtotime($bid->bid_deadline);

        if($overTime > $nowTime){
            return view("temp")->with("text","还未到截标时间.");
        }

        return true;
    }



    public function t_audit(Request $request,$id){
        $bid = Bid::find($id);
        if (!empty($request->review_agree)) {
          $bid->review_agree = 1;
        }else{
          $bid->review_agree = -1;
        }

        if (!empty($request->t_review)) {
          $bid->review_reason = $request->t_review;
        }

        if (!empty($request->decision_agree)) {
          $bid->decision_agree = 1;
          $bid->status = 1;
        }

        if (!empty($request->t_decision)) {
          $bid->decision_reason = $request->t_decision;
        }

        $bid->save();

        return Redirect::to('tenderee/my/'.$id);
    }


    public function b_audit(Request $request,$id){
        $uid = Auth::id();
        $bid = Bid::find($id);
        $firstq=bidder_get_firstq_by_c_ubid($uid,$bid);
        if (!empty($request->review_agree)) {
          $bid->review_agree = 1;
        }

        if (!empty($request->t_review)) {
          $bid->review_reason = $request->t_review;
        }

        if (!empty($request->decision_agree)) {
          $bid->decision_agree = 1;
          $bid->status = 1;
        }

        if (!empty($request->t_decision)) {
          $bid->decision_reason = $request->t_decision;
        }

        $bid->save();

        return Redirect::to('tenderee/my/'.$id);
    }

}