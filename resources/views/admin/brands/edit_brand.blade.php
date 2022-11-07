<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card p-4 mt-3">
                <div class="card-title">
                    <h2>Markayı Güncelle</h2>
                    <p class="float-right last-user">İşlem Yapan Son Kullanıcı: {{ $brand->user->name }}</p>
                </div>
                <form action="{{ route('brand.update', ['id' => $brand->id]) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="name">Marka Adı</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Marka Adı" value="{{ $brand->name }}" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-5 float-right">Güncelle <i class="fa fa-check" aria-hidden="true"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>
