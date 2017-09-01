<?php namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
//use App\Models\SteelSpec;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Steel_brandsRequest as StoreRequest;
use App\Http\Requests\Steel_brandsRequest as UpdateRequest;
use App\Models\Steel_products;
use DB;

class Steel_brandsCrudController extends CrudController {

	public function __construct() {
        parent::__construct();

        /*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
        $this->crud->setModel("App\Models\Steel_brands");
        $this->crud->setRoute("admin/steel_brands");
        $this->crud->setEntityNameStrings('品牌', '品牌');

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
                        'label' => '品牌名称',
                        'type' => 'text',
                        'placeholder' => '品牌名称'
                    ]);
        $this->crud->addField([// Select2
                        'label' => "所属钢厂",
                        'type' => 'selectf',
                        'name' => 'factory_id', // the db column for the foreign key
                        'entity' => 'factorys', // the method that defines the relationship in your Model
                        'attribute' => 'abbreviation', // foreign key attribute that is shown to user
                        'code'=>'code',
                        'model' => "App\Models\steel_factory" // foreign key model
                    ]);
        $this->crud->addField([    // TEXT
                        'name' => 'code',
                        'label' => '品牌编码',
                        'type' => 'text',
                        'placeholder' => '品牌编码'
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
                                'label' => '品牌名称',
                            ]);
        $this->crud->addColumn([
                                'name' => 'code',
                                'label' => "编码"
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

        $allspec=\App\Models\SteelSpec::all();
        foreach ($allspec as $ak=>$av){
            $this->data['specs'][$ak]['id']=$av->id;
            $this->data['specs'][$ak]['name']=$av->name;
            // $this->data['specs'][$ak]['value']=json_decode($av->value);
             $this->data['specs'][$ak]['value']=$av->value;
        }
        // dd($this->data['specs']);

        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('crud::createBrands', $this->data);
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
        $this->data['title'] = '品牌编辑';

        $this->data['id'] = $id;

        $allspec=\App\Models\SteelSpec::all();
        $products=Steel_products::where('bid', $id)->get();
        $this->data['products'] = $products;
        foreach ($allspec as $ak=>$av){
            $this->data['specs'][$ak]['id']=$av->id;
            $this->data['specs'][$ak]['name']=$av->name;
            $this->data['specs'][$ak]['value']=$av->value;
        }
        // dd($this->data);
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        return view('crud::editBrands', $this->data);
    }

	public function store(StoreRequest $request)
	{
	    //dd($request->all());
        $this->crud->hasAccessOrFail('create');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        //dd($this);
        $this->crud->model->name=$request->name;
        $this->crud->model->factory_id=$request->factory_id;
        $this->crud->model->code=$request->code;
        $this->crud->model->svids=$request->svids;
        $this->crud->model->save();
        //dd($this->crud->model);
        $product=new Steel_products();
        $productcodes=$request->productcode;
        if (!empty($productcodes)) {
            foreach ($productcodes as $key => $value) {
                if (!empty($value)) {
                      $aproducts[$key]['bid']=$this->crud->model->id;
                      $aproducts[$key]['steel_code']=$value;
                      $aproducts[$key]['brand']=$request->brand[$key];
                      $aproducts[$key]['cate_spec']=$request->cate_spec[$key];
                      $aproducts[$key]['size']=$request->size[$key];
                      $aproducts[$key]['material']=$request->material[$key];
                      $aproducts[$key]['spec_key']=$request->specs[$key];
                      $aproducts[$key]['created_at']=date('Y-m-d H:i:s');
                      $aproducts[$key]['updated_at']=date('Y-m-d H:i:s');
                      
                }
            }
        }

        $product->insert($aproducts);
 


        //return parent::storeCrud();
	}

	public function update(UpdateRequest $request)
	{
		 $this->crud->hasAccessOrFail('update');

        // fallback to global request instance
        if (is_null($request)) {
            $request = \Request::instance();
        }

        $bproducts=get_products_by_brandid($request->id);
        $productcodes=$request->productcode;
        if (!empty($productcodes)) {
            foreach ($productcodes as $key => $value) {
                if (!empty($value)) {
                      $aproducts[$key]['bid']=$request->id;
                      $aproducts[$key]['steel_code']=$value;
                      $aproducts[$key]['brand']=$request->brand[$key];
                      $aproducts[$key]['cate_spec']=$request->cate_spec[$key];
                      $aproducts[$key]['size']=$request->size[$key];
                      $aproducts[$key]['material']=$request->material[$key];
                      $aproducts[$key]['spec_key']=$request->specs[$key];
                }
            }
        }

        if (!empty($bproducts)) {
            foreach ($bproducts as $key => $value) {
                if (!empty($value)) {
                      $old_steel_code[]=$value->steel_code;
                }
            }
        }

        //  print_r($productcodes);print_r($old_steel_code); exit;
        
        $result=array_diff_assoc($old_steel_code,$productcodes);
        $result2=array_diff_assoc($productcodes,$old_steel_code);
        if (!empty($result)) {
            foreach ($result as $dk => $dv) {
                DB::table('steel_products')->where('steel_code', '=', $dv)->delete();
            }
        }
        if (!empty($result2)) {
            foreach ($result2 as $ak => $av) {
                 $product=new Steel_products();
                 $product->insert($aproducts[$ak]);
            }
           
        }
        
        // print_r($result);print_r($result2);exit;
        // dd($result);

        if ($this->crud->model->id==$request->id) {
                $this->crud->model->svids=$request->svids;
                $this->crud->model->save();
        }


        // update the row in the db
        $this->crud->update($request->get($this->crud->model->getKeyName()),
                            $request->except('redirect_after_save', '_token'));

        // show a success message
        \Alert::success(trans('backpack::crud.update_success'))->flash();

        return \Redirect::to($this->crud->route);
	}
}
