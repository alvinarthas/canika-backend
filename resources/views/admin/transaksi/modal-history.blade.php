<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body">
            <table class="table table-striped">
                <thead>
                    <th>No</th>
                    <th>Nomor Transaksi</th>
                    <th>Keterangan</th>
                    <th>Catatan</th>
                    <th>Jatuh Tempo Pembayaran</th>
                    <th>Tanggal History</th>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($trxhistory as $trx)
                    <tr>
                        <td>{{$i}}</td>
                        <td><label class="badge badge-danger">CAN{{$trx->trx_id}}</label></td>
                        <td>{{$trx->keterangan->keterangan}}</td>
                        <td>{{$trx->catatan}}</td>
                        <td>{{$trx->max_date}}</td>
                        <td>{{$trx->created_at}}</td>
                    </tr>
                    @php($i++)  
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>