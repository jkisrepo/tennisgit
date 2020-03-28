@extends('master')
@section('content')

<div class="box box-primary">
    @if(session('message'))
    </br>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{ session('message') }}.
    </div>
    @elseif(session('error'))
    </br>
    <div class="alert alert-error">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Error!</strong> {{ session('error') }}.
    </div>
    @endif

    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('academies/'.$academy.'/coaches')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.assign_coaches_form')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('/academies/'.$academy.'/coaches/add')}}" method="post">

            <div class="form-group">
                <label class="control-label col-sm-2" for="Coach">Coach:</label>
                <div class="col-sm-10">
                    <select class="form-control" name="coachids[]" multiple="">
                        <option value="" select disabled>Select Please</option>
                        @foreach($coaches as $coach)
                        <option value="{{$coach->id}}">{{$coach->name}}</option>
                        @endforeach

                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="col-md-10">
                    <input type="submit" class="btn btn-success" value="Submit">

                </div>
            </div>
        </form>
    </div>
</div>
@endsection
