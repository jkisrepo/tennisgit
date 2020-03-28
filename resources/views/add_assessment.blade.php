@extends('master')
@section('content')
<div class="box box-primary">
    @if(session('message'))
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> {{ session('message') }}.
    </div>
    @endif

    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('schedules')}}" class="btn btn-primary btn-sm" title="Go Back">
                <i class="fa fa-arrow-left"></i>
            </a>
            <h3>{{config('strings.new_assessment')}} for {{$player->name}}</h3>
        </div>

        <div class="row">
            <div class="form-group">
                <div class="col-md-3">
                    <label for="name">Match:</label>
                    <h4>{{$match->p1name}} vs {{$match->p2name}}</h4>
                </div>
                <div class="col-md-3">
                    <label for="name">Venue:</label>
                    <h4>
                        <p>{{$academy->country}}</p>
                    </h4>
                </div>
                <div class="col-md-3">
                    <label for="name">Court:</label>
                    <h4>{{$match->court_type}}</h4>
                </div>
                <div class="col-md-3">
                    <label for="name">Time:</label>
                    <h4>{{$match->date}}</h4>
                </div>
            </div>
        </div>

        <ul class="nav nav-pills">
            <li class="active"><a data-toggle="tab" href="#home">Technical</a></li>
            <li><a data-toggle="tab" href="#menu1">Physical</a></li>
        </ul>

        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <form role="form" action="{{url('assessments/')}}" method="post">
                    <input type="hidden" name="type" value="technical">
                    <input type="hidden" name="matchid" value="{{$match->id}}">
                    <input type="hidden" name="coachid" value="{{$player->coachid}}">
                    <input type="hidden" name="playerid" value="{{$player->id}}">
                    <div class="form-group">
                        <label for="email">Forehand:</label>
                        <textarea name="forehand_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="forehand_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Backhand:</label>
                        <textarea name="backhand_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="backhand_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Serve:</label>
                        <textarea name="serve_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="serve_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Return:</label>
                        <textarea name="return_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="return_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Volley:</label>
                        <textarea name="volley_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="volley_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Positioning:</label>
                        <textarea name="positioning_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="positioning_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Smash:</label>
                        <textarea name="smash_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="smash_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-{{config('strings.button.success')}}"
                            value="{{config('strings.button.save')}}">
                    </div>
                </form>
            </div>
            <div id="menu1" class="tab-pane fade">
                <form role="form" action="{{url('assessments/')}}" method="post">
                    <input type="hidden" name="type" value="physical">
                    <input type="hidden" name="matchid" value="{{$match->id}}">
                    <input type="hidden" name="coachid" value="{{$player->coachid}}">
                    <input type="hidden" name="playerid" value="{{$player->id}}">
                    <div class="form-group">
                        <label for="email">Strength:</label>
                        <textarea name="strength_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="strength_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Power:</label>
                        <textarea name="power_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="power_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Speed:</label>
                        <textarea name="speed_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="speed_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Agility:</label>
                        <textarea name="agility_review" class="form-control"></textarea></br>
                        <div class="rating-select">
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="1"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="2"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="3"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="4"></span></div>
                            <div class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                    data-value="5"></span></div>
                            <input name="agility_rate" class="rate" type="hidden">
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-{{config('strings.button.success')}}"
                            value="{{config('strings.button.save')}}">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
@section('js')
<script src="{{asset('dist/js/pages/add_assessment.js')}}"></script>
@endsection
