@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 table-responsive">
             <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item home-page"><a href="{{ route('home') }}">Arayüz</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rota Türleri</li>
                </ol>
            </nav>
            <div class="card p-3 mt-3">
                <div class="card-title">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>Rota Türleri</h2>
                        </div>
                        <div class="col-lg-6">
                            <button data-toggle="modal" data-target="#statusModal" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Rota Türüu</button>
                        </div>
                    </div>
                </div>
                <div class="dt-responsive table-responsive">
                    <table class="table table-striped table-bordered nowrap dataTable" id="tableData">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">İşlemler</th>
                                <th scope="col">Rota Türü Adı</th>
                                <th scope="col">Rota Türü Rengi</th>
                            </tr>
                        </thead>
                        @foreach ($route_types as $route_type)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-danger dropdown-toggle action-btn" type="button" data-toggle="dropdown">İşlem <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('routetype.edit', ['id' => $route_type->id]) }}" class="btn btn-info edit-btn"><i class="fa fa-pencil-square-o"></i> Güncelle</a></li>
                                        <li><a href="{{ route('routetype.destroy', ['id' => $route_type->id]) }}" onclick="return confirm('Silmek istediğinize emin misiniz?');" class="btn btn-danger edit-btn"><i class="fa fa-trash"></i> Sil</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $route_type->name }}</td>
                            <td style="background-color: {{ $route_type->color }}"></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yeni Rota Türüu Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('routetype.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Durum Adı</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Durum Adı" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="color">Durum Rengi</label>
                                <input type="text" class="form-control" id="colorpicker" value='#276cb8' name="color" placeholder="Durum Rengi">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success float-right">Kaydet <i class="fa fa-check" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>


@endsection
