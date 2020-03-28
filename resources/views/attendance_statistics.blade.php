@extends('master')
@section('css')
@endsection
@section('content')
<div class="body box-primary">


    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            {{ucfirst($user->name)}}'s Attendance {{config('strings.statistics')}}

        </h1>
    </section>
    </br>


    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="box-header">
                        <h4 class="table-heading">{{date("F", mktime(0, 0, 0, $postData['month1'], 10))}} -
                            {{$postData['year1']}}</h4>
                        <b>Total Present : </b> {{$totalByMonthAndYear->present}}
                        <b>Total Absent : </b> {{$totalByMonthAndYear->absent}}

                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="bar-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="box-header">
                        <h4 class="table-heading">{{$postData['year2']}}</h4>
                        <b>Total Present : </b> {{$totalByYear->present}}
                        <b>Total Absent : </b> {{$totalByYear->absent}}
                    </div>
                </div>
                <div class="box-body chart-responsive">
                    <div class="chart" id="bar-chart1" style="height: 300px;"></div>
                </div>
            </div>
        </div>

    </section>

    <!-- /.content -->

</div>
@javascript('byMonthAndYear', $byMonthAndYear)
@javascript('byYear', $byYear)
@endsection
@section('js')
<!-- Morris.js charts -->
<script src="{{asset('dist/js/raphael-min.js')}}"></script>
<script src="{{asset('plugins/morris/morris.min.js')}}"></script>
<script src="{{asset('dist/js/pages/attendance_statistics.js')}}"></script>
@endsection
