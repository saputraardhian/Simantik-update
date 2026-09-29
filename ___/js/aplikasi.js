/* FUNGSI BERSAMA */
function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}

/* 
=======================================
=======================================
*/

function rubah_password() {
	$.ajax({
		type: "GET",
		url: base_url+"adm/rubah_password/",
		success: function(response) {
			var teks_modal = '<div class="modal fade" id="m_ubah_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Update password</h4></div><div class="modal-body"><form name="f_ubah_password" id="f_ubah_password" onsubmit="return rubah_password_s();" method="post"><input type="hidden" name="id" id="id" value="'+response.id+'"><div id="konfirmasi"></div><table class="table table-form"><tr><td style="width: 25%">Username</td><td style="width: 75%"><input type="text" class="form-control" name="u1" id="u1" required value="'+response.username+'" readonly></td></tr><tr><td style="width: 25%">Password lama</td><td style="width: 75%"><input type="password" class="form-control" name="p1" id="p1" required></td></tr><tr><td style="width: 25%">Password Baru</td><td style="width: 75%"><input type="password" class="form-control" name="p2" id="p2" required></td></tr><tr><td style="width: 25%">Ulangi Password</td><td style="width: 75%"><input type="password" class="form-control" name="p3" id="p3" required></td></tr></table></div><div class="modal-footer"><button class="btn btn-primary" onclick="return rubah_password_s();">Simpan</button><button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div>';

			$("#tampilkan_modal").html(teks_modal);
			$("#m_ubah_password").modal('show');
			$("#p1").focus();
		}
	});
	return false;
}

function rubah_password_s() {
	var f_asal	= $("#f_ubah_password");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/rubah_password/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			$("#konfirmasi").html('<div class="alert alert-success">'+response.msg+'</div>');
			$("#m_ubah_password").modal('hide');
		} else {
			$("#konfirmasi").html('<div class="alert alert-danger">'+response.msg+'</div>');
		}
	});
	return false;
}

//barang
function m_barang_e(id) {
	$("#m_barang").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_barang/det/"+id,
		success: function(data) {
			$("#stok_barang").val(data.stok_barang);
			$("#nama_barang").val(data.nama_barang);
			$("#kode_jenisbarang").val(data.kode_jenisbarang);
			$("#kode_subjenisbarang").val(data.kode_subjenisbarang);
			$("#satuan").val(data.satuan);
			$("#id").val(data.id);
			$("#kode_jenisbarang").focus();
		}
	});
	return false;
}

function m_barang_s() {
	var f_asal	= $("#f_barang");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_barang/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/m_barang"); 
		} else {
			alert(response.msg || 'Gagal menyimpan data barang. Silakan periksa kembali isian form.');
		}
	}).fail(function() {
		alert('Terjadi kesalahan jaringan atau server saat menyimpan data.');
	});
	return false;
}

function m_barang_h(id) {
	if (confirm('Anda yakin ingin menghapus data ini?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_barang/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_barang"); 
				} else {
					alert(response.msg || 'Gagal menghapus data barang.');
				}
			}
		}).fail(function() {
			alert('Terjadi kesalahan jaringan saat menghapus data.');
		});
	}
	return false;
}

function m_barang_stok() {
	$("#m_barang_stok").modal('show');
	return false;
}


//pegawai
function m_pegawai_e(id) {
	$("#m_pegawai").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"adm/m_pegawai/det/"+id,
		success: function(data) {
			$("#nip").val(data.nip);
			$("#nama").val(data.nama);
			$("#username").val(data.username);
			$("#password").val(data.password);
			$("#id_unitkerja").val(data.id_unitkerja);
			$("#level").val(data.level);
			$("#id_eselon").val(data.id_eselon);
			$("#id").val(data.id);
			$("#nip").focus();
		}
	});
	return false;
}

function m_pegawai_s() {
	var f_asal	= $("#f_pegawai");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_pegawai/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/m_pegawai"); 
		} else {
			alert(response.msg || 'Gagal menyimpan data pegawai. Silakan periksa kembali isian form.');
		}
	}).fail(function() {
		alert('Terjadi kesalahan jaringan atau server saat menyimpan data.');
	});
	return false;
}

