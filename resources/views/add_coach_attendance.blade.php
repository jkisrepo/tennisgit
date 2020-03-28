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
            <a href="{{url('attendance/coaches')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.add_coach_attendance')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('/attendance/coaches/add')}}" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Coaches:</label>
                <div class="col-sm-10">
                    <select name="coach" class="form-control" id="coaches" required>
                        <option value="" selected disabled>Select Coach</option>
                        @foreach($coaches as $key => $value)
                        <option @if(auth()->user()->getType() == "coach") selected @endif
                            value="{{$value->id}}">{{$value->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Attendance:</label>
                <div class="col-sm-10">
                    <select name="attendance" class="form-control" id="attendance" required="">
                        <option value="" selected disabled>Select Attendance</option>
                        <option value="1">Present</option>
                        <option value="0">Absent</option>
                    </select>
                </div>
            </div>
            <div class="form-group absent_type" style="display:none;">
                <label class="control-label col-sm-2" for="contact">Absent Type:</label>
                <div class="col-sm-10">
                    <select name="absent_type" class="form-control" id="absent_type">
                        <option value="">Select Type</option>
                        <option value="1">Excused</option>
                        <option value="0">Unexcused</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Time:</label>
                <div class="col-sm-10">
                    <div class='input-group date'>
                        <input id='datetimepicker1' type='text' name="date_time" required="" class="form-control" />
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
<script src="{{asset('dist/js/pages/add_coach_attendance.js')}}">
</script>
@endsection
