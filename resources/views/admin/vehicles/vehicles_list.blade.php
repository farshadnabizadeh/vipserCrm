@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 table-responsive">
            <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item home-page"><a href="{{ route('home') }}">Arayüz</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Araçlar</li>
                </ol>
            </nav>
            <div class="card p-3 mt-3">
                <div class="card-title">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>Araçlar</h2>
                        </div>
                        <div class="col-lg-6">
                            <button data-toggle="modal" data-target="#vehicleModal" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Araç Ekle</button>
                        </div>
                    </div>
                </div>
                <div class="dt-responsive table-responsive">
                    <table class="table table-striped table-bordered nowrap dataTable" id="tableData">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">İşlem</th>
                                <th scope="col">Plaka</th>
                                <th scope="col">Marka</th>
                                <th scope="col">Model</th>
                                <th scope="col">Koltuk Sayısı (Max)</th>
                                <th scope="col">Bavul Sayısı (Max)</th>
                            </tr>
                        </thead>
                        @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-dark dropdown-toggle action-btn" type="button" data-toggle="dropdown">İşlem <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('vehicle.edit', ['id' => $vehicle->id]) }}" class="btn btn-info edit-btn"><i class="fa fa-pencil-square-o"></i> Güncelle</a></li>
                                        <li><a href="{{ route('vehicle.destroy', ['id' => $vehicle->id]) }}" onclick="return confirm('Are you sure?');" class="btn btn-danger edit-btn"><i class="fa fa-trash"></i> Sil</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $vehicle->number_plate }}</td>
                            <td>{{ $vehicle->brand->name }}</td>
                            <td>{{ $vehicle->model }}</td>
                            <td>{{ $vehicle->seat }}</td>
                            <td>{{ $vehicle->suitcase }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="vehicleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yeni Araç Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('vehicle.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="brandId">Marka</label>
                                <select name="brandId" id="brandId" class="form-control">
                                    <option></option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" id="model" name="model" placeholder="Model" required>
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
