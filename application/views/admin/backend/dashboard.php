<section class="content">

    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3> <?= $mahasiswa; ?></h3>

                    <p>Total Mahasiswa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <a href="<?= base_url('belakang/mahasiswa'); ?>" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3> <?= $dosen; ?></h3>

                    <p>Total Dosen</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <a href="<?= base_url('belakang/dosen'); ?>" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3> <?= $pinjamMhs; ?></h3>

                    <p>Total Barang Pinjam Mahasiswa</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
                <a href="<?= base_url('belakang/pinjaman/mahasiswa'); ?>" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3> <?= $pinjamDsn; ?></h3>

                    <p>Total Barang Pinjam Dosen</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
                <a href="<?= base_url('belakang/pinjaman/dosen'); ?>" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3> <?= $lbMhs; ?></h3>

                    <p>Total Barang OutOfDate MHS</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
                <a href="<?= base_url('belakang/lewat_batas/mahasiswa'); ?>" class="small-box-footer">Detail
                    <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3> <?= $lbDsn; ?></h3>

                    <p>Total Barang OutOfDate Dosen</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart fa-2x"></i>
                </div>
                <a href="<?= base_url('belakang/lewat_batas/dosen'); ?>" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <?php if (level($this->session->userdata('id')) == 'Super Admin') : ?>
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3> <?= $admin; ?></h3>

                    <p>Total Admin</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user fa-2x"></i>
                </div>
                <a href="<?= base_url('belakang/admin'); ?>" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <?php endif; ?>
    </div>

</section>

</script>