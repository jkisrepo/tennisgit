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

            <a href="{{url('/')}}" class="btn btn-primary btn-sm" title="Go Back"><i class="fa fa-arrow-left"></i></a>

            <h3>{{config('strings.new_feedback_form')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('feedback')}}" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Admins:</label>
                <div class="col-sm-10">
                    <select name="admin" class="form-control" id="admin">
                        @foreach($Admins as $admin)
                        <option value="{{$admin->id}}">{{$admin->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Message:</label>
                <div class="col-sm-10">
                    <textarea name="message" class="form-control" id="message"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="col-md-10">
                    <input type="submit" class="btn btn-success" value="Submit">

                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('dist/js/pages/anonymous_feedback.js')}}"></script>>
@endsection
