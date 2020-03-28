@extends('master')
@section('content')

<div class="box box-primary" id="playerForm">
    @if(session('message'))
    </br>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{ session('message') }}.
    </div>
    @endif
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('players')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.edit_player_form')}}</h3>
        </div>
        <form class="form-horizontal " role="form" action="{{url('players/'.$player->id.'/update')}}" method="post"
            enctype="multipart/form-data">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" required class="form-control" value="{{$player->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Parent:</label>
                    <div class="col-sm-10">
                        <input class="form-control" required name="parent" placeholder="Enter parent name"
                            value="{{$player->parent_name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" required class="form-control" id="email"
                            placeholder="Enter email" value="{{$player->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Contact:</label>
                    <div class="col-sm-10">
                        <input type="number" name="contact" required class="form-control" id="contact"
                            placeholder="Enter Contact" value="{{$player->contact}}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Gender:</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" required name="gender" id="inlineRadio1" @if($player->gender == "0")
                            checked @endif value="0"> Male
                        </label>
                        <label class="radio-inline">
                            <input type="radio" required name="gender" id="inlineRadio2" @if($player->gender == "1")
                            checked @endif value="1"> Female
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Date Of Birth:</label>
                    <div class="col-sm-10">
                        <input type="text" name="dob" required id="datetimepicker1" class="form-control"
                            placeholder="Choose Date Of Birth" value="{{$player->dob}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Address:</label>
                    <div class="col-sm-10">
                        <textarea name="address" required class="form-control" id="address"
                            placeholder="Enter Address">{{$player->address}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Style Of Play:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="stanceid" id="stanceid" required>
                            <option value="" selected disabled>Select Please</option>
                            @foreach($stances as $stance)
                            @if($player->stanceid==$stance->id)
                            <option selected="selected" value="{{$stance->id}}">{{$stance->stance}}</option>
                            @else
                            <option value="{{$stance->id}}">{{$stance->stance}}</option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="Coach">Academy:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="academyId" id="academyId" required>
                            @if(auth()->user()->getType() == "coach")
                            <option value="{{auth()->user()->id}}">
                                {{auth()->user()->name}}</option>
                            @else
                            <option value="" selected disabled>Select Please</option>
                            @foreach($academies as $academy)
                            @if($player->academy_id==$academy->id)
                            <option selected="selected" value="{{$academy->id}}">{{$academy->title}}</option>
                            @else
                            <option value="{{$academy->id}}">{{$academy->title}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="Coach">Coach:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="coachid" id="coachid" required>
                            @if(auth()->user()->getType() == "coach")
                            <option value="{{auth()->user()->id}}">
                                {{auth()->user()->name}}</option>
                            @else
                            <option value="" selected disabled>Select Please</option>
                            @foreach($coaches as $coach)
                            @if($player->coachid==$coach->id)
                            <option selected="selected" value="{{$coach->id}}">{{$coach->name}}</option>
                            @else
                            <option value="{{$coach->id}}">{{$coach->name}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="remark">Remark:</label>
                    <div class="col-sm-10">
                        <textarea name="remark" class="form-control" id="remark"
                            placeholder="Enter Remark">{{$player->remark}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2"></label>
                    <div class="col-md-10">
                        <input type="submit" class="btn btn-{{config('strings.button.success')}}"
                            value="{{config('strings.button.save')}}">
                    </div>
                </div>
            </div>
            <div class="col-sm-4">

                @if($player->profile_picture ==NULL )
                <img src="{{ asset('images/images2.jpg')}}" height="200" width="200" style="margin-bottom: 10px">
                @else
                <img src="{{ asset('images/'.$player->profile_picture.'')}}" height="200" width="200"
                    style="margin-bottom: 10px">
                @endif
                <input type="file" name="profile_picture" class="form-control">
            </div>
        </form>
    </div>
</div>

@endsection

@section('js')
<script src="{{asset('dist/js/pages/update_player.js')}}"></script>
@endsection
