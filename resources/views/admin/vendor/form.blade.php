@extends('admin.layout.main')

@section('content_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Vendor</h4>
                    <p class="card-description">
                    Masukan data vendor baru
                    </p>
                    @if ($jenis=="create")
                    <form class="forms-sample" enctype="multipart/form-data" action="{{route('storeVendor')}}" method="post">
                        @csrf
                    @elseif ($jenis=="edit")
                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('updateVendor',['id' => $vendor->id])}}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="vendor_id" value="{{$vendor->id}}">
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
                            <label for="exampleInputName1">Nama Vendor</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Name" value="@isset($vendor->nama){{$vendor->nama}}@endisset" required>
                        </div>
                        <div class="form-group">
                                <label for="exampleInputName1">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="@isset($vendor->username){{$vendor->username}}@endisset" required>
                            </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="@isset($vendor->email){{$vendor->email}}@endisset" required>
                        </div>
                        @if($jenis == "create")
                        <div class="form-group">
                            <label for="exampleInputPassword4">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword4">Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"placeholder="Password" required>
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleInputName1">Nomor HP</label>
                            <input type="text" class="form-control" id="hp" name="hp" placeholder="Nomor Hp" value="@isset($vendor->hp){{$vendor->hp}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Alamat" value="@isset($vendor->alamat){{$vendor->alamat}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Email Perusahaan</label>
                            <input type="email_perusahaan" class="form-control" id="email_perusahaan" name="email_perusahaan" placeholder="Email Perusahaan" value="@isset($vendor->email_perusahaan){{$vendor->email_perusahaan}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Website</label>
                            <input type="text" class="form-control" id="website" name="website" placeholder="Website" value="@isset($vendor->website){{$vendor->website}}@endisset">
                        </div>
                        @if ($jenis=="edit")
                            <div class="form-group">
                                <label for="exampleSelectGender">Status Vendor</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach($status as $stat)
                                        @if($stat->status_id == $vendor->status)
                                            <option value="{{$stat->status_id}}" selected>{{$stat->status}}</option>
                                        @else
                                        <option value="{{$stat->status_id}}">{{$stat->status}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        @endif
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