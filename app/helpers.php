<?php
// namespace App\helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Models\Quote;
// use Illuminate\Support\Facades\Redirect;

function get_cname_by_id($id){
    $retVal = (empty($id)) ? 0 : DB::select('select name from categories where id=?', [$id]);
    // print_r($retVal);exit;
    $result=$retVal[0]->name;
    return $result;

}


function get_brand_name_by_id($id){
    if(!empty($id)&&is_numeric($id)){
        $retVal = (empty($id)) ? 0 : DB::select('select name from steel_brands where id=?', [$id]);
        $result=$retVal[0]->name;
        return $result;
    }else{
        return false;
    }
}

function brands_id_to_name($brands){
    $abrand=explode(',',$brands);
    foreach ($abrand as $key => $id) {
        $n_brands[]=get_brand_name_by_id($id);
    }
    return implode(',',$n_brands);
}

function get_brand_id_by_name($name){
    $retVal = (empty($name)) ? 0 : DB::select('select id from steel_brands where name=?', [$name]);
    if (empty($retVal)) {
        return 0;
    } else {
        return $result=$retVal[0]->id;
    }
}


function get_size_by_id($id){
    $retVal = (empty($id)) ? 0 : DB::select('select name from categories where id=?', [$id]);
    $result=$retVal[0]->name;
    return $result; 

}


function get_material_by_id($id){
    $retVal = (empty($id)) ? 0 : DB::select('select name from categories where id=?', [$id]);
    $result=$retVal[0]->name;
    return $result;
}


function get_pid_by_cids($bid,$cname,$size,$material){
    $retVal = (empty($bid) && empty($cname) && empty($size) && empty($material)) ? 0 : DB::select('select id from steel_products where bid=? and cate_spec=? and size=? and material=?', [$bid,$cname,$size,$material]);
    if (empty($retVal)) {
        return 0;
    } else {
        return $retVal[0]->id;
    }
    
}

function get_project_name_by_id($id){
    $retVal = (empty($id)) ? 0 : DB::table('project')->select('name')->where('id', $id)->first();
    $result=(!$retVal) ? 0 : $retVal->name;
    return $result;
}

function get_company_name_by_uid($uid){
    $user=user::find($uid);
    $cid=$user->company_id;
    $retVal = (empty($uid)) ? 0 : DB::table('company')->select('name')->where('id', $cid)->first();
    $result=(!$retVal) ? 0 : $retVal->name;
    return $result;
}

function get_company_name_by_cid($cid){
    $retVal = (empty($cid)) ? 0 : DB::table('company')->select('name')->where('id', $cid)->first();
    $result=(!$retVal) ? 0 : $retVal->name;
    return $result;
}

function get_company_add_by_uid($uid){
    $user=user::find($uid);
    $cid=$user->company_id;
    $retVal = (empty($uid)) ? 0 : DB::table('company')->select('province','city','county','address')->where('id', $cid)->first();
    $result=(!$retVal) ? 0 : $retVal->province.$retVal->city.$retVal->county.$retVal->address;
    return $result;
}

function get_company_info_by_uid($uid){
    $pid=get_user_parent_id($uid);
    if (empty($pid)) {
        $retVal = (empty($uid)) ? 0 : DB::table('company')->where('user_id', $uid)->first();
        $result=(!$retVal) ? 0 : $retVal;
    } else {
       $retVal = (empty($uid)) ? 0 : DB::table('company')->where('user_id', $pid)->first();
       $result=(!$retVal) ? 0 : $retVal;
    }

    return $result;
}

function get_company_users_by_companyid($cid){
    $retVal = (empty($cid)) ? array() : DB::table('users')->select('id')->where('company_id', $cid)->get();
     $cuids=array();
    foreach ($retVal as $key => $value) {
        $cuids[]=$value->id;
    }
    return $cuids;
}

function get_company_projects($cid){
    $cuids=get_company_users_by_companyid($cid);
    $retVal = (empty($cuids)) ? 0 : DB::table('project')->whereIn('user_id', $cuids)->orderBy('created_at', 'desc')->get();
    // dd($retVal);
    $a_projects=array();
        foreach ($retVal as $key => $value) {
            $a_projects[$value->id]['pid']=$value->id;
            $a_projects[$value->id]['name']=$value->name;
            $a_projects[$value->id]['province']=$value->province;
            $a_projects[$value->id]['city']=$value->city;
            $a_projects[$value->id]['area']=$value->area;
            $a_projects[$value->id]['add']=$value->add;
            $a_projects[$value->id]['brands']=brands_id_to_name($value->brands);
            $a_projects[$value->id]['m_name']=$value->m_name;
            $a_projects[$value->id]['c_type']=$value->c_type;
            $a_projects[$value->id]['amount']=$value->amount;
            $a_projects[$value->id]['settlement']=$value->settlement;
            $a_projects[$value->id]['paytype']=$value->paytype;
            $a_projects[$value->id]['quote_request']=$value->quote_request;
        }
    return $a_projects;
}

function get_company_type_name($id){
    switch ($id) {
        case '1':
            return '国有企业';
            break;
        case '2':
            return '集体企业';
            break;
        case '3':
            return '独资企业';
            break;
        case '4':
            return '合资企业';
            break;        
        default:
            return '民营企业';
            break;
    }
}

function get_user_parent_id($uid){
    $retVal = (empty($uid)) ? 0 : DB::table('users')->select('id_parent')->where('id', $uid)->first();
    $result=(!$retVal) ? 0 : $retVal->id_parent;
    return $result;
}

function get_cuids_by_uid($uid){
    $parent_id=get_user_parent_id($uid);
    if (!empty($parent_id)) {
        $ousers = DB::table('users')
                    ->where('id_parent', '=', $parent_id)
                    ->get();
        $uids=array();
        foreach ($ousers as $value) {
            $uids[]=$value->id;
        }
        $retVal = (empty($uids)) ? array() : $uids ;
        return $retVal;
    } else {
         $ousers = DB::table('users')
                    ->where('id_parent', '=', $uid)
                    ->get();
        $uids=array();
        foreach ($ousers as $value) {
            $uids[]=$value->id;
        }
        $retVal = (empty($uids)) ? array() : $uids ;
        return $retVal;
    }
    
    
}


function get_bid_typename_by_id($tid){
    if ($tid==0) {
        return '批次';
    }elseif ($tid==1) {
        return '项目（统一价）';
    } else {
        return '项目（分品牌）';
    }
}

function get_bid_opentype($companys){
  if (empty($companys)) {
      return '公开';
  } else {
      return '定向';
  }
}

function is_enroll_bid($uid,$bid){
    $parent_id=get_user_parent_id($uid);
    if (!empty($uid&&$bid)) {
        $retVal =  DB::table('user_quote')->select('id')->where([
                        ['uid', '=', $uid],
                        ['bid', '=', $bid],
                    ])->orWhere([
                        ['uid', '=', $parent_id],
                        ['bid', '=', $bid],
                    ])->first();
        return (!$retVal) ? 0 : 1;
    } else {
        return 0;
    }
    
}

function company_enroll_bid($uid,$bid){
    $retVal =  DB::table('user_quote')->select('uid')->where('bid', '=', $bid)->get();
    if (!empty($retVal)) {
        $uids=array();
        foreach ($retVal as $value) {
            $uids[]=$value->uid;
        }
    $user_cid=Auth::user()->company_id;
    $cuids=get_company_users_by_companyid($user_cid);
    $r=array_intersect($uids,$cuids);
    $result = (empty($r)) ? 0 : 1 ;
        return $result;
    } else {
        return 0;
    }
}

function get_bidfile($uid,$bid){
    $filepath=DB::select('select bidfile from user_quote where uid = ? and bid=?', [$uid,$bid]);
    // dd($filepath);
    if (empty($filepath)) {
        $url = 0;
    } else {
        $url = $filepath[0]->bidfile;
    }
    return $retVal = (empty($url)) ? 0 : $url ;
}


function bidder_get_firstq_by_ubid($uid,$bid){
       if (!empty($uid && $bid)) {
        $retVal =  DB::table('quote_prices')->where([
                        ['who', '=', $uid],
                        ['bid', '=', $bid],
                    ])->get();
            if ($retVal->isEmpty()) {
                return 0;
            } else {
                return $retVal;
            }
                
        } else {
            return 0;
        }
    
}

function bidder_get_firstq_by_c_ubid($uid,$bid){
       if (!empty($uid && $bid)) {
        $cuids=get_cuids_by_uid($uid);
        $retVal =  DB::table('quote_prices')->where('bid', '=', $bid)
                    ->whereIn('who', $cuids)
                    ->get();
            if ($retVal->isEmpty()) {
                return 0;
            } else {
                return $retVal;
            }
                
        } else {
            return 0;
        }
}

function bidder_update_firstq_audit_by_ubid($user,$bid){
    if (!empty($user && $bid)) {
       $fqs=bidder_get_firstq_by_c_ubid($user->id,$bid);
     
       $fqids=array();
       foreach ($fqs as $value) {
           $fqids[]=$value->id;
       }
            if ($user->hasPermissionTo('复核')) {
                DB::table('quote_prices')
                    ->whereIn('id',$fqids)
                    ->update(['review_agree' => -1]);
            }elseif($user->hasPermissionTo('决策')) {
                DB::table('quote_prices')
                    ->whereIn('id',$fqids)
                    ->update(['decision_agree' => -1,'status' => 1]);
                    // ->update(['status' => 1]);
            }
       }
}

function bidder_get_firstq_by_cubid_eloq($uid,$bid){
       if (!empty($uid && $bid)) {
        $cuids=get_cuids_by_uid($uid);
        $retVal =  Quote::where('bid', '=', $bid)
                    ->whereIn('who', $cuids)
                    ->get();
            if ($retVal->isEmpty()) {
                return 0;
            } else {
                return $retVal;
            }
        } else {
            return 0;
        }
}


function get_firstq_companys($bid){
    $retVal = (empty($bid)) ? 0 : DB::table('user_quote')->select('uid')->where('bid', $bid)->get();
    $result=($retVal->isEmpty()) ? 0 : $retVal;
    return $result;
}


function get_secondq_companys($bid){
    $retVal = (empty($bid)) ? 0 : DB::table('user_quote')
                        ->select('uid')
                        ->where([
                        ['bid', '=', $bid],
                        ['second_quote', '=', 1]
                        ])
                        ->get();
    $result=(empty($retVal)) ? 0 : $retVal;
    return $result;
}

function get_secondq_post_companys($bid){
    $retVal = (empty($bid)) ? 0 : DB::table('user_quote')
                        ->select('uid')
                        ->where([
                        ['bid', '=', $bid],
                        ['second_price_post', '=', 1]
                        ])
                        ->get();
    $result=(empty($retVal)) ? 0 : $retVal;
    return $result;
}


function get_firstq_companys_bysum_price($bid){
    $retVal = (empty($bid)) ? 0 : DB::table('quote_prices')
    ->select(DB::raw('who,amount,SUM(price) AS tfsprice'))
    ->where('bid', $bid)
    ->groupBy('who')
    ->orderBy('tfsprice','asc')
    ->get();
    $result=($retVal->isEmpty()) ? 0 : $retVal;
    return $result;
}


