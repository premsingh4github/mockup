<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	public function index(){
		if(Auth::check()){
			return View::make('admin/home');
		}
		else{
			return View::make('login');
		}
	}
	public function showWelcome()
	{
		return View::make('hello');
	}
	public function loginCheck()	
	{
		
		$data = Input::only(['username', 'password']);
		

		return Redirect::to((Auth::attempt(['email' => $data['username'], 'password' => $data['password']]))? '/home' : '/');  	 		
		
	}
	public function home(){
		
		return View::make( (Auth::check())? 'admin.home' : '/login');
	}
	public function logout(){

		if(Auth::check()){
		  Auth::logout();
		}		
		 return Redirect::to('/');
	}
	public function addTeam($id){
		die();
		if($project = Project::find($id)){
			return View::make('admin.addTeam')->with('project',$project);
		}
		return Redirect::to('/');
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
	public function  pdf(){
		return View::make('pdf');
	}
	public function addComment(){	
		if(count($_POST['X']) > 0){
			$X = $_POST['X'];
			$Y = $_POST['Y'];
			$P = $_POST['page'];	
			$arg = 0;
				$comment = new Comment;
				$comment->X = implode(",",$X);
				$comment->Y = implode(",",$Y);
				$comment->page = implode(",",$P);
				$comment->documentId = $_POST['documentId'];
				$comment->userId = $_POST['userId'];
				if($comment->save()){
					$arg = 1;
				}
			echo $arg;
		}
		else{
			echo 1;
		}
	}
	public function addComment1(){	
		$_POST = json_decode(file_get_contents("PHP://input"));
		//echo json_encode($_POST);
		$fabric = new Fabric;
		$fabric->obj = file_get_contents("PHP://input");
		$fabric->save();
		echo $fabric->id;
	}
	public function addText(){
		print_r($_POST);
		//die();
	
			$arg = 0;
				$text = new Text;
				$text->X = $_POST['X'];
				$text->Y = $_POST['Y'];
				$text->data = $_POST['data'];
				$text->textId = $_POST['ID'];
				$text->documentId = $_POST['documentId'];
				$text->userId = $_POST['userId'];
				$text->page = $_POST['page'];
				if($text->save()){
					$arg = $text->id;
				}
			echo $arg;
	
	}
	public function showComment($id){		
		$dataX =   Comment::select('X','Y','page')->where('documentId','=',$id)->get();	

		$i= 0 ;
		$commentX = array();
		$commentY = array();
		$commentpage = array();
		foreach($dataX as $data){			
			$commentX = array_merge($commentX, explode(",",$data->X));		
			$commentY= array_merge($commentY, explode(",",$data->Y));
			$commentpage=array_merge($commentpage, explode(",",$data->page));	
		}
		
		//displayArr($commentX);
		//displayArr($commentpage);
		$comment['X'] = $commentX ;
		$comment['Y'] = $commentY ;
		$comment['page'] = $commentpage ;
		echo json_encode($comment);
		
	}
	public function showText($id){
		$data =   Text::select('id','textId','X','Y','data','page')->orderBy('textId', 'ASC')->where('documentId','=',$id)->get();		
		if(count($data) > 0){
			foreach ($data as $value) {
				$commentId[] = $value->id;
				$commentX[] = $value->X;
				$commentY[] = $value->Y;
				$commentData[] = $value->data;
				$commentPage[] = $value->page;			
			}
			$text['Id'] = $commentId ;
			$text['X'] = $commentX;
			$text['Y'] = $commentY;
			$text['data'] = $commentData;
			$text['page'] = $commentPage;
			echo json_encode($text);
		}
		else{
			echo 1;
		}
				
	}
	public function deleteText($id){
		$text = Text::find($id);
		if($text->delete()){
			echo 1;
		}

	}
	public function listDraw($id){
		$data =   Comment::where('documentId','=',$id)->get();
		if(count($data) > 0){
			foreach ($data as $value) {
				$commentId[] = $value->id;
				$commentX[] = $value->X;
				$commentY[] = $value->Y;
				$commentData[] = $value->data;
				$commentPage[] = $value->page;
				$commentUser[] = Member::select('id','name','email')->where('id','=',$value->userId)->get();			
			}
			$text1['Id'] = $commentId ;
			//$text['X'] = $commentX;
			//$text['Y'] = $commentY;
			//$text['data'] = $commentData;
			//$text['page'] = $commentPage;
			$text1['user'] = $commentUser;
			echo json_encode($text1);
		}	
		//echo json_encode($data);
	}
	public function deleteDraw($id){
		$draw = Comment::find($id);
		if($draw->delete()){
			echo 1;
		}
		else{
			echo 0;
		}

	}
}
