@extends('admin/admin')

@section('content')
 <div class="container">
    <h2>All the Projects</h2>
     <div class="panel panel-primary">
         <div class="panel-heading">
        <a style="color:#FFF;decoration:none" href="{{ URL::to('projects') }}">View All Projects </a>
        @if(Auth::user()->memberType < 2)
        <a style="color:#FFF" href="{{ URL::to('projects/create') }}"> Create a Projecs</a>
        @endif
     </ul>
         </div>
         <div class="panel-body">
            @if (Session::has('message'))
                <div class="alert alert-info">{{ Session::get('message') }}</div>
            @endif

            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Status</td>
                        <td>Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
               @if(count($projects) > 0) 
                @foreach($projects as $key => $value)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $value->name }}</td>
                        <td>{{ $value->description }}</td>
                        <td>{{ ($value->status == 1)? "Active" : "Inactive"; }}</td>

                        <!-- we will also add show, edit, and delete buttons -->
                        <td>

                            <!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
                            <!-- we will add this later since its a little more complicated than the other two buttons -->
                           
                           
                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-small btn-success"  href="{{ URL::to('projects/' . $value->id) }}">View</a>

                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            @if(Auth::user()->memberType == 0 || Auth::user()->id == $value->createdBy)
                            <a class="btn btn-small btn-info" href="{{ URL::to('projects/' . $value->id . '/edit') }}">Edit</a>
                           {{ Form::open(array('url' => 'projects/' . $value->id,'style'=>"display:inline")) }}
                                {{ Form::hidden('_method', 'DELETE') }}
                               {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                           {{ Form::close() }} 
                           @endif
                        </td>
                    </tr>
                @endforeach    
               @else
               <tr><td colspan=5>No project added yet!</></tr>
               @endif
                </tbody>
            </table>
         </div>
     </div>

 

 <!-- will be used to show any messages -->
 

 </div>
  
@stop