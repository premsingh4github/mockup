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
	                 }
	                  ?>
	 				@endif 
	                </div>
	            </div>
	        </div>
	        
	        <div class="col-sm-10 col-md-10" id="body">
	        	<div id ="document">

	        		@include('pdf'); 
	        	</div>
	        	@if (Session::has('message'))
	        	    <div class="alert alert-info">{{ Session::get('message') }}</div>
	        	@endif
	        	<div id="addFile" style="display:none;" class="col-md-8">
	        			<h1>{{$project->name}}</h1>
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
	        			         	    	  {{ Form::label('file','File',array('id'=>'','class'=>'')) }}
	        			         	    </div>
	        			         	    <div class="col-md-6">
	        			         	    	 {{ Form::file('files',array('class'=>'file','required')) }}
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
	        			
	        	</div>

	                                   
	          

	        </div>
	    </div>
	   <!--  <script src="//code.jquery.com/jquery-1.10.2.js"></script> -->
	    
	
@stop
