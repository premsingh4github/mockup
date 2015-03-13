
function addPoint(x,y){
 
    addClick(x, y, true);
    redraw();

}

function redraw(){

  context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas
  
  context.strokeStyle = "#df4b26";
  context.lineJoin = "round";
  context.lineWidth = 5;      
  for(var i=0; i < clickX.length; i++) {    
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
function draw(){
  
 
  var c = document.getElementById("canvas"); 
  var context = c.getContext("2d"); 
  var clickX = new Array();

  var clickY = new Array();

  var clickDrag = new Array();
  var paint;
alert("comment");
  function addPoint1(x,y){
   
      addClick(x, y, true);
      redraw();

  }

  function addClick1(x, y, dragging)
  {
   
    clickX.push(x);
    clickY.push(y);
    clickDrag.push(dragging);
  }

  $('#canvas').mousedown(function(e){
    var mouseX = e.pageX - this.offsetLeft;
    var mouseY = e.pageY - this.offsetTop;
    paint = true;

    addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
    redraw();     
  });
  $('#canvas').mousemove(function(e){
    if(paint){
      addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
      redraw();
    }
  });
  $('#canvas').mouseup(function(e){
     // console.trace(333);

    paint = false;
  });
  $('#canvas').mouseleave(function(e){
    //console.log(e.view.clickX);
    //console.log(e.view.clickY);
    paint = false;
  });
  $('#submit').click(function(e){
   
  var submit = document.getElementById('submit');
  document.getElementById("submit").innerHTML = "saving";
    var data1 = {"X":clickX,"Y":clickY};
    //var data = JSON.stringify(data1);
    console.trace(typeof data);
         $.ajax({
                type : 'POST',
                url : $('#base').val()+'/addComment',                                             
                data : data1,
                dataType:'json',
                success: function(data) {
                alert(data);
                document.getElementById("submit").innerHTML = "save";
                },
                error : function(XMLHttpRequest, textStatus, errorThrown) {                                  
                    alert('Error while saving comments');
                }
            });    

  });
  function redraw1(){

    //context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas
    
    context.strokeStyle = "#df4b26";
    context.lineJoin = "round";
    context.lineWidth = 5;      
    for(var i=0; i < clickX.length; i++) {    
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

