<div class="col-12">
    {{ csrf_field() }}
    <input type="hidden" name="id_barang" class="id_barang" value="{{ (isset($get_barang)) ? $get_barang->id_barang : null }}">
    <input type="hidden" name="type_post" class="type_post" value="{{ (isset($get_barang)) ? 'PUT' : 'POST' }}">
    <div class="form-group">
        <label for="">Kategori Barang</label>
        <select name="kategori_barang" id="" class="form-control form-control-sm chosen-select">
            <option value="">- Kategori Barang -</option>
            @foreach ($kategori_barang as $list_kat)
                <option value="{{ $list_kat->id }}" {{ (isset($get_barang) && $list_kat->id == $get_barang->id_kategori_barang) ? 'selected' : null }}>{{ $list_kat->nm_kategori_barang }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="">Nama Barang</label>
        <input type="text" name="nm_barang" id="" class="form-control form-control-sm" value="{{ (isset($get_barang)) ? $get_barang->nm_barang : null }}">
    </div>
</div>