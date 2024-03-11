<div class="col-12">
    {{ csrf_field() }}
    <input type="hidden" name="id" class="id" value="{{ (isset($get_kategori_barang)) ? $get_kategori_barang->id : null }}">
    <input type="hidden" name="type_post" class="type_post" value="{{ (isset($get_kategori_barang)) ? 'PUT' : 'POST' }}">
    <div class="form-group">
        <label for="">Nama Kategori Barang</label>
        <input type="text" name="nm_kategori_barang" id="" class="form-control form-control-sm" value="{{ (isset($get_kategori_barang)) ? $get_kategori_barang->nm_kategori_barang : null }}">
    </div>
</div>