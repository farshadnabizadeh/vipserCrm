@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-danger mt-3" onclick="previousPage();"><i class="fa fa-chevron-left"></i> Önceki Sayfa</button>
            <div class="card p-4 mt-3">
                <div class="card-title">
                    <h2>Müşteriyi Güncelle</h2>
                    <p class="float-right last-user">İşlem Yapan Son Kullanıcı: {{ $customer->user->name }}</p>
                </div>
                <form action="{{ route('customer.update', ['id' => $customer->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="customerName">Müşteri Adı</label>
                                <input type="text" class="form-control" id="customerName" name="customerNameSurname" placeholder="Müşteri Adı" value="{{ $customer->name_surname }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="customerPhone">Müşteri Telefon Numarası</label>
                                <input type="text" class="form-control" id="phone_get" name="customerPhone" placeholder="Müşteri Telefon Numarası" value="{{ $customer->phone }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="customerCountry">Ülkesi</label>
                                <input type="text" class="form-control" id="country_get" name="customerCountry" placeholder="Ülkesi" value="{{ $customer->country }}" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="customerEmail">Email Adresi</label>
                                <input type="text" class="form-control" id="customerEmail" name="customerEmail" placeholder="Email Adresi" value="{{ $customer->email }}">
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
