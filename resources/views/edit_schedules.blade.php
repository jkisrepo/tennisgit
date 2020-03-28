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
            <h3>{{config('strings.edit_match_form')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('schedules/'.$match->id.'/update')}}" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Player 1:</label>
                <div class="col-sm-10">
                    <select name="player1" required class="form-control" id="player1">
                        <option value="" selected disabled>Select Player 1</option>
                        @foreach($players as $key => $value)
                        @if($match->player1==$value->id)
                        <option selected="selected" value="{{$value->id}}">{{$value->name}}</option>
                        @else
                        <option value="{{$value->id}}">{{$value->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Player 2:</label>
                <div class="col-sm-10">
                    <select name="player2" required class="form-control" id="player2">
                        <option value="" selected disabled>Select Player2</option>
                        @foreach($playerWithoutP1 as $players)
                        @if($players->id==$match->player2)
                        <option selected="selected" value="{{$players->id}}">{{ $players->name }}</option>
                        @else
                        <option value="{{$players->id}}">{{$players->name}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Academy:</label>
                <div class="col-sm-10">
                    <select name="academy" class="form-control" id="academy" required>
                        <option value="" selected disabled>Select Academy</option>
                        @foreach($academies as $academy)
                        @if($match->academy_id==$academy->id)
                        <option selected="selected" value="{{$academy->id}}">{{$academy->title}}</option>
                        @else
                        <option value="{{$academy->id}}">{{$academy->title}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Court:</label>
                <div class="col-sm-10">
                    <select name="court" class="form-control" id="court" required>
                        <option value="" selected disabled>Select Court</option>
                        @foreach($courts as $court)
                        @if($court->court_id == $match->court_id)
                        <option selected="selected" value="{{$court->court_id}}">{{$court->court_type}}</option>
                        @else
                        <option value="{{$court->court_id}}">{{$court->court_type}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Time:</label>
                <div class="col-sm-10">
                    <div class='input-group date'>
                        <input type='text' id='datetimepicker1' name="date_time" class="form-control"
                            value="{{$match->date}}" required />
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
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('dist/js/pages/edit_schedules.js')}}"></script>
@endsection
