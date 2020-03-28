@extends('master')
@section('content')
<div class="box box-primary">
  @if(session('message'))
  <br>
  <div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Success!</strong> {{ session('message') }}.
  </div>
  @endif
  @if(session('ErrorMessage'))
  </br>
   <div class="alert alert-warning">
   <a href="#" class="close" data-dismiss='alert'>&times;</a>
   <strong>Warning!</strong> {{ session('ErrorMessage')}}
   </div>
  @endif
  
  <div class="box-body">
    <div class="box-header">
      <a href="{{url('users?type='.Request::input('type').'')}}" class="btn btn-primary btn-sm" title="Go Back"><i class="fa fa-arrow-left"></i></a>
      @if(old('id'))
        @if(app('request')->input('type') == "admin")
          <h3>{{config('strings.edit_admin_form')}}</h3>
        @elseif(app('request')->input('type') == "coach")
          <h3>{{config('strings.edit_coach_form')}}</h3>
        @endif
      @else
        @if(app('request')->input('type') == "admin")
          <h3>{{config('strings.new_admin_form')}}</h3>
        @elseif(app('request')->input('type') == "coach")
          <h3>{{config('strings.new_coach_form')}}</h3>
        @endif
      @endif
    </div>
     @if(old('id'))
     <form action="{{url('/users/'.old('id').'/edit')}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
     @else
     <form action="{{url('/users/add')}}" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
     @endif   
      <input type="hidden" name="usertype" value="{{$user_types->id}}">
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Name:</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" required="required"  name="name" placeholder="Enter name" value="{{old('name')}}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Email:</label>
        <div class="col-sm-8">
            <input type="email" class="form-control" required="required"  name="email" placeholder="Enter Email" value="{{old('email')}}">
        </div>
      </div>

      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Profile Picture:</label>
        <div class="col-sm-8">
           @if(old('profile_picture'))
           <img src="{{asset('images/'.old('profile_picture'))}}" height="100" width="100">
           @endif
           <input type="file" class="form-control"  name="profile_picture">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <input type="submit" class="btn btn-{{config('strings.button.success')}}" value="{{config('strings.button.save')}}">
          @if(old('id') == "")
          <input type="submit" name="addNew" class="btn btn-{{config('strings.button.info')}}" value="{{config('strings.button.save_n_new')}}">
          @endif
         
        </div>
      </div>
    </form>
  </div>  
</div>
@endsection