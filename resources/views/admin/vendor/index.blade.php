@extends('admin.layout.main')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection
@php
  use App\Status;
@endphp
@section('content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Index Vendor</h4>
      <table class="table table-striped table-bordered" id="dataTables">
        <thead>
          <th>No</th>
          <th>Avatar</th>
          <th>Username</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No Hp</th>
          <th>Status</th>
          <th>Action</th>
        </thead>
        <tbody>
          @php($i=1)
          @foreach($vendor as $vend)
            <tr>
              <td>{{$i}}</td>
              <td><img src="{{$vend->avatar}}" width="25%" alt="image"/></td>
              <td>{{$vend->username}}</td>
              <td>{{$vend->nama}}</td>
              <td>{{$vend->email}}</td>
              <td>{{$vend->hp}}</td>
              <td>{{Status::where('status_id',$vend->status)->where('jenis','vendor')->first()->status}}</td>
              <td>
                <a class="btn btn-gradient-danger btn-rounded btn-fw" href="{{route('editVendor',['id' => $vend->id])}}">Ubah</a>
              </td>
            </tr>
          @php($i++)  
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('js')
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

<script>
  $(document).ready( function () {
    $('#dataTables').DataTable();
  } );
</script>
@endsection