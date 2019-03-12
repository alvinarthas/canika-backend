@extends('admin.layout.main')

@section('content_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Kategori</h4>
                    <p class="card-description">
                    Masukan data Kategori baru
                    </p>
                    @if ($jenis=="create")
                    <form class="forms-sample" enctype="multipart/form-data" action="{{route('storeKategori')}}" method="post">
                        @csrf
                    @elseif ($jenis=="edit")
                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('updateKategori',['id' => $kategori->id])}}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="kategori_id" value="{{$kategori->id}}">
                    @endif
                    @if ($errors->count() > 0)
                        <div class="card-body">
                            <blockquote class="blockquote blockquote-primary">
                                @foreach( $errors->all() as $message )
                                    <li>{{ $message }}</li>
                                  @endforeach
                            </blockquote>
                        </div>
                    @endif
                        <div class="form-group">
                            <label for="exampleInputName1">Nama Bank</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Name" value="@isset($kategori->nama){{$kategori->nama}}@endisset" required>
                        </div>
                        <div class="form-group">
                                <label for="exampleInputName1">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">@isset($kategori->deskripsi){{$kategori->deskripsi}}@endisset</textarea>
                            </div>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
@endsection