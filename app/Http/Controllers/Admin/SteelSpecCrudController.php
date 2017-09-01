<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\SteelSpecRequest as StoreRequest;
use App\Http\Requests\SteelSpecRequest as UpdateRequest;
use App\Models\SteelSpec;
use DB;

class SteelSpecCrudController extends CrudController {

	public function __construct() {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\SteelSpec");
        $this->crud->setRoute("admin/steelspec");
        $this->crud->setEntityNameStrings('规格', '钢材规格');

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/

		//$this->crud->setFromDb();

		// ------ CRUD FIELDS
        // $this->crud->addField($options, 'update/create/both');
        // $this->crud->addFields($array_of_arrays, 'update/create/both');
        // $this->crud->removeField('name', 'update/create/both');
        // $this->crud->removeFields($array_of_names, 'update/create/both');
        $this->crud->addField([    // TEXT
            'name' => 'name',
            'label' => '钢铁属性名称',
            'type' => 'text',
            'placeholder' => '钢铁属性名称'
        ]);

        // ------ CRUD COLUMNS
        // $this->crud->addColumn(); // add a single column, at the end of the stack
        // $this->crud->addColumns(); // add multiple columns, at the end of the stack
        // $this->crud->removeColumn('column_name'); // remove a column from the stack
        // $this->crud->removeColumns(['column_name_1', 'column_name_2']); // remove an array of columns from the stack
        // $this->crud->setColumnDetails('column_name', ['attribute' => 'value']);
        // $this->crud->setColumnsDetails(['column_1', 'column_2'], ['attribute' => 'value']);
        $this->crud->addColumn([
            'name' => 'id',
            'label' => 'id',
        ]);
        $this->crud->addColumn([
            'name' => 'name',
            'label' => '钢铁属性名称',
        ]);
        // ------ CRUD ACCESS
        // $this->crud->allowAccess(['list', 'create', 'update', 'reorder', 'delete']);
        // $this->crud->denyAccess(['list', 'create', 'update', 'reorder', 'delete']);

        // ------ CRUD REORDER
        // $this->crud->enableReorder('label_name', MAX_TREE_LEVEL);
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('reorder');

        // ------ CRUD DETAILS ROW
        // $this->crud->enableDetailsRow();
        // NOTE: you also need to do allow access to the right users: $this->crud->allowAccess('details_row');
        // NOTE: you also need to do overwrite the showDetailsRow($id) method in your EntityCrudController to show whatever you'd like in the details row OR overwrite the views/backpack/crud/details_row.blade.php

        // ------ AJAX TABLE VIEW
        // Please note the drawbacks of this though: 
        // - 1-n and n-n columns are not searchable
        // - date and datetime columns won't be sortable anymore
        // $this->crud->enableAjaxTable(); 

        // ------ ADVANCED QUERIES
        // $this->crud->addClause('active');
        // $this->crud->addClause('type', 'car');
        // $this->crud->addClause('where', 'name', '==', 'car');
        // $this->crud->addClause('whereName', 'car');
        // $this->crud->addClause('whereHas', 'posts', function($query) {
        //     $query->activePosts();
        // });
        // $this->crud->orderBy();
        // $this->crud->groupBy();
        // $this->crud->limit();
    }

    public function create()
    {
        $this->crud->hasAccessOrFail('create');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['fields'] = $this->crud->getCreateFields();
        $this->data['title'] = trans('backpack::crud.add').' '.$this->crud->entity_name;


        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('crud::createSteelSpec', $this->data);
    }

    public function test(){
//        $this->crud->hasAccessOrFail('test');
        echo "xxxx";
        $ss = \App\Models\SteelSpec::find(1)->specvalues;
        foreach ($ss as $value){
            print_r($value);
            echo $value->name;
        }
       // print_r($ss);
    }


    public function storeSpecs(StoreRequest $request = null)
    {
        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        // insert item in the db
        //$item = $this->crud->create($request->except(['redirect_after_save', 'password']));
        $name=$request->input('name');
        $item = $this->crud->model->create([
            'name' =>$name,
        ]);

        $spec_value_name = $request->input('value');
        $spec_value_code = $request->input('code');
        $num=count($spec_value_name);
        for ($i=0;$i<=$num;$i++){
            if (!empty($spec_value_name[$i])){
                $specvalues[$spec_value_name[$i]]=$spec_value_code[$i];
            }
        }
        foreach ($specvalues as $k=>$v){
            $item->specvalues()->create([
            'spec_id' => $item->id,
            'name' => $k,
            'code' => $v
        ]);
        }
        $get_spec_values=$this->crud->model->find($item->id)->specvalues;
        foreach ($get_spec_values as $sv){
            $ssvalues[]=$sv->toArray();
        }
        $item->value=$ssvalues;
        $item->save();

        // show a success message
        \Alert::success(trans('backpack::crud.insert_success'))->flash();

        // redirect the user where he chose to be redirected
        switch ($request->input('redirect_after_save')) {
            case 'current_item_edit':
                return \Redirect::to($this->crud->route.'/'.$item->getKey().'/edit');

            default:
                return \Redirect::to($request->input('redirect_after_save'));
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->crud->hasAccessOrFail('update');

        // get the info for that entry
        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;

        $this->data['spec_values']= $this->crud->model->find($id)->specvalues;
        // dd($spec_values);

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('crud::editSteelSpec', $this->data);
    }



	public function store(StoreRequest $request)
	{
		return self::storeSpecs($request);
	}

	public function update(UpdateRequest $request)
	{
		$this->crud->hasAccessOrFail('update');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        $id=$request->id;
        foreach ($request->svid as $key => $value) {
            if (!empty($value)) {
                DB::table('steel_products_spec_value')
                ->where('id', $value)
                ->update(['name' => $request->svname[$key],'code' => $request->svcode[$key]]);
            } else {
                DB::table('steel_products_spec_value')->insert(
                    ['spec_id' => $id, 'name' => $request->svname[$key],'code' => $request->svcode[$key]]
                );
            }
            
        }

        $svalues=$this->crud->model->find($id)->specvalues;
        // dd($svalues);
        if (!empty($svalues)) {
            foreach ($svalues as $k => $specval) {
                $tmpvalues[$k]['id']=$specval->id;
                $tmpvalues[$k]['spec_id']=$specval->spec_id;
                $tmpvalues[$k]['name']=$specval->name;
                $tmpvalues[$k]['code']=$specval->code;
                $tmpvalues[$k]['sort']=$k;
            }
        }

        $spec=$this->crud->model->find($id);
        $spec->value=$tmpvalues;
        $spec->save();
        //存新的specvalue
        // $nsvs=array();
        // if (!empty($request->new_svname)) {
        //     foreach ($request->new_svname as $nk => $nv) {
        //         $nsvs[$nk]['spec_id']=$id;
        //         $nsvs[$nk]['name']=$nv;
        //         $nsvs[$nk]['code']=$request->new_svcode[$nk];

        //         DB::transaction(function ($nsvs,$nk,$id) {
        //         $nsvs[$nk]['id']=DB::table('steel_products_spec_value')->insertGetId($nsvs[$nk]);
        //         $ssp=SteelSpec::find($id);
        //         $ssp_value=$ssp->value;
        //         array_push($ssp_value,$nsvs[$nk]);
        //         $ssp->value=$ssp_value;
        //         $ssp->save();
        //         });

        //     }
            
            
        // }


        

        // dd($request);

        // update the row in the db
        $this->crud->update($request->get($this->crud->model->getKeyName()),
                            $request->except('redirect_after_save'));

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        return \Redirect::to($this->crud->route);
	}
}
