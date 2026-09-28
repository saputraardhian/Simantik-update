<?php
	// Generate ID Penerimaan Otomatis
	$today = date("Y-m-d");
	$query = mysql_query("SELECT max(substring(id_penerimaan,12,(LENGTH (id_penerimaan)-11))) as maxID from t_penerimaan_barang where substring(tgl_diterima,1,10)='$today' ORDER BY LENGTH(id_penerimaan) DESC, id_penerimaan DESC");
	$dataMax = mysql_fetch_array($query);
	$idMax = $dataMax['maxID'];
	$noUrut = (int) $idMax;
	$noUrut++;
	$newID = $today . "-" . sprintf($noUrut);

	// Load daftar barang master untuk Select2
	$strSQL = "SELECT * FROM m_barang ORDER BY nama_barang";
	$objQuery = mysql_query($strSQL);
	$master_barang_list = array();
	if ($objQuery) {
		while($row = mysql_fetch_array($objQuery)) {
			$master_barang_list[] = array(
				'key' => $row['kode_jenisbarang'] . '-' . $row['kode_subjenisbarang'],
				'nama' => $row['nama_barang'],
				'satuan' => strtoupper($row['satuan'])
			);
		}
	}
?>

<div class="row">
  <div class="col-md-12">

    <!-- Card: Transaksi Update Stok Barang -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4><i class="fa-solid fa-boxes-packing" style="color: var(--primary);"></i> Transaksi Update & Penerimaan Stok Barang</h4>
        <div class="panel-action">
          <button type="button" class="btn btn-primary btn-sm" onclick="return m_barang_stok_new();">
            <i class="fa-solid fa-plus"></i> Tambah Penerimaan Stok
          </button>
        </div>
      </div>
      <div class="panel-body" style="padding: 0;">
        <div class="table-responsive" style="display: block; width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; border: none; margin-bottom: 0;">
          <table class="table table-hover" style="margin-bottom: 0; width: 100%; min-width: 780px; max-width: none; white-space: nowrap;">
          <thead>
            <tr>
              <th style="width: 50px; min-width: 50px;" class="ctr">No</th>
              <th style="width: 150px; min-width: 150px;">Kode Penerimaan</th>
              <th style="width: 150px; min-width: 150px;">Kode Barang</th>
              <th style="min-width: 200px;">Nama Barang</th>
              <th style="width: 130px; min-width: 130px;" class="ctr">Jumlah Diterima</th>
              <th style="width: 160px; min-width: 160px;">Sumber Penerimaan</th>
              <th style="width: 130px; min-width: 130px;" class="ctr">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if (!empty($data)) {
                $no = 1;
                foreach ($data as $d) {
            ?>
              <tr>
                <td class="ctr" style="font-weight: 600; color: #64748b;"><?php echo $no; ?></td>
                <td>
                  <span style="font-weight: 700; color: #0f172a;"><?php echo $d->id_penerimaan; ?></span>
                </td>
                <td>
                  <span style="font-size: 12px; color: #64748b; font-family: monospace;"><?php echo $d->kode_jenisbarang.' '.$d->kode_subjenisbarang; ?></span>
                </td>
                <td>
                  <?php if (!empty($d->nama_barang)): ?>
                    <span style="font-weight: 600; color: #1e293b;"><?php echo $d->nama_barang; ?></span>
                  <?php else: ?>
                    <span style="display: inline-flex; align-items: center; gap: 6px; background: #fef3c7; color: #92400e; border: 1px solid #fde68a; padding: 3px 8px; border-radius: 6px; font-size: 11.5px; font-weight: 600;">
                      <i class="fa-solid fa-box-archive"></i> [Arsip / Kode Lama]
                    </span>
                  <?php endif; ?>
                </td>
                <td class="ctr">
                  <span class="stock-badge stock-badge-available">
                    +<?php echo $d->jumlah_penerimaan; ?>
                  </span>
                </td>
                <td>
                  <span style="color: #475569;"><?php echo !empty($d->sumber_penerimaan) ? $d->sumber_penerimaan : '-'; ?></span>
                </td>
                <td class="ctr">
                  <div class="btn-group" style="display: inline-flex; gap: 6px;">
                    <a href="#" onclick="return m_stokbarang_e(<?php echo $d->id; ?>);" class="btn btn-outline-primary btn-xs" title="Edit Penerimaan">
                      <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <a href="#" onclick="return m_stokbarang_h(<?php echo $d->id; ?>);" class="btn btn-outline-danger btn-xs" title="Hapus Penerimaan">
                      <i class="fa-solid fa-trash-can"></i> Hapus
                    </a>
                  </div>
                </td>
              </tr>
            <?php 
                  $no++;
                }
              } else {
            ?>
              <tr>
                <td colspan="7" class="ctr" style="padding: 36px; color: #94a3b8;">
                  <i class="fa-solid fa-box-open" style="font-size: 36px; margin-bottom: 8px; display: block;"></i>
                  Belum ada riwayat transaksi penerimaan barang.
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

<!-- =========================================================================
     MODAL 1: Tambah Penerimaan Stok Barang (m_barang_stok_new)
     ========================================================================= -->
<div class="modal fade" id="m_barang_stok_new" tabindex="-1" role="dialog" aria-labelledby="modalLabelTambahStok">
  <div class="modal-dialog" style="width: 95%; max-width: 1250px; margin: 30px auto;" role="document">
    <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);">
      
      <div class="modal-header" style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 18px 24px; border-top-left-radius: 14px; border-top-right-radius: 14px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; opacity: 0.6;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 id="modalLabelTambahStok" style="margin: 0; font-size: 17px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 10px;">
          <i class="fa-solid fa-cart-flatbed" style="color: var(--primary);"></i>
          Data Barang Masuk / Tambah Stok
        </h4>
      </div>

      <form action="<?php echo base_url();?>adm/stok_barang/tambah_stok/" method="post" accept-charset="utf-8" enctype="multipart/form-data">
        <input type="hidden" name="id" id="id" value="0">

        <div class="modal-body" style="padding: 24px;">
          
          <!-- Header Bar: Kode Penerimaan & Tambah Baris -->
          <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px 18px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div style="display: flex; align-items: center; gap: 12px;">
              <label style="margin: 0; font-size: 13px; font-weight: 700; color: #334155;">
                <i class="fa-solid fa-receipt" style="color: var(--primary); margin-right: 4px;"></i> Kode Penerimaan:
              </label>
              <input type="text" name="id_penerimaan" id="id_penerimaan" value="<?php echo $newID; ?>" class="form-control" style="width: 170px; height: 36px; font-weight: 700; background: #ffffff; text-align: center;" readonly />
            </div>

            <div>
              <button type="button" class="btn btn-success btn-sm" onclick="additem_stock();" style="padding: 7px 14px;">
                <i class="fa-solid fa-plus"></i> Tambah Baris Barang
              </button>
            </div>
          </div>

          <!-- Table Items Container -->
          <div class="table-responsive" style="border: 1px solid #e2e8f0; border-radius: 10px; overflow-x: auto; -webkit-overflow-scrolling: touch; margin-bottom: 0;">
            <table class="table" style="margin-bottom: 0; min-width: 680px;">
              <thead>
                <tr>
                  <th width="28%">Nama Barang (Cari ATK)</th>
                  <th width="15%">Jumlah Diterima</th>
                  <th width="20%">Sumber Penerimaan</th>
                  <th width="15%">Nilai Penerimaan (Rp)</th>
                  <th width="16%">Tanggal Dokumen</th>
                  <th width="6%" class="ctr">Aksi</th>
                </tr>
              </thead>
              <tbody id="itemlist_stock">
                <!-- Elemen baris baru akan di-append ke sini lewat JavaScript -->
              </tbody>
            </table>
          </div>

        </div>

        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px; display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="fa-solid fa-xmark"></i> Batal
          </button>
          <button type="submit" name="submit" class="btn btn-primary" style="padding: 9px 20px;">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Penambahan Stok
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- =========================================================================
     MODAL 2: Edit Penambahan Barang (m_editstok_barang)
     ========================================================================= -->
