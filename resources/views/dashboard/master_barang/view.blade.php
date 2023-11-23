<table class="table table-striped">
    <tr>
        <th>ID Barang</th>
        <th>:</th>
        <td>{{ $barang->id_barang }}</td>
    </tr>
    <tr>
        <th>Nama Barang</th>
        <th>:</th>
        <td>{{ $barang->nm_barang }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <th>:</th>
        <td>{!! ($barang->sts == 1) ? '<div class="badge badge-success">Tersedia</div>' : '<div class="badge badge-danger">Tidak Tersedia</div>' !!}</td>
    </tr>
</table>