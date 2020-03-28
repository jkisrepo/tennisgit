@extends('master')
@section('content')

<div class="modal fade in" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select a Player</h4>
            </div>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<div id="myModal1" class="modal Modal1 fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Winner</h4>
            </div>
            <div style="display: none" id="winner_updated" class="alert alert-success" role="alert"></div>
            <form method="post" id="winner_form">
                <div class="modal-body">
                    <div class="container">

                        <input type="hidden" name="match_id" id="match_id">
                        <div class="form-group">
                            <div class="radio">
                                <label><input type="radio" value="-1" name="player" id="player1"><span
                                        id="winner_0"></span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label><input type="radio" value="-1" name="player" id="player2"><span
                                        id="winner_1"></span></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="radio">
                                <label><input type="radio" value="-1" name="player" id="draw">Draw</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default">Submit</button>
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
            @if(auth()->user()->getType()=="admin" || auth()->user()->getType()=="coach")
            <a href="{{url('/schedules/create')}}" class="btn btn-success btn-sm pull-right" title="Add New"><i
                    class="fa fa-plus"></i></a>
            @endif
            <h3 class="table-heading">{{config('strings.match_details')}}</h3>
        </div>

        <div class="box-header row">
            <form action="{{url('schedules')}}" class="form-inline col-sm-8" method="get">
                <div class="form-group">
                    <select name="searchColumn" id="searchColumn" class="form-control">
                        <option value="player">Player</option>
                        <option value="academy">Academy</option>
                        <option value="date_time">Date</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="searchBy" id="datetimepicker1" required="" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" id="table_search" class="btn btn-default" value="&#xf002;">
                </div>
            </form>
            <div class="col-sm-4">
                <a href="{{url('schedules/export')}}" class="btn btn-warning  pull-right export"><i
                        class="fa fa-file-excel-o"></i>&nbsp;Export</a>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Player 1</th>
                    <th>Player 2</th>
                    <th>Academy</th>
                    <th>Court</th>
                    <th>Date/Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matches as $match)
                <tr class="tr_{{$match->id}}">
                    <td>{{$match->p1name}} @if($match->winner_id == $match->player1) <b>(W)</b>
                        @elseif($match->winner_id == -1) <b>(Tied)</b> @endif</td>
                    <td>{{$match->p2name}} @if($match->winner_id == $match->player2) <b>(W)</b>
                        @elseif($match->winner_id == -1) <b>(Tied)</b> @endif</td>
                    <td>{{$match->title}}</td>
                    <td>{{$match->court_type}}</td>
                    <td>{{$match->date}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                @if(auth()->user()->getType() =="admin" ||
                                auth()->user()->getType() =="coach")
                                <li>
                                    <a class="assessment" data-match-id="{{$match->id}}"
                                        data-player1="{{$match->player1}}" data-player2="{{$match->player2}}"
                                        title="Assessments"><i
                                            class="fa fa-file"></i>{{config('strings.button.assessments')}}
                                    </a>
                                </li>
                                <li>
                                    <a class="winner" data-match-id="{{$match->id}}" data-winner="{{$match->winner_id}}"
                                        data-player1="{{$match->player1}}" data-player2="{{$match->player2}}"
                                        data-player1-name="{{$match->p1name}}" data-player2-name="{{$match->p2name}}"
                                        title="Winner"><i
                                            class="fa fa-trophy"></i>{{config('strings.button.winner')}}</a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{url('schedules/'.$match->id.'/view')}}"><i
                                            class="fa fa-eye"></i>{{config('strings.button.view')}}
                                    </a>
                                </li>
                                @if(auth()->user()->getType()=="admin" || auth()->user()->getType()=="coach")
                                <li>
                                    <a href="{{url('schedules/'.$match->id.'/edit')}}"><i class="fa fa-pencil"></i>
                                        {{config('strings.button.edit')}}
                                    </a>
                                </li>
                                <li>
                                    <a class="delete" id="{{$match->id}}"><i class="fa fa-trash"></i>
                                        {{config('strings.button.delete')}}
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
        {{$matches->links()}}
    </div>
    <!-- /.box-body -->

    @endsection

    @section('js')
    <script src="{{asset('dist/js/pages/schedules.js')}}"></script>
    @endsection
