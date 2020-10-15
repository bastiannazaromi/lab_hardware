<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 col-12 text-right">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAdd"><i
                                class="fa fa-shopping-cart"></i> Pinjam</button>
                    </div>
                    <?php if (form_error('nama_barang')) : ?>
                    <?= form_error('nama_barang', '<small class="text-danger">', '</small>'); ?> <br>
                    <?php endif; ?>
                    <?php if (form_error('jumlah')) : ?>
                    <?= form_error('jumlah', '<small class="text-danger">', '</small>'); ?> <br>
                    <?php endif; ?>

                    <br>
                    <br>
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-hover">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Maximal Pengembalian</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Denda</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($pinjaman as $hasil) : ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $hasil['nama_barang']; ?></td>
                                    <td><?= $hasil['jumlah']; ?></td>
                                    <td><?= date('d F Y - H:i:s', strtotime($hasil['tanggal_pinjam'])); ?></td>
                                    <td><?= date('d F Y', strtotime($hasil['max_kembali'])); ?></td>
                                    <td><?= $hasil['tanggal_kembali']; ?></td>
                                    <td>
                                        <?= tempoTgl($hasil['max_kembali'], $hasil['tanggal_kembali']); ?>
                                    </td>
                                    <td>
                                        <div class="badge <?= $hasil['status'] == 'Selesai' ? 'btn-success' : 'badge-warning'; ?>"
                                            role="alert">
                                            <?= $hasil['status']; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?= denda($hasil['max_kembali'], $hasil['tanggal_kembali']); ?>
                                    </td>
                                    <td>
                                        <?php if ($hasil['status'] == "Menunggu") : ?>
                                        <a href="#" class="badge badge-warning edit_brg" data-toggle="modal"
                                            data-target="#modalEdit<?= $hasil['id']; ?>"><i class="fa fa-edit"></i>
                                            Edit</a>
                                        <a href="<?= base_url() ?>mahasiswa/beranda/hapus/<?= $hasil['id']; ?>"
                                            class="badge badge-danger delete-people tombol-hapus"><i
                                                class="fa fa-trash"></i> Hapus</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Modal Add-->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('mahasiswa/beranda/tambah'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pinjambarang">Pinjam Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_pinjam">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="custom-select" id="kategori" name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $ktg) : ?>
                            <option value="<?= $ktg['kategori']; ?>"><?= $ktg['kategori']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <select class="custom-select" id="nama_barang" name="nama_barang">
                            <option value="">-- Pilih Barang --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" id="stok" name="stok" readonly autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Pinjam</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required
                            autocomplete="off">
                        <small class="text-danger" id="pesan_jumlah"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="add" class="btn btn-primary" id="btn_pinjam">Pinjam</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit-->
<?php foreach ($pinjaman as $dt) : ?>
<div class="modal fade" id="modalEdit<?= $dt['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('mahasiswa/beranda/edit'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpinjam">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="<?= $dt['id']; ?>" name="id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>" class="csrf_edit_pinjam">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="custom-select kategori_e" name="kategori"
                            data-nm_brg="<?= $dt['nama_barang']; ?>" data-kategori="<?= $dt['kategori']; ?>"
                            data-stok="<?= $dt['normal'] - $dt['dipinjam'] + $dt['jumlah']; ?>"
                            data-jumlah="<?= $dt['jumlah']; ?>">
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $ktg) : ?>
                            <option value="<?= $ktg['kategori']; ?>"
                                <?php if ($ktg['kategori'] == $dt['kategori']) echo 'selected="selected"'; ?>>
                                <?= $ktg['kategori']; ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <select class="custom-select nama_barang_e" name="nama_barang">
                            <option value="">-- Pilih Nama Barang --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control stok_e" name="stok" readonly autocomplete="off"
                            value="<?= $dt['normal'] - $dt['dipinjam'] + $dt['jumlah']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Pinjam</label>
                        <input type="number" class="form-control jumlah_e" name="jumlah" min="1" required
                            autocomplete="off" value="<?= $dt['jumlah']; ?>">
                        <small class="text-danger pesan_edit"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit" class="btn btn-warning edit_barang">Edit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>

<script src="<?= base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>

