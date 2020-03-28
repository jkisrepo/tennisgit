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

    @if(session('warning'))
    </br>
    <div class="alert alert-warning">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Warning!</strong> {{ session('warning') }}.
    </div>
    @endif
    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('/')}}" class="btn btn-primary btn-sm" title="Go Back"><i class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.assign_drill')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('drills/assign')}}" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Players:</label>
                <div class="col-sm-10">
                    <select name="player" required class="form-control" id="player">
                        <option value="" selected disabled>Select Player</option>
                        @foreach($players as $key => $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Drills:</label>
                <div class="col-sm-10">
                    <select name="drill" class="form-control" id="drill" required>
                        <option value="" selected disabled>Please Select Drills</option>
                        @foreach($drills as $drill)
                        <option value="{{$drill->id}}">{{$drill->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Time:</label>
                <div class="col-sm-10">
                    <div class='input-group date'>
                        <input id='datetimepicker1' type='text' name="date_time" class="form-control" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
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
<script src="{{asset('dist/js/pages/assign_drills.js')}}"></script>
@endsection
