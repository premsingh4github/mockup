var commentX = new Array();
var commentY = new Array();
var commentP = new Array();
loadDraw();
function loadDraw(){
 
  $.ajax({
      type : 'POST',
      url : $('#base').val()+'/showComment/'+ documentId,
      success: function(data) {                             
      if(data != '1'){ 
     // alert(data);                         
        var comment = JSON.parse(data); 
        var xx =  comment.X;          
       // loadComment(comment.X,comment.Y,comment.page);             
        for(var i=0; i < comment.X.length; i++) {
            commentX.push(comment.X[i]);
            commentY.push(comment.Y[i]);
            commentP.push(comment.page[i]);
          } 
          // console.log("data",comment);
      }                                             
        
        
      },
      error : function(XMLHttpRequest, textStatus, errorThrown) {                                  
          //alert('error2--3');
      }
  });
}
//alert(Math.abs(10 - 18) );
$('#show').click(function(e){
 draw1();
});
function draw1(){
   
   var a = [], l = commentP.length;
      for(var i=0; i<l; i++) {
        for(var j=i+1; j<l; j++)
              if (commentP[i] === commentP[j]) j = ++i;
        a.push(commentP[i]);
      }
     var b = a.sort(function(a, b){return a-b});
      
    for(var t = 1; t<= b.length; t++){
      var canvas_Id = 'canvas_' + b[t-1];
      var c = document.getElementById('canvas_' + b[t-1]); 
   
      //var cont = c.getContext("2d");
      var ctx = c.getContext("2d");
       ctx.clearRect(0, 0, c.width, c.height);
       // context.clearRect(0, 0, canvas.width, canvas.height);
       // console.log(b[t-1]);                
        for(var i=0; i < commentP.length; i++) {
          if(commentP[i] == b[t-1]) {
                var textX = [104, 148, 125, 171];
                var testY = [442, 446, 413, 421];
               // for(var i =0 ; i < commentP.length; i++){
                  if( Math.abs(commentX[i] - commentX[i+1])  < 15 ||  Math.abs(commentY[i] - commentY[i+1])  < 15 ){
                      ctx.moveTo(commentX[i],commentY[i]);                  
                  }
                  else{
                    ctx.moveTo(commentX[i+1],commentY[i+1]);
                    // alert("X:" + commentX[i] + "Y:" + commentY[i] + Math.abs(commentX[i] - commentX[i+1]) + " ---" +  Math.abs(commentY[i] - commentY[i+1]));
                  }
                  ctx.strokeStyle = "#df4b26";
                  ctx.lineJoin = "round";
                  ctx.lineWidth = 5;
                  ctx.lineTo(commentX[i+1],commentY[i+1]);
                  ctx.stroke();
               // }
          }   
        
        }
    }
    loadText();
}

  function loadText(){

    if(textCommentLoad){
        $.ajax({
              type : 'POST',
              url : $('#base').val()+'/showText/'+ documentId,
              success: function(data) {                            
              if(data != '1'){ 
                
                //$( ".commentBody" ).empty();                  
               var comment = JSON.parse(data);                 
                for(var i = 0; i < comment.data.length; i++){            
                   var c = document.getElementById("comment_"+ comment.page[i]);
                   if(document.getElementById("textComment_"+ comment.Id[i]) == null){
                     c.innerHTML = c.innerHTML + "<div id='text_"+ comment.Id[i] + "'><div textId='"+comment.Id[i] + "' class='commentBody' page='"+comment.page[i]+"'  X='"+comment.X[i]+"'  Y='"+comment.Y[i]+"' id = 'textComment_"+ comment.Id[i] + "'>"+ comment.data[i] +"</div><div class='delete' id='"+ comment.Id[i] + "' textId='"+ comment.Id[i] + "' >delete</div>";               
                     textCommentId = comment.Id[i] + 1; 
                   }
                   else{
                     //alert("textComment_"+ comment.Id[i]);
                   }
                }
              }
              else{
              // alert(1);
              }
               listDraw();
              },
              error : function(XMLHttpRequest, textStatus, errorThrown) {                                  
                  //alert('error2--3');
              }
        });
      textCommentLoad = false;
    }
  
 }
 function listDraw(){
   var c = document.getElementById("comment_1");
    $.ajax({
              type : 'GET',
              url : ($('#base').val() + '/listDraw/'+ documentId),
              success: function(data) {                            
                 var comment = JSON.parse(data);
                 for(var i=0; i< comment.Id.length; i++){
                    //console.log(comment.user[i][0].name);                    
                    c.innerHTML = c.innerHTML + "<div id='draw_"+comment.Id[i]+"'>By "+comment.user[i][0].name+"</div><div class='deleteDraw' drawId='"+comment.Id[i]+"'>delete</div>"; //"<div id='draw_"+ comment.Id[i] + "'><div textId='"+comment.Id[i] + "' class='commentBody' >"+ comment.data[i] +"</div><div class='delete'  >delete</div>";               
                    
                 }
                 
              
              },
              error : function(XMLHttpRequest, textStatus, errorThrown) {                                  
                  //alert('error2--3');
              }
        });
 }