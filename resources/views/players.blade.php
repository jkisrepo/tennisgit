@extends('master')
@section('content')
<!-- Modal -->


<div class="box box-primary">

    @if(session('message'))
    </br>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{ session('message') }}.
    </div>
    @endif


    <div style="display: none" id="player_delete" class="alert alert-success" role="alert"></div>

    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            @if(auth()->user()->getType() == "admin")
            <a href="{{url('/players/create')}}" class="btn btn-success btn-sm pull-right" title="New Player"><i
                    class="fa fa-plus"></i></a>
            @endif

            <h3 class="table-heading">{{config('strings.players')}}</h3>
        </div>

        <div class="box-header row">
            <form action="{{url('players')}}" class="form-inline col-sm-8" method="get">
                <div class="form-group">
                    <select name="searchColumn" class="form-control">
                        <option value="name">Name</option>
                        <option value="email">Email</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" name="searchBy" required="" class="form-control">

                </div>
                <div class="form-group">
                    <input type="submit" id="table_search" class="btn btn-default" value="&#xf002;">
                </div>
            </form>
            <div class="col-sm-4">
                <a href="{{url('players/export')}}" class="btn btn-warning export pull-right"><i
                        class="fa fa-file-excel-o"></i>&nbsp;Export</a>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Academy</th>
                    <th>Coach</th>
                    <th>Contact</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($players as $player)

                <tr class="tr_{{$player->id}}">
                    <td>{{$player->name}}</td>
                    <td>{{$player->email}}</td>
                    <td>{{$player->title}}</td>
                    <td>{{$player->cname}}</td>
                    <td>{{$player->contact}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">


                                <li>
                                    <a href="{{url('players/'.$player->id.'/view')}}">
                                        <i class="fa fa-eye"></i>
                                        {{config('strings.button.view')}}
                                    </a>
                                </li>

                                @if(auth()->user()->getType() == "admin")
                                <li>
                                    <a href="{{url('players/'.$player->id.'/edit')}}">
                                        <i class="fa fa-pencil"></i>
                                        {{config('strings.button.edit')}}
                                    </a>
                                </li>
                                <li>
                                    <a class="delete" id="{{$player->id}}">
                                        <i class="fa fa-trash"></i>
                                        {{config('strings.button.delete')}}
                                    </a>
                                </li>
                                @endif
                                <li class="divider"></li>
                                <li>
                                    <a href="{{url('attendance/players?player_id='.$player->id.'')}}">
                                        <i class="fa fa-dashboard"></i>
                                        {{config('strings.button.attendance')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('players/'.$player->id.'/assessments?type=technical')}}">
                                        <i class="fa fa-file"></i>
                                        {{config('strings.button.assessments')}}
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$players->links()}}
    </div>
    <!-- /.box-body -->
    @endsection
    @section('js')
    <script src="{{asset('dist/js/pages/players.js')}}"></script>
    @endsection
