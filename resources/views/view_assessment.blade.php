@extends('master')
@section('content')

<div class="box box-primary">
    <!-- /.box-header -->
    <div class="box-body">
        <div class="box-header">
            <a href="{{url('players/'.$player->id.'/assessments')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.view_assessment')}} for {{$player->name}}</h3>
        </div>


        <div class="row">
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

        <ul class="nav nav-pills" id="assessment-type">
            <li class="active"><a data-toggle="tab" href="#home">Technical</a></li>
            <li><a data-toggle="tab" href="#menu1">Physical</a></li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <form method="post">
                    <div class="form-group">
                        <label for="email">Forehand:</label>

                        <textarea name="forehand_review" class="form-control" placeholder="Enter Backhand Review"
                            disabled="">{{$assessment->forehand->review}}</textarea></br>

                        <div class="rating-select">

                            <?php $forehand_rate=5-(int)$assessment->forehand->rating;
                            $assessment->forehand->rating = $assessment->forehand->rating =="" ? 0 : (int) $assessment->forehand->rating;?>
                            @for($i = 0; $i < $assessment->forehand->rating; $i++)
                                <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                                        data-value="{{$i+1}}"></span></div>
                                @endfor
                                @for($j = $assessment->forehand->rating; $j < 5; $j++) <div
                                    class="btn btn-default btn-sm"><span class="glyphicon glyphicon-star-empty"
                                        data-value="{{$j+1}}"></span></div>
                        @endfor
                        <input name="forehand_rate" value="{{$assessment->forehand->rating}}" class="rate"
                            type="hidden">
                    </div>
            </div>
            <div class="form-group">
                <label for="email">Backhand:</label>

                <textarea name="backhand_review" class="form-control" placeholder="Enter Forehand Review"
                    disabled="">{{$assessment->backhand->review}}</textarea></br>

                <div class="rating-select">
                    <?php $backhand_rate=5-(int)$assessment->backhand->rating;
                    $assessment->backhand->rating = $assessment->backhand->rating =="" ? 0 : (int) $assessment->backhand->rating;?>
                    @for($i = 0; $i < $assessment->backhand->rating; $i++)
                        <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                                data-value="{{$i+1}}"></span></div>
                        @endfor
                        @for($j = $assessment->backhand->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                                class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
                @endfor
                <input name="backhand_rate" value="{{$assessment->backhand->rating}}" class="rate" type="hidden">
            </div>

        </div>
        <div class="form-group">
            <label for="email">Serve:</label>

            <textarea name="serve_review" class="form-control" placeholder="Enter Serve Review"
                disabled="">{{$assessment->serve->review}}</textarea></br>

            <div class="rating-select">
                <?php $serve_rate=5-(int)$assessment->serve->rating;
                $assessment->serve->rating = $assessment->serve->rating =="" ? 0 : (int) $assessment->serve->rating;?>
                @for($i = 0; $i < $assessment->serve->rating; $i++)
                    <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                            data-value="{{$i+1}}"></span></div>
                    @endfor
                    @for($j = $assessment->serve->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                            class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
            @endfor
            <input name="serve_rate" class="rate" value="{{$assessment->serve->rating}}" type="hidden">
        </div>

    </div>
    <div class="form-group">
        <label for="email">Return:</label>

        <textarea name="return_review" class="form-control" placeholder="Enter Return Review"
            disabled="">{{$assessment->return->review}}</textarea></br>


        <div class="rating-select">
            <?php $return_rate=5-(int)$assessment->return->rating;
            $assessment->return->rating = $assessment->return->rating =="" ? 0 : (int) $assessment->return->rating?>
            @for($i = 0; $i < $assessment->return->rating; $i++)
                <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                        data-value="{{$i+1}}"></span></div>
                @endfor
                @for($j = $assessment->return->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
        @endfor
        <input name="return_rate" value="{{$assessment->return->rating}}" class="rate" type="hidden">
    </div>

</div>
<div class="form-group">
    <label for="email">Volley:</label>

    <textarea name="volley_review" class="form-control" placeholder="Enter Volley Review"
        disabled="">{{$assessment->volley->review}}</textarea></br>

    <div class="rating-select">
        <?php $volley_rate=5-(int)$assessment->volley->rating;
        $assessment->volley->rating = $assessment->volley->rating =="" ? 0 : (int) $assessment->volley->rating?>
        @for($i = 0; $i < $assessment->volley->rating; $i++)
            <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                    data-value="{{$i+1}}"></span></div>
            @endfor
            @for($j = $assessment->volley->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                    class="glyphicon glyphicon-star-empty" data-value="{{$i+1}}"></span></div>
    @endfor
    <input name="volley_rate" class="rate" value="{{$assessment->volley->rating}}" type="hidden">
</div>

</div>
<div class="form-group">
    <label for="email">Positioning:</label>

    <textarea name="positioning_review" class="form-control" placeholder="Enter Positioning Review"
        disabled="">{{$assessment->positioning->review}}</textarea></br>

    <div class="rating-select">
        <?php $positioning_rate=5-(int)$assessment->positioning->rating;
        $assessment->positioning->rating = $assessment->positioning->rating =="" ? 0 : (int) $assessment->positioning->rating;?>
        @for($i = 0; $i < $assessment->positioning->rating; $i++)
            <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                    data-value="{{$i+1}}"></span></div>
            @endfor
            @for($j = $assessment->positioning->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                    class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
    @endfor
    <input name="positioning_rate" value="{{$assessment->positioning->rating}}" class="rate" type="hidden">
</div>

</div>
<div class="form-group">
    <label for="email">Smash:</label>

    <textarea class="form-control" disabled="">{{$assessment->smash->review}}</textarea></br>

    <div class="rating-select">
        <?php $smash_rate=5-(int)$assessment->smash->rating;
        $assessment->smash->rating = $assessment->smash->rating =="" ? 0 : (int) $assessment->smash->rating;?>
        @for($i = 0; $i < $assessment->smash->rating; $i++)
            <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                    data-value="{{$i+1}}"></span></div>
            @endfor
            @for($j = $assessment->smash->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                    class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
    @endfor
    <input value="{{$assessment->smash->rating}}" class="rate" type="hidden">
</div>

</div>
</form>
</div>
<div id="menu1" class="tab-pane fade in">
    <div class="form-group">
        <label for="email">Strength:</label>

        <textarea name="strength_review" class="form-control" placeholder="Enter Strength And Power Review"
            disabled="">{{$assessment->strength->review}}</textarea></br>

        <div class="rating-select">
            <?php $strength_rate=5-(int)$assessment->strength->rating;
            $assessment->strength->rating = $assessment->strength->rating == "" ? 0 : (int) $assessment->strength->rating;?>
            @for($i = 0; $i < $assessment->strength->rating; $i++)
                <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                        data-value="{{$i+1}}"></span></div>
                @endfor
                @for($j = $assessment->strength->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                        class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
        @endfor
        <input name="strength_rate" value="{{$assessment->strength->rating}}" class="rate" type="hidden">
    </div>
</div>
<div class="form-group">
    <label for="email">Power:</label>

    <textarea name="power_review" class="form-control" placeholder="Enter Strength And Power Review"
        disabled="">{{$assessment->power->review}}</textarea></br>

    <div class="rating-select">
        <?php $power_rate=5-(int)$assessment->power->rating;
        $assessment->power->rating = $assessment->power->rating == "" ? 0 : (int) $assessment->power->rating;?>
        @for($i = 0; $i < $assessment->power->rating; $i++)
            <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                    data-value="{{$i+1}}"></span></div>
            @endfor
            @for($j = $assessment->power->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                    class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
    @endfor
    <input name="power_rate" value="{{$assessment->power->rating}}" class="rate" type="hidden">
</div>
</div>

<div class="form-group">
    <label for="email">Speed:</label>

    <textarea name="speed_review" class="form-control" disabled="">{{$assessment->speed->review}}</textarea></br>

    <div class="rating-select">
        <?php $speed_rate=5-(int)$assessment->speed->rating ;
        $assessment->speed->rating = $assessment->speed->rating == "" ? 0 : (int) $assessment->speed->rating;?>
        @for($i = 0; $i < $assessment->speed->rating; $i++)
            <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                    data-value="{{$i+1}}"></span></div>
            @endfor
            @for($j = $assessment->speed->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                    class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
    @endfor
    <input name="speed_rate" value="{{$assessment->agility->rating}}" class="rate" type="hidden">
</div>

</div>
<div class="form-group">
    <label for="email">Agility:</label>

    <textarea name="agility_review" class="form-control" disabled="">{{$assessment->agility->review}}</textarea></br>

    <div class="rating-select">
        <?php $speed_agility_rate=5-(int)$assessment->agility->rating;
        $assessment->agility->rating = $assessment->agility->rating == "" ? 0 : (int) $assessment->agility->rating;?>
        @for($i = 0; $i < $assessment->agility->rating; $i++)
            <div class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-star-empty"
                    data-value="{{$i+1}}"></span></div>
            @endfor
            @for($j = $assessment->agility->rating; $j < 5; $j++) <div class="btn btn-default btn-sm"><span
                    class="glyphicon glyphicon-star-empty" data-value="{{$j+1}}"></span></div>
    @endfor
    <input name="agility_rate" value="{{$assessment->agility->rating}}" class="rate" type="hidden">
</div>
</div>
</div>
</div>
</div>
@endsection
