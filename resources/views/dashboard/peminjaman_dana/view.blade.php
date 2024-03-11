<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table class="w-100 ">
                <tr>
                    <th>Nama Karyawan</th>
                    <th>:</th>
                    <td><?= $data_peminjaman->nm_karyawan ?></td>
                    <th>Tgl Peminjaman</th>
                    <th>:</th>
                    <td><?= date('d F Y', strtotime($data_peminjaman->tgl_peminjaman)) ?></td>
                </tr>
                <tr>
                    <th>Tipe Peminjaman</th>
                    <th>:</th>
                    <td><?= $tipe_peminjaman ?></td>
                    <th>Nilai Peminjaman</th>
                    <th>:</th>
                    <td>Rp. <?= number_format($data_peminjaman->nilai_peminjaman, 2) ?></td>
                </tr>
                <tr>
                    <th>Tenor</th>
                    <th>:</th>
                    <td><?= $data_peminjaman->tenor ?> Bulan</td>
                    <th>Keterangan</th>
                    <th>:</th>
                    <td><?= $data_peminjaman->keterangan ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <th>:</th>
                    <td><?= $status ?></td>
                </tr>
            </table>
        </div>
        <?php if($data_peminjaman->tipe_pinjaman == '2') : ?>
        <div class="col-12">
            <table class="table table-striped" style="margin-top:2vh;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Barang</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list_barang_peminjaman as $kredit_barang)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kredit_barang->nama_barang }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-12 {{ isset($data_pembayaran) && count($data_pembayaran) > 0 ? '' : 'd-none' }}">
            <h5>List Pembayaran</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Tgl Tenor</th>
                        <th class="text-center">Nilai Tagihan</th>
                        <th class="text-center">Tgl Bayar</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    {!! isset($data_pembayaran) && count($data_pembayaran) > 0 ? $list_pembayaran : null !!}
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
