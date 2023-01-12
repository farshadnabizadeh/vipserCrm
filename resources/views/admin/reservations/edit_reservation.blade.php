@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <button class="btn btn-danger mt-3" onclick="previousPage();"><i class="fa fa-chevron-left"></i> Önceki Sayfa</button>
            <div class="card p-3 mt-3">
                <div class="card-title">
                    <nav class="nav nav-borders">
                        <a class="nav-link active ms-0" href="{{ route('reservation.edit', ['id' => $reservation->id]) }}"><i class="fa fa-user"></i> Rezervasyon Bilgileri</a>
                        <a class="nav-link" href="{{ route('reservation.edit', ['id' => $reservation->id, 'page' => 'payments']) }}"><i class="fa fa-money"></i> Ödeme Bilgileri @if(!$hasPaymentType) <i class="fa fa-ban"></i> @else <i class="fa fa-check"></i> @endif</a>
                        <a class="nav-link" href="{{ route('reservation.edit', ['id' => $reservation->id, 'page' => 'comissions']) }}"><i class="fa fa-percent"></i> Komisyon </a>
                    </nav>
                </div>
                <div class="card h-100">
                    <div class="card-body">
                        <form action="{{ route('reservation.update', ['id' => $reservation->id]) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="reservationDate">Rezervasyon Tarihi</label>
                                        <input type="text" class="form-control datepicker" id="reservationDate" name="reservationDate" placeholder="Rezervasyon Tarihi" value="{{ $reservation->reservation_date }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="reservationTime">Rezervasyon Saati</label>
                                        <input type="text" class="form-control" id="reservationTime" name="reservationTime" placeholder="Rezervasyon Saati" maxlength="5" onkeypress="timeFormat(this)" value="{{ $reservation->reservation_time }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="totalCustomer">Kişi Sayısı</label>
                                        <input type="number" class="form-control" id="totalCustomer" name="totalCustomer" placeholder="Kişi Sayısı" value="{{ $reservation->total_customer }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="sobId">Rezervasyon Kaynağı</label>
                                        <select id="sobId" name="sourceId" class="form-control">
                                            <option value="{{ $reservation->source_id }}" selected>{{ $reservation->source->name }}</option>
                                            @foreach ($sources as $source)
                                            <option value="{{ $source->id }}">{{ $source->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="note">Rezervasyon Notu</label>
                                        <textarea class="form-control" name="note" id="note" placeholder="Rezervasyon Notu">{{ $reservation->reservation_note }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success mt-5 float-right update-page-btn">Güncelle <i class="fa fa-check" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addPaymentTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Yeni Ödeme Türü Ekle</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form method="POST">
                @csrf
                <input type="hidden" id="reservation_id" value="{{ $reservation->id }}">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="paymentType">Ödeme Türü</label>
                            <select class="form-control" id="paymentType" name="paymentType" required>
                                <option></option>
                                @foreach ($payment_types as $payment_type)
                                <option value="{{ $payment_type->id }}">{{ $payment_type->payment_type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label for="paymentPrice">Ücret</label>
                            <input type="text" class="form-control" placeholder="Ücret" id="paymentPrice">
                        </div>
                    </div>
               </div>
               <button type="button" class="btn btn-success float-right" id="addPaymentTypetoReservationSave">Kaydet <i class="fa fa-check" aria-hidden="true"></i></button>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
         </div>
      </div>
   </div>
</div>

@endsection