function get_secondq_companys_bysum_price($bid){
    $scompanys=get_secondq_companys($bid);
    $scids=array();
    if(!empty($scompanys)){
        foreach ($scompanys as $ck => $cv) {
            $scids[]=$cv->uid;
        }
    }
    $retVal = (empty($bid)) ? 0 : DB::table('quote_prices')
    ->select(DB::raw('who,amount,SUM(second_price) AS tfsprice'))
    ->where('bid', $bid)
    ->whereIn('who', $scids)
    ->groupBy('who')
    ->orderBy('tfsprice','asc')
    ->get();
    $result=($retVal->isEmpty()) ? 0 : $retVal;
    return $result;
}

function qr_to_id($qr_name){
    switch ($qr_name) {
        case '含17%增值税发票':
            return '1';
            break;
        case '含运费':
            return '2';
            break;
        case '含吊机费':
            return '3';
            break;
        case '过磅费':
            return '4';
            break;        
        case '含服务费':
            return '5';
            break;  
    }
}

function qr_id_to_name($qr_id){
    switch ($qr_id) {
        case '1':
            return '含17%增值税发票';
            break;
        case '2':
            return '含运费';
            break;
        case '3':
            return '含吊机费';
            break;
        case '4':
            return '过磅费';
            break;        
        case '5':
            return '含服务费';
            break;
    }
}

function qr_id_to_name_string($array){
    $str='';
    krsort($array);
    foreach ($array as $value) {
        if (!empty($value)) {
            $s=qr_id_to_name($value);
            $str=$s.','.$str;
        }
    }
    $str=trim($str,',');
    return $str;

}

function get_qtype_name($id){
    switch ($id) {
        case '1':
            return '下单日我的钢铁网价格';
            break;
        case '2':
            return '到货日我的钢铁网价格';
            break;
        case '3':
            return '下单日广州钢材批发网价格';
            break;
        case '4':
            return '到货日广州钢材批发网价格';
            break;        
        default:
            return '下单日我的钢铁网价格';
            break;
    }
}

function get_updown_name($value){
    switch ($value) {
        case '0':
            return '下浮';
            break;
        case '1':
            return '上浮';
            break;       
        default:
            return '下浮';
            break;
    }
}

function get_updown_symbol($value){
    switch ($value) {
        case '0':
            return '-';
            break;
        case '1':
            return '+';
            break;       
        default:
            return '';
            break;
    }
}

function get_stage_name($id){
    switch ($id) {
        case '0':
            return '报名';
            break;
        case '2':
            return '投标中';
            break;
        case '3':
            return '二次议价中';
            break;
        case '4':
            return '二次比价中';
            break;
        case '5':
            return '已开标';
            break;          
        default:
            return '报名';
            break;
    }
}

function has_quote($who,$bid){
    if (!empty($who)&&!empty($bid)) {
        $record = DB::table('quote_prices')->where([
                ['who', '=', $who],
                ['bid', '=', $bid],
            ])->get();
       if ($record->isEmpty()) {
           return 0;
       } else {
           return 1;
       }
       
    } else {
       return 0;
    }
}

function company_has_quote($who,$bid){
    if (!empty($who)&&!empty($bid)) {
        $cuids=get_cuids_by_uid($who);
        $record = DB::table('quote_prices')->where('bid', '=', $bid)
            ->whereIn('who', $cuids)
            ->get();
       if ($record->isEmpty()) {
           return 0;
       } else {
           return 1;
       }
       
    } else {
       return 0;
    }
    
}

//判断用户是否进入二次议价
function in_second_quote($uid,$bid){
    $suids=get_secondq_companys($bid);
    $uids=array();
    if (!empty($suids)) {
        foreach ($suids as $value) {
           $uids[]=$value->uid;
        }
        if (in_array($uid,$uids)) {
            return 1;
        } else {
            return 0;
        }
        
    } else {
        return 0;
    }
}

