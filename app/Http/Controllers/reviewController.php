<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\User;

class reviewController extends Controller
{
    public function getReviewList(){
        $companyInfoList = DB::table('company')->get();
        return view('admin-review')->with('companyInfoList', $companyInfoList);
    }

    public function getReviewData(Request $request){
    	$returnData = DB::table('company')->where('id', '=', $request->fieldId)->get();
    	return response()->json(['data'=>$returnData]);
    }

    public function passReview(Request $request){
    	DB::table('company')
    		->where('id', $request->infoId)
    		->update(['is_review'=>true]);

    	return $this->getReviewList();
    }
}
