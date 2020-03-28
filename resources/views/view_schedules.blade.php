@extends('master')
@section('content')


<div class="box box-primary">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('schedules')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            @if(auth()->user()->getType()=='admin' ||
            auth()->user()->getType()=='coach')
            <a href="{{url('/schedules/'.$match->id.'/edit')}}" class="btn btn-success btn-sm pull-right"
                title="Match Edit"><i class="fa fa-pencil"></i></a>
            @endif
            <h3>{{config('strings.view_match')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('schedules/'.$match->id.'/update')}}" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Player 1:</label>
                <div class="col-sm-10">
                    <select name="player1" required class="form-control" id="player1" disabled>
                        <option selected="selected" value="{{$match->player1}}">{{ $match->p1name }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Player 2:</label>
                <div class="col-sm-10">
                    <select name="player2" required class="form-control" id="player2" disabled>
                        <option selected="selected" value="{{$match->player2}}">{{ $match->p2name }}</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Academy:</label>
                <div class="col-sm-10">
                    <select name="academy" class="form-control" id="academy" disabled>
                        <option value="">Please Select Academy</option>
                        <option selected="selected" value="{{$match->academy_id}}">{{$match->title}}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Court:</label>
                <div class="col-sm-10">
                    <select name="court" class="form-control" id="court" required="" disabled>
                        <option selected="selected" value="{{$match->court_id}}">{{ $match->court_type }}</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Time:</label>
                <div class="col-sm-10">
                    <input type='text' name="date_time" class="form-control" value="{{ $match->date }}" disabled />
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('dist/js/pages/view_schedules.js')}}"></script>
@endsection
