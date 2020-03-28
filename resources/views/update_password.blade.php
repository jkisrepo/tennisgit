@extends('master')
@section('content')
<div class="box box-primary">
    @if(session('message'))
    </br>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{ session('message') }}.
    </div>
    @endif
    <div class="box-body">
        <div class="box-header">
            <h3>Change Password Form</h3>
        </div>
        <form action="{{url('/change_password')}}" method="post" class="form-horizontal" role="form">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Email:</label>
                <div class="col-sm-8">
                    <input type="email" class="form-control" required="required" name="email" readonly="readonly"
                        placeholder="Enter Email" value="{{$user->email }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" required="required" name="password"
                        placeholder="Enter Password" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Confirm Password:</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" required="required" name="confirm_password"
                        placeholder="Enter Confirm Password" value="">
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-{{config('strings.button.success')}}"
                        value="{{config('strings.button.save')}}">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


@section('js')
<script src="{{asset('dist/js/pages/upadte_password.js')}}"></script>
@endsection
