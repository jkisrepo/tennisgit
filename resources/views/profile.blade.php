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
            <h3 class="mtop-6">{{config('strings.profile')}}</h3>
        </div>
        <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        @if(auth()->user()->profile_picture ==NULL)
                        <img src="{{ asset('images/images2.jpg')}}" class="profile-user-img img-responsive img-circle"
                            alt="User profile picture">
                        @else
                        <img class="profile-user-img img-responsive img-circle"
                            src="{{asset('images/'.auth()->user()->profile_picture.'')}}" alt="User profile picture">
                        @endif

                        <h3 class="profile-username text-center mtop-6">
                            {{  auth()->user()->name }}</h3>
                        <p class="text-muted text-center">{{auth()->user()->getType()}}</p>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

                <!-- About Me Box -->

                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <form action="{{url('profile_update')}}" method="post" class="form-horizontal" role="form"
                    enctype="multipart/form-data">

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Name:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" required="required" name="name"
                                placeholder="Enter name" value="{{auth()->user()->name}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Email:</label>
                        <div class="col-sm-8">
                            <input type="email" class="form-control" required="required" name="email"
                                placeholder="Enter Email" value="{{auth()->user()->email}}" readonly>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="name">Profile Picture:</label>
                        <div class="col-sm-8">
                            <input type="file" class="form-control" name="profile_picture">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" class="btn btn-{{config('strings.button.success')}}"
                                value="{{config('strings.button.save')}}">
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
        </div>

    </div>
</div>
@endsection
