
<!-- Main Content -->
@extends('Front.master')
@section('title',$deneme->title)
@section('bg',asset($deneme->image))
@section('content')



                <div class="col-md-9 mx-auto">
{!!$deneme->content!!}
                    <br></br>
<span class="text-danger">Okunma sayisi: <b>{{$deneme->hit}}</b></span>
        </div>





    @include('Widgets.categorywidget')
@endsection
<!-- Footer -->
