@extends('admin.admin')
@section('contain')

	<div class="container">
		<h2>Create a Project</h2>
		<div class="panel panel-primary">
		    <div class="panel-heading">
		   <a style="color:#FFF;decoration:none" href="{{ URL::to('projects') }}">View All Projects </a>
		    <a style="color:#FFF" href="{{ URL::to('projects/create') }}"> Create a Projecs</a>
		</ul>
		    </div>
		    <div class="panel-body">

		    	{{ HTML::ul($errors->all()) }}

		    	{{ Form::open(array('url' => 'projects')) }}

		    	    <div class="form-group">
		    	        <div class="col-md-4 ">
		    	        	{{ Form::label('name', 'Project Name',array('class'=>'')) }}
		    	        </div>
		    	        <div class="col-md-6">
		    	        	{{ Form::text('name', Input::old('name'), array('class' => 'form-control col-md-5')) }}
		    	        </div>
		    	        
		    	    </div>

		    	    <div class="form-group">
		    	        <div class="col-md-4">
		    	        	{{ Form::label('description', 'Project Description') }}
		    	        </div>
		    	        <div class="col-md-6">
		    	        	<textarea name="description" cols= 40 rows=5>
		    	        		{{Input::old('description')}}
		    	        	</textarea>		    	        	
		    	        </div>		    	        
		    	    </div>
		    	    <div class="form-group">
		    	    	<div class="col-md-4">
		    	    		{{ Form::label('startDate', 'Start Date') }}
		    	    	</div>
		    	    	<div class="col-md-6">
		    	    		<div class='input-group date' id='datetimepicker5'>
		    	    							<input id = "startDate" name="startDate" type='text' class="form-control" data-date-format="YYYY/MM/DD"/>
		    	    							<span class="input-group-addon">
		    	    								<span class="glyphicon glyphicon-calendar"></span>
		    	    							</span>
		    	    						</div>
		    	    		
		    	    	</div>
		    	    </div>
		    	    <div class="form-group">
		    	    	<div class="col-md-4">
		    	    		{{ Form::label('finishDate', 'Finish Date') }}
		    	    	</div>
		    	    	<div class="col-md-6">
		    	    		<div class='input-group date' id='datetimepicker5'>
		    	    							<input id="finishDate" name="finishDate" type='text' class="form-control" data-date-format="YYYY/MM/DD"/>
		    	    							<span class="input-group-addon">
		    	    								<span class="glyphicon glyphicon-calendar"></span>
		    	    							</span>
		    	    						</div>
		    	    		
		    	    	</div>
		    	    </div>	
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
		    	    <div class="form-group">
	        	    	    <div class="col-md-4 ">
	        	    	    	{{ Form::label('product', 'Products',array('class'=>'')) }}
	        	    	    </div>

	        	    	    <div class="col-md-6">
			    	    		<div class="checkbox">
			    	    			@if(count($productTypes)>0)
			    	    				@foreach($productTypes as $productType)
			    	    					 <label><input name="productTypes[]" <?php if(in_array($productType->id,$projectProducts)){ echo 'checked' ; } ?>  type="checkbox" value="{{$productType->id}}">{{$productType->name}}</label>
			    	    				@endforeach
			    	    			@endif	    	    		         
	    	    		         
	    	    		        </div>
	    	    		        
	        	    	    </div>

	        	    	    
	        	    	</div>	   	   
		    	    <div class="col-md-12">
		    	    {{ Form::submit('Create the Project!', array('class' => 'btn btn-primary')) }}
		    		</div>
		    	{{ Form::close() }}


		    </div>
		    <!--  -->
		</div>	
		

	<!-- if there are creation errors, they will show here -->

	</div>
	@stop