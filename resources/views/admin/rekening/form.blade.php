@extends('admin.layout.main')

@section('content_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Rekening</h4>
                    <p class="card-description">
                    Masukan data Rekening baru
                    </p>
                    @if ($jenis=="create")
                    <form class="forms-sample" enctype="multipart/form-data" action="{{route('storeRekening')}}" method="post">
                        @csrf
                    @elseif ($jenis=="edit")
                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('updateRekening',['id' => $rekening->id])}}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="rekening_id" value="{{$rekening->id}}">
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
                            <label for="exampleSelectGender">Nama Bank</label>
                            <select class="form-control" id="bank_id" name="bank_id">
                                @foreach($banks as $bank)
                                    @isset($rekening->bank_id)
                                        @if($bank->id == $rekening->bank_id)
                                            <option value="{{$bank->id}}" selected>{{$bank->nama}}</option>
                                        @else
                                        <option value="{{$bank->id}}">{{$bank->nama}}</option>
                                        @endif
                                    @else
                                        <option value="{{$bank->id}}">{{$bank->nama}}</option>
                                    @endisset
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Nama Pemilik</label>
                            <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" placeholder="Nama Pemilik" value="@isset($rekening->nama_pemilik){{$rekening->nama_pemilik}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Nomor Rekening</label>
                            <input type="text" class="form-control" id="norek" name="norek" placeholder="Nomor Rekening" value="@isset($rekening->norek){{$rekening->norek}}@endisset" required>
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