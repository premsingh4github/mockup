@extends('admin.admin')
@section('contain')
	<div class="container">

	<nav class="nav navbar navbar-inverse">
	    
	    <ul class="nav navbar-nav">
	        <li><a href="{{ URL::to('members') }}">View All Members</a></li>
	        <li><a href="{{ URL::to('members/create') }}">Create a Member</a>
	    </ul>
	</nav>

	<h1>Edit {{$member->name}}</h1>
	<?php
	//displayArr($member); 
	?>

	<!-- if there are creation errors, they will show here -->
	{{ HTML::ul($errors->all()) }}

	
	{{ Form::model($member, array('route' => array('members.update', $member->id), 'method' => 'PUT')) }}

	    <div class="form-group">
	        {{ Form::label('name', 'Name') }}
	        {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
	    </div>

	    <div class="form-group">
	        {{ Form::label('email', 'Email') }}
	        {{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
	    </div>
	    

	    <div class="form-group">
	        {{ Form::label('memberType', 'Member Type') }}
	        {{ Form::select('memberType', array('0' => 'Select a Type', '1' => 'Project Manager', '2' => 'Developer', '3' => 'Designer','4' =>'Client'), Input::old('memberType'), array('class' => 'form-control')) }}
	    </div>	    
	    <div class="form-group">
	        {{ Form::label('department', 'Department') }}
	        {{ Form::select('department', array('0' => 'Select a Department', '1' => 'Survice', '0' => 'Product'), Input::old('department'), array('class' => 'form-control')) }}
	    </div>

	    <div class="form-group">
	        {{ Form::label('status', 'Status') }}
	        {{ Form::select('status', array(' ' => 'Select a Status', '1' => 'Active', '0' => 'Inactive'), Input::old('status'), array('class' => 'form-control')) }}
	    </div>

	    {{ Form::submit('Edit the Member!', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

	</div>
	@stop