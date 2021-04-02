@extends('back.layouts.master')
@section('title','Silinen Makaleler')
@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@yield('title') </h6>
            <h6 class="m-0 font-weight-bold float-right text-primary"><strong>{{$news->count()}}</strong> Makale bulundu.
                <a href="{{route('admin.makaleler.index')}}" class="btn btn-primary btn-sm"> Güncel Makaleler</a>
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
                                <a href="{{route('admin.recover.new',$new->id)}}" title="Makaleyi Geri Yükle" class="btn btn-sm btn-primary"><i class="fa fa-recycle"></i> <a/>
                                <a href="{{route('admin.hard.delete.new',$new->id)}}" title="Sil" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> <a/>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection



