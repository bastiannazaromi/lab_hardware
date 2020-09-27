$(document).ready(function () {

	$("#normal").change(function () {
		let stok = $("#stok").val();
		let normal = $("#normal").val();

		let rusak = stok - normal;

		if (rusak < 0) {
			$("#rusak").val('');
			$("#pesan_rusak").text('Jumlah barang normal melebihi stok !');
			$("#tambah_barang").attr('disabled', 'disabled');
		} else {
			$("#rusak").val(rusak);
			$("#pesan_rusak").text('');
			$("#tambah_barang").removeAttr('disabled');
		}
	});


	$("#normal_e").change(function () {
		let stok = $("#stok_e").val();
		let normal = $("#normal_e").val();

		let rusak = stok - normal;

		if (rusak < 0) {
			$("#rusak_e").val('');
			$("#pesan_rusak_e").text('Jumlah barang normal melebihi stok !');
			$("#tambah_barang_e").attr('disabled', 'disabled');
		} else {
			$("#rusak_e").val(rusak);
			$("#pesan_rusak_e").text('');
			$("#edit_barang").removeAttr('disabled');
		}
	});

	var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>',
		csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

	var menunggus = $('.menunggu');
	var dipinjams = $('.dipinjam');
	var selesais = $('.selesai');

	for (menunggu of menunggus) {
		menunggu.addEventListener("change", function (event) {
			let id = $(this).data('id');
			console.log(id);
		});
	}

	for (dipinjam of dipinjams) {
		dipinjam.addEventListener("change", function (event) {
			let id = $(this).data('id');
			console.log(id);
		});
	}

	for (selesai of selesais) {
		selesai.addEventListener("change", function (event) {
			let id = $(this).data('id');
			console.log(id);
		});
	}

});
