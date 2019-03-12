@extends('admin.layout.main')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')
<div class="col-lg-12 grid-margin stretch-card">
  <div class="card">
    <div class="card-body">
      <h4 class="card-title">Index Bank</h4>
      <table class="table table-striped table-bordered" id="dataTables">
        <thead>
          <th>No</th>
          <th>Gambar</th>
          <th>Nama Bank</th>
          <th>Action</th>
        </thead>
        <tbody>
          @php($i=1)
          @foreach($banks as $bank)
            <tr>
              <td>{{$i}}</td>
              <td><img src="{{$bank->image}}" width="50%" alt="image"/></td>
              <td>{{$bank->nama}}</td>
              <td>
                <form action="{{route('destroyBank',['id' => $bank->id])}}" method="POST">
                  {{ csrf_field()}}
                  {{ method_field('DELETE') }}
                    <a class="btn btn-gradient-danger btn-rounded btn-fw" href="{{route('editBank',['id' => $bank->id])}}">Ubah</a>
                    <button class="btn btn-danger" onclick="return confirm('Anda Yakin ingin Menghapus?');"><i class="fa fa-close" aria-hidden="true"></i> Hapus</button>
                </form>
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