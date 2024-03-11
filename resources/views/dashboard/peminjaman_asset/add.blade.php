<div class="row">
    <div class="col-12">
        {{ csrf_field() }}
        <input type="hidden" name="id_peminjaman_asset" class="id_peminjaman_asset"
            value="{{ isset($peminjaman_asset) ? $peminjaman_asset->id_peminjaman_asset : auth()->user()->username }}">
        <input type="hidden" name="type_post" class="type_post" value="{{ isset($peminjaman_asset) ? 'PUT' : 'POST' }}">
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="">Tgl Awal Peminjaman</label>
            <input type="date" name="tgl_awal_peminjaman" id="" class="form-control form-control-sm"
                value="{{ isset($peminjaman_asset) ? $peminjaman_asset->tgl_awal_peminjaman : null }}" requried>
        </div>
        <div class="form-group">
            <label for="">Tgl Pengembalian</label>
            <input type="date" name="tgl_pengembalian" id="" class="form-control form-control-sm"
                value="{{ isset($peminjaman_asset) ? $peminjaman_asset->tgl_pengembalian : null }}" requried>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="">Nama Karyawan</label>
            <select name="karyawan" id="" class="form-control form-control-sm chosen-select">
                <option value="">- Nama Karyawan -</option>
                @foreach ($karyawan as $list_karyawan)
                    <option value="{{ $list_karyawan->id_karyawan }}"
                        {{ isset($peminjaman_asset) && $list_karyawan->id_karyawan == $peminjaman_asset->id_karyawan }}>
                        {{ $list_karyawan->nm_karyawan }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="">Keterangan</label>
            <textarea name="keterangan" id="" cols="30" rows="2" class="form-control form-control-sm">{{ isset($peminjaman_asset) ? $peminjaman_asset->keterangan : null }}</textarea>
        </div>
    </div>
    <div class="col-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Asset</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="list_asset">

            </tbody>
            <tbody>
                <tr>
                    <td></td>
                    <td>
                        <select name="" id="" class="form-control form-control-sm item_asset chosen_select_asset"></select>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-success add_asset">
                            <i class="fa fa-plus"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(".chosen-select").select2({
        width: '100%',
        dropdownParent: $("#addPeminjamanAssetMB"),
        placeholder: 'Select an option',
        ajax: {
            url: '/get_peminjaman_asset_list_karyawan',
            type: 'POST',
            dataType: 'JSON',
            data: function(params) {
                return {
                    searchTerm: params.term,
                    page: params.page,
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

    $(".chosen_select_asset").select2({
        width: '100%',
        dropdownParent: $("#addPeminjamanAssetMB"),
        placeholder: 'Select an option',
        ajax: {
            url: '/get_asset',
            type: 'POST',
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