function company_in_second_quote($uid,$bid){
    $user=user::find($uid);
    $suids=get_secondq_companys($bid);
    $uids=array();
    $cids=array();
    if (!empty($suids)) {
        foreach ($suids as $value) {
           $uids[]=$value->uid;
           $tmp_user=user::find($value->uid);
           $cids[]=$tmp_user->company_id;
        }
        if (in_array($uid,$uids) || in_array($user->company_id,$cids)) {
            return 1;
        } else {
            return 0;
        }
        
    } else {
        return 0;
    }
}

function is_want_price_post($bid){
    // $result=DB::table('bids')->where('id', $bid)->value('want_price');
    $retVal = (empty(DB::table('bids')->where('id', $bid)->value('want_price'))) ? 0 : 1 ;
    return $retVal;
}

//判断用户有无提交二次议价
function is_second_price_post($who,$bid){
    $retVal = DB::table('user_quote')->select('second_price_post')->where([
                ['uid', '=', $who],
                ['bid', '=', $bid],
            ])->get();
    if ($retVal->isEmpty()) {
        return 0;
    } else {
        return $retVal[0]->second_price_post;
    }
}

function is_any_second_price_post($bid){
    $any=DB::table('user_quote')->select(DB::raw("GROUP_CONCAT(distinct second_price_post) as sp"))
                        ->where('bid', '=', $bid)
                        ->groupBy('bid')
                        ->get();
    return empty($any[0]->sp)?0:1;
}


function bidder_getbids_by_uid($uid){
    $user=User::find($uid);
    // $uids=[$uid,$parent_id];
    $uids=get_company_users_by_companyid($user->company_id);
    $retVal = (empty($uid)) ? 0 : DB::table('user_quote')->select('bid')->whereIn('uid', $uids)->get();
    $result=array();
    if(!empty($retVal)){
        foreach($retVal as $vbid){
            $result[]=$vbid->bid;
        }
    }
    return $result;
}


function update_user_is_post_second_price($bid,$uid){
    DB::table('user_quote')
                    ->where([
                            ['bid', '=', $bid],
                            ['uid', '=', $uid]
                        ])
                    ->update(['second_price_post' => 1]);
}


function get_sqp_who_low_price($bid){
        //二次议价谁最低
        $ttprices_wl_tmp=DB::table('quote_prices')->select(DB::raw("pid,SUBSTRING_INDEX(GROUP_CONCAT(second_price,'|',who ORDER BY second_price ASC),',',1) as wl"))
                        ->where('bid', '=', $bid)
                        ->groupBy(['brand_id','cname_cid','size_cid','material_cid'])
                        ->get();
        $ttprices_wl=array();
        if (!empty($ttprices_wl_tmp)) {
            foreach ($ttprices_wl_tmp as $key => $value) {
                if(!empty($value->wl)){
                    $tmp_who=explode('|',$value->wl);
                    $ttprices_wl[$tmp_who[1]]['pid']=$value->pid;
                    $ttprices_wl[$tmp_who[1]]['who']=$tmp_who[1];
                    $ttprices_wl[$tmp_who[1]]['slprice']=$tmp_who[0];
                }
                
            }
        }   
        return $ttprices_wl;
}

function to_wanyuan($money){
    return number_format($money);
    //return $retVal = (empty($money)) ? 0 : ($money/10000).'万元' ;
}

function stage_redirect($stage,$id){
 return redirect('tenderee/my/999');
                return redirect()->action(
                'BidsController@bid_over', ['id' => $id]
            );
    switch ($stage) {
        case 5:
            return redirect()->action(
                'BidsController@bid_over', ['id' => $id]
            );
            dd(1111);
            break;
        
        default:
            return Redirect::to('/');
            break;
    }
}

