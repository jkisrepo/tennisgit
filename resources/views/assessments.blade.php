@extends('master')
@section('content')

<div class="modal fade in" id="myModal2" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form class="form-inline" method="get" action="{{url('/players/'.$player->id.'/statistics')}}">
                <div class="modal-body">


                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4>{{config('strings.graph_for')}}</h4>
                    <hr>
                    <div class="row">

                        <div class="form-group">
                            <div class="col-sm-6">
                                <label>Fields</label>
                                <select name="field" class="form-control">
                                    @foreach($fieldGraph as $field)
                                    <option value="{{$field}}">{{$field}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
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
                                    @for($i=date('Y'); $i <= date('Y')+3; $i++) <option @if(date('Y')==$i) selected=""
                                        @endif value="{{$i}}">{{$i}}</option>

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
                                    @for($i=date('Y'); $i <= date('Y')+3; $i++) <option @if(date('Y')==$i) selected=""
                                        @endif value="{{$i}}">{{$i}}</option>

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
            <a class="btn btn-success pull-right charts"><i class="fa fa-bar-chart"></i></a>

            <h3 class="table-heading">{{$player->name}}'s {{config('strings.assessments')}}</h3>


        </div>


        <div class="box-header row">
            <form style="margin-top: 8px" action="{{url('players/'.$player->id.'/assessments')}}"
                class="form-inline col-sm-8" method="get">

                <input type="hidden" name="type" value="{{Request::input('type')}}">
                <input type="hidden" name="searchColumn" class="form-control" value="date_time">

                <div class="form-group">
                    <input type="text" name="searchBy" id="datetimepicker1" placeholder="Search By Match Date"
                        required="" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" id="table_search" value="&#xf002;">
                </div>
            </form>
            <div class="col-sm-4">
                <ul class="nav nav-pills pull-right" id="assessment-type">
                    <li @if($type=="technical" ) class="active" @endif><a
                            href="{{url('players/'.$player->id.'/assessments?type=technical')}}">Technical</a></li>
                    <li @if($type=="physical" ) class="active" @endif><a
                            href="{{url('players/'.$player->id.'/assessments?type=physical')}}">Physical</a></li>
                </ul>



            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>

                    <th>Match</th>
                    @if($type == "technical")
                    <th>Forehand</th>
                    <th>Backhand</th>
                    <th>Serve</th>
                    <th>Return</th>
                    <th>Volley</th>
                    <th>Positioning</th>
                    <th>Smash</th>
                    @endif
                    @if($type == "physical")
                    <th>Strength</th>
                    <th>Speed</th>
                    <th>Power</th>
                    <th>Agility</th>
                    @endif
                    <th>Match Date</th>
                    @if(auth()->user()->getType() !== "player")
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($assessments as $assessment)
                <tr class="tr_{{$assessment->id}}">
                    <td>{{$assessment->p1name}} vs {{$assessment->p2name}}</td>
                    @foreach($fields as $field)
                    @if($assessment->{$field} != null)
                    <td>{{$assessment->{$field}->rating}}</td>
                    @else
                    <td></td>
                    @endif
                    @endforeach
                    <td>{{$assessment->date}}</td>
                    @if(auth()->user()->getType() !== "player")
                    <td>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">

                                <li>
                                    <a
                                        href="{{url('players/'.$player->id.'/assessments/'.$assessment->id.'/view?match_id='.$assessment->match_id.'')}}"><i
                                            class="fa fa-eye"></i>{{config('strings.button.view')}}
                                    </a>
                                </li>
                                <li>
                                    <a
                                        href="{{url('players/'.$player->id.'/assessments/'.$assessment->id.'/edit?match_id='.$assessment->match_id.'')}}"><i
                                            class="fa fa-pencil"></i>
                                        {{config('strings.button.edit')}}
                                    </a>
                                </li>
                                <li>
                                    <a class="delete" data-player-id="{{$player->id}}"
                                        data-assessment-id="{{$assessment->id}}"><i
                                            class="fa fa-trash"></i>{{config('strings.button.delete')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$assessments->links()}}
        <span><b>Note : </b>{{config('strings.note_assessment')}}</span>
    </div>
    <!-- /.box-body -->

    @endsection

    @section('js')
    <script src="{{asset('dist/js/pages/assessments.js')}}"> </script>
    @endsection
