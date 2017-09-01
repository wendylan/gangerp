<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/9
 * Time: 17:39
 */
namespace App\Http\Controllers;

//use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Models\Steel_brands;
use App\project;
use Validator;
use Auth;
use Redirect;

class ProjectsController extends BaseController {
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        // get all the projects
        $projects = Bid::all();
        // load the view and pass the projects
        return View::make('projects.index')
            ->with('projects', $projects);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

        $brands=Steel_brands::all();
        $q_request=explode(',',\Config::get('settings.q_request'));
        $pay_type=explode(',',\Config::get('settings.pay_type'));
        //dd($q_request);
        // load the create form (app/views/projects/create.blade.php)
        // return View('projects.create')->with('brands', $brands);
        return view('projects.create', ['brands' =>  $brands,'q_request' =>  $q_request,'pay_type' =>  $pay_type]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //dd($request);
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name'       => 'required',
            // 'email'      => 'required|email',
            // 'nerd_level' => 'required|numeric'
        );
        $validator = Validator::make($request->all(), $rules);
        // process the login
        if ($validator->fails()) {
            return Redirect::to('projects/create')
                ->withErrors($validator);
        } else {
            // store
            $project = new project;
            $project->name       = $request->name;
            $project->user_id       = Auth::id();
            $project->province      = $request->s_province;
            $project->city      = $request->s_city;
            $project->area = $request->s_county;
            $project->add = $request->add;
            $project->brands = implode(',',$request->brands);
            $project->m_name = $request->m_name;
            $project->c_type = $request->c_type;
            $project->amount = $request->amount;
            $project->quote_request = implode(',',$request->q_request);
            $project->settlement = $request->settlement;
            $project->paytype = $request->paytype;
            $project->save();
            // redirect
            //Session::flash('message', 'Successfully created nerd!');
            return redirect('tenderee/projects');
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
        $nerd = Bid::find($id);
        // show the view and pass the nerd to it
        return View::make('projects.show')
            ->with('nerd', $nerd);
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
        return View::make('projects.edit')
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
            return Redirect::to('projects/' . $id . '/edit')
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
            return Redirect::to('projects');
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
        return Redirect::to('projects');
    }

    public function getProjectData($id){
        $userId = Auth::id();
        $returnData = Project::where('user_id', $userId)->where('id', $id)->get();
        $brandsId = explode(',', $returnData[0]->brands);
        $brandsName = "";
        foreach ($brandsId as $value) {
            $brandsName .= get_brand_name_by_id($value).',';
        }
        $returnData[0]->brands = $brandsName;
        return response()->json(['data'=>$returnData]);
    }

    public function getEditProjectData($id){
        $userId = Auth::id();
        $brandsRange = Steel_brands::all();
        $returnData = Project::where('user_id', $userId)->where('id', $id)->get();
        $returnData[] = $brandsRange;

        $brandsId = explode(',', $returnData[0]->brands);
        $brandsName = array();
        $count = 0;
        foreach ($brandsId as $value) {
            $brandsName[] = ['name'=>get_brand_name_by_id($value), 'value'=>$brandsId[$count]];
            $count++;
        }
        // dd($brandsName);
        $returnData[] = $brandsName;
        return response()->json(['data'=>$returnData]);
    }

    public function getEditProjectFormData(Request $request){
        $userId = Auth::id();
        $projectId = $request->id;
        $brands = '';
        $count = 0;

        foreach ($request->brands_range as $value) {
            if($count == count($request->brands_range)-1){
                $brands .= $value;
            }else{
                $brands .= $value.',';
            }
            $count++;
        }
        
        $quote_request = '';
        for($i=0; $i<count($request->requirement); $i++){
            if( $i != count($request->requirement)-1){
                $quote_request .= $request->requirement[$i].',';
            }else{
                $quote_request .= $request->requirement[$i];
            }
        }
        $returnData = Project::where('user_id', $userId)
                                ->where('id', $projectId)
         ->update(['name'=>$request->project_name, "province"=>$request->province, "city"=>$request->city, "area"=>$request->area, 'add'=>$request->address, 'brands'=>$brands, "m_name"=>$request->brands_name, 'c_type'=>$request['measure-methods'], 'quote_request'=>$quote_request]);
        if($returnData){
            return Redirect::to('tenderee/projects');
        }else{
            return false;
        }
        
    }
}