function get_fq_advise_prices($id){
      $lprices_tmp =array();
      $lprices_tmp = DB::table('quote_prices')
                    ->select(DB::raw("*,GROUP_CONCAT(price order by brand_id) AS aprice,GROUP_CONCAT(s_price order by brand_id) AS as_price,GROUP_CONCAT(d_price order by brand_id) AS ad_price,GROUP_CONCAT(m_price order by brand_id) AS am_price,GROUP_CONCAT(brand_id order by brand_id) AS brand_ids"))
                    ->where('bid', '=', $id)
                    ->groupBy(['cname_cid','size_cid','material_cid'])
                    ->get();   

    $ta_prices=array();
    foreach ($lprices_tmp as $key => $value) {
        $tmp_brands=explode(',',$value->brand_ids);
        $tmp_aprices=explode(',',$value->aprice);
        $tmp_as_price=explode(',',$value->as_price);
        $tmp_ad_price=explode(',',$value->ad_price);
        $tmp_am_price=explode(',',$value->am_price);
        foreach ($tmp_brands as $bk => $bv) {
            $ta_prices[$key]['tbrands'][$bv]['price'][]=$tmp_aprices[$bk];
            $ta_prices[$key]['tbrands'][$bv]['s_price'][]=isset($tmp_as_price[$bk])?$tmp_as_price[$bk]:0;
            $ta_prices[$key]['tbrands'][$bv]['d_price'][]=isset($tmp_ad_price[$bk])?$tmp_ad_price[$bk]:0;
            $ta_prices[$key]['tbrands'][$bv]['m_price'][]=isset($tmp_am_price[$bk])?$tmp_am_price[$bk]:0;
            $ta_prices[$key]['cname_cid']=$value->cname_cid;
            $ta_prices[$key]['size_cid']=$value->size_cid;
            $ta_prices[$key]['material_cid']=$value->material_cid;
            $ta_prices[$key]['amount']=$value->amount;
        }
    }
        // dd($ta_prices);
    foreach ($ta_prices as $tk => $tv) {
        foreach ($tv['tbrands'] as $tt_bid => $ttv) {
                $tmp_lprice=$ttv['price'];
                $tmp_ls_price=$ttv['s_price'];
                $tmp_ld_price=$ttv['d_price'];
                $tmp_lm_price=$ttv['m_price'];
                sort($tmp_lprice);
                sort($tmp_ls_price);
                sort($tmp_ld_price);
                sort($tmp_lm_price);
                $adv_prices[$tk]['adv_price'][$tt_bid]=$tmp_lprice[0]+$tmp_ls_price[0]+$tmp_ld_price[0]+$tmp_lm_price[0];
            $adv_prices[$tk]['cname_cid']=$tv['cname_cid'];
            $adv_prices[$tk]['size_cid']=$tv['size_cid'];
            $adv_prices[$tk]['material_cid']=$tv['material_cid'];
            $adv_prices[$tk]['amount']=$tv['amount'];
        }
        asort($adv_prices[$tk]['adv_price']);
    }
    //  dd($adv_prices);
    return empty($adv_prices)?0:$adv_prices;
}


function array_combine2($arr1, $arr2) {
    // $count = min(count($arr1), count($arr2));
    $ccids=count($arr1);
    $cfprices=count($arr2);
    $num=$ccids-$cfprices;
    if ($num>0) {
        for ($i=0; $i <$num ; $i++) { 
            array_push($arr2,0);
        }
    }
    return array_combine($arr1,$arr2);
}

//steel spec


function get_products_by_brandid($bid){
    $results = DB::select('select * from steel_products where bid = :bid', ['bid' => $bid]);
    return $results;
}


//权限
function get_all_permissionsid_by_uid($uid){
    $perm_ids = DB::table('permission_users')->where('user_id', '=', $uid)->get();
    $fperm_ids=array();
    if (!$perm_ids->isEmpty()) {
        foreach ($perm_ids as $value) {
            $fperm_ids[]=$value->permission_id;
        }
    }
    return $fperm_ids;
}


function delete_all_permissions_by_uid($uid){
    DB::table('permission_users')->where('user_id', '=', $uid)->delete();
}


