@extends('admin/admin')

@section('content')
 <div class="container">

 <nav class="navbar navbar-inverse">
     <div class="navbar-header">
        
     </div>
     <ul class="nav navbar-nav">
         <li><a href="{{ URL::to('members') }}">View All Members</a></li>
         <li><a href="{{ URL::to('members/create') }}">Create a Member</a>
     </ul>
 </nav>

 <h1>All the Members</h1>

 <!-- will be used to show any messages -->
 @if (Session::has('message'))
     <div class="alert alert-info">{{ Session::get('message') }}</div>
 @endif

 <table class="table table-striped table-bordered">
     <thead>
         <tr>
             <td>ID</td>
             <td>Name</td>
             <td>Email</td>
             <td>Member Type</td>
             <td>Actions</td>
         </tr>
     </thead>
     <tbody>
        <?php $i=1; ?>
     @foreach($members as $key => $value)
         <tr>
             <td>{{ $i++; }}</td>
             <td>{{ $value->name }}</td>
             <td>{{ $value->email }}</td>
             <td><?php
                    if($value->memberType == 0){
                        echo "Super Admin";
                    }
                    elseif ($value->memberType == 1) {
                       echo "Manager";
                    }
                    elseif ($value->memberType == 2) {
                       echo "Developer";
                    }
                    elseif ($value->memberType == 3) {
                       echo "Designer";
                    }
                    elseif ($value->memberType == 4) {
                       echo "Client";
                    }
                    else{
                        echo "Invalid Type";
                    }
              ?></td>

             <!-- we will also add show, edit, and delete buttons -->
             <td>

                 <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                 <!-- we will add this later since its a little more complicated than the other two buttons -->
                
                {{ Form::open(array('url' => 'members/' . $value->id, 'style'=>"display:inline")) }}
                    {{ Form::hidden('_method', 'DELETE') }}
                    {{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
                {{ Form::close() }}
            
                 <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                 <a class="btn btn-small btn-success" href="{{ URL::to('members/' . $value->id) }}">View</a>

                 <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                 <a class="btn btn-small btn-info" href="{{ URL::to('members/' . $value->id . '/edit') }}">Edit</a>

             </td>
         </tr>
     @endforeach
     </tbody>
 </table>

 </div>
  
@stop