<div class="modal fade" id="m_editstok_barang" tabindex="-1" role="dialog" aria-labelledby="modalLabelEditStok">
  <div class="modal-dialog" style="max-width: 650px;" role="document">
    <div class="modal-content" style="border-radius: 14px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);">
      
      <div class="modal-header" style="background: #ffffff; border-bottom: 1px solid #e2e8f0; padding: 18px 24px; border-top-left-radius: 14px; border-top-right-radius: 14px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px; opacity: 0.6;">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 id="modalLabelEditStok" style="margin: 0; font-size: 17px; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 10px;">
          <i class="fa-solid fa-pen-to-square" style="color: var(--primary);"></i>
          Edit Catatan Penambahan Barang
        </h4>
      </div>

      <form name="f_barang_stok" id="f_barang_stok" onsubmit="return m_barang_stok_s();">
        <input type="hidden" name="id" id="id" value="0">

        <div class="modal-body" style="padding: 24px;">
          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
              <label>Kode Penerimaan</label>
              <input type="text" class="form-control" name="id_penerimaan" id="id_penerimaan" readonly style="background: #f1f5f9; font-weight: 700;">
            </div>
            <div>
              <label>Tanggal Dokumen</label>
              <input type="date" class="form-control" name="tgl_dokumen" id="tgl_dokumen" required>
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
              <label>Kode Jenis Barang</label>
              <input type="text" class="form-control" name="kode_jenisbarang" id="kode_jenisbarang" readonly style="background: #f1f5f9;">
            </div>
            <div>
              <label>Kode Subjenis Barang</label>
              <input type="text" class="form-control" name="kode_subjenisbarang" id="kode_subjenisbarang" readonly style="background: #f1f5f9;">
            </div>
          </div>

          <div style="margin-bottom: 16px;">
            <label>Nama Barang</label>
            <input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly style="background: #f1f5f9; font-weight: 600;">
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
            <div>
              <label>Jumlah Penerimaan</label>
              <input type="number" min="1" class="form-control" name="jumlah_penerimaan" id="jumlah_penerimaan" required>
            </div>
            <div>
              <label>Nilai Penerimaan (Rp)</label>
              <input type="text" class="form-control" name="nilai_penerimaan" id="nilai_penerimaan" placeholder="Contoh: 150000" required>
            </div>
          </div>

          <div>
            <label>Sumber Penerimaan</label>
            <input type="text" class="form-control" name="sumber_penerimaan" id="sumber_penerimaan" placeholder="Contoh: CV Putramas Group / DIPA" required>
          </div>
        </div>

        <div class="modal-footer" style="background: #f8fafc; border-top: 1px solid #e2e8f0; padding: 16px 24px; border-bottom-left-radius: 14px; border-bottom-right-radius: 14px; display: flex; justify-content: flex-end; gap: 10px;">
          <button type="button" class="btn btn-default" data-dismiss="modal">
            <i class="fa-solid fa-xmark"></i> Tutup
          </button>
          <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- =========================================================================
     JAVASCRIPT: Select2 Searchable & Dynamic Rows Tambah Stok
     ========================================================================= -->
