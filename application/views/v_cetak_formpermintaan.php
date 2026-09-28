<?php
  // Format tanggal Indonesia
  if (!function_exists('format_tgl_indo')) {
    function format_tgl_indo($tgl_str) {
      if (empty($tgl_str)) return date('d F Y');
      $bulan = array(
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
      );
      $ts = strtotime($tgl_str);
      if (!$ts) return $tgl_str;
      $d = date('j', $ts);
      $m = (int)date('n', $ts);
      $y = date('Y', $ts);
      return $d . ' ' . (isset($bulan[$m]) ? $bulan[$m] : '') . ' ' . $y;
    }
  }

  // Data pemohon
  $nip_pengajuan = isset($datayangmengajukan->nip_pegawai) ? $datayangmengajukan->nip_pegawai : '';
  $nama_pemohon = isset($datayangmengajukan->nama) && !empty($datayangmengajukan->nama) ? $datayangmengajukan->nama : '';
  
  if (empty($nama_pemohon) && !empty($nip_pengajuan)) {
    $q = mysql_query("SELECT nama FROM m_pegawai WHERE nip='$nip_pengajuan'");
    if ($q && mysql_num_rows($q) > 0) {
      $r = mysql_fetch_assoc($q);
      $nama_pemohon = $r['nama'];
    }
  }
  if (empty($nama_pemohon)) {
    $nama_pemohon = '..........................................';
  }

  $tgl_pengajuan = isset($qtgl_permintaan->tgl_permintaan) && !empty($qtgl_permintaan->tgl_permintaan) 
    ? format_tgl_indo($qtgl_permintaan->tgl_permintaan) 
    : format_tgl_indo(date('Y-m-d'));

  $kode_permintaan = isset($id_permintaan) ? $id_permintaan : (isset($this->uri->segments[3]) ? $this->uri->segments[3] : '-');

  // Embed Logo BPS langsung dalam base64 agar SELALU tampil di PDF & printer tanpa delay
  $logo_path = FCPATH . 'upload/logo.png';
  if (file_exists($logo_path)) {
    $logo_base64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logo_path));
  } else {
    $logo_base64 = base_url('upload/logo.png');
  }

  $is_preview = isset($_GET['preview']) && $_GET['preview'] == '1';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Permintaan Barang Persediaan - <?php echo htmlspecialchars($kode_permintaan); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <style>
    /* Reset & Page Setup untuk A4 Standar */
    @page {
      size: A4 portrait;
      margin: 12mm 15mm 12mm 15mm;
    }

    * {
      box-sizing: border-box;
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
    }

    body {
      font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
      font-size: 11pt;
      line-height: 1.4;
      color: #000000;
      background-color: <?php echo $is_preview ? '#ffffff' : '#f1f5f9'; ?>;
      margin: 0;
      padding: <?php echo $is_preview ? '0' : '20px 0'; ?>;
    }

    .paper-sheet {
      background: #ffffff;
      width: <?php echo $is_preview ? '100%' : '210mm'; ?>;
      max-width: 210mm;
      min-height: <?php echo $is_preview ? 'auto' : '297mm'; ?>;
      margin: 0 auto;
      padding: <?php echo $is_preview ? '12mm 15mm' : '15mm 18mm'; ?>;
      box-shadow: <?php echo $is_preview ? 'none' : '0 4px 18px rgba(0, 0, 0, 0.12)'; ?>;
      border-radius: 4px;
      position: relative;
    }

    /* Print Action Bar (Hanya tampil di browser layar, tersembunyi saat di-print atau mode preview modal) */
    .no-print-toolbar {
      width: 210mm;
      margin: 0 auto 14px auto;
      display: <?php echo $is_preview ? 'none' : 'flex'; ?>;
      align-items: center;
      justify-content: space-between;
      background: #1e293b;
      color: #ffffff;
      padding: 10px 18px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .no-print-toolbar .btn-print {
      background: #2563eb;
      color: #ffffff;
      border: none;
      padding: 7px 16px;
      border-radius: 6px;
      font-size: 12.5px;
      font-weight: 700;
      cursor: pointer;
    }

    .no-print-toolbar .btn-print:hover {
      background: #1d4ed8;
    }

    .no-print-toolbar .btn-close {
      background: rgba(255, 255, 255, 0.15);
      color: #ffffff;
      border: 1px solid rgba(255,255,255,0.25);
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 12px;
      cursor: pointer;
    }

    /* Kop Surat Kedinasan BPS */
    .kop-surat-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2px;
    }

    .kop-logo-td {
      width: 80px;
      vertical-align: middle;
      text-align: center;
      padding-right: 14px;
    }

    .kop-logo-img {
      width: 75px;
      height: auto;
      display: block;
    }

    .kop-text-td {
      vertical-align: middle;
      text-align: center;
    }

    .kop-instansi-1 {
      font-size: 14pt;
      font-weight: bold;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      color: #000000;
    }

    .kop-instansi-2 {
      font-size: 16pt;
      font-weight: bold;
      letter-spacing: 1px;
      text-transform: uppercase;
      color: #000000;
      margin: 1px 0;
    }

    .kop-alamat {
      font-size: 8.5pt;
      color: #222222;
      line-height: 1.35;
      margin-top: 3px;
    }

    /* Garis Ganda Pemisah Kop Surat Resmi */
    .kop-divider {
      border: 0;
      border-top: 2.5px solid #000000;
      border-bottom: 1px solid #000000;
      height: 4px;
      margin: 8px 0 18px 0;
    }

    /* Judul Dokumen */
    .dokumen-judul-box {
      text-align: center;
      margin-bottom: 18px;
    }

    .dokumen-judul {
      font-size: 13pt;
      font-weight: bold;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      margin: 0;
    }

    /* Tabel Data Rincian Barang */
    .data-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 24px;
      font-size: 10pt;
    }

    .data-table th,
    .data-table td {
      border: 1px solid #000000;
      padding: 6px 8px;
    }

    .data-table th {
      background-color: #f2f2f2 !important;
      font-weight: bold;
      text-align: center;
      vertical-align: middle;
      font-size: 9.5pt;
    }

    .data-table .subhead-col {
      background-color: #fafafa !important;
      font-size: 8pt;
      font-style: italic;
      color: #444444;
      text-align: center;
      padding: 2px 0;
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }

    /* Area Kolom Tanda Tangan Resmi - Font Normal (Tidak Bold) */
    .ttd-container-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 14px;
      font-size: 10pt;
      page-break-inside: avoid;
    }

    .ttd-container-table td {
      vertical-align: top;
      padding: 0 10px;
    }

    .ttd-box {
      text-align: center;
      font-weight: normal !important;
    }

    .ttd-jabatan {
      font-weight: normal !important;
      margin-bottom: 58px; /* Ruang tanda tangan */
      line-height: 1.4;
    }

    .ttd-nama {
      font-weight: normal !important;
      color: #000000;
      margin: 0;
    }

    /* Tampilan Responsif Layar Kecil / Mobile */
    @media screen and (max-width: 768px) {
      body {
        padding: 0 !important;
        font-size: 9.5pt !important;
      }
      .paper-sheet {
        width: 100% !important;
        min-height: auto !important;
        padding: 10px !important;
        box-shadow: none !important;
      }
      .no-print-toolbar {
        width: 100% !important;
        border-radius: 0 !important;
        margin-bottom: 8px !important;
      }
      .kop-instansi-1 { font-size: 11pt !important; }
      .kop-instansi-2 { font-size: 13pt !important; }
      .kop-alamat { font-size: 7.5pt !important; }
      .data-table { font-size: 8.5pt !important; }
      .data-table th, .data-table td { padding: 4px 5px !important; }
    }

    /* Aturan Khusus Media Cetak / PDF */
    @media print {
      body {
        background: transparent !important;
        padding: 0 !important;
        margin: 0 !important;
      }

      .no-print-toolbar {
        display: none !important;
      }

      .paper-sheet {
        box-shadow: none !important;
        border-radius: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        min-height: auto !important;
      }
    }
  </style>
