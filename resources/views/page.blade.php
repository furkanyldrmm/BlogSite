@extends('Front.master')
@section('title',$sayfa->title)
@section('bg',$sayfa->image)
@section('content')
<!-- Main Content -->

        <div class="col-lg-8 col-md-10 mx-auto">
            {{$sayfa->content}}
        </div>

@endsection


