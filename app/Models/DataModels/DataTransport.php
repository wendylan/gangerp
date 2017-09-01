<?php

namespace App\Models\DataModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DataModels\DataTransport;

class DataTransport extends Model
{
	// use SoftDeletes;
    //
    protected $table = 'data_transport';
    // protected $dates = ['deleted_at'];
    protected $guarded = [];

    // 获取运费价格
     // @param Array(品牌) String(city) String(area)
    public function scopeGetTransportPrice($query, $brands, $city, $area){
        $result = [];
        foreach ($brands as $key => $value) {
            $tempSql = DataTransport::where('brand', $value)->where('city', $city)->where('area', $area)->get();
            if(count($tempSql) === 0){
                $result[] = ['brand'=>$value, 'data'=>DataTransport::where('type', 1)->where('city', $city)->where('area', $area)->get()];
            }else{
                $result[] = ['brand'=>$value, 'data'=>DataTransport::where('brand', $value)->where('city', $city)->where('area', $area)->get()];
            }
        }
        return $result;
    }

    public function scopeGetBrandsType($query, $brands){
        $transportType = [];
        foreach ($brands as $key => $value) {
            $result = DataTransport::where('brand', $value)->get();
            if(count($result) == 0){
                $transportType[] = ['type'=>1, 'brand'=>$value];
            }else{
                $transportType[] = ['type'=>2, 'brand'=>$value];
            }
        }
        return $transportType;
    }

    public function getFreightByCity($city){
        $freightInfo = DataTransport::where('city',$city)->get();
        return $freightInfo;
    }
}
