@extends('layout')

@section('content')
   <section >
   <div class="container login" style="width:300px;margin-top:-18px;">
       <div class="row " >
           <div class="center span4 well">
               <legend>Please Sign In</legend>
               <div class="alert alert-error">
                   <a class="close" data-dismiss="alert" href="#">×</a>Incorrect Username or Password!
               </div>
               <form method="POST" action="login" accept-charset="UTF-8">
               <input type="text" id="username" class="span4" name="username" placeholder="Email" />
               <input type="password" id="password" class="span4" name="password" placeholder="Password" />
               <label class="checkbox">
                   <input type="checkbox" name="remember" value="1" /> Remember Me
               </label>
               <button type="submit" name="submit" class="btn btn-primary btn-block">Sign in</button>
               </form>
           </div>
       </div>
   </div>
   <p class="text-center muted ">&copy; Copyright 2013 - Application Name</p>
   </section>
   <!-- Main Container Ends -->
    
   <!-- Forgot Password Model Box -->
   <div id="forgot" class="modal hide fade in" style="display: none; ">
   <div class="modal-header">
   <a class="close" data-dismiss="modal">×</a>
   <h3>Forgot Password</h3>
   </div>
   <div class="modal-body">
   <p>Enter your username to reset the password</p>
   <form>
         <div class="controls controls-row">
             <input id="email" name="email" type="text" class="span3" placeholder="email" />
         </div>
    
   </form>
   </div>
   <div class="modal-footer">
   <a href="#" class="btn btn-primary">Submit</a>
   <a href="#" class="btn" data-dismiss="modal">Close</a>
   </div>
   </div>
    
   <!-- Contact Us Model Box -->
   <div id="contact" class="modal hide fade in" style="display: none; ">
   <div class="modal-header">
   <a class="close" data-dismiss="modal">×</a>
   <h3>Contact Us</h3>
   </div>
   <div class="modal-body">
   <form>
         <div class="controls controls-row">
             <input id="name" name="name" type="text" class="span3" placeholder="Name" />
         </div>
    
          <div class="controls controls-row">
          <input id="email" name="email" type="email" class="span3" placeholder="Email address" />
          </div>
    
         <div class="controls">
             <textarea id="message" name="message" class="span5" placeholder="Your Message" rows="5"></textarea>
         </div>
    
     </form>
   </div>
    
   <div class="modal-footer">
   <a href="#" class="btn btn-primary">Submit</a>
   <a href="#" class="btn" data-dismiss="modal">Close</a>
   </div>
   </div>
  
@stop
