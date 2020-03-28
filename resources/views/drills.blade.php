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
            <a href="{{url('/drills/create')}}" class="btn btn-success btn-sm pull-right" title="Add New"><i
                    class="fa fa-plus"></i></a>
            <h3 class="table-heading">{{config('strings.drill_details')}}</h3>
        </div>

        <div class="box-header row">
            <form action="{{url('drills')}}" class="form-inline col-sm-8" method="get">

                <input type="hidden" name="searchColumn" class="form-control" value="name">

                <div class="form-group">
                    <input type="text" name="searchBy" placeholder="Search By Title" required="" class="form-control"
                        id="inputGroupSuccess1" aria-describedby="inputGroupSuccess1Status">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-default" id="table_search" value="&#xf002;">
                </div>
            </form>
            <div class="col-sm-4">
                <a href="{{url('drills/export')}}" class="btn btn-warning export pull-right"><i
                        class="fa fa-file-excel-o"></i>&nbsp;Export</a>
            </div>

        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Video</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($drills as $drill)
                <tr class="tr_{{$drill->id}}">
                    <td>{{$drill->name}}</td>
                    <td>{{$drill->description}}</td>
                    <td>
                        @if($drill->video_file != "")
                        <video width="200" controls>
                            <source src="{{asset('/drill_files/'.$drill->video_file.'')}}" type="video/mp4">
                            <source src="{{asset('/drill_files/'.$drill->video_file.'')}}" type="video/ogg">
                        </video>
                        @endif
                    </td>

                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Action <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{url('drills/'.$drill->id.'/view')}}"><i class="fa fa-eye"></i>
                                        {{config('strings.button.view')}}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{url('drills/'.$drill->id.'/edit')}}"><i class="fa fa-pencil"></i>
                                        {{config('strings.button.edit')}}
                                    </a>
                                </li>
                                <li>
                                    <a id="{{$drill->id}}" class="delete"><i class="fa fa-trash"></i>
                                        {{config('strings.button.delete')}}
                                    </a>
                                </li>


                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{$drills->links()}}
    </div>
    <!-- /.box-body -->

    @endsection

    @section('js')
    <script src="{{asset('dist/js/pages/drills.js')}}"></script>
    @endsection
