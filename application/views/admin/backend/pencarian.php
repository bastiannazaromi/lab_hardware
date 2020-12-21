<section class="content">

    <?php echo $this->session->flashdata('flash_sukses'); ?>
    <?php echo $this->session->flashdata('flash_error'); ?>

    <div class="row">
        <div class="col-xl-12 col-md-12 mb-4">

            <form class="form-inline" action="" onsubmit="ajax_search(); return false">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                    value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_token">
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fas fa-search nav-icon"></i></div>
                    </div>
                    <input type="text" name="cari_barang" class="form-control" id="cari_barang" placeholder="Search"
                        autocomplete="off">
                </div>

                <button type="submit" class="btn btn-primary mb-2">Search</button>
            </form>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tabel_cari" class="table table-bordered table-hover">
                            <thead class="bg-light text-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Peminjam</th>
                                    <th>Nama Barang</th>
                                    <th>ID User</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Max Pengembalian</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="isi_table">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<script>
function ajax_search() {
    let inputan = $("#cari_barang").val();
    let csrfName = $("#csrf_token").attr('name');
    let csrfHash = $("#csrf_token").val();

    var dataJson = {
        [csrfName]: csrfHash,
        inputan: inputan,
    };

    $.ajax({
        url: "<?= base_url('belakang/pencarian/cari'); ?>",
        type: "POST",
        data: dataJson,
        dataType: 'json',
        success: function(result) {
            $('.tr_isi').remove();
            $(result.barang).each(function(i) {
                $("#tabel_cari").append(
                    "<tr class=" + "tr_isi" + ">" +
                    "<td>" + (i + 1) + "</td>" +
                    "<td>" + result.barang[i].nama_peminjam + "</td>" +
                    "<td>" + result.barang[i].nama_barang + "</td>" +
                    "<td>" + result.barang[i].id_user + "</td>" +
                    "<td>" + result.barang[i].tanggal_pinjam + "</td>" +
                    "<td>" + result.barang[i].max_kembali + "</td>" +
                    "<td>" + result.barang[i].tanggal_kembali + "</td>" +
                    "<td>" + result.barang[i].status + "</td>" +
                    "<tr>");
            });
            $('#csrf_token').val(result.token);
        }
    });
}
</script>