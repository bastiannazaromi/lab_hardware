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

	var edit_brgs = $('.edit_brg');
	var normals = $('.normal_e');
	var stoks = $('.stok_e');
	var rusaks = $('.rusak_e');
	var pesan_rusaks = $('.pesan_rusak_e');
	var edit_barangs = $('.edit_barang');

	$(edit_brgs).each(function (i) {
		$(normals[i]).change(function () {
			let stok = $(stoks[i]).val();
			let normal = $(normals[i]).val();
			let rusak = stok - normal;

			if (rusak < 0) {
				$(rusaks[i]).val('');
				$(pesan_rusaks[i]).text('Jumlah barang normal melebihi stok !');
				$(edit_barangs[i]).attr('disabled', 'disabled');
			} else {
				$(rusaks[i]).val(rusak);
				$(pesan_rusaks[i]).text('');
				$(edit_barangs[i]).removeAttr('disabled');
			}
		});

	});

});
