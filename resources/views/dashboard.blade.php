@extends('master')
<div class="modal fade in" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select An Event</h4>
            </div>
            <div class="modal-body">
                <ul class="list-unstyled">
                    <li><a href="{{url('schedules/create')}}">Match</a></li>
                    <li><a href="{{url('drills/assign')}}">Drill</a></li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@section('css')
<!-- fullCalendar 2.2.5-->
<link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/fullcalendar/fullcalendar.print.css')}}" media="print">
<style type="text/css">
    .event_type {
        margin-right: 10px;
    }
</style>
@endsection
@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">

    <h1>
        {{config('strings.dashboard')}}

    </h1>

</section>
</br>
<section class="content">
    @if(auth()->user()->getType()=='admin')
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <a href="{{url('schedules')}}">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$numMatches}}</h3>

                        <p>Matches</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-trophy"></i>
                    </div>

                </div>
            </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <a href="{{url('academies')}}">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$numAcademies}}</h3>

                        <p>Academies</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-university"></i>
                    </div>

                </div>
            </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <a href="{{url('players')}}">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$numPlayers}}</h3>

                        <p>Players</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>

                </div>
            </a>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <a href="{{url('users?type=coach')}}">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$numCoaches}}</h3>

                        <p>Coaches</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user"></i>
                    </div>

                </div>
            </a>
        </div>
        <!-- ./col -->

    </div>
    @endif

    <!-- Main content -->
    <section class="content">


        <div class="row">
            <!-- /.col -->

            <div class="box box-primary">
                <div class="box-body no-padding">
                    <section class="content-header">
                        <label class="event_type">
                            <a href="{{url('/')}}" class="btn btn-default btn-sm" style="height: 25px;"></a>&nbsp;
                            @if(Request::is("dashboard"))
                            <b style="font-size: 15px;">All</b>
                            @else
                            <b style="font-weight: normal;">All</b>
                            @endif
                        </label>

                        <label class="event_type">
                            <a href="{{url('dashboard/matches')}}" class="btn btn-info btn-sm"
                                style="height: 25px;"></a>&nbsp;
                            @if(Request::is("dashboard/matches"))
                            <b style="font-size: 15px;">Matches</b>&nbsp;&nbsp;
                            @else
                            <b style="font-weight: normal;">Matches</b>&nbsp;&nbsp;
                            @endif
                        </label>

                        <label class="event_type">
                            <a href="{{url('dashboard/drills')}}" class="btn btn-danger btn-sm"
                                style="height: 25px;"></a>&nbsp;
                            @if(Request::is("dashboard/drills"))
                            <b style="font-size: 15px;">Drills</b>&nbsp;&nbsp;
                            @else
                            <b style="font-weight: normal;">Drills</b>&nbsp;&nbsp;
                            @endif

                        </label>


                        @if(auth()->user()->getType()=='admin' ||
                        auth()->user()->getType()=='coach')


                        <div class="dropdown pull-right">
                            <a class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown"><i
                                    class="fa fa-plus"></i></a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="{{url('schedules/create')}}">Match</a></li>
                                <li class="divider"></li>
                                <li><a href="{{url('drills/assign')}}">Drill</a></li>
                            </ul>
                        </div>



                        @endif
                    </section>
                    </br></br>
                    <!-- THE CALENDAR -->
                    <div id="calendar"></div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->

            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</section>
<!-- /.content -->
</div>



@javascript('dashboard_events', $events)

@endsection

@section('js')
<!-- fullCalendar 2.2.5 -->
<script src="{{asset('plugins/fullcalendar/fullcalendar.min.js')}}"></script>
<!-- Page specific script -->
<script type="text/javascript" src="{{asset('dist/js/pages/dashboard_final.js')}}"></script>
@endsection