<script>
$(document).ready(function() {

    // modal add

    $('#kategori').change(function() {
        let csrfName = $("#csrf_pinjam").attr('name');
        let csrfHash = $("#csrf_pinjam").val();

        var kategori = $(this).val();
        var option = [];

        var dataJson = {
            [csrfName]: csrfHash,
            kategori: kategori
        };

        $.ajax({
            url: "<?= base_url('mahasiswa/beranda/cari_barang'); ?>",
            type: 'post',
            dataType: 'json',
            data: dataJson,
            success: function(result) {
                $("#csrf_pinjam").val(result.token);

                var option = [];
                var stok = [];
                $(result.hasil).each(function(i) {
                    stok[i] = result.hasil[i].normal - result.hasil[i].dipinjam;
                    option.push('<option value="' + result.hasil[i].nama_barang +
                        '" data-stok="' + stok[i] + '">' +
                        result.hasil[i].nama_barang + '</option>');
                });

                $('#nama_barang').html(option.join(''));
                $('#stok').val('');
            }
        });
    });

    $('#nama_barang').click(function() {
        let stok = $(this).find(':selected').data('stok');
        let nama_barang = $(this).val();
        $('#stok').val(stok);
    });

    $('#jumlah').change(function() {
        let stok = $('#nama_barang').find(':selected').data('stok');
        let jumlah = $(this).val();

        let hasil = stok - jumlah;
        if (hasil < 0) {
            $('#pesan_jumlah').text("Jumlah barang pinjam melebihi stok barang");
            $("#btn_pinjam").attr('disabled', 'disabled');
        } else {
            $('#pesan_jumlah').text("");
            $("#btn_pinjam").removeAttr('disabled');
        }
    });

    // modal edit
    let edit_brgs = $('.edit_brg');
    let csrfHashs = ($('.csrf_edit_pinjam'));
    let kategoris = $('.kategori_e');
    let nama_barangs = $('.nama_barang_e');
    let stoks = $('.stok_e');
    let jumlahs = $('.jumlah_e');
    let pesan_edits = $('.pesan_edit');
    let edit_barangs = $('.edit_barang');
    let nm_brg = "";
    let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    $(edit_brgs).each(function(i) {

        $(edit_brgs[i]).click(function() {
            nm_brg = $(kategoris[i]).data('nm_brg');

            var kategori = $(kategoris[i]).data('kategori');
            var option = [];

            $(kategoris[i]).val(kategori);
            $(stoks[i]).val($(kategoris[i]).data('stok'));
            $(jumlahs[i]).val($(kategoris[i]).data('jumlah'));
            $(pesan_edits[i]).text("");
            $(edit_barangs[i]).removeAttr('disabled');

            var dataJson = {
                [csrfName]: csrfHash,
                kategori: kategori
            };

            $.ajax({
                url: "<?= base_url('mahasiswa/beranda/cari_barang'); ?>",
                type: 'post',
                dataType: 'json',
                data: dataJson,
                success: function(result) {
                    $(csrfHashs).val(result.token);
                    csrfHash = result.token;
                    $("#csrf_pinjam").val(result.token);

                    var option = [];
                    var stok = [];
                    $(result.hasil).each(function(i) {
                        let select = [];
                        if (result.hasil[i].nama_barang == nm_brg) {
                            select[i] = 'selected="selected"';
                        } else {
                            select[i] = '';
                        }
                        stok[i] = result.hasil[i].normal - result.hasil[
                                i]
                            .dipinjam;
                        option.push('<option value="' + result.hasil[i]
                            .nama_barang +
                            '" data-stok="' + stok[i] +
                            '"' + select[i] + '>' +
                            result.hasil[i].nama_barang +
                            '</option>');
                    });

                    $(nama_barangs[i]).html(option.join(''));
                }
            });

        });

        $(kategoris[i]).change(function() {
            csrfName = $(csrfHashs[i]).attr('name');
            csrfHash = $(csrfHashs[i]).val();

            var kategori = $(this).val();
            var option = [];

            var dataJson = {
                [csrfName]: csrfHash,
                kategori: kategori
            };

            $.ajax({
                url: "<?= base_url('mahasiswa/beranda/cari_barang'); ?>",
                type: 'post',
                dataType: 'json',
                data: dataJson,
                success: function(result) {
                    $(csrfHashs).val(result.token);
                    $("#csrf_pinjam").val(result.token);
                    csrfHash = result.token;

                    var option = [];
                    var stok = [];
                    $(result.hasil).each(function(i) {
                        stok[i] = result.hasil[i].normal - result.hasil[
                                i]
                            .dipinjam;
                        option.push('<option value="' + result.hasil[i]
                            .nama_barang +
                            '" data-stok="' + stok[i] + '">' +
                            result.hasil[i].nama_barang +
                            '</option>');
                    });

                    $(nama_barangs[i]).html(option.join(''));
                    $(stoks[i]).val('');
                    $(jumlahs[i]).val('');
                }
            });

        });

        $(nama_barangs[i]).click(function() {
            let stok = $(this).find(':selected').data('stok');
            let nama_barang = $(this).val();
            $(stoks[i]).val(stok);
        });

        $(jumlahs[i]).change(function() {
            let stok = $(nama_barangs[i]).find(':selected').data('stok');
            let jumlah = $(this).val();

            let hasil = stok - jumlah;
            if (hasil < 0) {
                $(pesan_edits[i]).text("Jumlah barang pinjam melebihi stok barang");
                $(edit_barangs[i]).attr('disabled', 'disabled');
            } else {
                $(pesan_edits[i]).text("");
                $(edit_barangs[i]).removeAttr('disabled');
            }
        });

    });
});
</script>