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

    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('schedules')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.new_match_form')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('schedules/add')}}" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Player 1:</label>
                <div class="col-sm-10">
                    <select name="player1" required class="form-control" id="player1">
                        <option value="" selected disabled>Select Player 1</option>
                        @foreach($players as $key => $value)
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Player 2:</label>
                <div class="col-sm-10">
                    <select name="player2" required class="form-control" id="player2" disabled="">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Academy:</label>
                <div class="col-sm-10">
                    <select name="academy" class="form-control" id="academy" required>
                        <option value="" selected disabled>Please Select Academy</option>
                        @foreach($academies as $academy)
                        <option value="{{$academy->id}}">{{$academy->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Court:</label>
                <div class="col-sm-10">
                    <select name="court" required class="form-control" id="court" disabled="">

                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Time:</label>
                <div class="col-sm-10">
                    <div class='input-group date'>
                        <input id='datetimepicker1' type='text' name="date_time" class="form-control" required />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="col-md-10">
                    <input type="submit" class="btn btn-{{config('strings.button.success')}}"
                        value="{{config('strings.button.save')}}">
                    <input type="submit" name="addNew" class="btn btn-{{config('strings.button.info')}}"
                        value="{{config('strings.button.save_n_new')}}">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('dist/js/pages/add_schedules.js')}}"></script>
@endsection
