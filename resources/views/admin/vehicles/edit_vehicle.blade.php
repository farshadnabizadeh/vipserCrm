@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-danger mt-3" onclick="previousPage();"><i class="fa fa-chevron-left" aria-hidden="true"></i> Önceki Sayfa</button>
            <div class="card p-4 mt-3">
                <div class="card-title">
                    <h2>Aracı Güncelle</h2>
                    <p class="float-right last-user">İşlem Yapan Son Kullanıcı: {{ $vehicle->user->name }}</p>
                </div>
                <form action="{{ route('vehicle.update', ['id' => $vehicle->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="brandId">Marka</label>
                                <select class="form-control" name="brandId" id="brandId">
                                    <option value="{{ $vehicle->brand->id }}" selected>{{ $vehicle->brand->name }}</option>
                                    @foreach($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" name="model" id="model" value="{{ $vehicle->model }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="seat">Koltuk Sayısı</label>
                                <input type="text" class="form-control" name="seat" id="seat" placeholder="Koltuk Sayısı" value="{{ $vehicle->seat }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="suitcase">Bavul Sayısı</label>
                                <input type="text" class="form-control" name="suitcase" id="suitcase" placeholder="Bavul Sayısı" value="{{ $vehicle->suitcase }}">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-5 float-right">Güncelle <i class="fa fa-check" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
