@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-danger mt-3" onclick="previousPage();"><i class="fa fa-chevron-left" aria-hidden="true"></i> Önceki Sayfa</button>
            <div class="card p-4 mt-3">
                <div class="card-title">
                    <h3>Rezervasyon Güncelle</h3>
                </div>
                <form action="{{ route('bookingform.update', ['id' => $booking_form->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Adı</label>
                                    <input type="text" name="name" class="form-control" value="{{ $booking_form->name}}">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="surname">Soyadı</label>
                                    <input type="text" name="surname" class="form-control" value="{{ $booking_form->surname}}">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="phone">Telefon Numarası</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $booking_form->phone }}">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $booking_form->email }}">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="country">Ülkesı</label>
                                <select name="country" class="form-control" id="country">
                                    <option value="{{ $booking_form->country }}">{{ $booking_form->country }}</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->name }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="pickup_date">Rezervasyon Tarihi</label>
                                    <input type="date" name="pickup_date" class="form-control" id="startDate" value="{{ $booking_form->pickup_date }}">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="person">Kişi Sayısı</label>
                                    <input type="text" name="person" class="form-control" value="{{ $booking_form->person }}">
                                </label>
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
