<div class="container-fluid">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <input type="hidden" name="id_peminjaman" value="{{ $data_peminjaman->id }}">
            <h5>No. Peminjaman : {{ $data_peminjaman->id }} </h5>
            <h5>Nama Karyawan : {{ $data_peminjaman->nm_karyawan }} </h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">Tenor Ke</th>
                        <th class="text-center">Tgl Tenor</th>
                        <th class="text-center">Nilai Tagihan</th>
                        <th class="text-center">Tgl Bayar</th>
                        <th class="text-center">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $data_peminjaman->tenor; $i++)
                        <?php
                        $paid_sts = 0;
                        $paid_tgl_bayar = '';
                        $paid_keterangan = '';
                        foreach ($data_pembayaran_peminjaman as $pembayaran_peminjaman):
                            if ($paid_sts == 0 && $pembayaran_peminjaman->tenor_ke == $i + 1) {
                                $paid_sts = 1;
                                $paid_tgl_bayar = $pembayaran_peminjaman->tgl_bayar;
                                $paid_keterangan = $pembayaran_peminjaman->keterangan;
                            }
                        endforeach;
                        ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" name="check_tenor[]" id="" value="{{ $i + 1 }}"
                                    {{ $paid_sts == 1 ? 'checked disabled' : null }}>
                            </td>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td class="text-center">
                                <input type="hidden" name="tgl_tenor_{{ $i + 1 }}"
                                    value="{{ date('Y-m-d', strtotime('+ ' . ($i + 1) . ' month', strtotime($data_peminjaman->tgl_peminjaman))) }}">
                                {{ date('d F Y', strtotime('+ ' . ($i + 1) . ' month', strtotime($data_peminjaman->tgl_peminjaman))) }}
                            </td>
                            <td class="text-center">
                                {{ number_format($data_peminjaman->nilai_peminjaman / $data_peminjaman->tenor, 2) }}
                            </td>
                            <td class="text-center">
                                @if ($paid_sts == '1')
                                    {{ date('d F Y', strtotime($paid_tgl_bayar)) }}
                                @else
                                    <input type="date" name="tgl_bayar_{{ $i + 1 }}" id=""
                                        class="form-control form-control-sm"
                                        min="{{ date('Y-m-d', strtotime('+ ' . ($i + 1) . ' month', strtotime($data_peminjaman->tgl_peminjaman))) }}"
                                        value="">
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($paid_sts == '1')
                                    {{ $paid_keterangan }}
                                @else
                                    <textarea name="keterangan_{{ $i + 1 }}" id="" cols="30" rows="2"
                                        {{ $paid_sts == '1' ? 'readonly' : null }}>{{ $paid_keterangan }}</textarea>
                                @endif
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).on("submit", "#data_form", function(e) {
        e.preventDefault();

        Swal.fire({
            icon: "warning",
            title: "Anda sudah yakin ?",
            showCancelButton: true,
            confirmButtonText: "Simpan",
            cancelButtonText: "Batal"
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                $.ajax({
                    url: "/save_pembayaran_pinjaman",
                    type: "POST",
                    data: $(this).serialize(),
                    dataType: 'JSON',
                    cache: false,
                    success: function(hasil) {
                        if (hasil.status == '1') {
                            Swal.fire(hasil.msg,
                                "", "success").then((hasil1) => {
                                $("#addPeminjamanDana").modal('hide');
                                dataTable.ajax.reload();
                            });
                        } else {
                            Swal.fire(hasil.msg,
                                "", "error").then((hasil1) => {
                                $("#addPeminjamanDana").modal('hide');
                                dataTable.ajax.reload();
                            });
                        }
                    },
                });
            } else if (result.isDenied) {
                Swal.fire("Data batal di simpan !", "", "info");
            }
        });
    });
</script>
