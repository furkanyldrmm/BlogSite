
  <!-- Main Content -->
@extends('Front.master')
  @section('title','Anasayfa')
  @section('bg','uploads/pexels-photo-238118_copy1.jpeg')
  @section('content')
      <div class="col-lg-8 col-md-9 mx-auto">

@include('Widgets.yazilar')
      </div>
@include('Widgets.categorywidget')
  @endsection
  <!-- Footer -->
