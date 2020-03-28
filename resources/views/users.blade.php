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
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('/users/create?type='.Request::input('type').'')}}" class="btn btn-success btn-sm pull-right"
                title="New User"><i class="fa fa-plus"></i></a>
            @if(app('request')->input('type') == "admin")
            <h3 class="table-heading">{{config('strings.admin_details')}}</h3>
            @elseif(app('request')->input('type') == "coach")
            <h3 class="table-heading">{{config('strings.coach_details')}}</h3>
            @endif
            <div class="box-header row">
                <form action="{{url('users')}}" class="form-inline col-sm-8" method="get">
                    <input type="hidden" name="type" value="{{Request::input('type')}}">
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
                    @if(app('request')->input('type'))

                    <a href="{{url('users/export?type='.app('request')->input('type').'')}}"
                        class="btn btn-warning  pull-right export"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>

                    @else
                    <a href="{{url('users/export')}}" class="btn btn-warning export pull-right"><i
                            class="fa fa-file-excel-o"></i>&nbsp;Export</a>
                    @endif
                </div>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="tr_{{$user->id}}">
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">

                                @if(app('request')->input('type')=="coach")
                                <li>
                                    <a href="{{url('attendance/coaches?coach_id='.$user->id.'')}}"><i
                                            class="fa fa-dashboard"></i>{{config('strings.button.attendance')}}
                                    </a>
                                </li>
                                @endif
                                <li>
                                    <a href="{{url('users/'.$user->id.'/view?type='.Request::input('type').'')}}"><i
                                            class="fa fa-eye"></i>{{config('strings.button.view')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('users/'.$user->id.'/edit?type='.Request::input('type').'')}}"><i
                                            class="fa fa-pencil"></i>
                                        {{config('strings.button.edit')}}
                                    </a>
                                </li>
                                <li>
                                    <a id="{{$user->id}}" class="delete"><i
                                            class="fa fa-trash"></i>{{config('strings.button.delete')}}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$users->links()}}
    </div>
    @endsection

    @section('js')
    <script src="{{asset('dist/js/pages/users.js')}}"></script>
    @endsection
