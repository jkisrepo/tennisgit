@extends('master')
@section('content')
<div class="box box-primary">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('attendance/coaches')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.view_coach_attendance')}}</h3>
        </div>
        <form class="form-horizontal" role="form">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Coaches:</label>
                <div class="col-sm-10">
                    <select name="coach" required class="form-control" disabled="disabled" id="coaches">
                        <option value="" selected disabled>Select Coach</option>
                        <option selected="" value="{{$coach->id}}">{{$coach->name}}</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Attendance:</label>
                <div class="col-sm-10">
                    <select name="attendance" class="form-control" disabled="disabled" id="attendance" required="">
                        <option value="" selected disabled>Select Attendance</option>

                        <option @if($coach_attendance->attendance==1) selected @endif value="1" >Present</option>
                        <option @if($coach_attendance->attendance==0) selected @endif value="0">Absent</option>
                    </select>
                </div>
            </div>
            @if($coach_attendance->attendance==0)
            <div class="form-group absent_type">
                <label class="control-label col-sm-2" for="contact">Absent Type:</label>
                <div class="col-sm-10">
                    <select name="absent_type" class="form-control" disabled="disabled" id="absent_type">
                        <option value="">Select Type</option>
                        <option @if($coach_attendance->absent_type==1) selected @endif value="1">Excused</option>
                        <option @if($coach_attendance->absent_type==0) selected @endif value="0">Unexcused</option>
                    </select>
                </div>
            </div>
            @endif

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Time:</label>
                <div class="col-sm-10">
                    <div class='input-group date'>
                        <input id='datetimepicker1' type='text' value="{{$coach_attendance->date_time}}"
                            name="date_time" required="" class="form-control" disabled="disabled" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('dist/js/pages/view_coach_attendance.js')}}"></script>
@endsection
