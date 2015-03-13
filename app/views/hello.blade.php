<!doctype html>
<html>

<head>
  <!-- In production, only one script (pdf.js) is necessary -->
  <!-- In production, change the content of PDFJS.workerSrc below -->
  {{HTML::script('src/shared/util.js')}}
  {{HTML::script('src/display/metadata.js')}}
  {{HTML::script('src/display/canvas.js')}}
  {{HTML::script('src/display/webgl.js')}}
  {{HTML::script('src/display/pattern_helper.js')}}
  {{HTML::script('src/display/font_loader.js')}}
  {{HTML::script('src/display/annotation_helper.js')}}
  <script>
  
    // Specify the main script used to create a new PDF.JS web worker.
    // In production, leave this undefined or change it to point to the
    // combined `pdf.worker.js` file.
    PDFJS.workerSrc = 'src/worker_loader.js';
    
  </script>
  <script src="hello.js"></script>
</head>

<body>
  <canvas id="the-canvas" style="border:1px solid black;"/>
</body>

</html>
