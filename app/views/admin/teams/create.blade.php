@extends('admin.admin')
@section('contain')
	<div class="container">
		<h2>Create Team for  {{$project->name}}</h2>
		<div class="panel panel-primary">
		    <div class="panel-heading">
		   <a style="color:#FFF;decoration:none" >TEAM</a>
		    
		    </div>
		    <div class="panel-body">
		    	@if (Session::has('message'))
		    	    <div class="alert alert-info">{{ Session::get('message') }}</div>
		    	@endif
		    	
		    	{{ HTML::ul($errors->all()) }}

		    	{{ Form::model($project, array('route' => array('teams.update', $project->id), 'method' => 'PUT')) }}
		    	   
		    	
		    	    <div class="form-group">

		    	    	<div class="col-md-4">
		    	    		{{Form::label('projectTeam','Team Member')}}
		    	    	</div>
		    	    	<div class="col-md-8">
			    	    	<div class="col-md-3">
			    	    		<h5>Project Managers</h5>
				    	    	@if(count($managers))
				    	    		@foreach($managers as $manager)
				    	    		<div class="checkbox">
		    	    		          <label><input name="member[]" <?php if(in_array($manager->id,$teams)){ echo 'checked' ; } ?> type="checkbox" value="{{$manager->id}}">{{$manager->name}}</label>
		    	    		        </div>
				    	    		@endforeach
				    	    	@endif
			    	    	</div>
			    	    	<div class="col-md-3">
			    	    		<h5>Programmers</h5>
			    	    		@if(count($developers))
				    	    		@foreach($developers as $developer)
				    	    		<div class="checkbox">
		    	    		          <label><input name="member[]" <?php if(in_array($developer->id,$teams)){ echo 'checked' ; } ?>   type="checkbox" value="{{$developer->id}}">{{$developer->name}}</label>
		    	    		        </div>
				    	    		@endforeach
				    	    	@endif
		    	    		</div>
		    	    		<div class="col-md-3">
		    	    			<h5>Designers</h5>
			    	    		@if(count($designers))
				    	    		@foreach($designers as $designer)
				    	    		<div class="checkbox">
		    	    		          <label><input name="member[]" <?php if(in_array($designer->id,$teams)){ echo 'checked' ; } ?>  type="checkbox" value="{{$designer->id}}">{{$designer->name}}</label>
		    	    		        </div>
				    	    		@endforeach
				    	    	@endif		
		    	    		</div>
		    	    		<div class="col-md-3">
		    	    			<h5>Clients</h5>
			    	    		@if(count($clients))
				    	    		@foreach($clients as $client)
				    	    		<div class="checkbox">
		    	    		          <label><input name="member[]" <?php if(in_array($client->id,$teams)){ echo 'checked' ; } ?> type="checkbox" value="{{$client->id}}">{{$client->name}}</label>
		    	    		        </div>
				    	    		@endforeach
				    	    	@endif	
        
		    	    		</div>

		    	    	
		    	    	</div>
		    	    	
		    	    		

		    	    </div>    	   
		    	    <div class="col-md-12">
		    	    {{ Form::submit('Create the Team!', array('class' => 'btn btn-primary')) }}
		    		</div>
		    	{{ Form::close() }}


		    </div>
		    <!--  -->
		</div>	
		

	<!-- if there are creation errors, they will show here -->

	</div>
	@stop