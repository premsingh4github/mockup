<?php

class MemberController extends \BaseController {
	
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// get all members
		$members = Member::all();
		//displayArr($members);

		//load the view and pass the members
		return View::make('admin/members/index')->with('members',$members);

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('admin.members.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$rules = array(
		            'name'       => 'required',
		            'email'      => 'required|email|unique:members',
		            'memberType' => 'required|numeric',
		            'password'  => 'required|min:5',
		            'status'   => 'required',
		            'department'=> 'required'
		        );
		        $validator = Validator::make(Input::all(), $rules);

		        // process the login
		        if ($validator->fails()) {
		            return Redirect::to('members/create')
		                ->withErrors($validator)
		                ->withInput(Input::except('password'));
		        } else {
		            // store
		            $member = new Member;
		            $member->name       = Input::get('name');
		            $member->email      = Input::get('email');
		            $member->memberType = Input::get('memberType');
		            $member->password = Hash::make(Input::get('password'));
		            $member->status = Input::get('status');
		            $member->department =Input::get('department');
		            $member->save();

		            // redirect
		            Session::flash('message', 'Successfully created Member!');
		            return Redirect::to('members');
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
		$member = Member::find($id);
		return View::make('admin.members.show')->with('member',$member);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$member = Member::find($id);

        // show the edit form and pass the nerd
        return View::make('admin.members.edit')
            ->with('member', $member);
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
		            'name'       => 'required',
		            'email'      => 'required|email',
		            'memberType' => 'required|numeric',		           
		            'status'   => 'required',
		            'department'=> 'required'
		        );
		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
		    return Redirect::to('members/' . $id . '/edit')
		        ->withErrors($validator);
		} else {
		    // store
		    $member = Member::find($id);
		    $member->name       = Input::get('name');
            $member->email      = Input::get('email');
            $member->memberType = Input::get('memberType');
            if(!(Input::get('password') == '')){
            	$member->password = Hash::make(Input::get('password'));
            }            
            $member->status = Input::get('status');
            $member->department =Input::get('department');
            $member->save();

		    // redirect
		    Session::flash('message', 'Successfully updated Member!');
		    return Redirect::to('members');
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
		$member = Member::find($id);
       $member->delete();
       // redirect
       Session::flash('message', 'Successfully deleted the Member!');
       return Redirect::to('members');
	}


}