<script language="javascript">
  var masterBarangStock = <?php echo json_encode($master_barang_list); ?>;
  var masterBarangStockMap = {};
  for (var i = 0; i < masterBarangStock.length; i++) {
    masterBarangStockMap[masterBarangStock[i].key] = masterBarangStock[i];
  }

  // 1-based indexing sesuai kebutuhan loop controller backend (i=1; foreach($nama as $key=>$n){ $key=$i; ... })
  var stockRowIndex = 1;

  function createStockOptionsHTML() {
    var html = '<option value="">-- Pilih atau cari nama barang ATK --</option>';
    for (var i = 0; i < masterBarangStock.length; i++) {
      var item = masterBarangStock[i];
      html += '<option value="' + item.key + '">' + item.nama + ' (' + item.satuan + ')</option>';
    }
    return html;
  }

  function additem_stock() {
    var idx = stockRowIndex++;
    var todayStr = new Date().toISOString().split('T')[0];
    var container = document.getElementById('itemlist_stock');

    var row = document.createElement('tr');
    row.setAttribute('id', 'stock_row_' + idx);

    row.innerHTML = 
      '<td>' +
        '<select name="nama_input[' + idx + ']" id="stock_select_' + idx + '" class="form-control select2-stock-item" style="width: 100%;">' +
          createStockOptionsHTML() +
        '</select>' +
      '</td>' +

      '<td>' +
        '<div style="display: flex; align-items: center; gap: 6px;">' +
          '<input type="number" min="1" step="1" name="jumlah_input[' + idx + ']" id="stock_qty_' + idx + '" class="form-control" placeholder="0" style="text-align: center; font-weight: 700;" required>' +
          '<span class="unit-badge" id="stock_unit_' + idx + '" style="height: 38px; font-size: 11px;">-</span>' +
        '</div>' +
      '</td>' +

      '<td>' +
        '<input type="text" name="sumber_input[' + idx + ']" class="form-control" placeholder="Sumber (CV/DIPA)" style="height: 38px;" required>' +
      '</td>' +

      '<td>' +
        '<input type="text" name="nilai_input[' + idx + ']" class="form-control" placeholder="Nilai Rp" style="height: 38px;" required>' +
      '</td>' +

      '<td>' +
        '<input type="date" name="tgl_diterima[' + idx + ']" value="' + todayStr + '" class="form-control" style="height: 38px;" required>' +
      '</td>' +

      '<td class="ctr">' +
        '<button type="button" class="btn btn-outline-danger btn-xs" onclick="removeStockRow(' + idx + ');" title="Hapus baris">' +
          '<i class="fa-solid fa-trash-can"></i>' +
        '</button>' +
      '</td>';

    container.appendChild(row);

    // Aktifkan Select2 dengan pencarian di dalam modal
    $('#stock_select_' + idx).select2({
      dropdownParent: $('#m_barang_stok_new'),
      placeholder: '-- Pilih atau cari nama barang ATK --',
      allowClear: true,
      width: '100%'
    }).on('change', function () {
      var key = $(this).val();
      var item = masterBarangStockMap[key];
      if (item) {
        $('#stock_unit_' + idx).text(item.satuan || '-');
      } else {
        $('#stock_unit_' + idx).text('-');
      }
    });
  }

  function removeStockRow(idx) {
    var totalRows = $('#itemlist_stock tr').length;
    if (totalRows <= 1) {
      alert('Minimal harus ada 1 barang dalam daftar penerimaan.');
      return;
    }
    var row = document.getElementById('stock_row_' + idx);
    if (row) {
      row.parentNode.removeChild(row);
    }
  }

  // Buka modal dan auto-tambah 1 baris awal jika masih kosong
  $(document).ready(function () {
    $('#m_barang_stok_new').on('shown.bs.modal', function () {
      if ($('#itemlist_stock tr').length === 0) {
        additem_stock();
      }
    });
  });
</script>