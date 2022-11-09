@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="header bg-primary pb-6">
<div class="container-fluid">
    <div class="header-body">
    <div class="row align-items-center py-4">
        <div class="col-lg-6 col-7">
            <h6 class="h2 text-white d-inline-block mb-0 item-text font-weight-600">Arayüz </h6>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-dashboard-card">Rezervasyon Formları</h5>
                            <hr>
                            <a href="{{ route('bookingform.index') }}">
                                <span class="h2 mb-0 count-card">{{ $bookingFormCount }}</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="fa fa-wpforms"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-dashboard-card">Rezervasyonlar</h5>
                            <hr>
                            <a href="{{ route('contactform.index') }}">
                                <span class="h2 mb-0 count-card">{{ $reservationCount }}</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="fa fa-wpforms"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <h5 class="card-title text-dashboard-card">Araçlar</h5>
                            <hr>
                            <a href="{{ route('vehicle.index') }}">
                                <span class="h2 mb-0 count-card">{{ $vehicleCount }}</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <div class="icon icon-shape bg-gradient-info text-white rounded-circle shadow">
                                <i class="fa fa-car"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0" style="padding: 0; padding-top: 10px">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Rezervasyon Kaynak Özetleri</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0">
                    <canvas id="source-chart" width="800" height="450"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header border-0" style="padding: 0; padding-top: 10px">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Araç Özetleri</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding: 0">
                    <canvas id="vehicles-chart" width="800" height="450"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
