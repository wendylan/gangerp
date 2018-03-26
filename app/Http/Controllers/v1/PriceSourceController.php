<?php
namespace App\Http\Controllers\v1;
use DB;
use Illuminate\Http\Request;
use App\Models\DataModels\DataPriceSource;
class PriceSourceController extends BaseController{
    public $priceSource;
    public function __construct(DataPriceSource $priceSource){
        $this->priceSource = $priceSource;
    }
    public function getAllPriceSource(){
        return DataPriceSource::all();
    }
    public function addPricSourceName(Request $req){
		dd($req->input());
    }
    public function delPriceSourceName(Request $req){
    	$data = $req->input();
    	$priceSource = DataPriceSource::find($data['id']);
    	$priceSource->delete();
    }
    public function editPriceSourceName(Request $req){
    	$data = $req->input();
    	$priceSource = DataPriceSource::find($data['id']);
    	$priceSource->short_name = $data['short_name'];
    	$priceSource->save();
    }
}
