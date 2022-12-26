@extends('layouts.app')

@section('content')

@include('layouts.navbar')

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <button class="btn btn-primary mt-3" onclick="previousPage();"><i class="fa fa-chevron-left"></i> Önceki Sayfa</button>
                        <div class="card p-4 mt-3">
                            <div class="card-title">
                                <h2>Rezervasyon Özetini İndir</h2>
                                <a href="{{ route('reservation.create') }}" class="btn btn-primary float-right new-btn">Yeni Rezervasyon <i class="fa fa-arrow-right"></i></a>
                            </div>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row align-items-center">
                                            <div class="col-6">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary dropdown-toggle action-btn" type="button" data-toggle="dropdown"><img class="flag-img" src="{{ asset('assets/img/flags/it.png') }}"> İtalyanca <span class="caret"></span></button>
                                                    <ul class="dropdown-menu language-dropdown">
                                                        <li><a href="{{ route('reservation.download', ['id' => $reservation->id, 'lang' => 'en']) }}" class="btn btn-primary"><img class="flag-img" src="{{ asset('assets/img/flags/en.png') }}"> İngilizce</a></li>
                                                        <li><a href="{{ route('reservation.download', ['id' => $reservation->id, 'lang' => 'de']) }}" class="btn btn-primary"><img class="flag-img" src="{{ asset('assets/img/flags/de.png') }}"> Almanca</a></li>
                                                        <li><a href="{{ route('reservation.download', ['id' => $reservation->id, 'lang' => 'fr']) }}" class="btn btn-primary"><img class="flag-img" src="{{ asset('assets/img/flags/fr.png') }}"> Fransızca</a></li>
                                                        <li><a href="{{ route('reservation.download', ['id' => $reservation->id, 'lang' => 'es']) }}" class="btn btn-primary"><img class="flag-img" src="{{ asset('assets/img/flags/es.png') }}"> İspanyolca</a></li>
                                                        <li><a href="{{ route('reservation.download', ['id' => $reservation->id, 'lang' => 'ru']) }}" class="btn btn-primary"><img class="flag-img" src="{{ asset('assets/img/flags/ru.png') }}"> Rusça</a></li>
                                                        <li><a href="{{ route('reservation.download', ['id' => $reservation->id, 'lang' => 'pl']) }}" class="btn btn-primary"><img class="flag-img" src="{{ asset('assets/img/flags/pl.png') }}"> Lehçe</a></li>
                                                        <li><a href="{{ route('reservation.download', ['id' => $reservation->id, 'lang' => 'pt']) }}" class="btn btn-primary"><img class="flag-img" src="{{ asset('assets/img/flags/pt.png') }}"> Portekizce</a></li>
                                                        <li><a href="{{ route('reservation.download', ['id' => $reservation->id, 'lang' => 'ar']) }}" class="btn btn-primary"><img class="flag-img" src="{{ asset('assets/img/flags/ar.png') }}"> Arapça</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <button class="btn btn-primary float-right" onclick="voucherPdf();"><i class="fa fa-download"></i> PDF İndir</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding-top: 0">
                                        <div id="root">
                                            <div class="treatmentPlanCard">
                                                <div class="card-body">
                                                <div class="container page2">
                                                    <div class="row pageRow2">
                                                        <div class="newBorder2">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <img class="logo_page2" src="{{ asset('assets/img/logo.png') }}">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-3 patientInfo">
                                                                    <h2 class="patient-information-title">CUSTOMER<br> INFORMATION</h2>
                                                                    <br>
                                                                    <p><span>Name, Surname:</span><br> <b id="patient-name-pdf">{{ $reservation->customer->name_surname }}</b></p>
                                                                    <p><span>Phone Number:</span><br> <b>{{ $reservation->customer->phone }}</b></p>
                                                                    <p><span>Country:</span><br> <b>{{ $reservation->customer->country }}</b></p>
                                                                    {{-- <p>Gender: <b>{{ $reservation->patient->gender }}</b></p> --}}
                                                                    <br>
                                                                    <br>
                                                                    <h2 class="contact-title">CONTACT</h2>
                                                                    <br>
                                                                    <p><span>Contact Name:</span><br> <b>Vipser Support</b></p>
                                                                    <p><span>Phone: </span><br> <b>+90 546 842 39 19</b></p>
                                                                    <br>
                                                                </div>
                                                                <div class="col-9 bg-white">
                                                                    <h1 class="treatment-plan-title">RESERVATION SUMMARY</h1>
                                                                    <p class="treatment-name"></p>
                                                                    <table class="table table-bordered treatmentplan-table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Vehicle:</th>
                                                                                <th>Date:</th>
                                                                                <th>Price:</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    <span>VIP {{ $reservation->vehicle->model }}</span>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <span>{{ date('d.m.Y', strtotime($reservation->reservation_date)) }}</span>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    @foreach($reservation->subPaymentTypes as $subPaymentType)
                                                                                        <span>{{ $subPaymentType->payment_price }}</span>
                                                                                    @endforeach
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="row">
                                                                        <div class="col text-center changes text-white">
                                                                            <p class="thicker"></p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row section-service-photos">
                                                                        <div class="col-12" style="margin-bottom: 20px;">
                                                                            <h2 class="titlePhotos">PHOTOS</h2>
                                                                            <div class="subTitle">Your Car</div>
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <div class="img-cover">
                                                                                <img src="{{ asset('assets/img/gallery/1.png') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6" style="padding-left: 0; padding-right: 0">
                                                                            <div class="img-cover">
                                                                                <img src="{{ asset('assets/img/gallery/2.png') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 mt-2">
                                                                            <div class="img-cover">
                                                                                <img src="{{ asset('assets/img/gallery/3.png') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 mt-2" style="padding-left: 0; padding-right: 0">
                                                                            <div class="img-cover">
                                                                                <img src="{{ asset('assets/img/gallery/4.png') }}">
                                                                            </div>
                                                                        </div>
                                                                        {{-- <div class="col-6 mt-2">
                                                                            <div class="img-cover">
                                                                                <img src="{{ asset('assets/img/hotel-service-3.jpg') }}">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-6 mt-2" style="padding-left: 0">
                                                                            <div class="img-cover">
                                                                                <img src="{{ asset('assets/img/hotel-service-4.jpg') }}">
                                                                            </div>
                                                                        </div> --}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-3">
                                                                <div class="col-lg-12 text-center importantText">
                                                                    <p>IMPORTANT</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 text-center infoText">
                                                                    <p>If your travel plans change please inform us <b>48 hours</b> prior your arrival date</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-lg-12 text-center infoText">
                                                                    <p style="margin-bottom: 20px">We are here <b> 09:00 / 23:00 </b> to do our best to help you.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection