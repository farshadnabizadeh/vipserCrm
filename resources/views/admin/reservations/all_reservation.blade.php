@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 table-responsive">
            <button class="btn btn-primary mt-3" onclick="previousPage();"><i class="fa fa-chevron-left" aria-hidden="true"></i> Önceki Sayfa</button>
            <div class="card p-4 mt-3">
                <div class="card-title">
                    <div class="row">
                        <div class="col-md-6">
                            <h2>{{ $tableTitle }}</h2>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('reservation.create') }}" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Yeni Rezervasyon</a>
                        </div>
                    </div>
                </div>
                <div class="dt-responsive table-responsive">
                    <table class="table table-striped table-bordered nowrap dataTable" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">İşlem</th>
                                <th scope="col">ID</th>
                                <th scope="col">Kaynak</th>
                                <th scope="col">Rota Türü</th>
                                <th scope="col">Rezervasyon Tarihi</th>
                                <th scope="col">Rezervasyon Saati</th>
                                <th scope="col">GidişAlınış Yeri</th>
                                <th scope="col">GidişBırakılış Yeri</th>
                                <th scope="col">Dönüş Alınış Yeri</th>
                                <th scope="col">Dönüş Bırakılış Yeri</th>
                                <th scope="col">Müşteri Adı</th>
                                <th scope="col">Ödeme</th>
                                <th scope="col">Kişi Sayısı</th>
                            </tr>
                        </thead>
                        @foreach ($listAllByDates as $listAllByDate)
                            <tr>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-primary dropdown-toggle action-btn" type="button" data-toggle="dropdown">İşlem <span class="caret"></span></button>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ route('reservation.edit', ['id' => $listAllByDate->tId]) }}" class="btn btn-info edit-btn"><i class="fa fa-pencil-square-o"></i> Güncelle</a></li>
                                            <li><a href="{{ route('reservation.download', ['id' => $listAllByDate->tId, 'lang' => 'en']) }}" class="btn btn-success edit-btn"><i class="fa fa-download"></i> İndir</a></li>
                                        </ul>
                                    </div>
                                </td>
                                <td>{{ date('ymd', strtotime($listAllByDate->created_at)) . $listAllByDate->tId }}</td>
                                <td class="text-white" style="background-color: {{ $listAllByDate->color }}">{{ $listAllByDate->name }}</td>
                                @if ($listAllByDate->route_type_id)
                                    <td class="text-white" style="background-color: {{ $listAllByDate->rTcolor }}">{{ $listAllByDate->rTname }}</td>
                                @else
                                <td></td>
                                @endif
                                <td>{{ date('d-m-Y', strtotime($listAllByDate->reservation_date)) }}</td>
                                <td>{{ $listAllByDate->reservation_time }}</td>
                                <td>{{ $listAllByDate->pickup_location }}</td>
                                <td>{{ $listAllByDate->return_location }}</td>
                                <td>{{ $listAllByDate->return_pickup_location }}</td>
                                <td>{{ $listAllByDate->return_return_location }}</td>
                                <td>
                                    <a href="{{ route('customer.edit', ['id' => $listAllByDate->customer_id]) }}">{{ $listAllByDate->Cname }}</a>
                                </td>
                                <td>
                                    @if($listAllByDate->payment_price == NULL)
                                    <p class="text-center"><i class="fa fa-times non-icon"></i></p>
                                    @else
                                    <p class="text-center"><i class="fa fa-check check-icon"></i></p>
                                    @endif
                                </td>
                                <td>{{ $listAllByDate->total_customer }}</td>
                            </tr>
                        @endforeach
                    </table>
               </div>
            </div>
        </div>
    </div>
</div>

@endsection
