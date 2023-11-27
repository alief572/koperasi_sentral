<table class="table table-striped">
    <tr>
        <th>Tgl Awal Peminjaman</th>
        <th>:</th>
        <td>{{ date('d F Y', strtotime($data_peminjaman->tgl_awal_peminjaman)) }}</td>
        <th>Nama Karyawan</th>
        <th>:</th>
        <td>{{ $data_peminjaman->nm_karyawan }}</td>
    </tr>
    <tr>
        <th>Tgl Pengembalian</th>
        <th>:</th>
        <td>{{ date('d F Y', strtotime($data_peminjaman->tgl_pengembalian)) }}</td>
        <th>Keterangan</th>
        <th>:</th>
        <td>{{ $data_peminjaman->keterangan }}</td>
    </tr>
</table>

<h5>Asset yang Dipinjamkan</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Nama Asset</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data_asset_peminjaman as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">{{ $item->barang->nm_barang }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
