<div class="col-12">
    {{ csrf_field() }}
    {{-- {{ print_r($get_pemasukan) }} --}}
    <input type="hidden" name="type_post" class="type_post" value="{{ isset($get_pemasukan) ? 'PUT' : 'POST' }}">
    <input type="hidden" name="id_pemasukan" value="{{ isset($get_pemasukan) ? $get_pemasukan->id : null }}">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="">ID Pemasukan</label>
                <input type="text" name="" id="" class="form-control form-control-sm"
                    value="<?= isset($get_pemasukan) ? $get_pemasukan->id : 'new' ?>" readonly>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <input type="hidden" class="id_karyawan"
                    value="<?= isset($get_pemasukan) ? $get_pemasukan->id_karyawan : null ?>">
                <input type="hidden" class="nm_karyawan"
                    value="<?= isset($get_pemasukan) ? $get_pemasukan->nm_karyawan : null ?>">
                <label for="">Nama Karyawan</label>
                <select name="karyawan" id=""
                    class="form-control form-control-sm {{ isset($get_karyawan) ? 'chosen_select_karyawan2' : 'chosen_select_karyawan' }}"
                    required>
                    <option value="">- Pilih Karyawan -</option>
                    @if (isset($get_karyawan))
                        @foreach ($get_karyawan as $karyawan)
                            <option value="{{ $karyawan->id_karyawan }}"
                                {{ $karyawan->id_karyawan == $get_pemasukan->id_karyawan ? 'selected' : null }}>
                                {{ $karyawan->nm_karyawan }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Tgl Pemasukan</label>
                <input type="date" name="tgl_pemasukan" id="" class="form-control form-control-sm"
                    value="<?= isset($get_pemasukan) ? $get_pemasukan->tgl : date('Y-m-d') ?>">
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Nilai Pemasukan</label>
                <input type="text" name="nilai_pemasukan" id=""
                    class="form-control form-control-sm text-right numeric"
                    value="<?= isset($get_pemasukan) ? $get_pemasukan->nilai : null ?>">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="">Keterangan</label>
                <textarea name="keterangan" id="" cols="30" rows="10" class="form-control form-control-sm"><?= isset($get_pemasukan) ? $get_pemasukan->keterangan : null ?></textarea>
            </div>
        </div>
    </div>
</div>

<script>
    var id_karyawan = $(".id_karyawan").val();
    var nm_karyawan = $(".nm_karyawan").val();

    $(".chosen_select_karyawan").select2({
        width: '100%',
        dropdownParent: $("#addPemasukanTabunganMB"),
        placeholder: 'Select an option',
        ajax: {
            url: '/get_karyawan_pemasukan',
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
        dropdownParent: $("#addPemasukanTabunganMB"),
        placeholder: 'Select an option'
    });

    $(document).ready(function() {
        $('.numeric').autoNumeric();
    });
</script>
