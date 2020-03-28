@extends('master')
@section('content')
<div class="box box-primary">
  <div class="box-body">
    <div class="box-header">
      <a href="{{url('users?type='.Request::input('type').'')}}" class="btn btn-primary btn-sm" title="Go Back"><i class="fa fa-arrow-left"></i></a>
      @if(app('request')->input('type') == "admin")
          <h3>{{config('strings.view_admin_details')}}</h3>
        @elseif(app('request')->input('type') == "coach")
          <h3>{{config('strings.view_coach_details')}}</h3>
        @endif
    </div>
    
    <form  method="post" class="form-horizontal">
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Name:</label>
        <div class="col-sm-8">
            <input type="text" class="form-control" required="required"  name="name" placeholder="Enter name" value="{{old('name')}}" readonly="">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Email:</label>
        <div class="col-sm-8">
            <input type="email" class="form-control" required="required"  name="email" placeholder="Enter Email" value="{{old('email')}}" readonly="">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Profile Picture:</label>
        <div class="col-sm-8">
          @if(old('profile_picture') ==NULL )
            <img src="{{ asset('images/images2.jpg')}}" height="100" width="100" style="margin-bottom: 10px">
          @else
             <img src="{{asset('images/'.old('profile_picture'))}}" height="100" width="100">
          @endif
           
        </div>
      </div>
    </form>
  </div>  
</div>
@endsection