<div class="col-6">
    <table style="width: 100%;">
        <tr>
            <th>Nama Karyawan</th>
            <th>:</th>
            <th>{{ $data_tabungan[0]->nm_karyawan }}</th>
        </tr>
        <tr>
            <th>Saldo Tabungan</th>
            <th>:</th>
            <th>Rp. {{ number_format($ttl_tabungan, 2) }}</th>
        </tr>
    </table>
</div>

<br>

<div class="col-12">
    <table class="w-100">
        <tr>
            <th>Periode Awal</th>
            <td>:</td>
            <td>
                <input type="date" name="periode_awal" id="" class="form-control form-control-sm periode_awal">
            </td>
            <th>Periode Akhir</th>
            <td>:</td>
            <td>
                <input type="date" name="periode_akhir" id=""
                    class="form-control form-control-sm periode_akhir">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-primary cari_tabungan_karyawan"
                    data-id_karyawan="{{ $data_tabungan[0]->id_karyawan }}">
                    <i class="fa fa-search"></i> Cari
                </button>
            </td>
        </tr>
    </table>
    <table class="table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Karyawan</th>
                <th>Tipe</th>
                <th>Tanggal</th>
                <th>Nilai</th>
            </tr>
        </thead>
        <tbody class="list_history_tabungan">

        </tbody>
    </table>
</div>

<script>
    $(document).on('click', '.cari_tabungan_karyawan', function(){
        var id_karyawan = $(this).data('id_karyawan');
        var periode_awal = $('.periode_awal').val();
        var periode_akhir = $('.periode_akhir').val();

        if(periode_awal == '' || periode_awal == null){
            Swal.fire({
                title : 'Error !',
                title : 'Maaf, isi terlebih dahulu Periode Awal Tabungan !',
                icon: 'error'
            });

            return false;
        } else if(periode_awal == '' || periode_awal == null){
            Swal.fire({
                title : 'Error !',
                title : 'Maaf, isi terlebih dahulu Periode Akhir Tabungan !',
                icon: 'error'
            });

            return false;
        } else{
            $.ajax({
                type: 'POST',
                url: '{{ route("search_tabungan_karyawan") }}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_karyawan: id_karyawan,
                    periode_awal: periode_awal,
                    periode_akhir: periode_akhir
                },
                dataType: 'json',
                cache: false,
                beforeSend: function(result){
                    $('.cari_tabungan_karyawan').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(result){
                    $('.list_history_tabungan').html(result.list_tabungan);

                    $('.cari_tabungan_karyawan').html('<i class="fa fa-search"></i> Cari');
                },
                error: function(result){
                    Swal.fire({
                        title: 'Error !',
                        text: 'Maaf, ada kesalahan teknis, mohon dicoba kembali !',
                        icon: 'error'
                    });

                    $('.cari_tabungan_karyawan').html('<i class="fa fa-search"></i> Cari');
                }
            });
        }
    });
</script>
