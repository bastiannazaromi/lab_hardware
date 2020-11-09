<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
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
                                    <th>Denda</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; $denda = 0;
                                foreach ($pinjaman as $hasil) : ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $hasil['nama_barang']; ?></td>
                                    <td><?= $hasil['jumlah']; ?></td>
                                    <td><?= date('d F Y - H:i:s', strtotime($hasil['tanggal_pinjam'])); ?></td>
                                    <td><?= date('d F Y', strtotime($hasil['max_kembali'])); ?></td>
                                    <td><?= $hasil['tanggal_kembali']; ?></td>
                                    <td><?= tempoTgl($hasil['max_kembali'], $hasil['tanggal_kembali']); ?></td>
                                    <td>-</td>
                                    <td><?= $hasil['status'] ; ?></td>
                                </tr>
                                <?php $denda += denda($hasil['max_kembali'], $hasil['tanggal_kembali']);
                            endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table table-warning">
                                    <td colspan="7" class="text-center">Denda yang dibayar</td>
                                    <td>
                                        <div class="badge badge-warning">
                                            <?php if($pinjaman != null) : ?>
                                            <?= 'Rp. ' . number_format($denda / count($pinjaman)) ; ?>
                                            <?php endif ; ?>
                                        </div>
                                    </td>
                                    <td>-</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>