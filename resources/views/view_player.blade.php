@extends('master')
@section('content')
<div class="box box-primary">
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('players')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            @if(auth()->user()->getType() == "admin")
            <a href="{{url('/players/'.$player->id.'/edit')}}" class="btn btn-success btn-sm pull-right"
                title="Player Edit"><i class="fa fa-pencil"></i></a>
            @endif
            <h3>{{config('strings.view_player_details')}}</h3>
        </div>
        <form class="form-horizontal ">
            <div class="col-sm-8">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" disabled="disabled" required class="form-control"
                            value="{{$player->name}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Parent:</label>
                    <div class="col-sm-10">
                        <input class="form-control" value="{{$player->parent_name}}" disabled="disabled">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">Email:</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" disabled="disabled" class="form-control" id="email"
                            placeholder="Enter email" value="{{$player->email}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Contact:</label>
                    <div class="col-sm-10">
                        <input type="text" name="contact" disabled="disabled" maxlength="10" class="form-control"
                            id="contact" placeholder="Enter Contact" value="{{$player->contact}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Gender:</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="gender" disabled="disabled" id="inlineRadio1" @if($player->gender
                            == "0") checked @endif value="0"> Male
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="gender" disabled="disabled" id="inlineRadio2" @if($player->gender
                            == "1") checked @endif value="1"> Female
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Date Of Birth:</label>
                    <div class="col-sm-10">
                        <input type="text" name="dob" disabled="disabled" id="datetimepicker1" class="form-control"
                            placeholder="Choose Date Of Birth" value="{{$player->dob}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Address:</label>
                    <div class="col-sm-10">
                        <textarea name="address" disabled="disabled" class="form-control" id="address"
                            placeholder="Enter Address">{{$player->address}}</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="contact">Style Of Play:</label>
                    <div class="col-sm-10">
                        <input class="form-control" value="{{$stance->stance}}" disabled="disabled">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="Coach">Academy:</label>
                    <div class="col-sm-10">
                        <input class="form-control" value="{{$academy->title}}" disabled="disabled">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="Coach">Coach:</label>
                    <div class="col-sm-10">
                        <input class="form-control" value="{{$coach->name}}" disabled="disabled">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="remark">Remark:</label>
                    <div class="col-sm-10">
                        <textarea name="remark" disabled="disabled" class="form-control" id="remark"
                            placeholder="Enter Remark">{{$player->remark}}</textarea>
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
            </div>
        </form>
    </div>
</div>
@endsection
