@if(count($yazilar)>0)

    @foreach($yazilar as $yazi)
    <div class="post-preview">
        <a href="{{route('single',[$yazi->getCategory->slug, $yazi->slug])}}">
            <h2 class="post-title">
                {{$yazi->title}}
            </h2>
            <img src="{{$yazi->image}}" width="200"/>
            <h3 class="post-subtitle">
            </h3>
        </a>
        <p class="post-meta">
            <a href="#">{{$yazi->getCategory->name}}</a> <span class="float-right">{{$yazi->created_at->diffForHumans()}}</span>
        </p>
    </div>
    @if(!$loop->last)
        <hr>
    @endif
@endforeach
{{$yazilar->links()}}
@else
    <div class="alert alert-danger">
        <h1>Bu kategoriye ait yazi bulunamadı</h1>
    </div>
@endif
