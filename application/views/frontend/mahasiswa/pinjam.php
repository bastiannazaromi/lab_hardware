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
                        <?php echo form_open('dashboard/mahasiswa/checkout'); ?>
                        <table id="example" class="table table-bordered table-hover">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                    <th>
                                        <center><input type="checkbox" id="check-all"></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($barang as $hasil) : ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $hasil['nama_barang']; ?></td>
                                    <td><?= $hasil['jumlah']; ?></td>
                                    <td><?= $hasil['status']; ?></td>
                                    <td>
                                        <a href="#" class="badge badge-warning edit_brg" data-toggle="modal"
                                            data-target="#modalEdit" data-id="<?= enkrip($hasil['id']) ; ?>"
                                            data-stok="<?= $hasil['normal'] - $hasil['dipinjam'] + $hasil['jumlah']; ?>"
                                            data-kategori="<?= $hasil['kategori'] ; ?>"
                                            data-nama_barang="<?= $hasil['nama_barang'] ; ?>"
                                            data-jumlah="<?= $hasil['jumlah'] ; ?>"><i class="fa fa-edit"></i>
                                            Edit</a>
                                        <a href="<?= base_url() ?>dashboard/mahasiswa/hapus/<?= enkrip($hasil['id']); ?>"
                                            class="badge badge-danger delete-people tombol-hapus"><i
                                                class="fa fa-trash"></i> Hapus</a>
                                    </td>
                                    <td>
                                        <center>
                                            <input type="checkbox" class="check-item" name="id[]"
                                                value="<?= enkrip($hasil['id']); ?>">
                                        </center>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table table-warning">
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <center>
                                            <button type="submit" class="btn btn-success btn-sm"
                                                onclick="return confirm('Checkout barang tersebut ?')"><i
                                                    class="fa fa-check-double "></i></button>
                                        </center>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <?php echo form_close() ?>
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
        <form action="<?= base_url('dashboard/mahasiswa/tambah'); ?>" method="post">
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
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('dashboard/mahasiswa/edit'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpinjam">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_edit_pinjam">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="custom-select" name="kategori" id="kategori_e">
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $ktg) : ?>
                            <option value="<?= $ktg['kategori']; ?>">
                                <?= $ktg['kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <select class="custom-select" name="nama_barang" id="nama_barang_e">
                            <option value="">-- Pilih Nama Barang --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="text" class="form-control" id="stok_e" name="stok" readonly autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah Pinjam</label>
                        <input type="number" class="form-control" id="jumlah_e" name="jumlah" min="1" required
                            autocomplete="off">
                        <small class="text-danger" id="pesan_edit"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit" class="btn btn-warning" id="edit_barang">Edit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="<?= base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>

<script>
$(document).ready(function() {

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
            url: "<?= base_url('dashboard/mahasiswa/cari_barang'); ?>",
            type: 'post',
            dataType: 'json',
            data: dataJson,
            success: function(result) {
                $("#csrf_pinjam").val(result.token);

                var option = [];
                var stok = [];

                option.push('<option value="">-- Pilih Barang --</option>');

                $(result.hasil).each(function(i) {
                    stok[i] = result.hasil[i].normal - result.hasil[i].dipinjam;
                    option.push('<option value="' + result.hasil[i].nama_barang +
                        '" data-stok="' + stok[i] + '">' +
                        result.hasil[i].nama_barang + '</option>');
                });

                $('#nama_barang').html(option.join(''));
                $('#stok').val('');
                $('#jumlah').val('');
            }
        });
    });

    $('#nama_barang').click(function() {
        let stok = $(this).find(':selected').data('stok');
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

    let edit_brgs = $('.edit_brg');
    let csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    $(edit_brgs).each(function(i) {

        $(edit_brgs[i]).click(function() {

            var option = [];

            $('#id').val($(this).data('id'));
            $('#kategori_e').val($(this).data('kategori'));
            $('#stok_e').val($(this).data('stok'));
            $('#jumlah_e').val($(this).data('jumlah'));

            option.push('<option value="' + $(this).data('nama_barang') +
                '" data-stok="' + $(this).data('stok') + '">' +
                $(this).data('nama_barang') + '</option>');

            $('#nama_barang_e').html(option.join(''));

            $('#pesan_edit').text("");
            $('#edit_barang').removeAttr('disabled');

            console.log($(this).data('nama_barang'));

        });

    });

    $('#kategori_e').change(function() {
        csrfName = $('#csrf_edit_pinjam').attr('name');
        csrfHash = $('#csrf_edit_pinjam').val();

        var kategori = $(this).val();
        var option = [];

        var dataJson = {
            [csrfName]: csrfHash,
            kategori: kategori
        };

        $.ajax({
            url: "<?= base_url('dashboard/mahasiswa/cari_barang'); ?>",
            type: 'post',
            dataType: 'json',
            data: dataJson,
            success: function(result) {
                $('#csrf_edit_pinjam').val(result.token);
                $("#csrf_pinjam").val(result.token);
                csrfHash = result.token;

                var option = [];
                var stok = [];
                option.push('<option value="">-- Pilih Barang --</option>');

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

                $('#nama_barang_e').html(option.join(''));
                $('#stok_e').val('');
                $('#jumlah_e').val('');
            }
        });

    });

    $('#nama_barang_e').click(function() {
        let stok = $(this).find(':selected').data('stok');
        $('#stok_e').val(stok);
    });

    $('#jumlah_e').change(function() {
        let stok = $('#stok_e').val();
        let jumlah = $(this).val();

        let hasil = stok - jumlah;
        if (hasil < 0) {
            $('#pesan_edit').text("Jumlah barang pinjam melebihi stok barang");
            $('#edit_barang').attr('disabled', 'disabled');
        } else {
            $('#pesan_edit').text("");
            $('#edit_barang').removeAttr('disabled');
        }
    });
});
</script>