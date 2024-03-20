<table class="table table-striped">
    <tr>
        <th>ID Pengeluaran</th>
        <th>:</th>
        <td>{{ $pengeluaran->id }}</td>
        <th>Nama Karyawan</th>
        <th>:</th>
        <td>{{ $pengeluaran->nm_karyawan }}</td>
    </tr>
    <tr>
        <th>Tgl Pengeluaran</th>
        <th>:</th>
        <td>{{ date('d F Y', strtotime($pengeluaran->tgl)) }}</td>
        <th>Nilai Pengeluaran</th>
        <th>:</th>
        <td class="text-right">{{ number_format($pengeluaran->nilai, 2) }}</td>
    </tr>
    <tr>
        <th>Keterangan</th>
        <th>:</th>
        <td colspan="4">{{ $pengeluaran->keterangan }}</td>
    </tr>
</table>
