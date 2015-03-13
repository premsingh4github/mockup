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
  // color:white;
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
  <script>
    PDFJS.workerSrc = '{{url()}}/src/worker_loader.js';
  </script>
  <div id="canvas"></div>
  <div style="display:none" id="arrow"><img src="{{url()}}/aa1.png" height="50" width="20"/></div>   
  <div id="box" >
      <TEXTAREA  id="textComment"></TEXTAREA><br>
      <button onClick="textCommentCancel()"  id="textCommentCancel" class="btn btn-danger">Cancel</button>
      <button onClick="textCommentOk()" id="textCommentOk" type="button" class="btn btn-success">Ok</button>
    </div>
<div style="margin-top:-20px">
 <button id="draw" type="button" class="btn btn-default">Draw</button>
 <button id="comment" type="button" class="btn btn-default">Comment</button>
 <button id ="show" class="btn btn-small btn-success" type="button" >Show Comment</button>
 <button id ="submit" class="btn btn-small btn-success" type="button" >Save</button>
</div>  
<div>
    <div  style="float:right; width:85%" >
         <div  id ="PDF_container">
            <div class="tank">
              <div style="float:left;">
                   <div class="subtank1"> 
                    <canvas id="canvas1" >this is canvas</canvas> 
                  </div>
                  <div class="subtank2"> 
                    <canvas id="canvas"  style="">Your browser does not support the HTML5 canvas tag.</canvas>
                  </div>
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
                  <div id="myBox"></div> 
    </div>
  
  
</div>

{{HTML::script('hello.js')}}
<!-- {{HTML::script('js/draw.js')}} -->
<script type="text/javascript">
var clickX = new Array();
var clickY = new Array();
var clickDrag = new Array();
var clickPage = new Array();
var paint;
var draw = false;
var comment = false;
var textCommentId = 1 ;
var textCommentX = new Array();
var textCommentY = new Array();
var textCommentData = new Array();
var textCommentI = new Array();
var textCommentLoad = true;
$('#draw').click(function(e){
  if(draw == false){
    draw = true;
    comment = false;
    document.getElementById('comment').className = "btn btn-default";
    document.getElementById('draw').className = "btn btn-small btn-success";  
  }
  else{
     draw = false;
    document.getElementById('draw').className = "btn btn-default";
  }
  //draw = ( draw == true)? false : true;
  comment = false;
  

});
$('#comment').click(function(e){ 
  if(textCommentLoad){
    loadText();
  }
  if(comment == false){
    comment =true;
    document.getElementById('comment').className = "btn btn-small btn-success";
    draw = false;
    document.getElementById('draw').className = "btn btn-default";
  }
  else{
      comment = false;
      document.getElementById('comment').className = "btn btn-default";
  }  
 
});

  $('canvas').live("mousedown",function(e){
    if(draw){
        var page = Number($(this).attr("id").substring(7));
        paint = true;
        var c = document.getElementById($(this).attr("id"));   
        var context = c.getContext("2d");
        var mouseX = e.pageX - this.offsetLeft;
        var mouseY = e.pageY - this.offsetTop;  
        paint = true;
        addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop,page);
        redraw(context,page); 
    }
    if(comment){
      var page = Number($(this).attr("id").substring(7));
      var cordx = 0;
      var cordy = 0;
      if (!e) {
       var e = window.event;
      }
      if (e.pageX || e.pageY){
       cordx = e.pageX;
       cordy = e.pageY;
      }
      else if (e.clientX || e.clientY){
       cordx = e.clientX;
       cordy = e.clientY;
      }
      document.getElementById('textComment').value = "";
      document.getElementById('box').style.left = cordx;
      document.getElementById('box').style.top = cordy;
      document.getElementById('box').setAttribute("X",cordx);
      document.getElementById('box').setAttribute("Y",cordy);      
      document.getElementById('textCommentOk').setAttribute("page", page);      
      document.getElementById('box').style.display = "block";

      /*var text = prompt("Please enter your comment", "");
       if(text.length >1){
            var c = document.getElementById("comment_"+ page);
            c.innerHTML = c.innerHTML + "<div class='commentBody' id = 'textComment_"+ (textCommentId) + "'>"+ text +"</div>";
           //alert(textCommentId);  
            textCommentId++;
       }*/
      
    }
     
  });
  $('canvas').live('mousemove',function(e){
    var page = Number($(this).attr("id").substring(7));
    if(paint){
      addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, page, true);
      var c = document.getElementById($(this).attr("id"));   
      var context = c.getContext("2d");
      redraw(context,page);
    }
  });
  $('canvas').live('mouseleave',function(e){
    paint = false;
  });
  $('canvas').live('mouseup',function(e){
    paint = false;
  });