function get_quote_info_nanme($id){
    $q=Quote::find($id);
    // $b_name=get_brand_name_by_id($q->brand_id);
    $cname=get_cname_by_id($q->cname_cid);
    $size=get_size_by_id($q->size_cid);
    $m=get_material_by_id($q->material_cid);
    //return $b_name.$cname.$size.$m;
    return $cname.' / '.$size.' / '.$m;
}


//招标方   找出同一公司下的所有uid
function tenderee_get_cuids(){

}


function getDataTree($rows, $id='id',$pid = 'parent_id',$child = 'child',$root=0) {      
        $tree = array(); // 树 
        if(is_array($rows)){
             $array = array();
             foreach ($rows as $key=>$item){
             $array[$item[$id]] =& $rows[$key];
         }
         foreach($rows as $key=>$item){
             $parentId = $item[$pid];
             if($root == $parentId){
                 $tree[] =&$rows[$key];
             }else{
                 if(isset($array[$parentId])){
                     $parent =&$array[$parentId];
                     $parent[$child][]=&$rows[$key];
                 }
             }
         }
     }
     return $tree;
}

function is_json($string) {
  json_decode($string);
  return (json_last_error() == JSON_ERROR_NONE);
 }


 function qlist_to_title($string) {
  $qlist=json_decode($string);
  foreach ($qlist as $key=>$item)
    {
        $s[]=get_cname_by_id($item[0]).','.get_size_by_id($item[1]).','.get_material_by_id($item[2]).','.$item[3].'吨,'.$item[4];
    }

    $result=implode(' / ',$s);

  return $result;
 }

  function qrequest_to_title($string) {
    $qlist=json_decode($string);
    foreach ($qlist as $key=>$item)
        {
            $s[]=qr_id_to_name($item);
        }
        $result=implode(' / ',$s);

    return $result;
 }

 function get_audit_status($bid){
     $user=Auth::user();
     if ($user->hasPermissionTo('录入') && !empty($user->id_parent)) {
         if ($bid->decision_agree) {
             return '已审核';
         } elseif ($bid->review_agree) {
             return '已复核';
         }else {
             return '待复核';
         }
         
     }elseif ($user->hasPermissionTo('复核') && !empty($user->id_parent)) {
         if ($bid->decision_agree) {
             return '已审核';
         }elseif ($bid->review_agree) {
             return '已复核';
         } else {
             return '待复核';
         }
     }elseif ($user->hasPermissionTo('决策') && !empty($user->id_parent)) {
        if ($bid->decision_agree) {
             return '已审核';
         } else {
             return '待审核';
         }
     } else {
         return '已复核';
     }
     
 }

  function get_bidder_audit_status($bid){
     $user=Auth::user();
     $firstq=bidder_get_firstq_by_c_ubid($user->id,$bid);
     if ($user->hasPermissionTo('录入') && !empty($firstq[0])) {
         if ($firstq[0]->decision_agree!=0) {
             return '已审核';
         } elseif ($firstq[0]->review_agree!=0) {
             return '已复核';
         }else {
             return '待复核';
         }
         
     }elseif ($user->hasPermissionTo('复核') && !empty($firstq[0])) {
         if ($firstq[0]->decision_agree!=0) {
             return '已审核';
         }elseif ($firstq[0]->review_agree!=0) {
             return '已复核';
         } else {
             return '待复核';
         }
     }elseif ($user->hasPermissionTo('决策') && !empty($firstq[0])) {
        if ($firstq[0]->decision_agree!=0) {
             return '已审核';
         } else {
             return '待审核';
         }
     } else {
         return '已复核';
     }
     
 }


  function get_tip_step($bid){
    $now=Carbon\Carbon::now()->toDateTimeString();
     if ($now>$bid->bod && $bid->stage==5) {
          return '3';
     }elseif($now>$bid->bid_deadline && $bid->stage>2){
          return '2';
     }else {
         return '1';
     }
     
 }