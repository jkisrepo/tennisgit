@extends('master')
@section('content')
<div class="box box-primary">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{URL::previous()}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.view_assign_drill')}}</h3>
        </div>
        <form class="form-horizontal" role="form" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Players:</label>
                <div class="col-sm-10">
                    <input value="{{$assignDrill->player}}" readonly="" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Drills:</label>
                <div class="col-sm-10">
                    <input value="{{$assignDrill->drill}}" readonly="" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Time:</label>
                <div class="col-sm-10">
                    <div class='input-group date'>
                        <input id='datetimepicker1' type='text' disabled name="date_time" class="form-control"
                            value="{{$assignDrill->date_time}}" />
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
<script src="{{asset('dist/js/pages/view_assign_drill.js')}}"></script>
@endsection
