/* -*- Mode: Java; tab-width: 2; indent-tabs-mode: nil; c-basic-offset: 2 -*- */
/* vim: set shiftwidth=2 tabstop=2 autoindent cindent expandtab: */

//
// See README for overview
//

'use strict';

//
// Fetch the PDF document from the URL using promises
//
var documentName = document.getElementById('documentName').value;
var documentId = document.getElementById('documentId').value;
var userId = document.getElementById('userId').value;
PDFJS.getDocument(documentName).then(function(pdf) {
createCanvas(pdf.numPages);
  for(var count = 1; count <= pdf.numPages;){
    pdf.getPage(count).then(function(page) {
      var scale = 1;
      var viewport = page.getViewport(scale);
      //
      // Prepare canvas using PDF page dimensions
      //
      var pageIndex = Number(page.pageIndex)+1;
      var canvas = document.getElementById('pdf_' + pageIndex);
      var context = canvas.getContext('2d');   
      canvas.height = viewport.height;    
      canvas.width = viewport.width;
      var canvas1 = document.getElementById('canvas_' + pageIndex);
      canvas1.height = viewport.height;
      canvas1.width = viewport.width;
      //
      // Render PDF page into canvas context
      //
      var renderContext = {
        canvasContext: context,
        viewport: viewport
      };
      //console.log("render page ",Number(page.pageIndex)+1);
      page.render(renderContext).then($.proxy(afterContextRender,page));
    });
    count++;
    //alert(1);
    //$( "#PDF_container" ).append( "<strong>Hello</strong>" );
   // document.getElementById("PDF_container").innerHTML =  document.getElementById("PDF_container").innerHTML + ""; 
  }
   
 // addPdf(pdf);

  var afterContextRender = function(){

  }

});
function createCanvas(pageNum){  
  var canvas = "";
  var commentBox = "";
  for(var i = 1;i<=pageNum; i++){
    var div = "<div class='tank'>" +
                    "<div style='float:left; width:75%'>"+
                      "<div class='subtank1'>" +
                        "<canvas id='pdf_"+ i +"' >this is canvas</canvas> " +
                      "</div>" +
                      "<div class='subtank2'>"+
                        "<canvas id='canvas_" + i +"'>Your browser does not support the HTML5 canvas tag.</canvas>"+
                      "</div>"+
                    "</div>" +
                  "</div>";
    var div2 = "<div  style='float:right; width:100%' id='comment_" + i +"'></div><div style='clear:both'></div>"
        canvas = canvas + div;
        commentBox = commentBox + div2;

  }            
 //var PDF_container = document.getElementById('PDF_container');
 document.getElementById("PDF_container").innerHTML = canvas; 
 document.getElementById("myBox").innerHTML = document.getElementById("myBox").innerHTML + commentBox         
}