@extends('admin.layout.main')

@section('content_css')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Transaksi : CAN{{$transaksi->id}}</h4>
                    <p class="card-description">
                    ubah status transaksi baru
                    </p>
                    <form class="forms-sample" enctype="multipart/form-data" action="{{route('updateTransaksi',['id' => $transaksi->id])}}" method="post">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="transaksi_id" value="{{$transaksi->id}}">

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
                            <label for="exampleSelectGender">Status Transaksi</label>
                            <select class="form-control" id="status" name="status">
                                @foreach($status as $stat)
                                    @if($stat->status_id == $transaksi->status)
                                        <option value="{{$stat->status_id}}" selected>{{$stat->status}}</option>
                                    @else
                                    <option value="{{$stat->status_id}}">{{$stat->status}}</option>
                                    @endif
                                @endforeach
                            </select>
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