</head>
<body>

  <!-- Floating Print Toolbar (Hanya di Layar Tab Penuh) -->
  <div class="no-print-toolbar">
    <div style="font-size: 12.5px;">
      <b>Pratinjau Cetak</b> &bull; Dokumen resmi ukuran A4
    </div>
    <div style="display: flex; gap: 8px;">
      <button type="button" class="btn-print" onclick="window.print();">
        Cetak Dokumen (Ctrl+P)
      </button>
      <button type="button" class="btn-close" onclick="window.close();">
        Tutup
      </button>
    </div>
  </div>

  <!-- Lembar Kertas Dokumen Cetak Ukuran A4 -->
  <div class="paper-sheet">

    <!-- 1. Kop Surat Resmi BPS -->
    <table class="kop-surat-table">
      <tr>
        <td class="kop-logo-td">
          <img src="<?php echo $logo_base64; ?>" alt="Logo BPS" class="kop-logo-img">
        </td>
        <td class="kop-text-td">
          <div class="kop-instansi-1">BADAN PUSAT STATISTIK</div>
          <div class="kop-instansi-2">PROVINSI JAWA TENGAH</div>
          <div class="kop-alamat">
            Jl. Pahlawan No. 6 Semarang 50241, Telp. (024) 8412801, Faks. (024) 8412802<br>
            Website: jateng.bps.go.id &bull; Pos-el: bps3300@bps.go.id
          </div>
        </td>
      </tr>
    </table>

    <div class="kop-divider"></div>

    <!-- 2. Judul Dokumen -->
    <div class="dokumen-judul-box">
      <h3 class="dokumen-judul">PERMINTAAN BARANG PERSEDIAAN</h3>
    </div>

    <!-- 3. Tabel Daftar Rincian Barang ATK/ART -->
    <table class="data-table">
      <thead>
        <tr>
          <th style="width: 5%;">No</th>
          <th style="width: 15%;">Kode Permintaan</th>
          <th style="width: 22%;">Kode Barang</th>
          <th style="width: 38%;">Nama Barang</th>
          <th style="width: 10%;">Satuan</th>
          <th style="width: 10%;">Banyaknya</th>
        </tr>
        <tr>
          <td class="subhead-col">(1)</td>
          <td class="subhead-col">(2)</td>
          <td class="subhead-col">(3)</td>
          <td class="subhead-col">(4)</td>
          <td class="subhead-col">(5)</td>
          <td class="subhead-col">(6)</td>
        </tr>
      </thead>
      <tbody>
        <?php 
          if (!empty($permintaan_barang)) {
            $no = 1;
            foreach ($permintaan_barang as $d) {
              $kode_gabung = $d->kode_jenisbarang . '-' . $d->kode_subjenisbarang;
        ?>
          <tr>
            <td class="text-center"><?php echo $no; ?></td>
            <td class="text-center" style="font-family: monospace; font-size: 9.5pt;">
              <?php echo htmlspecialchars($d->id_permintaan); ?>
            </td>
            <td class="text-center" style="font-family: monospace; font-size: 9.5pt;">
              <?php echo htmlspecialchars($kode_gabung); ?>
            </td>
            <td><?php echo htmlspecialchars($d->nama_barang); ?></td>
            <td class="text-center"><?php echo htmlspecialchars(strtoupper($d->satuan)); ?></td>
            <td class="text-center"><?php echo number_format($d->jumlah_permintaan); ?></td>
          </tr>
        <?php 
              $no++;
            }
          } else {
        ?>
          <tr>
            <td colspan="6" class="text-center" style="padding: 16px; color: #666;">
              Tidak ada rincian barang pada pengajuan ini.
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <!-- 4. Tanda Tangan & Pengesahan (Semua Teks Bersifat Normal / Tidak Bold) -->
    <table class="ttd-container-table">
      <!-- Baris 1: Pengajuan & Atasan -->
      <tr>
        <td style="width: 50%;">
          <div class="ttd-box">
            <div class="ttd-jabatan">
              Mengetahui,<br>
              Kabag/Kabid/Kasubbag/Kasi,
            </div>
            <p class="ttd-nama">(..........................................)</p>
          </div>
        </td>
        <td style="width: 50%;">
          <div class="ttd-box">
            <div class="ttd-jabatan">
              Semarang, <?php echo htmlspecialchars($tgl_pengajuan); ?><br>
              Yang Mengajukan,
            </div>
            <p class="ttd-nama"><?php echo htmlspecialchars($nama_pemohon); ?></p>
          </div>
        </td>
      </tr>

      <tr>
        <td colspan="2" style="height: 25px;"></td>
      </tr>

      <!-- Baris 2: Serah Terima di Subbag Umum -->
      <tr>
        <td style="width: 50%;">
          <div class="ttd-box">
            <div class="ttd-jabatan">
              Yang Menyerahkan,
            </div>
            <p class="ttd-nama">(..........................................)</p>
          </div>
        </td>
        <td style="width: 50%;">
          <div class="ttd-box">
            <div class="ttd-jabatan">
              Yang Menerima,
            </div>
            <p class="ttd-nama">(..........................................)</p>
          </div>
        </td>
      </tr>
    </table>

  </div>

  <?php if (!$is_preview): ?>
  <!-- Otomatis memicu dialog print jika dibuka langsung di tab baru -->
  <script type="text/javascript">
    window.addEventListener('load', function() {
      setTimeout(function() {
        window.print();
      }, 400);
    });
  </script>
  <?php endif; ?>

</body>
</html>