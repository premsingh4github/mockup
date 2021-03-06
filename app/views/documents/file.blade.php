@extends('admin.admin')
@section('contain')
 <input type="hidden" value="{{url()}}/uploads/{{$document->name}}" id="documentName" />
 <input type="hidden" value="{{$document->id}}" id="documentId" />
 <input type="hidden" value="{{Auth::user()->id}}" id="userId" />

  <!-- In production, only one script (pdf.js) is necessary -->
  <!-- In production, change the content of PDFJS.workerSrc below -->
  <style type="text/css">
   #box {
  // background-color:black;
   color:white;
  // padding:90px;
   position:absolute;
   display:none;
   font-family:verdana;
   font-size:20px;
   }
      #arrow {
   position:absolute;
   display:none;
   font-family:verdana;
   font-size:20px;
   margin-top: -50px;
   }
   .delete{
    //display: none;
   }
  
   .hidden{
    display: none;

   }
   .visible{
    display: block;
   }
 </style>
 <script type="text/JavaScript">  
  </script>  
  <style type="text/css">   
    .tank .subtank1{     
      z-index: -1;
       position: absolute;
    }
    .commentBody{
      border: solid 1px;
      border-color: green;
    }    
  </style>
  <script src="{{url()}}/js/jquery.min.js" type="text/javascript"></script>
  <script src="{{url()}}/src/shared/util.js"></script>
  <script src="{{url()}}/src/display/api.js"></script>
  <script src="{{url()}}/src/display/font_loader.js"></script>
  <script src="{{url()}}/src/display/canvas.js"></script>
  <script src="{{url()}}/src/display/webgl.js"></script> 
  <script src="{{url()}}/js/fabric.js"></script>
  <script src="{{url()}}/js/jscolor.js"></script>  
  <script>
    PDFJS.workerSrc = '{{url()}}/src/worker_loader.js';
  </script>
  <div style="display:none" id="arrow"><img src="{{url()}}/aa1.png" height="50" width="20"/></div>   
  <div id="box" >
      <TEXTAREA  id="textComment"></TEXTAREA><br>
      <button onClick="textCommentCancel()"  id="textCommentCancel" class="btn btn-danger">Cancel</button>
      <button onClick="textCommentOk()" id="textCommentOk" type="button" class="btn btn-success">Ok</button>

    </div>
<div style="margin-top:-20px">
 <button id="circle" type="button" class="btn btn-default">Circle</button>
 <button id="text" type="button" class="btn btn-default">Text</button>
 <button id ="selectColor" class="btn btn-small" type="button" >color</button>
 <input class="color hidden" id='color'  value="66ff00">

<!--  <button id ="submit" class="btn btn-small btn-success" type="button" >Save</button> -->
  

</div>  
<div>
    <div  style="float:right; width:85%" >
         <div  id ="PDF_container">
            <div class="tank">
              <div style="float:left; width:85%">
                   <div class="subtank1"> 
                    <canvas id="canvas1" >this is canvas</canvas> 
                  </div>
                  <div class="subtank2"> 
                    <canvas id="canvas"  style="">Your browser does not support the HTML5 canvas tag.</canvas>
                  </div>
              </div>
              <div  style="float:right; width:10%">
                comment  box
              </div>
              <div style="clear:both"></div>
            </div>
        </div>
        <div style="clrear:both"></div>
    </div>
    <div style=" float:left; width:15%">
                  <div class="col-sm-12 col-md-12">
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
                                    <a data-toggle="collapse" data-parent="#accordion" >
                                      <span class="glyphicon glyphicon-tasks"></span>
                                      <span id="productName_{{$product->id}}">
                                        {{$productType->name}}
                                      </span>
                                    </a>
                                                           
                                </h4>                      

                            </div>
                            <?php
                            $documents = Document::where('productId','=',$product->id)->get();
                            if(count($documents) > 0){

                              ?>
                              <div id="collapseFour{{$product->id}}" class="panel-collapse collapseFour" >
                                  <div class="panel-body" >
                                      <table class="table" >                      
                              <?php


                              foreach ($documents as $document) {
                                ?>
                                    <tr>
                                        <td>
                                            <span  class="glyphicon glyphicon-file project-file"></span>
                                           <!--  <a  class="project-file" onclick="projectFile({{$document->id}});">{{$document->title}}</a> -->
                                           <a  class="project-file"  href="{{url()}}/document/{{$document->id}}">{{$document->title}}</a>
                                        </td>
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
    </div>
   
  
</div>

{{HTML::script('hello.js')}}
<!-- {{HTML::script('js/draw.js')}} -->
<script type="text/javascript">
var action = 0;
//for selecting color
$('#selectColor').live('click',function(){
  if(this.className == 'btn btn-small'){
     this.className = 'btn btn-small btn-success';
     console.log($('#color').val());
     $('#color').removeClass("hidden");
  }
  else{
    this.className = 'btn btn-small';
    $('#color').addClass("hidden");
  } 
})
/// for fabric js
var x = 1;
$('#circle').live('click',function(){
  if(this.className == 'btn btn-default'){
    this.className = 'btn btn-default btn-success';
    action = "circle"; 
  }
  else{
     this.className = 'btn btn-default';    
  }
  console.log(this.className);
    
});
$('#text').live('click',function(){
  if(this.className == 'btn btn-default'){
    this.className = 'btn btn-default btn-success';
    action = 'text';
  }
  else{
    this.className = 'btn btn-default';
  }
})
$('canvas').live('click',function(e){
  //console.log(e.offsetX);
  switch(action){
    case "circle":
      circle(e.offsetX,e.offsetY);
      break;
    case "text":
      text(e.offsetX,e.offsetY);
      default:
  }

});
</script>
<script type="text/javascript">
function text(offsetX,offsetY){
   var canvas1 = new fabric.Canvas('canvas_1');
   canvas.add(new fabric.IText("I'm in Comic Sans", {fontFamily: 'Comic Sans',left: 100, top: 200}));
}

function circle(offsetX,offsetY){
    var circle = new fabric.Circle({
                       radius: 20, fill: '#'+$('#color').val() , left: (offsetX - 10), top: (offsetY - 10)
                     });
      var canvas = new fabric.Canvas('canvas_1');
       canvas.add(circle);
       action = 0; 
       var circle1 = new fabric.Circle({
                       radius: 20, fill: '#'+$('#color').val() , left: 200, top: 200
                     });
       alert($('#color').val());
      var canvas1 = new fabric.Canvas('canvas_1');
       canvas1.add(circle1);
}
</script>

@stop