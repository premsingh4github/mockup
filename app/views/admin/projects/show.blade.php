@extends('admin.admin')
@section('contain')

	    <div class="row">
	        <div class="col-sm-2 col-md-2">
	            <div class="panel-group" id="accordion">
	                <div class="panel panel-default">
	                    <div class="panel-heading">
	                        <h4 class="panel-title">
	                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
	                            </span>{{$project->name}}</a>
	                        </h4>
	                    </div>
	                    
	                </div>

	                <div class="panel panel-default">

	                </div>
	                <div class="panel panel-default">	                	
	                 @if(count($products) > 0)
	                 <?php
	                 foreach($products as $product){	                 	
	                 	$productType = ProductType::find($product->productTypeId);
	                 	?>
	                 	<div class="panel-heading">
                		    <h4 class="panel-title">
                		        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour{{$product->id}}">
                		        	<span class="glyphicon glyphicon-tasks"></span>
                		        	<span id="productName_{{$product->id}}">
                		        		{{$productType->name}}
                		        	</span>
                		        </a>
                		        @if(Auth::user()->memberType < 4)
                		        <a onclick="addFile({{$product->id}})">Add File</a>	 
                		        @endif               		        
                		    </h4>                		   

                		</div>
                		<?php
                		$documents = Document::where('productId','=',$product->id)->orderBy('version','ASC')->get();
                		$version = "";
                		if(count($documents) > 0){

                			?>
                			<div id="collapseFour{{$product->id}}" class="panel-collapse collapseFour" >
                			    <div class="panel-body" >
                			        <table class="table" >
                			        
                			                 			
                			<?php                			
                			foreach ($documents as $document) {
                				if($version != $document->version){
                					?>
                					<tr>
                			        	<td><span  class="glyphicon glyphicon-fire">version</span>{{$document->version}}   </td>
                			        </tr> 
                					<?php
                					$version = $document->version;
                				}
                			?>
                						<tr>
                						    <td>
                						        <span  class="glyphicon glyphicon-file project-file"></span>
                						       <!--  <a  class="project-file" onclick="projectFile({{$document->id}});">{{$document->title}}</a> -->
                						       <a  class="project-file"  href="{{url()}}/document/{{$document->id}}">{{$document->title}}</a>
                						    </td>
                						    @if($document->addedBy == Auth::user()->id)
                						    <td>
                						       <!--   -->
                						       <!--  <a  class="project-file" onclick="projectFile({{$document->id}});">{{$document->title}}</a> -->
                						       <a  class="project-file"  href="{{url()}}/document/destroy/{{$document->id}}"><span  class="glyphicon glyphicon-trash project-file"></span></a>

                						    </td>
                						    @endif
                						</tr>


                				<?php
                			}
                			?>
                			        </table>
                			    </div>
                			</div>

                			<?php
                		}	 
                		?>
	                 	<?php
	                 }
	                  ?>
	 				@endif 
	                </div>
	            </div>
	        </div>
	        <div class="col-sm-10 col-md-10" id="body">
	        	<div id ="document">
	        		
	        	</div>

	        	@if (Session::has('message'))
	        	    <div class="alert alert-info">{{ Session::get('message') }}</div>
	        	@endif
	        	<h2>{{$project->name}}</h2>
	        	<div id="addFile" style="display:none;" class="col-md-8">
	        			
	        			 <div class="panel panel-primary ">
	        			         <div class="panel-heading">
	        			        	<span id ="project-file"></span>
	        			                
	        			             </ul>
	        			         </div>
	        			         <div class="panel-body">
	        			         	{{ Form::open(array('url'=>'file-submit','files'=>true)) }}
	        			         	 {{ Form::hidden('productId', ' ', array('id' => 'productId')) }}
	        			         	<div class="form-group">
	        			         	    <div class="col-md-6 ">
	        			         	    	 {{ Form::label('title','Title',array('id'=>'','class'=>'')) }}
	        			         	    </div>
	        			         	    <div class="col-md-6">
	        			         	    	{{ Form::text('title','',array('id'=>'','class'=>'','required')) }}
	        			         	    </div>
	        			         	    
	        			         	</div>
	        			         	<div class="form-group">
	        			         	    <div class="col-md-6 ">
	        			         	    	 {{ Form::label('version','Version',array('id'=>'','class'=>'')) }}
	        			         	    </div>
	        			         	    <div class="col-md-6">
	        			         	    	{{ Form::text('version','',array('id'=>'','class'=>'','required')) }}
	        			         	    </div>
	        			         	    
	        			         	</div>
	        			         	<div class="form-group">
	        			         	    <div class="col-md-6 ">
	        			         	    	  {{ Form::label('file','File',array('id'=>'','class'=>'','required')) }}
	        			         	    </div>
	        			         	    <div class="col-md-6">
	        			         	    	 {{ Form::file('file',array('id'=>'','class'=>'','required')) }}
	        			         	    </div>
	        			         	    
	        			         	</div>
	        			         	<div class="form-group">
	        			         	    <div class="col-md-4 ">
	        			         	    	  {{ Form::submit('Save') }}
	        			         	    	   {{ Form::reset('Reset') }}
	        			         	    </div>
	        			         	    <div class="col-md-6">	        			         	   
	        			         	    </div>
	        			         	    
	        			         	</div>	        			         	 
	        			         	 {{ Form::close() }}
	        			         </div>
	        			     </div>
	        			     <div class="clear"></div>	        			
	        			
	        	</div>

	            <div class="col-sm-10 col-md-10">

	            			
	            			


	            			<div class="panel panel-primary">
	            			    <div class="panel-heading">
	            			   <a style="color:#FFF;decoration:none" href="{{ URL::to('projects') }}">View All Projects </a>
	            			    <a style="color:#FFF" href="{{ URL::to('projects/create') }}"> Create a Projecs</a>
	            			</ul>
	            			    </div>
	            			
	            			 
	            			    <div class="panel-body">
	            			    

	            			    	
	            			    	{{ Form::model($project, array('route' => array('projects.update', $project->id), 'method' => 'PUT')) }}	    	

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
	            			    	        		{{$project->description}}
	            			    	        	</textarea>		    	        	
	            			    	        </div>		    	        
	            			    	    </div>
	            			    	    <div class="form-group">
	            			    	    	<div class="col-md-4">
	            			    	    		{{ Form::label('startDate', 'Start Date') }}
	            			    	    	</div>
	            			    	    	<div class="col-md-6">
	            			    	    		<div class='input-group date' id='datetimepicker5'>
	            			    	    							<input name="startDate" type='text' value="{{$project->startDate}}" class="form-control" data-date-format="YYYY/MM/DD"/>
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
	            			    	    							<input name="finishDate" type='text'  value="{{$project->finishDate}}" class="form-control" data-date-format="YYYY/MM/DD"/>
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

	            			    	    <div class="col-md-6">
	            			    	    
	            			    		</div>
	            			    


	            			    </div> 
	            			    <!--  -->
	            		
	            			

	            		<!-- if there are creation errors, they will show here -->

	            		</div>
	            </div>                       
	          

	        </div>
	    </div>
	   <!--  <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
	    <script type="text/javascript">
	    	function addFile(productId){   		
	    		var text = document.getElementById("productName_"+productId).innerHTML ;
	    		document.getElementById("project-file").innerHTML = text;	    		
	    		document.getElementById("productId").value = productId;
	    		document.getElementById("addFile").style.display = "block";	    			
	    	}
	    </script>
	
@stop
