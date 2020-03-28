@extends('master')
@section('content')
<div class="modal fade in" id="myModal2" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            @if(auth()->user()->getType() == "player")
            <form class="form-inline" method="get"
                action="{{url('attendance/players/'.auth()->user()->player->id.'/graph')}}">
                @else
                <form class="form-inline" method="get"
                    action="{{url('attendance/players/'.Request::input('player_id').'/graph')}}">
                    @endif
                    <div class="modal-body">


                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </br>
                        <h4>{{config('strings.graph_by_month_and_year')}}</h4>
                        <hr>
                        <div class="row">

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label>Month</label>

                                    <select name="month1" class="form-control">
                                        @for($i=1; $i <= 12; $i++) <option @if(date('m')==$i) selected="" @endif
                                            value="{{$i}}">{{date("F", mktime(0, 0, 0, $i, 10))}}</option>

                                            @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label>Year</label>
                                    <select name="year1" class="form-control">
                                        @for($i=date('Y'); $i <= date('Y')+3; $i++) <option @if(date('Y')==$i)
                                            selected="" @endif value="{{$i}}">{{$i}}</option>

                                            @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        </br>
                        <h4>{{config('strings.graph_by_year')}}</h4>
                        <hr>
                        <div class="row">

                            <div class="form-group">
                                <div class="col-sm-6">
                                    <label>Year</label>
                                    <select name="year2" class="form-control">
                                        @for($i=date('Y'); $i <= date('Y')+3; $i++) <option @if(date('Y')==$i)
                                            selected="" @endif value="{{$i}}">{{$i}}</option>

                                            @endfor
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
        </div>

    </div>
</div>
<!-- Modal -->
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
            @if(auth()->user()->getType()=='admin' ||
            auth()->user()->getType()=='coach')
            <a href="{{url('/attendance/players/create')}}" class="btn btn-success btn-sm pull-right"
                title="New Player"><i class="fa fa-plus"></i></a>
            @endif
            @if(Request::input('player_id'))
            <h3 class="table-heading">{{$player->name}} Attendance</h3>
            @else
            <h3 class="table-heading">{{config('strings.player_attendance')}}</h3>
            @endif
        </div>
        <div class="box-header row">

            <form action="{{url('attendance/players')}}" class="form-inline col-sm-8" method="get">
                @if(Request::input('player_id'))
                <input type="hidden" name="player_id" value="{{Request::input('player_id')}}">
                @endif
                <div class="form-group">
                    <select name="searchColumn" class="form-control" id="searchColumn">
                        <option value="player">Player</option>
                        <option value="coach">Coach</option>
                        <option value="date_time">Date</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="searchBy" required="" id="datetimepicker1" class="form-control searchBy">
                </div>
                <div class="form-group">
                    <input type="submit" id="table_search" class="btn btn-default" value="&#xf002;">
                </div>
            </form>
            <div class="col-sm-4">
                @if(Request::input('player_id') || auth()->user()->getType() == "player")
                <a title="Attendance Graph" class="btn btn-primary charts pull-right"><i
                        class="fa fa-bar-chart"></i></a>
                @endif
                <a href="{{url('/attendance/player_attendance/export')}}" class="btn btn-warning export pull-right"><i
                        class="fa fa-file-excel-o"></i>&nbsp;Export</a>



            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Player</th>
                    <th>Coach</th>
                    <th>Attendance</th>
                    <th>Absent Type</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($playerattendance as $attendance)

                <tr class="tr_{{$attendance->id}}">
                    <td>{{$attendance->player_name}}</td>
                    <td>{{$attendance->coach_name}}</td>
                    <td>
                        @if($attendance->attendance==1)
                        Present
                        @else
                        Absent
                        @endif
                    </td>
                    <td>
                        @if($attendance->absent_type==1)
                        Excused
                        @elseif($attendance->absent_type==0 && $attendance->absent_type!==NULL)
                        Unexcused
                        @endif
                    </td>
                    <td>{{$attendance->date_time}}</td>
                    <td>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{url('attendance/'.$attendance->id.'/players/view')}}">
                                        <i class="fa fa-eye"></i>{{config('strings.button.view')}}
                                    </a>
                                </li>
                                @if(auth()->user()->getType()=='admin' ||
                                auth()->user()->getType()=='coach')
                                <li>
                                    <a href="{{url('attendance/'.$attendance->id.'/players/edit')}}"><i
                                            class="fa fa-pencil"></i>{{config('strings.button.edit')}}</a>
                                </li>
                                <li>
                                    <a id="{{$attendance->id}}" class="delete"><i
                                            class="fa fa-trash"></i>{{config('strings.button.delete')}}
                                    </a>
                                </li>
                                @endif


                            </ul>
                        </div>

                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
        {{$playerattendance->links()}}
    </div>
    <!-- /.box-body -->

    @endsection

    @section('js')
    <script src="{{asset('dist/js/pages/player_attendance.js')}}"></script>
    @endsection
