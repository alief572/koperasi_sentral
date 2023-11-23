<table class="table table-striped">
    <tr>
        <th>Nama Karyawan</th>
        <th>:</th>
        <td>{{ $hasil->nm_karyawan }}</td>
        <th>Tgl Mulai Kerja</th>
        <th>:</th>
        <td>{{ date("d F Y",strtotime($hasil->tgl_mulai_kerja)) }}</td>
    </tr>
    <tr>
        <th>No. HP</th>
        <th>:</th>
        <td>{{ $hasil->no_hp }}</td>
        <th>Tgl Resign</th>
        <th>:</th>
        <td>{{ date("d F Y",strtotime($hasil->tgl_resign)) }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <th>:</th>
        <td>{{ $hasil->email }}</td>
        <th>Pendidikan Terakhir</th>
        <th>:</th>
        <td>{{ $pendidikan_terakhir }}</td>
    </tr>
    <tr>
        <th>Tempat Lahir</th>
        <th>:</th>
        <td>{{ $hasil->birth_place }}</td>
        <th>No. Kartu Keluarga</th>
        <th>:</th>
        <td>{{ $hasil->no_kartu_keluarga }}</td>
    </tr>
    <tr>
        <th>Tgl Lahir</th>
        <th>:</th>
        <td>{{ date('d F Y',strtotime($hasil->birth_date)) }}</td>
        <th>No. BPJS</th>
        <th>:</th>
        <td>{{ $hasil->no_bpjs }}</td>
    </tr>
    <tr>
        <th>Gender</th>
        <th>:</th>
        <td>{{ ucfirst($hasil->gender) }}</td>
        <th>No. NPWP</th>
        <th>:</th>
        <td>{{ $hasil->no_npwp }}</td>
    </tr>
    <tr>
        <th>Agama</th>
        <th>:</th>
        <td>{{ ucfirst($hasil->religion) }}</td>
        <th>Alamat</th>
        <th>:</th>
        <td>{{ $hasil->alamat }}</td>
    </tr>
</table>

<h5>Data Bank</h5>
<table class="table table-striped">
    <tr>
        <th>Bank</th>
        <th>:</th>
        <td>{{ $bank }}</td>
    </tr>
    <tr>
        <th>Nomor Akun Bank</th>
        <th>:</th>
        <td>{{ $hasil->bank_account_number }}</td>
    </tr>
    <tr>
        <th>Nama di Akun Bank</th>
        <th>:</th>
        <td>{{ $hasil->bank_account_name }}</td>
    </tr>
    <tr>
        <th>Alamat Bank</th>
        <th>:</th>
        <td>{{ $hasil->bank_address }}</td>
    </tr>
    <tr>
        <th>Swift Code</th>
        <th>:</th>
        <td>{{ $hasil->swift_code }}</td>
    </tr>
</table>