<table class="table table-striped">
    <tr>
        <th>ID Pemasukan</th>
        <th>:</th>
        <td>{{ $pemasukan->id }}</td>
        <th>Nama Karyawan</th>
        <th>:</th>
        <td>{{ $pemasukan->nm_karyawan }}</td>
    </tr>
    <tr>
        <th>Tgl Pemasukan</th>
        <th>:</th>
        <td>{{ date('d F Y', strtotime($pemasukan->tgl)) }}</td>
        <th>Nilai Pemasukan</th>
        <th>:</th>
        <td class="text-right">{{ number_format($pemasukan->nilai, 2) }}</td>
    </tr>
    <tr>
        <th>Keterangan</th>
        <th>:</th>
        <td colspan="4">{{ $pemasukan->keterangan }}</td>
    </tr>
</table>
