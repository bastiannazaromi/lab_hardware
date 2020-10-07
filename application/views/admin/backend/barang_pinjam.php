<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <?php echo form_open('admin/barang_pinjam/multiple_delete'); ?>
                        <table id="example" class="table table-bordered table-hover">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Max Pengembalian</th>
                                    <th>Action</th>
                                    <th>
                                        <center><input type="checkbox" id="check-all"></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($pinjam as $hasil) : ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $hasil['nim']; ?></td>
                                    <td><?= $hasil['nama']; ?></td>
                                    <td><?= $hasil['nama_barang']; ?></td>
                                    <td><?= $hasil['jumlah']; ?></td>
                                    <td><?= $hasil['tanggal_pinjam']; ?></td>
                                    <td><?= date('d F Y', strtotime($hasil['max_kembali'])); ?></td>
                                    <td>
                                        <div class="form-group" class="badge">
                                            <label class="badge badge-danger">
                                                <input type="radio" name="edit_status_ <?= $hasil['id']; ?>"
                                                    class="menunggu"
                                                    <?= $hasil['status'] == 'Menunggu' ? 'checked' : ''; ?>
                                                    data-id="<?= $hasil['id']; ?>"
                                                    data-nama_barang="<?= $hasil['nama_barang']; ?>"
                                                    data-jumlah="<?= $hasil['jumlah']; ?>" data-status="Menunggu">
                                                Menunggu
                                            </label>
                                            <label class="badge badge-warning">
                                                <input type="radio" name="edit_status_ <?= $hasil['id']; ?>"
                                                    class="dipinjam"
                                                    <?= $hasil['status'] == 'Dipinjam' ? 'checked' : ''; ?>
                                                    data-id="<?= $hasil['id']; ?>"
                                                    data-nama_barang="<?= $hasil['nama_barang']; ?>"
                                                    data-jumlah="<?= $hasil['jumlah']; ?>" data-status="Dipinjam">
                                                Dipinjam
                                            </label>
                                            <span class="badge badge-success">
                                                <input type="radio" name="edit_status_ <?= $hasil['id']; ?>"
                                                    class="selesai"
                                                    <?= $hasil['status'] == 'Selesai' ? 'checked' : ''; ?>
                                                    data-id="<?= $hasil['id']; ?>"
                                                    data-nama_barang="<?= $hasil['nama_barang']; ?>"
                                                    data-jumlah="<?= $hasil['jumlah']; ?>" data-status="Selesai">
                                                Selesai
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <center>
                                            <input type="checkbox" class="check-item" name="id[]"
                                                value="<?= $hasil['id'] ?>">
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
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>
                                        <center>
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Apakah anda yakin ingin menghapus data-data ini ?')"><i
                                                    class="fa fa-trash "></i></button>
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

<script src="<?= base_url(); ?>assets/admin/plugins/jquery/jquery.min.js"></script>

<script>
$(document).ready(function() {
    var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
        csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

    var menunggus = $('.menunggu');
    var dipinjams = $('.dipinjam');
    var selesais = $('.selesai');

    for (menunggu of menunggus) {
        menunggu.addEventListener("change", function(event) {
            let id = $(this).data('id');
            let nama_barang = $(this).data('nama_barang');
            let jumlah = $(this).data('jumlah');
            let status = $(this).data('status');

            var dataJson = {
                [csrfName]: csrfHash,
                id: id,
                nama_barang: nama_barang,
                jumlah: jumlah,
                status: status
            };

            $.ajax({
                url: "<?= base_url('admin/barang_pinjam/update'); ?>",
                type: 'post',
                data: dataJson,
                success: function() {
                    document.location.href =
                        `<?= base_url('admin/barang_pinjam'); ?>`;
                }
            });
        });
    }

    for (dipinjam of dipinjams) {
        dipinjam.addEventListener("change", function(event) {
            let id = $(this).data('id');
            let nama_barang = $(this).data('nama_barang');
            let jumlah = $(this).data('jumlah');
            let status = $(this).data('status');

            var dataJson = {
                [csrfName]: csrfHash,
                id: id,
                nama_barang: nama_barang,
                jumlah: jumlah,
                status: status
            };

            $.ajax({
                url: "<?= base_url('admin/barang_pinjam/update'); ?>",
                type: 'post',
                data: dataJson,
                success: function() {
                    document.location.href =
                        `<?= base_url('admin/barang_pinjam'); ?>`;
                }
            });
        });
    }

    for (selesai of selesais) {
        selesai.addEventListener("change", function(event) {
            let id = $(this).data('id');
            let nama_barang = $(this).data('nama_barang');
            let jumlah = $(this).data('jumlah');
            let status = $(this).data('status');

            var dataJson = {
                [csrfName]: csrfHash,
                id: id,
                nama_barang: nama_barang,
                jumlah: jumlah,
                status: status
            };

            $.ajax({
                url: "<?= base_url('admin/barang_pinjam/update'); ?>",
                type: 'post',
                data: dataJson,
                success: function() {
                    document.location.href =
                        `<?= base_url('admin/barang_pinjam'); ?>`;
                }
            });
        });
    }
});
</script>