function m_pegawai_h(id) {
	if (confirm('Anda yakin ingin menghapus data pegawai ini?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/m_pegawai/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/m_pegawai"); 
				} else {
					alert(response.msg || 'Gagal menghapus data pegawai.');
				}
			}
		}).fail(function() {
			alert('Terjadi kesalahan jaringan saat menghapus data.');
		});
	}
	return false;
}

// permintaan barang

function m_permintaan_s() {
	var f_asal	= $("#f_permintaan_barang");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/m_permintaan_barang/simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/permintaan_barang"); 
		} else {
			alert(response.msg || 'Gagal menyimpan pengajuan permintaan barang.');
		}
	}).fail(function() {
		alert('Terjadi kesalahan jaringan atau server saat menyimpan pengajuan.');
	});
	return false;
}

function m_permintaan_setujui(id) {
	$.ajax({
		type: "GET",
		url: base_url+"adm/kelola_permintaan_barang/ambil_barang/"+id,
		success: function(data) {
			if (data.status == "ok") {
				var jml_data	= Object.keys(data.data).length;
				var hate 	= '<div class="modal fade" id="m_permintaan_setujui" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" style="max-width: 650px;" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Setujui Permintaan Barang</h4></div><div class="modal-body"><form name="f_list_barang" id="f_list_barang" method="post" action="'+base_url+'adm/kelola_permintaan_barang/serahkan_barang/"><div style="margin-bottom: 12px; display: flex; align-items: center; gap: 10px;"><label style="margin: 0; font-weight: 700;">Kode Permintaan: </label><input type="text" name="id_permintaan" id="id_permintaan" value="'+id+'" class="form-control" style="width: 170px; height: 34px; font-weight: 700; text-align: center;" readonly /><input type="hidden" name="id_list_barang" id="id_list_barang" value="'+id+'"></div><div id="konfirmasi"></div><div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 12px;"><table class="table table-bordered table-hover" style="min-width: 480px; margin-bottom: 0;"><thead><tr><th width="50%">Pilih Barang</th><th width="50%">Kuantitas Permintaan</th></tr></thead><tbody>';
				
				if (jml_data > 0) {
					$.each(data.data, function(i, item) {
						var checkedAttr = (item.nip_pegawai_menyerahkan != "") ? "checked" : "";
						hate += '<tr><td><label style="cursor: pointer; display: flex; align-items: center; gap: 8px; margin: 0;"><input type="checkbox" value="'+item.id+'" name="id_list[]" '+checkedAttr+'> <span>'+item.nama_barang+'</span></label></td><td><input type="hidden" name="nama_input[]" readonly class="form-control" value="'+item.kode_jenisbarang+'-'+item.kode_subjenisbarang+'" /><input name="jumlah_input[]" readonly class="form-control" style="width: 100px; text-align: center; font-weight: 600;" value="'+item.jumlah_permintaan+'" /></td></tr>';
					});				
				} else {
					hate += '<tr><td colspan="2" class="text-center" style="padding: 20px; color: #64748b;">Barang Sudah Diserahkan Semua</td></tr>';
				}
				hate += '</tbody></table></div><div class="modal-footer"><button class="btn btn-primary" type="submit"><i class="fa-solid fa-check"></i> Serahkan Barang</button><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div></div>';
				$("#tampilkan_modal").html(hate);
				$("#m_permintaan_setujui").modal('show');
			} else {
				console.log('gagal');
			}
		}
	});

	return false;
}

function m_permintaan_h_admin(id) {
	if (confirm('Anda yakin menghapus Kode permintaan '+id)) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/kelola_permintaan_barang/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					if (response.level == "notuser") {
					window.location.assign(base_url+"adm/kelola_permintaan_barang"); 
					}
					else
					{
					window.location.assign(base_url+"adm/permintaan_barang");
					}
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}

