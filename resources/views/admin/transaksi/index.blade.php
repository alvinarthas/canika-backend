@extends('admin.layout.main')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Index Transaksi</h4>
      <table class="table table-striped table-bordered" id="dataTables">
        <thead>
          <th>No</th>
          <th style="width:5%">Transaksi ID</th>
          <th>Nama Customer</th>
          <th>Nama Vendor</th>
          <th>Nama Barang</th>
          <th>Status DP</th>
          <th>Qty</th>
          <th>Harga</th>
          <th>Status Transaksi</th>
          <th>Catatan</th>
          <th>Action</th>
        </thead>
        <tbody>
          @php($i=1)
          @foreach($transaksi as $trx)
            <tr>
                
                <td>{{$i}}</td>
                <td><a class="btn btn-gradient-danger btn-rounded btn-fw" onclick="showHistory({{$trx->id}})">CAN{{$trx->id}}</a></td>
                {{ csrf_field() }}
                <td>{{$trx->customer->username}}</td>
                <td>{{$trx->barang->vendor->username}}</td>
                <td>{{$trx->barang->nama}}</td>
                <td>{{$trx->dp_status === 1 ? "Lunas":"Down Payment" }}</td>
                <td>{{$trx->qty}}</td>
                <td>{{$trx->harga}}</td>
                @if($trx->status == 0)
                    <td><label class="badge badge-warning">Belum Selesai</label></td>
                @elseif($trx->status == 1)
                    <td><label class="badge badge-info">Telah Selesai</label></td>
                @elseif($trx->status == 99)
                    <td><label class="badge badge-danger">Batal</label></td>
                @endif
                <td>{{$trx->catatan}}</td>
                <td>
                  <a class="btn btn-gradient-danger btn-rounded btn-fw" href="{{route('editTransaksi',['id' => $trx->id])}}">Ubah Status Transaksi</a>
                </td>
            </tr>
          @php($i++)  
          @endforeach
        </tbody>
      </table>
          <!-- Modal -->
          <div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          </div>
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
    $('#exampleModal').on('shown.bs.modal', function () {
      // $('#myInput').trigger('focus')
    })
  } );

  function showHistory(id){
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url: '/admin/showhistory',
        dataType: 'html',
        type    : 'POST',
        data		: {'_token' : _token,'id' : id},
        success: function(data){
            $("#myModal").html(data).modal('show');
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            if (XMLHttpRequest.status === 200) {
                bootbox.alert(textStatus+' errornya '+errorThrown);
            }else{
                unloading();
                unloading(); bootbox.alert('Maaf, Terjadi kesalahan dalam sistem!!');
            }
        }
    });
  }
</script>
@endsection