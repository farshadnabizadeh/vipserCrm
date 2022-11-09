@extends('layouts.app')

@section('content')

@include('layouts.navbar')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 table-responsive">
             <nav aria-label="breadcrumb" class="mt-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item home-page"><a href="{{ route('home') }}">Arayüz</a></li>
                    <li class="breadcrumb-item active" aria-current="page">İndirimler</li>
                </ol>
            </nav>
            <div class="card p-3 mt-3">
                <div class="card-title">
                    <div class="row">
                        <div class="col-lg-6">
                            <h2>İndirimler</h2>
                        </div>
                        <div class="col-lg-6">
                            <button data-toggle="modal" data-target="#discountModal" class="btn btn-primary float-right"><i class="fa fa-plus" aria-hidden="true"></i> Yeni İndirim</button>
                        </div>
                    </div>
                </div>
                <div class="dt-responsive table-responsive">
                    <table class="table table-striped table-bordered nowrap dataTable" id="tableData">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">İşlemler</th>
                                <th scope="col">İndirim Adı</th>
                                <th scope="col">İndirim Kodu</th>
                                <th scope="col">İndirim Yüzdesi</th>
                                <th scope="col">Not</th>
                            </tr>
                        </thead>
                        @foreach ($discounts as $discount)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-danger dropdown-toggle action-btn" type="button" data-toggle="dropdown">İşlem <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ url('/definitions/discounts/edit/'.$discount->id) }}" class="btn btn-info edit-btn inline-popups"><i class="fa fa-pencil-square-o"></i> Güncelle</a></li>
                                        <li><a href="{{ url('/definitions/discounts/destroy/'.$discount->id) }}" onclick="return confirm('Are you sure?');" class="btn btn-danger edit-btn"><i class="fa fa-trash"></i> Sil</a></li>
                                    </ul>
                                </div>
                            </td>
                            <td>{{ $discount->name }}</td>
                            <td>{{ $discount->code }}</td>
                            <td>{{ $discount->percentage }}</td>
                            <td>{{ $discount->note }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yeni İndirim Ekle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('discount.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">İndirim Adı</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="İndirim Adı" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="code">İndirim Kodu</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="İndirim Kodu" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="percentage">İndirim Yüzdesi</label>
                                <input type="number" class="form-control" id="percentage" name="percentage" placeholder="İndirim Yüzdesi" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="note">Not</label>
                                <input type="text" class="form-control" id="note" name="note" placeholder="Not">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right">Kaydet <i class="fa fa-check" aria-hidden="true"></i></button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

@endsection
