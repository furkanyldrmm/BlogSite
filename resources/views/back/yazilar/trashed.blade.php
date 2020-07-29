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

                            <td>{{$yazi->created_at->diffForHumans()}}</td>
                            <td>
                                <a href="{{route('admin.yazilar.recover',$yazi->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-recycle"></i></a>

                                <a href="{{route('admin.yazilar.harddelete',$yazi->id)}}" class="btn btn-sm btn-danger"><i class="fa fa-times"></i></a>


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

@endsection

@section('js')


@endsection
