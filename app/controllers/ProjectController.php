<?php

class ProjectController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$projects = Project::all();		
		return View::make('admin/projects/index')->with('projects',$projects);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if(Auth::user()->memberType > 1){
				return Redirect::to('/');
		}

		$managers = Member::where('memberType', '=',1)->get();
		$developers = Member::where('memberType', '=',2)->get();
		$designers = Member::where('memberType','=',3)->get();
		$clients = Member::where('memberType','=',4)->get();
		$productTypes = ProductType::all();
		$teams = array();
		$projectProducts = array();
		return View::make('admin.projects.create')
						->with('managers',$managers)
						->with('developers',$developers)
						->with('designers',$designers)
						->with('clients',$clients)
						->with('teams',$teams)
						->with('productTypes',$productTypes)
						->with('projectProducts',$projectProducts);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		
		$rules = array(
		            'name'       => 'required|unique:projects'
		           
		        );
		        $validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails()) {
		            return Redirect::to('projects/create')
		                ->withErrors($validator);
		        } else {
		            // store
		            $project = new Project;
		            $project->name = Input::get('name');
		            $project->description = Input::get('description');
		            $project->status = '1';
		            $project->startDate = Input::get('startDate');
		            $project->finishDate = Input::get('finishDate');
		            $project->createdBy = Auth::user()->id;
		            $project->name       = Input::get('name');
		            $message = '';	
		            if($project->save()){
				            	$pro = Project::where('name','=',$project->name)->take(1)->get();
				            	foreach ($pro as $project) {}
				            	if(count(Input::get('member')) > 0){
				            		ProjectTeam::where('projectId','=', $project->id)->delete();		            		            	
				            		$countM = 0;
				            		foreach(Input::get('member') as $member){
				            			$team = new ProjectTeam;
				            			$team->projectId = $project->id;
				            			$team->memberId = $member;
				            			($team->save())? $countM++: '' ;
				            		}
				            		$message =  "<br>".$countM ." member added to " . $project->name . " Project!";
				            	}
				            	if(count(Input::get('productTypes')) > 0){
				            		$countP = 0;				            		
				            		Product::where('projectId','=', $project->id)->delete();
				            		foreach(Input::get('productTypes') as $productType){
				            			$product = new Product;
				            			$product->projectId = $project->id;
				            			$product->productTypeid = $productType;
				            			($product->save())? $countP++: '' ;
				            		}
				            		$message = $message . "<br>".$countP ." Product added to " . $project->name . " Project!";
				            	}		            		
				

				            }

		            Session::flash('message', 'Successfully created Project!'.$message);
		            return Redirect::to('projects');
		           
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
		
		$products = Product::where('projectId','=',$id)->get();
		$project = Project::find($id);
		$managers = Member::where('memberType', '=',1)->get();
		$developers = Member::where('memberType', '=',2)->get();
		$designers = Member::where('memberType','=',3)->get();
		$clients = Member::where('memberType','=',4)->get();
		$members = ProjectTeam::where('projectId','=',$id)->get();
		$products = Product::where('projectId','=',$id)->get();
		$projectProducts = array();
		foreach ($products as $product) {
			$projectProducts[] = $product->productTypeId;
		}
		$productTypes = ProductType::all();
		$version ;
		$team = array();
		foreach ($members as $member) {
					$team[] = $member->memberId;
				}
		return View::make('admin.projects.show')
						->with('project',$project)
						->with('products',$products)
						->with('managers',$managers)
						->with('developers',$developers)
						->with('designers',$designers)
						->with('clients',$clients)
						->with('teams',$team)
						->with('productTypes',$productTypes)
						->with('projectProducts',$projectProducts);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		if(Auth::user()->memberType > 1){
				return Redirect::to('/');
		}
		$project = Project::find($id);
		$managers = Member::where('memberType', '=',1)->get();
		$developers = Member::where('memberType', '=',2)->get();
		$designers = Member::where('memberType','=',3)->get();
		$clients = Member::where('memberType','=',4)->get();
		$members = ProjectTeam::where('projectId','=',$id)->get();
		$products = Product::where('projectId','=',$id)->get();
		$projectProducts = array();
		foreach ($products as $product) {
			$projectProducts[] = $product->productTypeId;
		}
		$productTypes = ProductType::all();
		$team = array();
		foreach ($members as $member) {
					$team[] = $member->memberId;
				}
		return View::make('admin.projects.edit')
						->with('project',$project)
						->with('managers',$managers)
						->with('developers',$developers)
						->with('designers',$designers)
						->with('clients',$clients)
						->with('teams',$team)
						->with('productTypes',$productTypes)
						->with('projectProducts',$projectProducts);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$rules = array(
				            'name'       => 'required|unique:projects,name,'.$id
				           
				        );
				        $validator = Validator::make(Input::all(), $rules);
				
				if ($validator->fails()) {
				            return Redirect::to('projects/'.$id.'/edit')
				                ->withErrors($validator);
				        } else {
				            // store
				            $project = Project::find($id);
				            $project->name = Input::get('name');
				            $project->description = Input::get('description');
				            $project->status = '1';
				            $project->startDate = Input::get('startDate');
				            $project->finishDate = Input::get('finishDate');
				            $message = '';				           
				            if($project->save()){
				            	$pro = Project::where('name','=',$project->name)->take(1)->get();
				            	foreach ($pro as $project) {}
				            	if(count(Input::get('member')) > 0){
				            		ProjectTeam::where('projectId','=', $project->id)->delete();		            		            	
				            		$countM = 0;
				            		foreach(Input::get('member') as $member){
				            			$team = new ProjectTeam;
				            			$team->projectId = $project->id;
				            			$team->memberId = $member;
				            			($team->save())? $countM++: '' ;
				            		}
				            		$message =  "<br>".$countM ." member added to " . $project->name . " Project!";
				            	}
				            	if(count(Input::get('productTypes')) > 0){
				            		$countP = 0;				            		
				            		Product::where('projectId','=', $project->id)->delete();
				            		foreach(Input::get('productTypes') as $productType){
				            			$product = new Product;
				            			$product->projectId = $project->id;
				            			$product->productTypeid = $productType;
				            			($product->save())? $countP++: '' ;
				            		}
				            		$message = $message . "<br>".$countP ." Product added to " . $project->name . " Project!";
				            	}		            		
				

				            }

				            Session::flash('message', 'Successfully Updated Project!'.$message);
				            return Redirect::to('projects');
				            //echo "prem";
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
		$project = Project::find($id);
		$project->delete();
		Session::flash('message','Successfully deleted the Project!');
		return Redirect::to('projects');
	}
	public function fileUpload(){		
		$file = Input::file('file');
		$filename = Input::file('file')->getClientOriginalName();
		$extension = Input::file('file')->getClientOriginalExtension();
		$path = Input::file('file')->getRealPath();
		$destinationPath = 'uploads';
		$productId = Input::get('productId');		
		$filename = time()."." .$extension;		
		$upload_success = Input::file('file')->move($destinationPath, $filename);
		if( $upload_success ) {
			$image = new File;
			$image->productId = Input::get('productId');
			$image->title = Input::get('title');
			$image->name = $filename;
			displayArr($image);
			die();
			if($image->save()){
				 Session::flash('message', 'Successfully file uploaded!');
		   		return Redirect::to('projects/23');
			}
			else{
				 Session::flash('message', 'file  could not uploaded!');
		   		return Redirect::to('projects/23');
			}

		  
		} else {
		   return Response::json('error', 400);
		}

	}
	


}
