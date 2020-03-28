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
            <a href="{{url('players')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.new_player_form')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('players/add')}}" method="post"
            enctype="multipart/form-data">
            <div class="form-group">
                <label class="control-label col-sm-2" for="picture">Upload Picture:</label>
                <div class="col-sm-10">
                    <input type="file" name="profile_picture" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Name:</label>
                <div class="col-sm-10">
                    <input type="text" name="name" placeholder="Enter name" required class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Parent Name:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="parent" placeholder="Enter parent name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
                <div class="col-sm-10">
                    <input type="email" name="email" required class="form-control" id="email" placeholder="Enter email">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Contact:</label>
                <div class="col-sm-10">
                    <input type="number" name="contact" required class="form-control" id="contact"
                        placeholder="Enter Contact">
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Gender:</label>
                <div class="col-sm-10">
                    <label class="radio-inline">
                        <input type="radio" required name="gender" id="inlineRadio1" value="0"> Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" required name="gender" id="inlineRadio2" value="1"> Female
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Date Of Birth:</label>
                <div class="col-sm-10">
                    <input type="text" required name="dob" id="datetimepicker1" class="form-control"
                        placeholder="Choose Date Of Birth">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address:</label>
                <div class="col-sm-10">
                    <textarea rows="3" required name="address" class="form-control" id="address"
                        placeholder="Enter Address"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Style Of Play:</label>
                <div class="col-sm-10">
                    <select class="form-control" name="stanceid" id="stanceid" required>
                        <option value="" selected disabled>Select Please</option>
                        @foreach($stances as $stance)
                        <option value="{{$stance->id}}">{{$stance->stance}}</option>
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
                            {{auth()->user()->name}}
                        </option>
                        @else
                        <option value="" selected disabled>Select Please</option>
                        @foreach($academies as $academy)
                        <option value="{{$academy->id}}">{{$academy->title}}</option>
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
                        <option value="{{$coach->id}}">{{$coach->name}}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="remark">Remark:</label>
                <div class="col-sm-10">
                    <textarea name="remark" class="form-control" id="remark" placeholder="Enter Remark"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="col-md-10">
                    <input type="submit" class="btn btn-{{config('strings.button.success')}}"
                        value="{{config('strings.button.save')}}">
                    <input type="submit" name="addNew" class="btn btn-{{config('strings.button.info')}}"
                        value="{{config('strings.button.save_n_new')}}">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('dist/js/pages/add_player.js')}}"></script>
@endsection
