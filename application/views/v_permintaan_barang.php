<?php
	// Inisialisasi default
	$id_permintaan = '';
	$nama = array();
	$jumlah = array();
	
	$nipku = $this->session->userdata('admin_nip');
	$username = $this->session->userdata('admin_user');
	if (strlen($nipku) == 5 || $username == 'sunarto4' || $username == 'hyas')
	{
		$strSQL = "SELECT * FROM m_barang order by nama_barang";
	}
	else
	{
		$strSQL = "SELECT * FROM m_barang where substring(kode_jenisbarang,6,2) <> '05' order by nama_barang ";
	}
	$objQuery = mysql_query($strSQL);
	$master_barang_list = array();
	if ($objQuery) {
		while($row = mysql_fetch_array($objQuery)) {
			$master_barang_list[] = array(
				'key' => $row['kode_jenisbarang'].'-'.$row['kode_subjenisbarang'],
				'nama' => $row['nama_barang'],
				'satuan' => strtoupper($row['satuan']),
				'stok' => (int) $row['stok_barang']
			);
		}
	}
?>

<div class="row">
  <div class="col-md-12">

    <!-- Flash message alert -->
    <?php if ($this->session->flashdata("k")): ?>
      <div style="margin-bottom: 20px;">
        <?php echo $this->session->flashdata("k"); ?>
      </div>
    <?php endif; ?>

    <!-- Card 1: Riwayat Permintaan Barang -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4><i class="fa-solid fa-clock-rotate-left" style="color: var(--primary);"></i> Riwayat Permintaan Barang Saya</h4>
      </div>
      <div class="panel-body" style="padding: 0;">
        <table class="table table-hover" style="margin-bottom: 0;">
          <thead>
            <tr>
              <th width="8%" class="ctr">No</th>
              <th width="42%">Kode Permintaan</th>
              <th width="25%">Status</th>
              <th width="25%" class="ctr">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              if (!empty($databarang)) {
                $no = 1;
                foreach ($databarang as $d) {
                  $isDiserahkan = ($d->nip_pegawai_menyerahkan != '');
            ?>
              <tr>
                <td class="ctr" style="font-weight: 600; color: #64748b;"><?php echo $no; ?></td>
                <td>
                  <span style="font-weight: 700; color: #0f172a;"><?php echo $d->id_permintaan; ?></span>
                </td>
                <td>
                  <?php if ($isDiserahkan): ?>
                    <span class="stock-badge stock-badge-available"><i class="fa-solid fa-circle-check"></i> Sudah Diserahkan</span>
                  <?php else: ?>
                    <span class="stock-badge stock-badge-warning"><i class="fa-solid fa-hourglass-half"></i> Menunggu Penyerahan</span>
                  <?php endif; ?>
                </td>
                <td class="ctr">
                  <div class="btn-group" style="display: inline-flex; gap: 6px;">
                    <?php if (!$isDiserahkan): ?>
                      <a href="#" onclick="return m_permintaan_e('<?php echo $d->id_permintaan; ?>');" class="btn btn-outline-primary btn-xs" title="Ubah Pengajuan">
                        <i class="fa-solid fa-pen-to-square"></i> Ubah
                      </a>
                    <?php else: ?>
                      <a href="#" onclick="return m_permintaan_v('<?php echo $d->id_permintaan; ?>');" class="btn btn-outline-primary btn-xs" title="Lihat Rincian">
                        <i class="fa-solid fa-eye"></i> Detail
                      </a>
                    <?php endif; ?>

                    <a href="#" onclick="return m_permintaan_h('<?php echo $d->id_permintaan; ?>');" class="btn btn-outline-danger btn-xs" title="Hapus Pengajuan">
                      <i class="fa-solid fa-trash-can"></i> Hapus
                    </a>

                    <a href="<?php echo base_url(); ?>adm/cetak_formpermintaan/<?php echo $d->id_permintaan; ?>" class="btn btn-outline-warning btn-xs" target="_blank" title="Cetak Bukti">
                      <i class="fa-solid fa-print"></i> Cetak
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
                <td colspan="4" class="ctr" style="padding: 30px; color: #94a3b8;">
                  <i class="fa-solid fa-box-open" style="font-size: 32px; margin-bottom: 8px; display: block;"></i>
                  Belum ada riwayat permintaan barang.
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Card 2: Form Pengajuan Permintaan Barang Baru -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4><i class="fa-solid fa-cart-plus" style="color: var(--primary);"></i> Form Pengajuan Permintaan Barang Baru</h4>
        <div class="panel-action">
          <button type="button" class="btn btn-success btn-sm" onclick="additem();" id="btn-tambah-baris">
            <i class="fa-solid fa-plus"></i> Tambah Jenis Barang
          </button>
        </div>
      </div>
      <div class="panel-body">
        <form id="form_permintaan" action="<?php echo base_url(); ?>adm/permintaan_barang/simpan/" method="post" accept-charset="utf-8" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="0">

          <div style="margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">
            <div style="font-size: 13px; font-weight: 600; color: #475569;">
              Daftar Barang yang Diajukan
            </div>
            <div style="font-size: 12px; color: #64748b;">
              <i class="fa-solid fa-shield-halved" style="color: #10b981;"></i> Ketersediaan stok divalidasi otomatis secara sistematis
            </div>
          </div>

          <!-- Dynamic Item Rows Target Container -->
          <div id="itemlist"></div>

          <!-- Form Footer Actions -->
          <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
            <div id="validation-hint" style="font-size: 13px; font-weight: 600; color: #64748b;">
              <i class="fa-solid fa-circle-info"></i> Pilih barang dan tentukan kuantitas yang dibutuhkan.
            </div>
            
            <div style="display: flex; gap: 10px;">
              <button type="button" class="btn btn-default" onclick="additem();">
                <i class="fa-solid fa-plus"></i> Tambah Baris
              </button>
              <button type="submit" name="submit" id="btn-simpan" class="btn btn-primary" style="padding: 10px 24px; font-size: 14px;">
                <i class="fa-solid fa-paper-plane"></i> Kirim Pengajuan Permintaan
              </button>
            </div>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
  // Dataset Master Barang disimpan di memori JavaScript client-side
  // Angka fisik stok dirahasiakan dan tidak pernah dicetak sebagai teks/angka di DOM
  var masterBarang = <?php echo json_encode($master_barang_list); ?>;
  var masterBarangMap = {};
  for (var b = 0; b < masterBarang.length; b++) {
    masterBarangMap[masterBarang[b].key] = masterBarang[b];
  }

  var rowIndex = 1;

  function createOptionsHTML() {
    var html = '<option value="">-- Pilih atau cari nama barang ATK --</option>';
    for (var b = 0; b < masterBarang.length; b++) {
      var item = masterBarang[b];
      html += '<option value="' + item.key + '">' + item.nama + ' (' + item.satuan + ')</option>';
    }
    return html;
  }

  function additem() {
    var idx = rowIndex++;
    var container = document.getElementById('itemlist');

    var card = document.createElement('div');
    card.setAttribute('class', 'item-form-card');
    card.setAttribute('id', 'row_' + idx);

    card.innerHTML = 
      '<div class="item-row-grid">' +
        '<div>' +
          '<label style="display: block; font-size: 12px; margin-bottom: 4px; color: #475569;">Nama Barang</label>' +
          '<select name="nama_input[' + idx + ']" id="select_barang_' + idx + '" class="form-control select2-barang" style="width: 100%;">' +
            createOptionsHTML() +
          '</select>' +
        '</div>' +

        '<div>' +
          '<label style="display: block; font-size: 12px; margin-bottom: 4px; color: #475569;">Jumlah Permintaan</label>' +
          '<div class="qty-input-group">' +
            '<input type="number" min="1" step="1" name="jumlah_input[' + idx + ']" id="qty_input_' + idx + '" class="form-control" placeholder="0" disabled oninput="handleQtyChange(' + idx + ');">' +
            '<span class="unit-badge" id="unit_badge_' + idx + '">-</span>' +
          '</div>' +
        '</div>' +

        '<div>' +
          '<label style="display: block; font-size: 12px; margin-bottom: 4px; color: #475569;">Ketersediaan</label>' +
          '<div id="status_badge_' + idx + '">' +
            '<span class="stock-badge stock-badge-pending"><i class="fa-solid fa-circle-question"></i> Pilih barang</span>' +
          '</div>' +
        '</div>' +

        '<div style="text-align: right; padding-top: 18px;">' +
          '<button type="button" class="btn btn-outline-danger btn-xs" onclick="removeItem(' + idx + ');" title="Hapus baris ini">' +
            '<i class="fa-solid fa-trash-can"></i>' +
          '</button>' +
        '</div>' +
      '</div>';

    container.appendChild(card);

    // Inisialisasi Select2 pada dropdown yang baru dibuat
    $('#select_barang_' + idx).select2({
      placeholder: '-- Pilih atau cari nama barang ATK --',
      allowClear: true,
      width: '100%'
    }).on('change', function () {
      handleItemSelection(idx);
    });

    validateAllRows();
  }

  function removeItem(idx) {
    var totalRows = $('#itemlist .item-form-card').length;
    if (totalRows <= 1) {
      alert('Minimal harus ada 1 jenis barang yang diajukan.');
      return;
    }
    var row = document.getElementById('row_' + idx);
    if (row) {
      row.parentNode.removeChild(row);
      validateAllRows();
    }
  }

  function handleItemSelection(idx) {
    var selectEl = $('#select_barang_' + idx);
    var qtyInput = $('#qty_input_' + idx);
    var unitBadge = $('#unit_badge_' + idx);
    var statusBadge = $('#status_badge_' + idx);

    var selectedKey = selectEl.val();
    var item = masterBarangMap[selectedKey];

    if (!selectedKey || !item) {
      unitBadge.text('-');
      qtyInput.val('').prop('disabled', true);
      statusBadge.html('<span class="stock-badge stock-badge-pending"><i class="fa-solid fa-circle-question"></i> Pilih barang</span>');
      validateAllRows();
      return;
    }

    unitBadge.text(item.satuan || 'UNIT');

    // Kondisi 1: Stok Barang = 0
    // Langsung tampilkan badge merah dan kunci input kuantitas
    if (item.stok <= 0) {
      qtyInput.val('').prop('disabled', true);
      statusBadge.html('<span class="stock-badge stock-badge-empty"><i class="fa-solid fa-circle-xmark"></i> Stok Habis</span>');
    } else {
      // Stok tersedia (> 0)
      qtyInput.prop('disabled', false);
      if (!qtyInput.val() || parseInt(qtyInput.val(), 10) <= 0) {
        // Kondisi 2: User belum mengisi jumlah
        statusBadge.html('<span class="stock-badge stock-badge-pending"><i class="fa-solid fa-circle-info"></i> Tentukan jumlah</span>');
      } else {
        checkRowStock(idx);
      }
    }

    validateAllRows();
  }

  function handleQtyChange(idx) {
    checkRowStock(idx);
    validateAllRows();
  }

  function checkRowStock(idx) {
    var selectEl = $('#select_barang_' + idx);
    var qtyInput = $('#qty_input_' + idx);
    var statusBadge = $('#status_badge_' + idx);

    var selectedKey = selectEl.val();
    var item = masterBarangMap[selectedKey];

    if (!selectedKey || !item) return;

    if (item.stok <= 0) {
      statusBadge.html('<span class="stock-badge stock-badge-empty"><i class="fa-solid fa-circle-xmark"></i> Stok Habis</span>');
      return;
    }

    var qty = parseInt(qtyInput.val(), 10);
    if (isNaN(qty) || qty <= 0) {
      // Kondisi 2: Belum isi kuantitas
      statusBadge.html('<span class="stock-badge stock-badge-pending"><i class="fa-solid fa-circle-info"></i> Tentukan jumlah</span>');
      return;
    }

    // Kondisi 3: Jumlah yang diminta <= stok fisik
    // Tampilkan Tersedia tanpa membocorkan angka
    if (qty <= item.stok) {
      statusBadge.html('<span class="stock-badge stock-badge-available"><i class="fa-solid fa-circle-check"></i> Tersedia</span>');
    } 
    // Kondisi 4: Jumlah yang diminta > stok fisik
    // Peringatan stok tidak cukup, tombol simpan dinonaktifkan
    else {
      statusBadge.html('<span class="stock-badge stock-badge-warning"><i class="fa-solid fa-triangle-exclamation"></i> Stok Tidak Mencukupi</span>');
    }
  }

  function validateAllRows() {
    var rows = $('#itemlist .item-form-card');
    var isAllValid = true;
    var errorMessage = '';

    if (rows.length === 0) {
      isAllValid = false;
      errorMessage = 'Silakan tambahkan minimal 1 jenis barang.';
    }

    rows.each(function () {
      var cardId = $(this).attr('id');
      var idx = cardId.replace('row_', '');

      var selectEl = $('#select_barang_' + idx);
      var qtyInput = $('#qty_input_' + idx);

      var selectedKey = selectEl.val();
      var item = masterBarangMap[selectedKey];

      if (!selectedKey || !item) {
        isAllValid = false;
        errorMessage = 'Pilih barang pada setiap baris pengajuan.';
        return false;
      }

      if (item.stok <= 0) {
        isAllValid = false;
        errorMessage = 'Ada barang dengan status Stok Habis. Silakan ganti atau hapus baris tersebut.';
        return false;
      }

      var qty = parseInt(qtyInput.val(), 10);
      if (isNaN(qty) || qty <= 0) {
        isAllValid = false;
        errorMessage = 'Tentukan jumlah barang yang valid pada setiap baris.';
        return false;
      }

      if (qty > item.stok) {
        isAllValid = false;
        errorMessage = 'Jumlah permintaan barang melebihi stok yang tersedia. Kurangi kuantitas pengajuan.';
        return false;
      }
    });

    var submitBtn = $('#btn-simpan');
    var hintEl = $('#validation-hint');

    if (isAllValid) {
      submitBtn.prop('disabled', false);
      hintEl.html('<span style="color: #10b981;"><i class="fa-solid fa-circle-check"></i> Seluruh barang tersedia dan siap diajukan.</span>');
    } else {
      submitBtn.prop('disabled', true);
      hintEl.html('<span style="color: #ef4444;"><i class="fa-solid fa-circle-exclamation"></i> ' + errorMessage + '</span>');
    }
  }

  // Generate 1 baris awal secara otomatis saat halaman pertama kali dibuka
  $(document).ready(function () {
    additem();

    // Mencegah submit jika status belum valid
    $('#form_permintaan').on('submit', function (e) {
      if ($('#btn-simpan').prop('disabled')) {
        e.preventDefault();
        alert('Pengajuan belum dapat dikirim karena ada barang yang melebihi stok atau belum lengkap.');
        return false;
      }
    });
  });
</script>
