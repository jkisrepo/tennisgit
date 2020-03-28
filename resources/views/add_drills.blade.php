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
      @if(URL::previous() == Request::fullUrl())
      <a onclick="urlBack()" class="btn btn-primary btn-sm" title="Go Back"><i class="fa fa-arrow-left"></i></a>
      @else
      <a href="{{url('drills')}}" class="btn btn-primary btn-sm" title="Go Back"><i class="fa fa-arrow-left"></i></a>
      @endif
      <h3>{{config('strings.new_drill_form')}}</h3>
    </div>
    <form class="form-horizontal" role="form" action="{{url('drills/add')}}" method="post" enctype="multipart/form-data">
     
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Title:</label>
        <div class="col-sm-10">
          <input name="title" required class="form-control" id="title">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="email">Description:</label>
        <div class="col-sm-10">
          <textarea name="description" class="form-control" id="description"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="contact">Video:</label>
        <div class="col-sm-10">
          <input type="file" name="video_file" class="form-control"  accept="video/*">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="contact">Images:</label>
        <div class="col-sm-10">
          <input type="file" name="image_files[]" multiple="" class="form-control"  accept="image/*">
        </div>
      </div>
      
      <div class="form-group">
        <label class="control-label col-sm-2"></label>
        <div class="col-md-10">
          <input type="submit" class="btn btn-{{config('strings.button.success')}}" value="{{config('strings.button.save')}}">
          <input type="submit" name="addNew" class="btn btn-{{config('strings.button.info')}}" value="{{config('strings.button.save_n_new')}}">
        </div>
      </div>
    </form>
  </div>
</div>
@endsection


