@extends('back.layouts.master')
@section('title')
    Post Oluştur
@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">@yield('title')</h6>
        </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach

                    </div>
                @endif
            <form method="post" action="{{route('admin.yazilar.store')}}" enctype="multipart/form-data">
                @csrf
<div class="form-group">
<label>Post Başlığı</label>
        <input type="text" name="title" class="form-control" required />
</div>

                <div class="form-group">
                    <label>Post Kategori</label>
                    <select class="form-control" name="category" required>
                        <option value="" >Seçim Yapınız</option>
                        @foreach($category as $categories)
                            <option value="{{$categories->id}}">{{$categories->name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Post Fotografı</label>
                    <input type="file" name="image" class="form-control" required />
                </div>
                <div class="form-group">
                    <label>Post İçeriği</label>
                    <label for="editor"></label><textarea id="editor" name="deneme" class="form-control" rows="4"></textarea>
                </div>
                <div class="form-group">
<button type="submit" class="btn btn-primary btn-block">Post Oluştur</button>
                </div>

            </form>
            </div>

        </div>

@endsection
@section('css')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('js')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#editor').summernote();
    });
</script>
@endsection
