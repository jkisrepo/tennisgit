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

    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('academies')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.edit_academy')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('/academies/'.$academy->id.'/update')}}" method="post"
            enctype="multipart/form-data">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Title:</label>
                <div class="col-sm-10">
                    <input type="text" name="title" required class="form-control" placeholder="Enter Title"
                        value="{{ $academy->title }}">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Contact:</label>
                <div class="col-sm-10">
                    <input type="number" name="contact" required class="form-control" placeholder="Enter Contact"
                        value="{{ $academy->contact }}" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Country:</label>
                <div class="col-sm-10">
                    <input type="text" name="country" required class="form-control" value="{{ $academy->country }}"
                        id="country" placeholder="Enter Country" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">State:</label>
                <div class="col-sm-10">
                    <input type="text" name="state" value="{{ $academy->state }}" class="form-control" id="contact"
                        placeholder="Enter State" required />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">City:</label>
                <div class="col-sm-10">
                    <input type="text" name="city" class="form-control" id="city" value="{{ $academy->city }}"
                        placeholder="Enter city" required />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address:</label>
                <div class="col-sm-10">
                    <textarea name="address" class="form-control" id="address" placeholder="Enter Address"
                        required>{{ $academy->address }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Court Types:</label>
                <div class="col-sm-10">
                    <select class="form-control" name="court_type[]" id="court_type" multiple="multiple" required>
                        <option value="" selected disabled>Select Please</option>
                        @foreach($court_types as $court_type)
                        @if(in_array($court_type->id,$academy_court))
                        <option selected="selected" value="{{$court_type->id}}">{{$court_type->court_type}}</option>
                        @else
                        <option value="{{$court_type->id}}">{{$court_type->court_type}}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="col-md-10">
                    <input type="submit" class="btn btn-{{config('strings.button.success')}}"
                        value="{{config('strings.button.save')}}">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('js')
<script src="{{asset('dist/js/pages/edit_academy.js')}}"></script>>
@endsection
