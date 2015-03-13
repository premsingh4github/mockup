<?php
  if(!Auth::check()){
        Redirect::to('/');
    }
?>
<html>
 
  {{HTML::style('css/datepicker.css')}}
   {{HTML::style('css/bootstrap.css')}}
  <style type="text/css">
  .alert-error{
    display: none;
  }
   </style>
  
    <body id="body">
     <input type ="hidden" id ="base" value="{{url()}}"/> 
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="position:inherit">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <!-- <a class="navbar-brand" href="loval">Mockup Version</a> -->
                {{ HTML::link('/', "Mockup Version",array('class' =>'navbar-brand'))}}
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                  <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>
                    <li><a >{{ Auth::user()->name}}</a></li>
                    
                   @if (Auth::check())
                      @if(Auth::user()->memberType <=1)
                      <li>{{ HTML::link('members', 'Members')}}</li>
                      @endif
                      <li>{{ HTML::link('logout', 'Log Out')}}</li>

                      
                    @else
                      <li><a href="/login">Login</a></li>                      
                     @endif
                   
                    <li class="dropdown">
                      {{ HTML::link('projects', "Projects ")}}
                      <!-- <a href="{{base_path()}}/projects" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Pojects <span class="caret"></span></a> -->
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Ipay</a></li>
                        <li><a href="#">KYC</a></li>
                        <li><a href="#">Loans Engine</a></li>
                        <!-- <li class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li> -->
                      </ul>
                    </li>
                  </ul>
                </div>
            </div>
          </nav>
          @yield('contain')

    
        @yield('content')
     {{HTML::script('js/jquery-latest.js')}}
     {{HTML::script('js/jquery.min.js')}}
      {{HTML::script('js/custom.js')}}
      {{HTML::script('js/bootstrap-datepicker.js')}}
      <script type="text/javascript">
            // When the document is ready
            $(document).ready(function () {
                
                $('#startDate').datepicker({
                    format: "yyyy-mm-dd"
                }); 
                $('#finishDate').datepicker({
                    format: "yyyy-mm-dd"
                }); 
            
            });
        </script>
    </body>
</html>