<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 col-12 text-right">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAdd"><i
                                class="fa fa-plus"></i> Kategori</button>
                    </div>

                    <?php if (form_error('kategori')) : ?>
                    <?= form_error('kategori', '<small class="text-danger">', '</small>'); ?> <br>
                    <?php endif; ?>

                    <br>
                    <br>
                    <div class="table-responsive">
                        <?php echo form_open('belakang/kategori/hapus'); ?>
                        <table id="example" class="table table-bordered table-hover">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Kategori</th>
                                    <th>Action</th>
                                    <th>
                                        <center><input type="checkbox" id="check-all"></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($kategori as $hasil) : ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $hasil['nama_kategori']; ?></td>
                                    <td>
                                        <a href="#" class="badge badge-warning edit_brg" data-toggle="modal"
                                            data-target="#modalEdit<?= enkrip($hasil['id']); ?>"><i
                                                class="fa fa-edit"></i>
                                            Edit</a>
                                    </td>
                                    <td>
                                        <center>
                                            <input type="checkbox" class="check-item" name="id[]"
                                                value="<?= enkrip($hasil['id']) ?>">
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
        <form action="<?= base_url('belakang/kategori/tambah'); ?>" method="post">
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
                        <label for="kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" required
                            autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="add" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit-->
<?php foreach ($kategori as $dt) : ?>
<div class="modal fade" id="modalEdit<?= enkrip($dt['id']); ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('belakang/kategori/edit'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="<?= enkrip($dt['id']); ?>" name="id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="kategori" name="kategori" required
                            autocomplete="off" value="<?= $dt['nama_kategori']; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="edit" class="btn btn-warning">Edit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endforeach; ?>