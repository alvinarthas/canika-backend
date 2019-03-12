@extends('admin.layout.main')

@section('content_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Admin</h4>
                    <p class="card-description">
                    Masukan data admin baru
                    </p>
                    @if ($jenis=="create")
                    <form class="forms-sample" enctype="multipart/form-data" action="{{route('storeAdmin')}}" method="post">
                        @csrf
                    @elseif ($jenis=="edit")
                        <form class="forms-sample" enctype="multipart/form-data" action="{{route('updateAdmin',['id' => $admin->id])}}" method="post">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="admin_id" value="{{$admin->id}}">
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
                            <label for="exampleInputName1">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Name" value="@isset($admin->nama){{$admin->nama}}@endisset" required>
                        </div>
                        <div class="form-group">
                                <label for="exampleInputName1">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="@isset($admin->username){{$admin->username}}@endisset" required>
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
                        @if ($jenis=="edit")
                            <div class="form-group">
                                <label for="exampleSelectGender">Status Customer</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach($status as $stat)
                                        @if($stat->status_id == $admin->status)
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