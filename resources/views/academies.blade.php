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
    <!-- /.box-header -->

    <div class="box-body">

        <div class="box-header">
            <a href="{{url('/academies/create')}}" class="btn btn-success btn-sm pull-right" title="Add New"><i
                    class="fa fa-plus"></i></a>

            <h3 class="table-heading">{{config('strings.academy_details')}}</h3>
        </div>
        <div class="box-header row">
            <form action="{{url('academies')}}" class="form-inline col-sm-8" method="get">

                <input type="hidden" name="searchColumn" class="form-control" value="title">

                <div class="form-group">
                    <input type="text" name="searchBy" placeholder="Search By Title" required="" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" id="table_search" value="&#xf002;">
                </div>
            </form>
            <div class="col-sm-4">
                <a href="{{url('academies/export')}}" class="btn btn-warning export pull-right"><i
                        class="fa fa-file-excel-o"></i>&nbsp;Export</a>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>No. Of Coach</th>
                    <th>No. Of Players</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($academies as $key=>$academy)
                <tr class="tr_{{$academy->id}}">
                    <td>{{$academy->title}}</td>
                    <td><a class="academies_link"
                            href="{{url('academies/'.$academy->id.'/coaches')}}">{{$coaches[$key]}}</a></td>
                    <td><a class="academies_link"
                            href="{{url('academies/'.$academy->id.'/players')}}">{{$players[$key]}}</a></td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="academies/{{$academy->id}}/view"><i
                                            class="fa fa-eye"></i>{{config('strings.button.view')}}
                                    </a>
                                </li>

                                <li>
                                    <a href="academies/{{$academy->id}}/edit"><i
                                            class="fa fa-pencil"></i>{{config('strings.button.edit')}}
                                    </a>
                                </li>

                                <li>
                                    <a class="delete" id="{{$academy->id}}"><i
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
        {{$academies->links()}}
    </div>
    <!-- /.box-body -->
    @endsection

    @section('js')
    <script src="{{asset('dist/js/pages/academies.js')}}"></script>
    @endsection
