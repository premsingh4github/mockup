<?php

class TeamController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return Redirect::to('/');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		return Redirect::to('/');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return Redirect::to('/');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		return Redirect::to('/');
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$project = Project::find($id);
		$managers = Member::where('memberType', '=',1)->get();
		$developers = Member::where('memberType', '=',2)->get();
		$designers = Member::where('memberType','=',3)->get();
		$clients = Member::where('memberType','=',4)->get();
		$members = ProjectTeam::where('projectId','=',$id)->first()->get();
		foreach ($members as $member) {
					$team[] = $member->memberId;
				}	
				
		return View::make('admin.teams.create')
						->with('project',$project)
						->with('managers',$managers)
						->with('developers',$developers)
						->with('designers',$designers)
						->with('clients',$clients)
						->with('teams',$team);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		if(count(Input::get('member')) > 0){
			ProjectTeam::where('projectId','=',$id)->delete();	
			$project = Project::find($id);	
			$count = 0;

			foreach(Input::get('member') as $member){
				$team = new ProjectTeam;
				$team->projectId = $id;
				$team->memberId = $member;
				($team->save())? $count++: '' ;
			}
			Session::flash('message', 'Successfully '.$count.' member added to '.$project->name.' Project!');
			return Redirect::to('projects');

		}
		
		Session::flash('message', 'No member is selected! plz select members.');
		return Redirect::to('teams/'.$id.'/edit');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return Redirect::to('/');
	}


}
