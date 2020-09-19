<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <fieldset class="border p-2 mb-3"
                    style="border: 5px solid #ddd !important; border-radius:10px; background-color:#adad85; padding-left:10px!important;">
                    <legend>Note*</legend>
                    <li class="ml-3">Foto profil menggunakan foto ijazah</li>
                    <li class="ml-3">Background foto merah</li>
                    <li class="ml-3">Recomended 3x4</li>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card-group">
                <div class="col-md-4">
                    <div class="card">
                        <img class="rounded-circle img-thumbnail mt-3"
                            src="<?= base_url('assets/uploads/profile/' . $mahasiswa[0]['foto']); ?>"
                            alt="Card image cap" width="150" height="150" style="display: block; margin: 0 auto;"
                            id="gambar_nodin">
                        <div class="card-body">
                            <form action="<?= base_url('user/dapur/profile'); ?>" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" value="<?= $mahasiswa[0]['id']; ?>" name="id">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                    value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_login">

                                <div class="form-group">
                                    <label for="nim">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim" required
                                        autocomplete="off" value="<?= $mahasiswa[0]['nim']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required
                                        autocomplete="off" value="<?= $mahasiswa[0]['nama']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="no_telepon">No Telepon</label>
                                    <input type="text" class="form-control" id="no_telepon" name="no_telepon"
                                        autocomplete="off" value="<?= $mahasiswa[0]['no_telepon']; ?>">
                                    <?= form_error('no_telepon', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" autocomplete="off"
                                        value="<?= $mahasiswa[0]['email']; ?>">
                                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="image">Update Foto <small class="text-dark">( Format : jpg |
                                            jpeg | png
                                            || max
                                            : 2 MB )</small></label>
                                    <input type="file" class="form-control" id="image" name="foto_profil"
                                        autocomplete="off">
                                    <small class="text-danger"><?= $this->session->flashdata('foto'); ?></small>
                                </div>
                                <button type="submit" name="update" class="btn btn-primary btn-block">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Update Password</h3>
                        </div>
                        <div class="card-body ">
                            <form action="<?= base_url('user/dapur/updatePass'); ?>" method="post">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                    value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_login">

                                <div class="form-group">
                                    <label for="pas_lama">Password Lama</label>
                                    <input type="password" class="form-control" id="pas_lama" name="pas_lama"
                                        autocomplete="off">
                                    <?= form_error('pas_lama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="pas_baru">Password Baru</label>
                                    <input type="password" class="form-control" id="pas_baru" name="pas_baru"
                                        autocomplete="off">
                                    <?= form_error('pas_baru', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="pas_konfir">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="pas_konfir" name="pas_konfir"
                                        autocomplete="off">
                                    <?= form_error('pas_konfir', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <button type="submit" name="update" class="btn btn-success btn-block">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>