<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 col-12 text-right">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAdd"><i
                                class="fa fa-plus"></i> Barang</button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                            data-target="#modalImport"><i class="fa fa-plus"></i> Excel</button>
                        <button type="button" class="btn btn-sm btn-warning"
                            onclick="window.location='<?= base_url('excel/Format_excel_barang.xlsx'); ?>'"><i
                                class="fa fa-download"></i>
                            Format</button>
                    </div>

                    <?php if (form_error('kategori')) : ?>
                    <?= form_error('kategori', '<small class="text-danger">', '</small>'); ?> <br>
                    <?php endif; ?>
                    <?php if (form_error('nama_barang')) : ?>
                    <?= form_error('nama_barang', '<small class="text-danger">', '</small>'); ?> <br>
                    <?php endif; ?>
                    <?php if (form_error('stok')) : ?>
                    <?= form_error('stok', '<small class="text-danger">', '</small>'); ?>
                    <?php endif; ?>
                    <?php if (form_error('normal')) : ?>
                    <?= form_error('normal', '<small class="text-danger">', '</small>'); ?>
                    <?php endif; ?>

                    <br>
                    <br>
                    <div class="table-responsive">
                        <?php echo form_open('admin/stok_barang/multiple_delete'); ?>
                        <table id="example" class="table table-bordered table-hover">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Nama Barang</th>
                                    <th>Stok Barang</th>
                                    <th>Normal</th>
                                    <th>Rusak</th>
                                    <th>Dipinjam</th>
                                    <th>Sisa Barang</th>
                                    <th>Action</th>
                                    <th>
                                        <center><input type="checkbox" id="check-all"></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($stok as $hasil) : ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $hasil['kategori']; ?></td>
                                    <td><?= $hasil['nama_barang']; ?></td>
                                    <td><?= $hasil['stok']; ?></td>
                                    <td><?= $hasil['normal']; ?></td>
                                    <td><?= $hasil['rusak']; ?></td>
                                    <td><?= $hasil['dipinjam']; ?></td>
                                    <td><?= $hasil['normal'] - $hasil['dipinjam']; ?></td>
                                    <td>
                                        <a href="#" class="badge badge-warning edit_brg" data-toggle="modal"
                                            data-target="#modalEdit<?= $hasil['id']; ?>"><i class="fa fa-edit"></i>
                                            Edit</a>
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

<!-- Modal Add-->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('admin/stok_barang/tambah'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="custom-select" id="kategori" name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Mikrokontroller & Modul">Mikrokontroller & Modul</option>
                            <option value="Sensor">Sensor</option>
                            <option value="Aktuator">Aktuator</option>
                            <option value="Toolkit">Toolkit</option>
                            <option value="Jaringan">Jaringan</option>
                            <option value="Kabel">Kabel</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control" id="nama" name="nama" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" min="1" required
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="normal">Barang Normal</label>
                        <input type="number" class="form-control" id="normal" name="normal" min="0" required
                            autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="rusak">Barang Rusak</label>
                        <input type="text" class="form-control" id="rusak" name="rusak" readonly>
                        <small class="text-danger" id="pesan_rusak"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="add" class="btn btn-primary" id="tambah_barang">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit-->
<?php foreach ($stok as $dt) : ?>
<div class="modal fade" id="modalEdit<?= $dt['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('admin/stok_barang/edit'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="<?= $dt['id']; ?>" name="id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="custom-select kategori_e" name="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Mikrokontroller & Modul"
                                <?php if ($dt['kategori'] == 'Mikrokontroller & Modul') echo 'selected="selected"'; ?>>
                                Mikrokontroller & Modul</option>
                            <option value="Sensor"
                                <?php if ($dt['kategori'] == 'Sensor') echo 'selected="selected"'; ?>>Sensor</option>
                            <option value="Aktuator"
                                <?php if ($dt['kategori'] == 'Aktuator') echo 'selected="selected"'; ?>>Aktuator
                            </option>
                            <option value="Toolkit"
                                <?php if ($dt['kategori'] == 'Toolkit') echo 'selected="selected"'; ?>>Toolkit
                            </option>
                            <option value="Jaringan"
                                <?php if ($dt['kategori'] == 'Jaringan') echo 'selected="selected"'; ?>>Jaringan
                            </option>
                            <option value="Kabel" <?php if ($dt['kategori'] == 'Kabel') echo 'selected="selected"'; ?>>
                                Kabel
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control" name="nama" required autocomplete="off"
                            value="<?= $dt['nama_barang']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" class="form-control stok_e" name="stok" min="1" required autocomplete="off"
                            value="<?= $dt['stok']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="normal">Barang Normal</label>
                        <input type="number" class="form-control normal_e" name="normal" min="0" required
                            autocomplete="off" value="<?= $dt['normal']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="rusak">Barang Rusak</label>
                        <input type="text" class="form-control rusak_e" name="rusak" value="<?= $dt['rusak']; ?>"
                            readonly>
                        <small class="text-danger pesan_rusak_e"></small>
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

<!-- Modal Import-->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('admin/stok_barang/import'); ?>" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="nim">Upload File</label>
                        <input type="file" class="form-control" name="fileExcel" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="add" class="btn btn-success">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>