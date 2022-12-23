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
                                <label for="plate">Plaka</label>
                                <input type="text" class="form-control" name="plate" placeholder="Plaka" id="plate" value="{{ $vehicle->number_plate }}" required>
                            </div>
                        </div>
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
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="model">Model</label>
                                <input type="text" class="form-control" name="model" id="model" value="{{ $vehicle->model }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="seat">Koltuk Sayısı</label>
                                <input type="text" class="form-control" name="seat" id="seat" placeholder="Koltuk Sayısı" value="{{ $vehicle->seat }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="suitcase">Bavul Sayısı</label>
                                <input type="text" class="form-control" name="suitcase" id="suitcase" placeholder="Bavul Sayısı" value="{{ $vehicle->suitcase }}">
                            </div>
                        </div>
                    </div>
                    <ul class="nav nav-tabs mt-3 d-flex" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="active-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Aktif Rezervasyonlar</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="cancel-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Arşivlenen Rezervasyonlar</a>
                        </li>
                    </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="active-tab">
                                <div class="col-lg-12">
                                    <div class="card h-100 mt-3">
                                        <div class="card-body">
                                            <h3 class="d-flex align-items-center mb-3">Müşteri Ait Rezervasyonlar</h3>
                                            <a href="{{ route('reservation.create') }}" class="btn btn-primary float-right add-new-btn"> <i class="fa fa-plus"></i> Yeni Rezervasyon </a>
                                            <div class="dt-responsive table-responsive">
                                                <table class="table table-striped table-bordered nowrap dataTable" id="dataTable">
                                                    <thead class="thead-light">
                                                        <th scope="col">İşlem</th>
                                                        <th scope="col">ID</th>
                                                        <th scope="col">Marka</th>
                                                        <th scope="col">Model</th>
                                                        <th scope="col">Kaynak</th>
                                                        <th scope="col">Rezervasyon Tarihi</th>
                                                        <th scope="col">Rezervasyon Saati</th>
                                                        <th scope="col">Alınış Yeri</th>
                                                        <th scope="col">Bırakılış Yeri</th>
                                                        <th scope="col">Müşteri Adı</th>
                                                        <th scope="col">Kişi Sayısı</th>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($vehicle->reservations as $reservation)
                                                        <tr>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-primary dropdown-toggle action-btn" type="button" data-toggle="dropdown">Actions <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li>
                                                                            <a href="{{ route('reservation.edit', ['id' => $reservation->id]) }}" class="btn btn-info edit-btn"> <i class="fa fa-pencil-square-o"></i> Edit / Show</a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="{{ route('reservation.destroy', ['id' => $reservation->id]) }}" onclick="return confirm('Are you sure?');" class="btn btn-danger edit-btn"> <i class="fa fa-trash"></i> Delete</a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                            <td>{{ date('ymd', strtotime($reservation->created_at)) . $reservation->customer->id . $reservation->id  }}</td>
                                                            <td>{{ $reservation->vehicle->brand->name }}</td>
                                                            <td>{{ $reservation->vehicle->model }}</td>
                                                            <td>{{ date('d-m-Y', strtotime($reservation->reservation_date)) }}</td>
                                                            <td>
                                                                <a href="{{ route('customer.edit', ['id' => $reservation->customer->id]) }}">{{ $reservation->customer->name_surname }}</a>
                                                            </td>
                                                            <td>{{ $reservation->bmiValue }}</td>
                                                            <td>{{ $reservation->height }} {{ $reservation->height_unit }}</td>
                                                            <td>{{ $reservation->weight }} {{ $reservation->weight_unit }}</td>
                                                            <td>@if($reservation->is_alcohol == "yes") <i class="fa fa-check check-icon"></i> @else <i class="fa fa-times non-icon"></i> @endif </td>
                                                            <td>@if($reservation->is_smoke == "yes") <i class="fa fa-check check-icon"></i> @else <i class="fa fa-times non-icon"></i> @endif </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="cancel-tab"> 
                            </div>
                        </div>
                    <button type="submit" class="btn btn-success mt-5 float-right">Güncelle <i class="fa fa-check" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
