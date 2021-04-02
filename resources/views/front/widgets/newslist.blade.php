@if(count($news)>0)
@foreach($news as $new)
    <div class="post-preview">
        <a href="{{route('single', [$new->getCategory->slug,$new->slug]  )}}">
            <h2 class="post-title">
                {{$new->title}}
            </h2>
            <img src="{{$new->image}}">
            <h3 class="post-subtitle">
                {!!\Illuminate\Support\Str::limit($new->content,75)!!}
            </h3>
        </a>
        <p class="post-meta"> Kategori :<a href="#">{{$new->getCategory->name}}</a> <span class="float-right">{{$new->created_at->diffForHumans()}}</span></p>
    </div>
    @if(!$loop->last)
        <hr>
    @endif
@endforeach
@else
    <div class="alert alert-danger">
        <h1>Bu Kategoriye ait yazı bulunamadı.</h1>
    </div>
@endif

{{$news->links("pagination::bootstrap-4")}}

