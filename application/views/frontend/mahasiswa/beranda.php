<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 col-12 text-right">
                        <a href="<?= base_url('dashboard/mahasiswa/pinjam') ?>" class="btn btn-primary"><i
                                class="fa fa-shopping-cart"></i>
                            keranjang</a>
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
                                    <th>Nama</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Maximal Pengembalian</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($pinjaman as $hasil) : ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $hasil['nama'] ; ?></td>
                                    <td><?= date('d F Y - H:i:s', strtotime($hasil['tanggal_pinjam'])); ?></td>
                                    <td><?= date('d F Y', strtotime($hasil['max_kembali'])); ?></td>
                                    <td>
                                        <a href="<?= base_url() ?>dashboard/mahasiswa/pinjaman/<?= enkrip($hasil['tanggal_pinjam']) ; ?>"
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