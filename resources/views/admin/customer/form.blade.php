@extends('admin.layout.main')

@section('content_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Customer</h4>
                    <p class="card-description">
                    Masukan data customer baru
                    </p>
                    @if ($jenis=="create")
                    <form class="forms-sample" enctype="multipart/form-data" action="{{route('storeCustomer')}}" method="post">
                        @csrf
                    @elseif ($jenis=="edit")
                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('updateCustomer',['id' => $customer->id])}}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="customer_id" value="{{$customer->id}}">
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
                            <label for="exampleInputName1">Nama Awal</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Name" value="@isset($customer->first_name){{$customer->first_name}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Nama Akhir</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Name" value="@isset($customer->last_name){{$customer->last_name}}@endisset" required>
                        </div>
                        <div class="form-group">
                                <label for="exampleInputName1">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="@isset($customer->username){{$customer->username}}@endisset" required>
                            </div>
                        <div class="form-group">
                            <label for="exampleInputEmail3">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="@isset($customer->email){{$customer->email}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelectGender">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="L"
                                @isset($customer->gender)
                                    @if($customer->gender == "L")
                                        selected
                                    @endif
                                @endisset>Laki-Laki</option>
                                <option value="P"
                                @isset($customer->gender)
                                    @if($customer->gender == "P")
                                        selected
                                    @endif
                                @endisset>Perempuan</option>
                            </select>
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
                            <input type="text" class="form-control" id="hp" name="hp" placeholder="Nomor Hp" value="@isset($customer->hp){{$customer->hp}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Tempat Lahir</label>
                            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Tempat Lahir" value="@isset($customer->tempat_lahir){{$customer->tempat_lahir}}@endisset" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" placeholder="Tanggal Lahir" value="@isset($customer->tanggal_lahir){{$customer->tanggal_lahir}}@endisset">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputName1">Tanggal Pernikahan</label>
                            <input type="date" class="form-control" id="tanggal_nikah" name="tanggal_nikah" placeholder="Tanggal Nikah" value="@isset($customer->tanggal_nikah){{$customer->tanggal_nikah}}@endisset">
                        </div>
                        @if ($jenis=="edit")
                            <div class="form-group">
                                <label for="exampleSelectGender">Status Customer</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach($status as $stat)
                                        @if($stat->status_id == $customer->status)
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