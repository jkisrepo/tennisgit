@extends('master')
@section('css')
@endsection
@section('content')
<div class="body box-primary">


    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            {{$player->name}}'s {{ucfirst($postData['field'])}} {{config('strings.statistics')}}

        </h1>
    </section>
    </br>


    <!-- Main content -->
    <section class="content">
        @if(!empty($byMonthAndYear))
        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="box-header">
                        <h4 class="table-heading">{{date("F", mktime(0, 0, 0, $postData['month1'], 10))}} -
                            {{$postData['year1']}}</h4>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="line-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        @endif
        @if(!empty($byYear))
        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="box-header">
                        <h4 class="table-heading">{{$postData['year2']}}</h4>
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="bar-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        @endif
    </section>

    <!-- /.content -->

</div>
@javascript('byMonthAndYear_statistic', $byMonthAndYear)
@javascript('byYear_statistic', $byYear)
@javascript('post_data_field', $postData['field'])
@endsection
@section('js')
<!-- Morris.js charts -->
<script src="{{asset('dist/js/raphael-min.js')}}"></script>
<script src="{{asset('plugins/morris/morris.min.js')}}"></script>
<script src="{{asset('dist/js/pages/statistics.js')}}"></script>
@endsection
