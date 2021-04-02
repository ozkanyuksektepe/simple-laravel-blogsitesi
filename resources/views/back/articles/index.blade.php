@extends('back.layouts.master')
@section('title','Tüm Makaleler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title') </h6>
            <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{$news->count()}}</strong> Makale bulundu.
        <a href="{{route('admin.trashed.new')}}" class="btn btn-warning btn-sm"><i class="fa fa-trash"></i> Silinen Makaleler</a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Fotoğraf</th>
                        <th>Makale Başlığı</th>
                        <th>Kategori</th>
                        <th>Hit</th>
                        <th>Oluşturulma Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                    </thead>
                    <tbody>
                     @foreach($news as $new)
                    <tr>
                        <td>
                            <img src="{{$new->image}}" width="200">
                        </td>
                        <td>{{$new->title}}</td>
                        <td>{{$new->getCategory->name}}</td>
                        <td>{{$new->hit}}</td>
                        <td>{{$new->created_at->diffForHumans()}}</td>
                        <td>
                            <input class="switch" new-id="{{$new->id}}" type="checkbox" data-on="Aktif" data-off="Pasif" data-onstyle="success" data-offstyle="danger" @if($new->status==1) checked @endif data-toggle="toggle">
                        </td>
                        <td>
                            <a target="_blank" href="{{route('single',[$new->getCategory->slug,$new->slug])}}" title="Görüntüle" class="btn btn-sm btn-success"><i class="fa fa-eye"></i> <a/>
                            <a href="{{route('admin.makaleler.edit',$new->id)}}" title="Düzenle" class="btn btn-sm btn-primary"><i class="fa fa-pen"></i> <a/>
                            <a href="{{route('admin.delete.new',$new->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> <a/>
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
        $(function() {
            $('.switch').change(function() {
                id = $(this)[0].getAttribute('new-id');
                statu=$(this).prop('checked');
                $.get("{{route('admin.switch')}}", {id:id,statu:statu}, function(data, status){
                });
            })
        })
    </script>
@endsection
