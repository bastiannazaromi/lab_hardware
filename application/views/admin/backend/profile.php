<section class="content">

    <div class="row">
        <div class="col-md-12">
            <div class="card-group">
                <div class="col-md-4">
                    <div class="card">
                        <img class="rounded-circle img-thumbnail mt-3"
                            src="<?= base_url('assets/uploads/profile/' . $admin[0]['foto']); ?>" alt="Card image cap"
                            width="150" height="150" style="display: block; margin: 0 auto;" id="gambar_nodin">
                        <div class="card-body">
                            <form action="<?= base_url('belakang/updateFoto'); ?>" method="post"
                                enctype="multipart/form-data">
                                <input type="hidden" value="<?= enkrip($admin[0]['id']); ?>" name="id">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                    value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        autocomplete="off" value="<?= $admin[0]['username']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required
                                        autocomplete="off" value="<?= $admin[0]['nama']; ?>">
                                </div>
                                <div class="form-group">
                                    <label for="level">Level</label>
                                    <input type="text" class="form-control" id="level" name="level" required
                                        autocomplete="off" value="<?= $admin[0]['level']; ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="image">Update Foto</label>
                                    <input type="file" class="form-control" id="image" name="foto_profil"
                                        autocomplete="off">
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
                            <form action="<?= base_url('belakang/updatePass'); ?>" method="post">
                                <input type="hidden" value="<?= enkrip($admin[0]['id']); ?>" name="id">
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                    value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <div class="form-group">
                                    <label for="pas_lama">Password Lama</label>
                                    <input type="password" class="form-control" id="pas_lama" name="pas_lama" required
                                        autocomplete="off">
                                    <?= form_error('pas_lama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="pas_baru">Password Baru</label>
                                    <input type="password" class="form-control" id="pas_baru" name="pas_baru" required
                                        autocomplete="off">
                                    <?= form_error('pas_baru', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="pas_konfir">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="pas_konfir" name="pas_konfir"
                                        required autocomplete="off">
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