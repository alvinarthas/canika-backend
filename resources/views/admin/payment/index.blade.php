@extends('admin.layout.main')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Index Pembayaran</h4>
      <table class="table table-striped table-bordered" id="dataTables">
        <thead>
          <th>No</th>
          <th>Transaksi ID</th>
          <th>Status Pembayaran</th>
          <th>Nama Pengirim</th>
          <th>Bank Pengirim</th>
          <th>Bank Tujuan</th>
          <th>Bukti Bayar</th>
          <th>Tanggal Transfer</th>
          <th>Action</th>
        </thead>
        <tbody>
          @php($i=1)
          @foreach($payment as $bayar)
            <tr>
              <td>{{$i}}</td>
              <td><label class="badge badge-danger">CAN{{$bayar->trx_id}}</label></td>
              @if($bayar->status == 0)
                <td><label class="badge badge-warning">Belum di Konfirmasi</label></td>
              @else
                <td><label class="badge badge-info">Sudah di Konfirmasi</label></td>
              @endif
              <td>{{$bayar->nama_pengirim}}</td>
              <td>{{$bayar->bank_pengirim}}</td>
              <td>{{$bayar->bank()->first()->nama}}</td>
              <td>{{$bayar->bukti_bayar}}</td>
              <td>{{$bayar->tgl_trf}}</td>
              @if($bayar->status == 0)
                <td><a href="{{route('approvePayment',['payment'=>$bayar->id,'trx'=>$bayar->trx_id,'dp'=>$bayar->trx->dp_status])}}">Approve Sekarang</a></td>
              @else
                <td><label class="badge badge-info">Pembayaran sudah di approve</label></td>
              @endif
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
    $('#dataTables').DataTable({
      "bSort": true,
        "bFilter": true,
        "sScrollY": "300px",
        "sScrollX": "100%",
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
        "bPaginate":true,
        "iDisplayLength": 10
    });
  } );
</script>
@endsection