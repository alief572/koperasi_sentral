@extends('dashboard.partial.main')

@section('content')
    <h4>
        {{ $title }}
        <button type="button" class="btn btn-sm btn-success ml-2 add_karyawan" data-toggle="modal" data-target="#addKaryawan">
            <i class="fa fa-plus"></i>
            Tambah Karyawan
        </button>
    </h4>
    <table class="table table-striped data-table">
        <thead>
            <th>No</th>
            <th>Nama Karyawan</th>
            <th>No HP</th>
            <th>Email</th>
            <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="modal fade" id="addKaryawan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Karyawan</h5>
                </div>
                <form action="" method="post" id="data_form">
                    {{ csrf_field() }}
                    <div class="modal-body" id="addKaryawanMB">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nama Karyawan</label>
                                    <input type="text" name="nm_karyawan" id=""
                                        class="form-control form-control-sm" required>
                                    @error('nm_karyawan')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">No. HP</label>
                                    <input type="text" name="no_hp" id="" class="form-control form-control-sm"
                                        required>
                                    @error('no_hp')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="" class="form-control form-control-sm"
                                        required>
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id=""
                                        class="form-control form-control-sm">
                                    @error('tempat_lahir')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tgl Lahir</label>
                                    <input type="date" name="tgl_lahir" id=""
                                        class="form-control form-control-sm">
                                    @error('tgl_lahir')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Gender</label>
                                    <select name="gender" id="" class="form-control form-control-sm" required>
                                        <option value="">- Gender -</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                    @error('gender')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Agama</label>
                                    <select name="agama" id="" class="form-control form-control-sm" required>
                                        <option value="">- Agama -</option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="Katholik">Katholik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="buddha">Buddha</option>
                                        <option value="kong hu cu">Kong Hu Cu</option>
                                    </select>
                                    @error('agama')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tgl Mulai Kerja</label>
                                    <input type="date" name="tgl_mulai_kerja" id=""
                                        class="form-control form-control-sm">
                                    @error('tgl_mulai_kerja')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tgl Resign</label>
                                    <input type="date" name="tgl_resign" id=""
                                        class="form-control form-control-sm">
                                    @error('tgl_resign')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Pendidikan Terakhir</label>
                                    <select name="pendidikan_terakhir" id="" class="form-control form-control-sm">
                                        <option value="0">Tidak Sekolah</option>
                                        <option value="1">SD</option>
                                        <option value="2">SMP</option>
                                        <option value="3">SMA</option>
                                        <option value="4">D3</option>
                                        <option value="5">S1</option>
                                        <option value="6">S2</option>
                                        <option value="7">S3</option>
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">No. Kartu Keluarga</label>
                                    <input type="text" name="no_kartu_keluarga" id=""
                                        class="form-control form-control-sm">
                                    @error('no_kartu_keluarga')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">No. BPJS</label>
                                    <input type="text" name="no_bpjs" id=""
                                        class="form-control form-control-sm">
                                    @error('no_bpjs')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">No. NPWP</label>
                                    <input type="text" name="no_npwp" id=""
                                        class="form-control form-control-sm">
                                    @error('no_npwp')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" id="" cols="30" rows="3" class="form-control form-control-sm"></textarea>
                                    @error('alamat')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <h5>Data Bank</h5>
                                <div class="form-group">
                                    <label for="">Bank</label>
                                    <select name="bank" id=""
                                        class="form-control form-control-sm chosen-select">
                                        <option value="">- Bank -</option>
                                        <option value="008">Bank Mandiri </option>
                                        <option value="002">Bank Rakyat Indonesia (BRI) </option>
                                        <option value="009">Bank Negara Indonesia (BNI) </option>
                                        <option value="022">Bank CIMB Niaga </option>
                                        <option value="011">Bank Danamon </option>
                                        <option value="013">Bank Permata </option>
                                        <option value="019">Bank Panin </option>
                                        <option value="016">Bank Maybank </option>
                                        <option value="009">Bank HSBC </option>
                                        <option value="426">Bank Mega </option>
                                        <option value="200">Bank Tabungan Negara (BTN) </option>
                                        <option value="427">Bank Syariah Indonesia (BSI) </option>
                                        <option value="147">Bank Muamalat </option>
                                        <option value="451">Bank Mayapada </option>
                                        <option value="411">Bank Artha Graha </option>
                                        <option value="010">Bank UOB Indonesia </option>
                                        <option value="401">Bank Shinhan Indonesia </option>
                                        <option value="028">Bank OCBC NISP </option>
                                        <option value="023">Bank Commonwealth </option>
                                        <option value="029">Bank Capital Indonesia </option>
                                        <option value="167">Bank QNB Indonesia </option>
                                        <option value="212">Bank Woori Saudara Indonesia 1906 </option>
                                        <option value="531">Bank Amar Indonesia </option>
                                        <option value="061">Bank ANZ Indonesia </option>
                                        <option value="057">Bank BNP Paribas Indonesia </option>
                                        <option value="213">Bank BTPN </option>
                                        <option value="547">Bank BTPN Syariah </option>
                                        <option value="425">Bank JTrust Indonesia </option>
                                        <option value="429">Bank Maybank Syariah Indonesia </option>
                                        <option value="453">Bank Danamon Syariah </option>
                                        <option value="452">Bank Permata Syariah </option>
                                        <option value="147">Bank Muamalat Indonesia </option>
                                        <option value="451">Bank Syariah Mandiri </option>
                                        <option value="422">Bank BRI Syariah </option>
                                        <option value="427">BNI Syariah </option>
                                        <option value="422">Bank Syariah Indonesia (Eks BRI Syariah)</option>
                                        <option value="427">Bank Syariah Indonesia (Eks BNI Syariah)</option>
                                    </select>
                                    @error('bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Nomor Akun Bank</label>
                                    <input type="text" name="nomor_akun_bank" id=""
                                        class="form-control form-control-sm">
                                    @error('nomor_akun_bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Nama di Akun Bank</label>
                                    <input type="text" name="nama_akun_bank" id=""
                                        class="form-control form-control-sm">
                                    @error('nama_akun_bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat Bank</label>
                                    <textarea name="alamat_bank" id="" cols="30" rows="5" class="form-control form-control-sm"></textarea>
                                    @error('alamat_bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Swift Code</label>
                                    <input type="text" name="swift_code" id=""
                                        class="form-control form-control-sm">
                                    @error('swift_code')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Karyawan</h5>
                </div>
                <form action="" method="post" id="edit_form">
                    {{ csrf_field() }}
                    <input type="hidden" name="id_karyawan" class="id_karyawan" value="">
                    <div class="modal-body" id="addKaryawanMB">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Nama Karyawan</label>
                                    <input type="text" name="nm_karyawan" id=""
                                        class="form-control form-control-sm nm_karyawan" required>
                                    @error('nm_karyawan')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">No. HP</label>
                                    <input type="text" name="no_hp" id=""
                                        class="form-control form-control-sm no_hp" required>
                                    @error('no_hp')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id=""
                                        class="form-control form-control-sm email" required>
                                    @error('email')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" id=""
                                        class="form-control form-control-sm tempat_lahir">
                                    @error('tempat_lahir')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tgl Lahir</label>
                                    <input type="date" name="tgl_lahir" id=""
                                        class="form-control form-control-sm tgl_lahir">
                                    @error('tgl_lahir')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Gender</label>
                                    <select name="gender" id="" class="form-control form-control-sm gender"
                                        required>
                                        <option value="">- Gender -</option>
                                        <option value="pria">Pria</option>
                                        <option value="wanita">Wanita</option>
                                    </select>
                                    @error('gender')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Agama</label>
                                    <select name="agama" id="" class="form-control form-control-sm agama"
                                        required>
                                        <option value="">- Agama -</option>
                                        <option value="islam">Islam</option>
                                        <option value="kristen">Kristen</option>
                                        <option value="Katholik">Katholik</option>
                                        <option value="hindu">Hindu</option>
                                        <option value="buddha">Buddha</option>
                                        <option value="kong hu cu">Kong Hu Cu</option>
                                    </select>
                                    @error('agama')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="">Tgl Mulai Kerja</label>
                                    <input type="date" name="tgl_mulai_kerja" id=""
                                        class="form-control form-control-sm tgl_mulai_kerja">
                                    @error('tgl_mulai_kerja')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Tgl Resign</label>
                                    <input type="date" name="tgl_resign" id=""
                                        class="form-control form-control-sm tgl_resign">
                                    @error('tgl_resign')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Pendidikan Terakhir</label>
                                    <select name="pendidikan_terakhir" id=""
                                        class="form-control form-control-sm pendidikan_terakhir">
                                        <option value="0">Tidak Sekolah</option>
                                        <option value="1">SD</option>
                                        <option value="2">SMP</option>
                                        <option value="3">SMA</option>
                                        <option value="4">D3</option>
                                        <option value="5">S1</option>
                                        <option value="6">S2</option>
                                        <option value="7">S3</option>
                                    </select>
                                    @error('pendidikan_terakhir')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">No. Kartu Keluarga</label>
                                    <input type="text" name="no_kartu_keluarga" id=""
                                        class="form-control form-control-sm no_kartu_keluarga">
                                    @error('no_kartu_keluarga')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">No. BPJS</label>
                                    <input type="text" name="no_bpjs" id=""
                                        class="form-control form-control-sm no_bpjs">
                                    @error('no_bpjs')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">No. NPWP</label>
                                    <input type="text" name="no_npwp" id=""
                                        class="form-control form-control-sm no_npwp">
                                    @error('no_npwp')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat</label>
                                    <textarea name="alamat" id="" cols="30" rows="3" class="form-control form-control-sm alamat"></textarea>
                                    @error('alamat')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <h5>Data Bank</h5>
                                <div class="form-group">
                                    <label for="">Bank</label>
                                    <select name="bank" id=""
                                        class="form-control form-control-sm chosen-select bank">
                                        <option value="">- Bank -</option>
                                        <option value="008">Bank Mandiri </option>
                                        <option value="002">Bank Rakyat Indonesia (BRI) </option>
                                        <option value="009">Bank Negara Indonesia (BNI) </option>
                                        <option value="022">Bank CIMB Niaga </option>
                                        <option value="011">Bank Danamon </option>
                                        <option value="013">Bank Permata </option>
                                        <option value="019">Bank Panin </option>
                                        <option value="016">Bank Maybank </option>
                                        <option value="099">Bank HSBC </option>
                                        <option value="426">Bank Mega </option>
                                        <option value="200">Bank Tabungan Negara (BTN) </option>
                                        <option value="427">Bank Syariah Indonesia (BSI) </option>
                                        <option value="147">Bank Muamalat </option>
                                        <option value="451">Bank Mayapada </option>
                                        <option value="411">Bank Artha Graha </option>
                                        <option value="010">Bank UOB Indonesia </option>
                                        <option value="401">Bank Shinhan Indonesia </option>
                                        <option value="028">Bank OCBC NISP </option>
                                        <option value="023">Bank Commonwealth </option>
                                        <option value="029">Bank Capital Indonesia </option>
                                        <option value="167">Bank QNB Indonesia </option>
                                        <option value="212">Bank Woori Saudara Indonesia 1906 </option>
                                        <option value="531">Bank Amar Indonesia </option>
                                        <option value="061">Bank ANZ Indonesia </option>
                                        <option value="057">Bank BNP Paribas Indonesia </option>
                                        <option value="213">Bank BTPN </option>
                                        <option value="547">Bank BTPN Syariah </option>
                                        <option value="425">Bank JTrust Indonesia </option>
                                        <option value="429">Bank Maybank Syariah Indonesia </option>
                                        <option value="453">Bank Danamon Syariah </option>
                                        <option value="452">Bank Permata Syariah </option>
                                        <option value="147">Bank Muamalat Indonesia </option>
                                        <option value="451">Bank Syariah Mandiri </option>
                                        <option value="422">Bank BRI Syariah </option>
                                        <option value="427">BNI Syariah </option>
                                        <option value="422">Bank Syariah Indonesia (Eks BRI Syariah)</option>
                                        <option value="427">Bank Syariah Indonesia (Eks BNI Syariah)</option>
                                    </select>
                                    @error('bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Nomor Akun Bank</label>
                                    <input type="text" name="nomor_akun_bank" id=""
                                        class="form-control form-control-sm nomor_akun_bank">
                                    @error('nomor_akun_bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Nama di Akun Bank</label>
                                    <input type="text" name="nama_akun_bank" id=""
                                        class="form-control form-control-sm nama_akun_bank">
                                    @error('nama_akun_bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Alamat Bank</label>
                                    <textarea name="alamat_bank" id="" cols="30" rows="5"
                                        class="form-control form-control-sm alamat_bank"></textarea>
                                    @error('alamat_bank')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="">Swift Code</label>
                                    <input type="text" name="swift_code" id=""
                                        class="form-control form-control-sm swift_code">
                                    @error('swift_code')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-sm btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View Data Karyawan</h5>
                </div>

                <div class="modal-body modal_body_view">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript_section')
    <script>
        $(document).ready(function() {
            // $(".chosen-select").select2({
            //     width: '100%',
            //     dropdownParent: $("#addKaryawanMB")
            // });

            $(".dataTables_filter input").addClass('dtb_search');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            dataTable = $(".data-table").DataTable({

                initComplete: function() {
                    // Add your class to the search input
                    $('.dataTables_filter input').addClass('dtb_search');
                },
                ajax: {
                    url: "{{ route('get_karyawan') }}",
                    type: "GET",
                    dataType: "JSON",
                    data: function(d) {
                        d.search = $(".dtb_search").val();
                    },
                    dataSrc: 'data'
                },
                columns: [{
                        data: 'no',
                    }, {
                        data: 'nm_karyawan'
                    },
                    {
                        data: 'no_hp'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'buttons'
                    }
                ],
                responsive: true,
                processing: true,
                serverSide: true,
                stateSave: true,
                destroy: true,
                paging: true,
            });

            $(document).on("click", ".edit_karyawan", function() {
                var id_karyawan = $(this).data('id_karyawan');
                // alert(id_karyawan);

                $.ajax({
                    type: "GET",
                    url: "/get_data_karyawan/" + id_karyawan,
                    cache: false,
                    dataType: "JSON",
                    success: function(result) {
                        $(".id_karyawan").val(id_karyawan);
                        $(".nm_karyawan").val(result.data.nm_karyawan);
                        $(".no_hp").val(result.data.no_hp);
                        $(".email").val(result.data.email);
                        $(".tempat_lahir").val(result.data.birth_place);
                        $(".tgl_lahir").val(result.data.birth_date);
                        $(".gender").val(result.data.gender);
                        $(".agama").val(result.data.religion);
                        $(".tgl_mulai_kerja").val(result.data.tgl_mulai_kerja);
                        $(".tgl_resign").val(result.data.tgl_resign);
                        $(".pendidikan_terakhir").val(result.data.pendidikan_terakhir);
                        $(".no_kartu_keluarga").val(result.data.no_kartu_keluarga);
                        $(".no_bpjs").val(result.data.no_bpjs);
                        $(".no_npwp").val(result.data.no_npwp);
                        $(".alamat").val(result.data.alamat);
                        $(".bank").val(result.data.bank_name);
                        $(".nomor_akun_bank").val(result.data.bank_account_number);
                        $(".nama_akun_bank").val(result.data.bank_account_name);
                        $(".alamat_bank").val(result.data.bank_address);
                        $(".swift_code").val(result.data.swift_code);

                        $("#editUser").modal('show');
                    }
                });
            });

            $(document).on("submit", "#delete_form", function(e) {
                e.preventDefault();
                var id_karyawan = $(this).data('id_karyawan');

                Swal.fire({
                    icon: "warning",
                    title: "Anda yakin ingin hapus data karyawan ini ?",
                    showCancelButton: true,
                    confirmButtonText: "Simpan",
                    cancelButtonText: "Batal"
                }).then((hasil) => {
                    if (hasil.isConfirmed) {

                        $.ajax({
                            type: "DELETE",
                            url: "/master_karyawan/" + id_karyawan,
                            data: $(this).serialize(),
                            cache: false,
                            success: function(result) {
                                dataTable.ajax.reload();
                            }
                        });
                    }
                });
            });

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
                            url: "/master_karyawan",
                            type: "POST",
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            cache: false,
                            success: function(hasil) {
                                Swal.fire(hasil.success,
                                    "", "success").then((hasil1) => {
                                    $("#addKaryawan").modal('hide');
                                    dataTable.ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        $('#' + key + '-error').text(value[0]);
                                    });
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire("Data batal di simpan !", "", "info");
                    }
                });
            });

            $(document).on("submit", "#edit_form", function(e) {
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
                            url: "/master_karyawan/" + $(".id_karyawan").val(),
                            type: "PUT",
                            data: $(this).serialize(),
                            dataType: 'JSON',
                            cache: false,
                            success: function(hasil) {
                                Swal.fire(hasil.success,
                                    "", "success").then((hasil1) => {
                                    $("#editUser").modal('hide');
                                    dataTable.ajax.reload();
                                });
                            },
                            error: function(xhr) {
                                if (xhr.status === 422) {
                                    var errors = xhr.responseJSON.errors;
                                    $.each(errors, function(key, value) {
                                        $('#' + key + '-error').text(value[0]);
                                    });
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire("Data batal di simpan !", "", "info");
                    }
                });
            });

            $(document).on("click", ".view_karyawan", function() {
                var id_karyawan = $(this).data('id_karyawan');
                // alert(id_karyawan);
                $.ajax({
                    type: "GET",
                    url: "/get_view_karyawan/" + id_karyawan,
                    cache: false,
                    success: function(result) {
                        // console.log(result);
                        $(".modal_body_view").html(result);
                        $("#viewUser").modal('show');
                    }
                });
            });
        });
    </script>
@endsection
