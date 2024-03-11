<div class="col-12">
    {{ csrf_field() }}
    <input type="hidden" name="type_post" class="type_post" value="{{ isset($get_pemasukan) ? 'PUT' : 'POST' }}">
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label for="">ID Pemasukan</label>
                <input type="text" name="id_pemasukan" id="" class="form-control form-control-sm"
                    value="<?= isset($get_pemasukan) ? $get_pemasukan->id : 'new' ?>" readonly>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="">Nama Karyawan</label>
                <select name="karyawan" id="" class="form-control form-control-sm chosen_select_karyawan"
                    required>
                    <option value="">- Pilih Karyawan -</option>
                </select>
            </div>
        </div>
    </div>
</div>

<script>
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
</script>
