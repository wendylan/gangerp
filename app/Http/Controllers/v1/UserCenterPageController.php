<?php
namespace App\Http\Controllers\v1;
use DB;
use Auth;
use Illuminate\Http\Request;
use App\Models\DataModels\DataProject;
use App\Models\DataModels\DataUserOrders;
use App\Http\Controllers\v1\DataProjectController;

class UserCenterPageController extends DataProjectController{

    protected $project;
    protected $order;

    public function __construct(DataUserOrders $dataUserOrders){
        $this->order = $dataUserOrders;
    }

    public function index(){
        return view('SteelData/UserCenter');
    }

    public function init(){
        $projectArr = parent::getUserProject();
        $orderArr = $this->order->getUserOrder(Auth::id())->toArray();
        foreach ($orderArr as $key => $value) {
            foreach ($projectArr as $index => $val) {
                if($value['project_id'] == $val['project_info_id']){
                    $orderArr[$key]['projectInfo'] = $val;
                }
            }
        }
        return $this->responseBuild(['projectDatas'=>$projectArr?$projectArr:'该账户没有任何可选项目', 'orderDatas'=>$orderArr]);
    }

    public function editProject(Request $Request){
        $reqDatas = $Request->all();
        if(parent::edit($reqDatas)){
            return $this->responseBuild(null, '修改成功');
        }else{
            return $this->response->error('操作失败', 500);
        }
    }

    public function delProject(Request $Request){
        if(parent::delete($Request->id)){
            return $this->responseBuild(null, '删除成功');
        }else{
            return $this->response->error('操作失败', 500);
        }
    }

    public function changesProjectContact(Request $Request){
        $result = parent::changesContact($Request->input('projectId'), $Request->input('targetId'));
        if($result){
            $projectId = DataProject::find($Request->input('projectId'))->get();
            return array('data'=>parent::getUserProject(),'message'=>'success','status_code'=>200);
        }else{
            return $this->response->error('操作无效', 500);
        }
    }

    public function cancelProjectContact(Request $Request){
        $result = parent::cancelContact($Request->input('projectId'), $Request->input('targetId'));
        if($result){
            return array('data'=>parent::getUserProject(),'message'=>'success','status_code'=>200);
        }else{
            return $this->response->error('操作无效', 500);
        }
    }

}
