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
                <a href="<?= base_url('admin/mahasiswa'); ?>" class="small-box-footer">Detail <i
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
                <a href="<?= base_url('admin/admin'); ?>" class="small-box-footer">Detail <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <?php endif; ?>
    </div>

</section>

</script>