<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-hover">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>ID User</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($pinjam as $hasil) : ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $hasil['id_user']; ?></td>
                                    <td><?= $hasil['nama']; ?></td>
                                    <td><?= $hasil['no_telepon']; ?></td>
                                    <td><?= $hasil['email']; ?></td>
                                    <td><?= $hasil['tanggal_pinjam']; ?></td>
                                    <td>
                                        <a href="<?= base_url() ?>belakang/pinjaman/cek/<?= enkrip($hasil['id_user']) . '/' . enkrip($hasil['tanggal_pinjam']) . '/' . enkrip($role) ; ?>"
                                            class="badge badge-success"><i class="fa fa-info"></i> Detail</a>
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
                url: "<?= base_url('belakang/pinjaman/update'); ?>",
                type: 'post',
                data: dataJson,
                success: function() {
                    document.location.href =
                        `<?= base_url('belakang/lewat_batas/') . $role; ?>`;
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
                url: "<?= base_url('belakang/pinjaman/update'); ?>",
                type: 'post',
                data: dataJson,
                success: function() {
                    document.location.href =
                        `<?= base_url('belakang/lewat_batas/') . $role; ?>`;
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
                url: "<?= base_url('belakang/pinjaman/update'); ?>",
                type: 'post',
                data: dataJson,
                success: function() {
                    document.location.href =
                        `<?= base_url('belakang/lewat_batas/') . $role; ?>`;
                }
            });
        });
    }
});
</script>