@php
  use App\Rekening;
@endphp
@extends('admin.layout.main')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Index Rekening</h4>
      <table class="table table-striped table-bordered" id="dataTables">
        <thead>
          <th>No</th>
          <th>Bank</th>
          <th>Nama Pemilik</th>
          <th>Nomor Rekening</th>
          <th>Action</th>
        </thead>
        <tbody>
          @php($i=1)
          @foreach($rekening as $rek)
            <tr>
              <td>{{$i}}</td>
              <td>{{$rek->bank->nama}}</td>
              <td>{{$rek->nama_pemilik}}</td>
              <td>{{$rek->norek}}</td>
              <td></td>
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