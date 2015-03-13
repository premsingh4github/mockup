<html>
  {{HTML::style('css/bootstrap.css')}}
  <style type="text/css">
  .alert-error{
    display: none;
  }
   </style>
  
    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="position:inherit">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Mockup Version</a>
              </div>
            </div>
          </nav>
          @yield('contain')

        @yield('content')
        {{HTML::script('js/jquery-latest.js')}}
       {{HTML::script('js/bootstrap.js')}}
    </body>
</html>