function m_permintaan_h(id) {
	if (confirm('Anda yakin Tidak Akan menampilkan transaksi  '+id+' lagi?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/kelola_permintaan_barang/not_tampil/"+id,
			success: function(response) {
				if (response.status == "ok") {
					if (response.level == "notuser") {
					window.location.assign(base_url+"adm/kelola_permintaan_barang"); 
					}
					else
					{
					window.location.assign(base_url+"adm/permintaan_barang");
					}
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}

function m_permintaan_e(id) {
	$.ajax({
		type: "GET",
		url: base_url+"adm/kelola_permintaan_barang/ambil_data_edit/"+id,
		success: function(data) {
			if (data.status == "ok") {
				var jml_data	= Object.keys(data.data).length;
				var hate 	= '<div class="modal fade" id="m_permintaan_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" style="width: 95%; max-width: 850px; margin: 20px auto;" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Edit Permintaan Barang</h4></div><div class="modal-body"><form name="f_permintaan_edit" id="f_permintaan_edit" method="post" action="'+base_url+'adm/kelola_permintaan_barang/edit_permintaan/"><div style="margin-bottom: 12px; display: flex; align-items: center; gap: 10px;"><label style="margin: 0; font-weight: 700;">Kode Permintaan: </label><input type="text" name="id_permintaan" id="id_permintaan" value="'+id+'" class="form-control" style="width: 170px; height: 34px; font-weight: 700; text-align: center;" readonly /></div><div id="konfirmasi"></div><div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 12px;"><table class="table table-bordered table-hover" style="min-width: 580px; margin-bottom: 0;"><thead><tr><th width="45%">Nama Barang</th><th width="35%">Jumlah Barang</th><th width="20%" class="text-center">Aksi</th></tr></thead><tbody id="itemlistedit">';
				if (jml_data > 0) {
					$.each(data.data, function(i, item) {
							hate += '<tr id="'+item.id+'tr"> '+
                              '<td width="45%"><input type="text" class="form-control" value="'+item.nama_barang+' ('+item.satuan+')" readonly /><input type="hidden" name="nama_input['+item.id+']" id="'+item.id+'" class="form-control" value="'+item.kode_jenisbarang+'-'+item.kode_subjenisbarang+'" ></td>'+
							  '<td width="35%"><input type="number" min="1" name="jumlah_input['+item.id+']" class="form-control" value="'+item.jumlah_permintaan+'" /></td>'+
                              '<td width="20%" class="text-center"><a class="btn btn-outline-danger btn-xs" onclick="busek('+item.id+'); return false;" id="'+item.id+'"><i class="fa-solid fa-trash-can"></i> Hapus</a></td>'+
                              '</tr>';
					});				
				} else {
					hate += '<tr><td colspan="3" class="text-center" style="padding: 20px; color: #64748b;">Barang Sudah Diserahkan Semua</td></tr>';
				}
				hate += '</tbody></table></div><div style="margin-top: 10px;"><a class="btn btn-success btn-sm" onclick="additemedit(); return false"><i class="fa-solid fa-plus"></i> Tambah Barang</a></div><div class="modal-footer"><button class="btn btn-primary" type="submit"><i class="fa-solid fa-floppy-disk"></i> Update</button><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div></div>';
				$("#tampilkan_modal").html(hate);
				$("#m_permintaan_edit").modal('show');
			} else {
				console.log('gagal');
			}
		}
	});

	return false;
}

function m_permintaan_e_admin(id) {
	$.ajax({
		type: "GET",
		url: base_url+"adm/kelola_permintaan_barang/ambil_data_edit/"+id,
		success: function(data) {
			if (data.status == "ok") {
				var jml_data	= Object.keys(data.data).length;
				var hate 	= '<div class="modal fade" id="m_permintaan_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" style="width: 95%; max-width: 850px; margin: 20px auto;" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Konfirmasi Permintaan Barang</h4></div><div class="modal-body"><form name="f_permintaan_edit" id="f_permintaan_edit" method="post" action="'+base_url+'adm/kelola_permintaan_barang/edit_permintaan_admin/"><div style="margin-bottom: 12px; display: flex; align-items: center; gap: 10px;"><label style="margin: 0; font-weight: 700;">Kode Permintaan: </label><input type="text" name="id_permintaan" id="id_permintaan" value="'+id+'" class="form-control" style="width: 170px; height: 34px; font-weight: 700; text-align: center;" readonly /></div><div id="konfirmasi"></div><div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 12px;"><table class="table table-bordered table-hover" style="min-width: 600px; margin-bottom: 0;"><thead><tr><th width="40%">Nama Barang</th><th width="25%">Jumlah Barang</th><th width="35%">Catatan</th></tr></thead><tbody id="itemlistedit">';
				if (jml_data > 0) {
					$.each(data.data, function(i, item) {
							hate += '<tr id="'+item.id+'tr"> '+
                              '<td width="40%"><input type="text" class="form-control" value="'+item.nama_barang+'" readonly/><input type="hidden" name="nama_input['+item.id+']" id="'+item.id+'" class="form-control" value="'+item.kode_jenisbarang+'-'+item.kode_subjenisbarang+'" ></td>'+
							  '<td width="25%"><input type="number" min="1" name="jumlah_input['+item.id+']" class="form-control" value="'+item.jumlah_permintaan+'" /></td>'+
                              '<td width="35%"><input type="text" class="form-control" id="catatan_input['+item.id+']" name="catatan_input['+item.id+']" value="'+(item.catatan || '')+'"/></td>'+
                              '</tr>';
					});				
				} else {
					hate += '<tr><td colspan="3" class="text-center" style="padding: 20px; color: #64748b;">Barang Sudah Diserahkan Semua</td></tr>';
				}
				hate += '</tbody></table></div><div class="modal-footer"><button class="btn btn-primary" type="submit"><i class="fa-solid fa-check"></i> Setujui Diproses</button><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div></div>';
				$("#tampilkan_modal").html(hate);
				$("#m_permintaan_edit").modal('show');
			} else {
				console.log('gagal');
			}
		}
	});

	return false;
}

function m_permintaan_v(id) {
	$.ajax({
		type: "GET",
		url: base_url+"adm/kelola_permintaan_barang/ambil_data_edit/"+id,
		success: function(data) {
			if (data.status == "ok") {
				var jml_data	= Object.keys(data.data).length;
				var hate 	= '<div class="modal fade" id="m_permintaan_edit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"><div class="modal-dialog" style="width: 95%; max-width: 850px; margin: 20px auto;" role="document"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 id="myModalLabel">Detail Permintaan Barang</h4></div><div class="modal-body"><form name="f_permintaan_edit" id="f_permintaan_edit" method="post"><div style="margin-bottom: 12px; display: flex; align-items: center; gap: 10px;"><label style="margin: 0; font-weight: 700;">Kode Permintaan: </label><input type="text" name="id_permintaan" id="id_permintaan" value="'+id+'" class="form-control" style="width: 170px; height: 34px; font-weight: 700; text-align: center;" readonly /></div><div id="konfirmasi"></div><div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 12px;"><table class="table table-bordered table-hover" style="min-width: 600px; margin-bottom: 0;"><thead><tr><th width="40%">Nama Barang</th><th width="25%">Jumlah Barang</th><th width="35%">Catatan</th></tr></thead><tbody id="itemlistedit">';
				if (jml_data > 0) {
					$.each(data.data, function(i, item) {
							hate += '<tr id="'+item.id+'tr"> '+
                              '<td width="40%"><input type="text" class="form-control" value="'+item.nama_barang+'" readonly/><input type="hidden" name="nama_input['+item.id+']" id="'+item.id+'" class="form-control" value="'+item.kode_jenisbarang+'-'+item.kode_subjenisbarang+'" ></td>'+
							  '<td width="25%"><input name="jumlah_input['+item.id+']" class="form-control" value="'+item.jumlah_permintaan+'" readonly/></td>'+
                              '<td width="35%"><input type="text" class="form-control" id="catatan_input['+item.id+']" name="catatan_input['+item.id+']" value="'+(item.catatan || '-')+'" readonly/></td>'+
                              '</tr>';
					});				
				} else {
					hate += '<tr><td colspan="3" class="text-center" style="padding: 20px; color: #64748b;">Barang Sudah Diserahkan Semua</td></tr>';
				}
				hate += '</tbody></table></div><div class="modal-footer"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Tutup</button></div></form></div></div></div></div>';
				$("#tampilkan_modal").html(hate);
				$("#m_permintaan_edit").modal('show');
			} else {
				console.log('gagal');
			}
		}
	});

	return false;
}



 function busek(id) {
			$.ajax({
				type: "GET",
				url: base_url+"adm/kelola_permintaan_barang/hapus_barang/"+id
				});
                var ele = id + 'tr';
                var elem = document.getElementById(ele);
                return elem.parentNode.removeChild(elem);
            }
	
			
function fncCreateSelectOption(ele){
		$.ajax({
				type: "GET",
				url: base_url+"adm/kelola_permintaan_barang/ambil_master_barang/",
				success: function(data) {
				if (data.status == "ok") {
				var objSelect = ele;
				var Item = new Option("", ""); 
				objSelect.options[objSelect.length] = Item;	
				var jml_data	= Object.keys(data.data).length;
				if (jml_data > 0) {
					$.each(data.data, function(i, item) {
					var ItemBaru = new Option(item.nama_barang,item.kode_jenisbarang+'-'+item.kode_subjenisbarang); 
					objSelect.options[objSelect.length] = ItemBaru;	
					});	
				} else {
				console.log('gagal');
				}}
			}
		 });
	return false;
}			
var i = 1;
function additemedit() {
//                menentukan target append
                var itemlist = document.getElementById('itemlistedit');

//                membuat element
                var row = document.createElement('tr');
                var nama = document.createElement('td');
				var jumlah = document.createElement('td');
				//var kodejenis = document.createElement('td');
				//var kodesubjenis = document.createElement('td');
                var aksi = document.createElement('td');
                aksi.setAttribute('width', '50px');

//                meng append element
                itemlist.appendChild(row);
                row.appendChild(nama);
				row.appendChild(jumlah);
                row.appendChild(aksi);

//                membuat element select nama barang
                var nama_input = document.createElement('select');
                nama_input.setAttribute('name', 'nama_input[' + i + ']');
                nama_input.setAttribute('class', 'input-block-level');
				fncCreateSelectOption(nama_input);

				
//                membuat element input jumlah barang
                var jumlah_input = document.createElement('input');
                jumlah_input.setAttribute('name', 'jumlah_input[' + i + ']');
                jumlah_input.setAttribute('class', 'input-block-level');
				
               
				var hapus = document.createElement('span');

//                meng append element input
                nama.appendChild(nama_input);
				jumlah.appendChild(jumlah_input);
				//kodejenis.appendChild(kodejenis_input);
				//kodesubjenis.appendChild(kodesubjenis_input);
                aksi.appendChild(hapus);

                hapus.innerHTML = '<a>hapus</a>';
//                membuat aksi delete element
                hapus.onclick = function () {
                    row.parentNode.removeChild(row);
                };

                i++;
            }
			
//stok barang
function m_stokbarang_e(id) {
	$("#m_editstok_barang").modal('show');
	$.ajax({
		type: "GET",
		url: base_url+"adm/stok_barang/det/"+id,
		success: function(data) {
			$("#id_penerimaan").val(data.id_penerimaan);
			$("#nama_barang").val(data.nama_barang);
			$("#kode_jenisbarang").val(data.kode_jenisbarang);
			$("#kode_subjenisbarang").val(data.kode_subjenisbarang);
			$("#tgl_dokumen").val(data.tgl_dokumen);
			$("#jumlah_penerimaan").val(data.jumlah_penerimaan);
			$("#sumber_penerimaan").val(data.sumber_penerimaan);
			$("#nilai_penerimaan").val(data.nilai_penerimaan);
			$("#id").val(data.id);
			$("#id_penerimaan").focus();
		}
	});
	return false;
}


function m_stokbarang_h(id) {
	if (confirm('Anda yakin..?')) {
		$.ajax({
			type: "GET",
			url: base_url+"adm/stok_barang/hapus/"+id,
			success: function(response) {
				if (response.status == "ok") {
					window.location.assign(base_url+"adm/stok_barang/"); 
				} else {
					console.log('gagal');
				}
			}
		});
	}
	return false;
}

function m_barang_stok_new() {
	$("#m_barang_stok_new").modal('show');
	return false;
}

function m_barang_stok_s() {
	var f_asal	= $("#f_barang_stok");
	var form	= getFormData(f_asal);

	$.ajax({		
		type: "POST",
		url: base_url+"adm/stok_barang/edit_simpan",
		data: JSON.stringify(form),
		dataType: 'json',
		contentType: 'application/json; charset=utf-8'
	}).done(function(response) {
		if (response.status == "ok") {
			window.location.assign(base_url+"adm/stok_barang/"); 
		} else {
			console.log('gagal');
		}
	});
	return false;
}

/* =========================================================================
   Universal Touch & Drag-to-Scroll Enhancement for Tables & Navbars
   Memungkinkan swipe/drag langsung pada tabel di SEMUA ROLE tanpa harus klik scrollbar kecil
   ========================================================================= */
function enableDragToScroll(selector) {
  $(selector).each(function () {
    var slider = this;
    if ($(slider).data('dragScrollActive')) return;
    $(slider).data('dragScrollActive', true);

    var isDown = false;
    var startX;
    var scrollLeft;
    var isMoved = false;

    $(slider).addClass('drag-scrollable');

    $(slider).on('mousedown', function (e) {
      if ($(e.target).closest('a, button, input, select, textarea, .btn, .select2').length) {
        return;
      }
      isDown = true;
      isMoved = false;
      $(slider).addClass('active-dragging');
      startX = e.pageX;
      scrollLeft = slider.scrollLeft;
    });

    $(document).on('mousemove', function (e) {
      if (!isDown) return;
      var currentX = e.pageX;
      var walk = (currentX - startX) * 1.3;
      if (Math.abs(walk) > 4) {
        isMoved = true;
        e.preventDefault();
      }
      slider.scrollLeft = scrollLeft - walk;
    });

    $(document).on('mouseup', function () {
      if (isDown) {
        isDown = false;
        $(slider).removeClass('active-dragging');
      }
    });

    // Cegah trigger aksi link/click saat user sedang melakukan drag geser
    $(slider).on('click', function (e) {
      if (isMoved) {
        e.preventDefault();
        e.stopPropagation();
        isMoved = false;
      }
    });
  });
}

function initUniversalTableScroll() {
  // Pastikan semua tabel data di SEMUA ROLE otomatis dibungkus container table-responsive
  $('table:not(.table-form, .table-no-responsive)').each(function () {
    var $tbl = $(this);
    if (!$tbl.parent().hasClass('table-responsive')) {
      $tbl.wrap('<div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 12px;"></div>');
    }
  });

  enableDragToScroll('.table-responsive, .simantik-nav-links, .scroll');
}

$(document).ready(function () {
  initUniversalTableScroll();

  // Trigger ulang saat ada AJAX yang selesai me-render tabel/modal baru
  $(document).ajaxComplete(function () {
    initUniversalTableScroll();
  });

  // Trigger ulang bila ada tab bootstrap yang berganti (misal di Kelola Permintaan)
  $('a[data-toggle="tab"]').on('shown.bs.tab', function () {
    initUniversalTableScroll();
  });

  // Trigger ulang bila modal terbuka
  $(document).on('shown.bs.modal', function () {
    initUniversalTableScroll();
  });

  // Auto-scroll navbar item aktif jika navbar dalam mode scroll horizontal (misal di tablet)
  var navLinks = document.querySelector('.simantik-nav-links');
  var activeNavItem = document.querySelector('.simantik-nav-links .simantik-nav-item.active');
  if (navLinks && navLinks.scrollWidth > navLinks.clientWidth && activeNavItem && typeof activeNavItem.scrollIntoView === 'function') {
    setTimeout(function () {
      activeNavItem.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }, 250);
  }
});		