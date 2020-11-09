<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 col-12 text-right">
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAdd"><i
                                class="fa fa-plus"></i> Mahasiswa</button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal"
                            data-target="#modalImport"><i class="fa fa-plus"></i> Excel</button>
                        <button type="button" class="btn btn-sm btn-warning"
                            onclick="window.location='<?= base_url('excel/Format_excel_mahasiswa.xlsx'); ?>'"><i
                                class="fa fa-download"></i>
                            Format</button>
                    </div>

                    <?php if (form_error('nim')) : ?>
                    <?= form_error('nim', '<small class="text-danger">', '</small>'); ?> <br>
                    <?php endif; ?>
                    <?php if (form_error('nama')) : ?>
                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?> <br>
                    <?php endif; ?>
                    <?php if (form_error('semester')) : ?>
                    <?= form_error('semester', '<small class="text-danger">', '</small>'); ?> <br>
                    <?php endif; ?>
                    <?php if (form_error('kelas')) : ?>
                    <?= form_error('kelas', '<small class="text-danger">', '</small>'); ?>
                    <?php endif; ?>

                    <br>
                    <br>
                    <div class="table-responsive">
                        <?php echo form_open('belakang/mahasiswa/hapus'); ?>
                        <table id="example" class="table table-bordered table-hover">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>No. HP</th>
                                    <th>Email</th>
                                    <th>Semester</th>
                                    <th>Kelas</th>
                                    <th>Password</th>
                                    <th>Action</th>
                                    <th>
                                        <center><input type="checkbox" id="check-all"></center>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                foreach ($mahasiswa as $hasil) : ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $hasil['nim']; ?></td>
                                    <td><?= $hasil['nama']; ?></td>
                                    <td><?= $hasil['no_telepon']; ?></td>
                                    <td><?= $hasil['email']; ?></td>
                                    <td><?= $hasil['semester']; ?></td>
                                    <td><?= $hasil['kelas']; ?></td>
                                    <td><a href="<?= base_url() ?>belakang/mahasiswa/resetPassword/<?= enkrip($hasil['id']); ?>"
                                            class="badge badge-success delete-people"><i class="fa fa-edit"></i>
                                            Reset</a>
                                    <td>
                                        <a href="#" class="badge badge-warning" data-toggle="modal"
                                            data-target="#modalEdit<?= enkrip($hasil['id']); ?>"><i
                                                class="fa fa-edit"></i>
                                            Edit</a>
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
        <form action="<?= base_url('belakang/mahasiswa/tambah'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" name="nim" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Mahasiswa</label>
                        <input type="text" class="form-control" name="nama" required autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="custom-select" name="semester">
                            <option value="">-- Pilih Semester --</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select class="custom-select" id="kelas" name="kelas">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>
                        </select>
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
<?php foreach ($mahasiswa as $dt) : ?>
<div class="modal fade" id="modalEdit<?= enkrip($dt['id']); ?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('belakang/mahasiswa/edit'); ?>" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="<?= enkrip($dt['id']); ?>" name="id">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control" name="nim" required autocomplete="off"
                            value="<?= $dt['nim']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Mahasiswa</label>
                        <input type="text" class="form-control" name="nama" required autocomplete="off"
                            value="<?= $dt['nama']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="semester">Semester</label>
                        <select class="custom-select" name="semester">
                            <option value="">-- Pilih Semester --</option>
                            <option value="1" <?php if ($dt['semester'] == '1') echo 'selected="selected"'; ?>>1
                            </option>
                            <option value="2" <?php if ($dt['semester'] == '2') echo 'selected="selected"'; ?>>2
                            </option>
                            <option value="3" <?php if ($dt['semester'] == '3') echo 'selected="selected"'; ?>>3
                            </option>
                            <option value="4" <?php if ($dt['semester'] == '4') echo 'selected="selected"'; ?>>4
                            </option>
                            <option value="5" <?php if ($dt['semester'] == '5') echo 'selected="selected"'; ?>>5
                            </option>
                            <option value="6" <?php if ($dt['semester'] == '6') echo 'selected="selected"'; ?>>6
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelas">Kelas</label>
                        <select class="custom-select" name="kelas">
                            <option value="">-- Pilih Kelas --</option>
                            <option value="A" <?php if ($dt['kelas'] == 'A') echo 'selected="selected"'; ?>>A</option>
                            <option value="B" <?php if ($dt['kelas'] == 'B') echo 'selected="selected"'; ?>>B</option>
                            <option value="C" <?php if ($dt['kelas'] == 'C') echo 'selected="selected"'; ?>>C</option>
                            <option value="D" <?php if ($dt['kelas'] == 'D') echo 'selected="selected"'; ?>>D</option>
                            <option value="E" <?php if ($dt['kelas'] == 'E') echo 'selected="selected"'; ?>>E</option>
                            <option value="F" <?php if ($dt['kelas'] == 'F') echo 'selected="selected"'; ?>>F</option>
                            <option value="G" <?php if ($dt['kelas'] == 'G') echo 'selected="selected"'; ?>>G</option>
                            <option value="H" <?php if ($dt['kelas'] == 'H') echo 'selected="selected"'; ?>>H</option>
                            <option value="I" <?php if ($dt['kelas'] == 'I') echo 'selected="selected"'; ?>>I</option>
                            <option value="J" <?php if ($dt['kelas'] == 'J') echo 'selected="selected"'; ?>>J</option>
                            <option value="K" <?php if ($dt['kelas'] == 'K') echo 'selected="selected"'; ?>>K</option>
                            <option value="L" <?php if ($dt['kelas'] == 'L') echo 'selected="selected"'; ?>>L</option>
                            <option value="M" <?php if ($dt['kelas'] == 'M') echo 'selected="selected"'; ?>>M</option>
                            <option value="N" <?php if ($dt['kelas'] == 'N') echo 'selected="selected"'; ?>>N</option>
                            <option value="O" <?php if ($dt['kelas'] == 'O') echo 'selected="selected"'; ?>>O</option>
                        </select>
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

<!-- Modal Import-->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="<?= base_url('belakang/mahasiswa/import'); ?>" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Mahasiswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                    <div class="form-group">
                        <label for="fileExcel">Upload File</label>
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