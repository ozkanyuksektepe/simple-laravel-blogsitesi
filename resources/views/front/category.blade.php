@extends('front.layouts.master')
@section('title',$category->name.' Kategorisi | '.count($news). ' Yazı bulundu.')
@section('content')

     <div class="col-md-9 mx-auto">
        @include('front.widgets.newslist')
      </div>
@include('front.Widgets.categoryWidget')
@endsection
