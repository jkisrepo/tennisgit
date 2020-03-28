@extends('master')
@section('content')
<div class="box box-primary">
    <!-- /.box-header -->
  <div class="box-body">
    <div class="box-header">
      <a href="{{url('academies')}}" class="btn btn-primary btn-sm" title="Go Back"><i class="fa fa-arrow-left"></i></a>
      <a href="{{url('/academies/'.$academy->id.'/edit')}}" class="btn btn-success btn-sm pull-right" title="Academy Edit"><i class="fa fa-pencil"></i></a>
      <h3>{{config('strings.view_academy')}}</h3>
    </div>
    <form class="form-horizontal">
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Title:</label>
        <div class="col-sm-10">
          <input type="text" name="title" required class="form-control" readonly="readonly" placeholder="Enter Title" value="{{ $academy->title }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="name">Contact:</label>
        <div class="col-sm-10">
          <input type="text" name="contact" readonly="readonly" required class="form-control" placeholder="Enter Contact" value="{{ $academy->contact }}">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="email">Country:</label>
        <div class="col-sm-10">
          <input type="text" name="country" readonly="readonly" class="form-control" value="{{ $academy->country }}" id="country" placeholder="Enter Country">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="contact">State:</label>
        <div class="col-sm-10">
          <input type="text" name="state" readonly="readonly" value="{{ $academy->state }}"  class="form-control" id="contact" placeholder="Enter State">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="contact">City:</label>
        <div class="col-sm-10">
          <input type="text" name="city" readonly="readonly"  class="form-control" id="city" value="{{ $academy->city }}" placeholder="Enter city">
        </div>
      </div>
      <div class="form-group">
        <label class="control-label col-sm-2" for="address">Address:</label>
        <div class="col-sm-10">
          <textarea name="address" readonly="" style="resize:none" class="form-control" id="address" placeholder="Enter Address">{{ $academy->address }}</textarea>
        </div>
      </div>
     
      <div class="form-group">
        <label class="control-label col-sm-2" for="contact">Court Types:</label>
        <div class="col-sm-10">
          <input type="text" readonly="" value="{{$academy_courts}}" class="form-control">
        </div>
      </div>
      
    </form>
  </div>
</div>
@endsection

