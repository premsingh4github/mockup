<?php

class DocumentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
		            'title' => 'required',
		            'file' 	=>'required',
		            'version' => 'required'
		           
		        );
		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
		    return Redirect::to('members/create')
		        ->withErrors($validator)
		        ->withInput(Input::except('password'));
		}
		else{

			$file = Input::file('file');
			$filename = Input::file('file')->getClientOriginalName();
			$extension = Input::file('file')->getClientOriginalExtension();
			$path = Input::file('file')->getRealPath();
			$destinationPath = 'uploads';
			$productId = Input::get('productId');		
			$filename = time()."." .$extension;
			$product = Product::find($productId);
			$upload_success = Input::file('file')->move($destinationPath, $filename);
			if( $upload_success ) {
				$image = new Document;
				$image->productId = Input::get('productId');
				$image->title = Input::get('title');
				$image->version = Input::get('version');
				$image->addedBy = Auth::user()->id;
				$image->name = $filename;			
				if($image->save()){
					 Session::flash('message', 'Successfully file uploaded!');
			   		return Redirect::to('projects/'.$product->projectId);
				}
				else{
					 Session::flash('message', 'file  could not uploaded!');
			   		return Redirect::to('projects/'.$product->projectId);
				}

			  
			} else {
			   return Response::json('error', 400);
			}

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
		if($document = Document::find($id)){
			$product = Product::find($document->productId);
			$project = Project::find($product->projectId);		
			$products = Product::where('projectId','=',$project->id)->get();
			$comments = Comment::all();

							return View::make('documents.show')
														->with('project',$project)
														->with('products',$products)
														->with('document',$document)
														->with('comments',$comments);
		}
		else{
			return Redirect::to('');
		}		
		
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$productId = Product::select('projectId')->join('documents','documents.productId','=','products.id')->where('documents.id','=',$id)->take(1)->get();
		foreach ($productId as $value) {}		
		$document = Document::find($id);
		if(unlink("uploads/".$document->name)){
			$document->delete();
			Session::flash('message','Successfully deleted the document!');
			return Redirect::to('projects/'.$value->projectId);
		}
		else{
			Session::flash('message','Sorry  document could not deleted!');
			return Redirect::to('projects/'.$value->projectId);
		}
		//
	}


}
