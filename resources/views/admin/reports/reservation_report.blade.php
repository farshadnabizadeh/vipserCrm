@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-lg-12">
            <button class="btn btn-danger" onclick="previousPage();"><i class="fa fa-chevron-left"></i> Önceki Sayfa</button>
            <div class="card mt-3">
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="row pb-3">
                            <div class="col-lg-6">
                                <label for="startDate">Başlangıç Tarihi</label>
                                <input type="text" class="form-control datepicker" id="startDate" name="startDate" placeholder="Başlangıç Tarihi" value="{{ $start }}" autocomplete="off" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="endDate">Bitiş Tarihi</label>
                                <input type="text" class="form-control datepicker" id="endDate" name="endDate" placeholder="Bitiş Tarihi" autocomplete="off" value="{{ $end }}" required>
                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-success mt-3 float-right" type="submit">Raporu Al</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3>{{ date('d-m-Y', strtotime($start)) }} & {{ date('d-m-Y', strtotime($end)) }} tarihleri arasındaki Rezervasyon Raporu</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card p-3">
                                <div class="card-title">
                                    <h2>Terapist Raporu</h2>
                                </div>
                                <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Terapist Adı</th>
                                        <th>Yaptığı Bakım</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($therapistAll as $therapist)
                                        <tr>
                                            <td>{{ $therapist->name }}</td>
                                            <td>{{ $therapist->therapistCount }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card p-3">
                                <div class="card-title">
                                    <h2>Hizmet Raporu</h2>
                                </div>
                                <table id="tableData" class="table table-striped table-bordered nowrap">
                                    <thead>
                                    <tr>
                                        <th>Bakım</th>
                                        <th>Yaptığı Bakım</th>
                                        <th>Toplam Fiyat</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($serviceAll as $service)
                                        <tr>
                                            <td>{{ $service->name }}</td>
                                            <td>{{ $service->serviceCount }}</td>
                                            <td>{{ $service->cost * $service->serviceCount . ' EURO' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
