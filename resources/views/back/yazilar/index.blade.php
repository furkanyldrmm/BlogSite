@extends('back.layouts.master')
@section('title')
    Tüm Postlar
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 float-right font-weight-bold text-primary">{{$yazilar->count() ."yazi bulundu"}}
                <a href="{{route('admin.trashed.yazilar')}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"> </i>Silinen Makaleler </a>

            </h6>


            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotograf</th>
                        <th>Post Başlığı</th>
                        <th>Kategori</th>
                        <th>Hit</th>
                        <th>Durum</th>
                        <th>Oluşturulma Tarih</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($yazilar as $yazi)
                        <tr>
                            <td><img src="{{asset($yazi->image)}}" width="200px" alt="fotograf"/></td>
                            <td>{{$yazi->title}}</td>
                            <td>{{$yazi->getCategory->name}}</td>
                            <td>{{$yazi->hit}}</td>
                            <td>
                                <input class="switch" article-id="{{$yazi->id}}" type="checkbox" data-on="Aktif"
                                       data-onstyle="success" data-offstyle="danger" data-off="Pasif"
                                       @if($yazi->status==1) checked @endif data-toggle="toggle">

                            </td>
                            <td>{{$yazi->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('single',[$yazi->getCategory->slug,$yazi->slug])}}" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                <a href="{{route('admin.yazilar.edit',$yazi->id)}}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-pen"></i></a>
                                <a href="{{route('admin.yazilar.sil',$yazi->id)}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>


                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('css')

    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
@endsection

@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        $(function () {
            $('.switch').change(function () {
                id = $(this)[0].getAttribute('article-id');
                statu = $(this).prop('checked');
                $.get("{{route('admin.switch')}}", {id: id , statu: statu}, function (data, status) {

                });

            })
        })


    </script>
@endsection
