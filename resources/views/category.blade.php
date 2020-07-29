
<!-- Main Content -->
@extends('Front.master')
@section('title',$category->name. ' Kategorisi | '.count($yazilar). ' yazi bulundu' )
@section('content')
    <div class="col-lg-8 col-md-9 mx-auto">
   @include('Widgets.yazilar')

    </div>
    @include('Widgets.categorywidget')
@endsection
<!-- Footer -->
