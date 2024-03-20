<div class="col-12">
    {{ csrf_field() }}
    {{-- {{ print_r($get_pengeluaran) }} --}}
    <input type="hidden" name="type_post" class="type_post" value="{{ isset($get_pengeluaran) ? 'PUT' : 'POST' }}">
    <input type="hidden" name="id_pengeluaran" value="{{ isset($get_pengeluaran) ? $get_pengeluaran->id : null }}">
    <div class="row">
        <div class="col-6">
            <table class="table">
                <tr>
                    <th>Nilai Tabungan</th>
                    <th>:</th>
                    <th class="nilai_tabungan_karyawan">Rp. <?= number_format(0, 2) ?></th>
                </tr>
            </table>
        </div>
        <div class="col-6"></div>
        <div class="col-6">
            <div class="form-group">
                <label for="">ID Pengeluaran</label>
                <input type="text" name="" id="" class="form-control form-control-sm"
                    value="<?= isset($get_pengeluaran) ? $get_pengeluaran->id : 'new' ?>" readonly>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="hidden" class="id_karyawan"
                    value="<?= isset($get_pengeluaran) ? $get_pengeluaran->id_karyawan : null ?>">
                <input type="hidden" class="nm_karyawan"
                    value="<?= isset($get_pengeluaran) ? $get_pengeluaran->nm_karyawan : null ?>">
                <label for="">Nama Karyawan</label>
                <select name="karyawan" id=""
                    class="form-control form-control-sm get_tabungan {{ isset($get_karyawan) ? 'chosen_select_karyawan2' : 'chosen_select_karyawan' }}"
                    required>
                    <option value="">- Pilih Karyawan -</option>
                    @if (isset($get_karyawan))
                        @foreach ($get_karyawan as $karyawan)
                            <option value="{{ $karyawan->id_karyawan }}"
                                {{ $karyawan->id_karyawan == $get_pengeluaran->id_karyawan ? 'selected' : null }}>
                                {{ $karyawan->nm_karyawan }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Tgl Pengeluaran</label>
                <input type="date" name="tgl_pengeluaran" id="" class="form-control form-control-sm"
                    value="<?= isset($get_pengeluaran) ? $get_pengeluaran->tgl : date('Y-m-d') ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Nilai Pengeluaran</label>
                <input type="text" name="nilai_pengeluaran" id=""
                    class="form-control form-control-sm text-right numeric"
                    value="<?= isset($get_pengeluaran) ? $get_pengeluaran->nilai : null ?>">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="">Keterangan</label>
                <textarea name="keterangan" id="" cols="30" rows="10" class="form-control form-control-sm"><?= isset($get_pengeluaran) ? $get_pengeluaran->keterangan : null ?></textarea>
            </div>
        </div>
    </div>
</div>

<script>
    var id_karyawan = $(".id_karyawan").val();
    var nm_karyawan = $(".nm_karyawan").val();

    $(".chosen_select_karyawan").select2({
        width: '100%',
        dropdownParent: $("#addPengeluaranTabunganMB"),
        placeholder: 'Select an option',
        ajax: {
            url: '/get_karyawan_pengeluaran',
            type: 'GET',
            dataType: 'JSON',
            data: function(params) {
                return {
                    searchTerm: params.term,
                    _token: '{{ csrf_token() }}'
                }
            },
            processResults: function(data) {
                return {
                    results: data
                }
            }
        }
    });

    $(".chosen_select_karyawan2").select2({
        width: '100%',
        dropdownParent: $("#addPengeluaranTabunganMB"),
        placeholder: 'Select an option'
    });

    $(document).ready(function() {
        $('.numeric').autoNumeric();
    });

    
</script>
