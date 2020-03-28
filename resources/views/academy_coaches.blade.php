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
            <a href="{{url('/academies/'.$academy->id.'/coaches/assign')}}" class="btn btn-success btn-sm pull-right"
                title="Add New"><i class="fa fa-plus"></i></a>
            <h3 class="table-heading">{{$academy->title}}'s {{config('strings.academy_coaches_details')}}</h3>
        </div>
        <div class="box-header row">
            <form action="{{url('academies/'.$academy->id.'/coaches')}}" class="form-inline col-sm-8" method="get">

                <input type="hidden" name="searchColumn" class="form-control" value="name">

                <div class="form-group">
                    <input type="text" name="searchBy" required="" class="form-control"
                        placeholder="Search by coach name">

                </div>
                <div class="form-group">
                    <input type="submit" id="table_search" class="btn btn-default" value="&#xf002;">
                </div>
            </form>
            <div class="col-sm-4">
                <a href="{{url('academies/'.$academy->id.'/coaches/export')}}"
                    class="btn btn-warning export  pull-right"><i class="fa fa-file-excel-o"></i>&nbsp;Export</a>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Academy</th>
                    <th>Coach</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($academyCoaches as $academycoach)
                <tr>
                    <td>{{$academycoach->title}}</td>
                    <td>{{$academycoach->name}}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{url('academies/coaches/'.$academycoach->id.'/delete')}}"><i
                                            class="fa fa-trash"></i> Delete
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{$academyCoaches->links()}}
    </div>
    <!-- /.box-body -->
    @endsection
