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
            <a href="{{url('drills')}}" class="btn btn-primary btn-sm" title="Go Back"><i
                    class="fa fa-arrow-left"></i></a>
            <h3>{{config('strings.edit_drill_form')}}</h3>
        </div>
        <form class="form-horizontal" role="form" action="{{url('drills/'.$drill->id.'/edit')}}" method="post"
            enctype="multipart/form-data">

            <div class="form-group">
                <label class="control-label col-sm-2" for="name">Title:</label>
                <div class="col-sm-10">
                    <input name="title" value="{{$drill->name}}" required class="form-control" id="title">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Description:</label>
                <div class="col-sm-10">
                    <textarea name="description" class="form-control"
                        id="description">{{$drill->description}}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Video:</label>
                <div class="col-sm-10">
                    @if(!empty($drill->video_file))
                    <video width="200" controls>
                        <source src="{{asset('/drill_files/'.$drill->video_file.'')}}" type="video/mp4">
                        <source src="{{asset('/drill_files/'.$drill->video_file.'')}}" type="video/ogg">

                    </video>
                    @endif
                    <input type="file" name="video_file" class="form-control" accept="video/*">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact">Images:</label>
                <div class="col-sm-10">
                    <input type="file" name="image_files[]" multiple="" class="form-control" accept="image/*">
                </div>
            </div>

            @if(!empty($drill_images))

            <div class="form-group">
                <label class="control-label col-sm-2" for="contact"></label>
                <div class="col-sm-10">
                    @foreach($drill_images as $image)
                    <div class="col-sm-2">
                        <div class="img-wrap">
                            <span class="close" data-id="{{$image->id}}">&times;</span>
                            <img src="{{asset('/drill_files/'.$image->drill_image.'')}}" class="img-responsive">
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
            @endif


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
<script src="{{asset('dist/js/pages/edit_drills.js')}}"></script>
@endsection