function textCommentOk(){
  
  if(document.getElementById('textComment').value.length > 0){        
       var c = document.getElementById("comment_"+ document.getElementById('textCommentOk').getAttribute('page'));
       textCommentId++;       
       var data = {"documentId":documentId,"userId":userId,"X":document.getElementById('box').getAttribute("X"),"Y":document.getElementById('box').getAttribute("Y"),"ID":textCommentId ,"data": document.getElementById('textComment').value,"page": document.getElementById('textCommentOk').getAttribute('page')};
    
    document.getElementById("submit").innerHTML = "saving";
        $.ajax({
            type:'POST',
            url : $('#base').val()+'/addText',
            data : data,        
            success: function(data){              
              c.innerHTML = c.innerHTML + "<div id='text_"+ data + "'><div  textId='"+ data + "' class='commentBody' page= '"+document.getElementById('textCommentOk').getAttribute('page')+"' X='"+document.getElementById('box').getAttribute('X')+"' Y='"+document.getElementById('box').getAttribute('Y')+"' id = 'textComment_"+ data + "'>"+ document.getElementById('textComment').value +"</div><div class='delete' textId='"+ data + "' id='delete_"+ data + "' >delete</div></div>";
             document.getElementById("submit").innerHTML = "save";            
            },
            error: function(XMLHttpRequest, textStatus, errorThrown){
              alert(errorThrown);
            } 
        });

  }
  document.getElementById('box').style.display = "none";
}
function textCommentCancel(){
  document.getElementById('box').style.display = "none";
}
function redraw(context,page){
  //context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas
  
  context.strokeStyle = "#df4b26";
  context.lineJoin = "round";
  context.lineWidth = 5;
      
  for(var i=0; i < clickX.length; i++) {
  if(page == clickPage[i]) {
    context.beginPath();
    if(clickDrag[i] && i){
      context.moveTo(clickX[i-1], clickY[i-1]);
     }else{
       context.moveTo(clickX[i]-1, clickY[i]);
     }
     context.lineTo(clickX[i], clickY[i]);
     context.closePath();
     context.stroke();
  }   
    
  }
}
function addClick(x, y, page, dragging)
{
  clickX.push(x);
  clickY.push(y);
  clickDrag.push(dragging);
  clickPage.push(page);
}
$('#submit').click(function(e){
  var Document = documentId; 
  if(clickX.length > 0){    
    var data = {"documentId":documentId,"userId":userId,"X":clickX,"Y":clickY,"page":clickPage};
    document.getElementById("submit").innerHTML = "saving";
    $.ajax({
        type:'POST',
        url : $('#base').val()+'/addComment',
        data : data,        
        success: function(data){
         // alert(data);
         document.getElementById("submit").innerHTML = "save";
         clickX.length = 0;
         clickDrag.length = 0;
         clickY.length = 0;
        },
        error: function(XMLHttpRequest, textStatus, errorThrown){
          alert(errorThrown);
        } 
    });
  }
  else{
   console.log("no comment");
  }   
});
$('.commentBody').live('click',function(e){  
  if(this.style.borderColor == 'red'){
   // document.getElementById(this.getAttribute('textid')).style.display = 'none';
    this.setAttribute("style", "border-color: green;");
  }
  else{
    
     this.setAttribute("style", "border-color: red;");
     //document.getElementById(this.getAttribute('textid')).style.display = 'block';
     //console.log(document.getElementById(this.getAttribute('textid')));
  }
  
console.log(this); 
 var c = document.getElementById('canvas_'+ this.getAttribute("page"));      
      document.getElementById('arrow').style.left = this.getAttribute("X");
      document.getElementById('arrow').style.top = this.getAttribute("Y");
      document.getElementById('arrow').style.display = (document.getElementById('arrow').style.display == "block")? "none" : "block";

});
$('.delete').live('click',function(e){ 
  var text = document.getElementById('textComment_'+this.getAttribute("textId"));  
          $.ajax({
              type : 'GET',
              url : ($('#base').val() + '/deleteText/'+ this.getAttribute("textId")),
              success: function(data) {                            
             
              
              },
              error : function(XMLHttpRequest, textStatus, errorThrown) {                                  
                  //alert('error2--3');
              }
        });
   $( '#text_'+this.getAttribute("textId")).empty();
});
$('.deleteDraw').live('click',function(e){
  $.ajax({
              type : 'POST',
              url : ($('#base').val() + '/deleteDraw/'+ this.getAttribute("drawId")),
              success: function(data) {
               window.location = $('#base').val() + "/document/" + documentId ;                
              },
              error : function(XMLHttpRequest, textStatus, errorThrown) {                                  
                  //alert('error2--3');
              }
        });
})
</script>

@stop