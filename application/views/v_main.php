<?php
$sess_user  = $this->session->userdata('admin_user');
$sess_nama  = $this->session->userdata('admin_nama');
$sess_level = $this->session->userdata('admin_level');
$sess_nip   = $this->session->userdata('admin_nip');

// Tanggal hari ini
$hari_arr = array('Sunday'=>'Minggu','Monday'=>'Senin','Tuesday'=>'Selasa','Wednesday'=>'Rabu','Thursday'=>'Kamis','Friday'=>'Jumat','Saturday'=>'Sabtu');
$bulan_arr = array('01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli','08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember');
$hari_ini = isset($hari_arr[date('l')]) ? $hari_arr[date('l')] : date('l');
$tgl_ini = date('d');
$bln_ini = isset($bulan_arr[date('m')]) ? $bulan_arr[date('m')] : date('m');
$thn_ini = date('Y');
$tanggal_lengkap = "$hari_ini, $tgl_ini $bln_ini $thn_ini";

// Sapaan waktu dinamis
$jam_sekarang = (int)date('H');
if ($jam_sekarang >= 4 && $jam_sekarang < 11) {
    $sapaan = "Selamat Pagi";
} else if ($jam_sekarang >= 11 && $jam_sekarang < 15) {
    $sapaan = "Selamat Siang";
} else if ($jam_sekarang >= 15 && $jam_sekarang < 18) {
    $sapaan = "Selamat Sore";
} else {
    $sapaan = "Selamat Malam";
}

// Statistik ringkas dengan pengaman
$total_barang  = 0;
$total_ajuan   = 0;
$total_pending = 0;
$total_selesai = 0;

$q_barang = $this->db->query("SELECT COUNT(*) as jml FROM m_barang");
if ($q_barang && $q_barang->num_rows() > 0) {
    $total_barang = (int)$q_barang->row()->jml;
}

if ($sess_level == 'user') {
    $q_ajuan = $this->db->query("SELECT COUNT(DISTINCT id_permintaan) as jml FROM t_permintaan_barang WHERE nip_pegawai = '$sess_nip'");
    if ($q_ajuan && $q_ajuan->num_rows() > 0) {
        $total_ajuan = (int)$q_ajuan->row()->jml;
    }
    
    $q_pending = $this->db->query("SELECT COUNT(DISTINCT id_permintaan) as jml FROM t_permintaan_barang WHERE nip_pegawai = '$sess_nip' AND (nip_pegawai_menyerahkan IS NULL OR nip_pegawai_menyerahkan = '')");
    if ($q_pending && $q_pending->num_rows() > 0) {
        $total_pending = (int)$q_pending->row()->jml;
    }
    
    $q_selesai = $this->db->query("SELECT COUNT(DISTINCT id_permintaan) as jml FROM t_permintaan_barang WHERE nip_pegawai = '$sess_nip' AND nip_pegawai_menyerahkan IS NOT NULL AND nip_pegawai_menyerahkan != ''");
    if ($q_selesai && $q_selesai->num_rows() > 0) {
        $total_selesai = (int)$q_selesai->row()->jml;
    }

    $q_recent = $this->db->query("SELECT id_permintaan, MAX(tgl_permintaan) as tgl, MAX(nip_pegawai_menyerahkan) as diserahkan FROM t_permintaan_barang WHERE nip_pegawai = '$sess_nip' GROUP BY id_permintaan ORDER BY tgl DESC LIMIT 5");
    $recent_permintaan = $q_recent ? $q_recent->result() : array();
} else {
    $q_ajuan = $this->db->query("SELECT COUNT(DISTINCT id_permintaan) as jml FROM t_permintaan_barang");
    if ($q_ajuan && $q_ajuan->num_rows() > 0) {
        $total_ajuan = (int)$q_ajuan->row()->jml;
    }
    
    $q_pending = $this->db->query("SELECT COUNT(DISTINCT id_permintaan) as jml FROM t_permintaan_barang WHERE nip_pegawai_menyerahkan IS NULL OR nip_pegawai_menyerahkan = ''");
    if ($q_pending && $q_pending->num_rows() > 0) {
        $total_pending = (int)$q_pending->row()->jml;
    }
    
    $q_selesai = $this->db->query("SELECT COUNT(DISTINCT id_permintaan) as jml FROM t_permintaan_barang WHERE nip_pegawai_menyerahkan IS NOT NULL AND nip_pegawai_menyerahkan != ''");
    if ($q_selesai && $q_selesai->num_rows() > 0) {
        $total_selesai = (int)$q_selesai->row()->jml;
    }

    $q_recent = $this->db->query("SELECT t.id_permintaan, MAX(t.tgl_permintaan) as tgl, p.nama, MAX(t.nip_pegawai_menyerahkan) as diserahkan FROM t_permintaan_barang t LEFT JOIN m_pegawai p ON t.nip_pegawai = p.nip GROUP BY t.id_permintaan ORDER BY tgl DESC LIMIT 5");
    $recent_permintaan = $q_recent ? $q_recent->result() : array();
}
?>

<div class="row">
  <div class="col-md-12">

    <!-- 1. Hero Welcome Card -->
    <div class="hero-welcome-card">
      <div class="hero-content-wrap">
        <div class="hero-meta-row">
          <div class="hero-tag">
            <i class="fa-solid fa-boxes-packing"></i> SISTEM PERMINTAAN ATK &amp; ART
          </div>
          <div class="hero-date-mobile hidden-sm hidden-md hidden-lg">
            <i class="fa-regular fa-calendar-days"></i> <?php echo $tanggal_lengkap; ?>
          </div>
        </div>
        <h2 class="hero-title"><?php echo $sapaan; ?>, <?php echo $sess_nama; ?>!</h2>
        <p class="hero-subtitle">
          Selamat datang di <strong>SIMANTIK</strong>. Portal pengajuan kebutuhan perlengkapan kantor (ATK/ART) secara transparan dan tertib administrasi.
        </p>
        <div class="hero-actions">
          <?php if ($sess_level == 'user'): ?>
            <a href="<?php echo base_url(); ?>adm/permintaan_barang" class="btn btn-primary btn-sm">
              <i class="fa-solid fa-cart-plus"></i> Ajukan Permintaan Baru
            </a>
          <?php else: ?>
            <a href="<?php echo base_url(); ?>adm/kelola_permintaan_barang" class="btn btn-primary btn-sm">
              <i class="fa-solid fa-boxes-packing"></i> Kelola Permintaan Masuk
            </a>
            <a href="<?php echo base_url(); ?>adm/stok_barang" class="btn btn-default btn-sm">
              <i class="fa-solid fa-warehouse"></i> Stok Persediaan
            </a>
          <?php endif; ?>
        </div>
      </div>
      <div class="hero-illustration hidden-xs">
        <img src="<?php echo base_url(); ?>___/img/logo-bps.svg" alt="BPS Logo" />
      </div>
    </div>

    <!-- 2. KPI / Stat Cards -->
    <div class="kpi-row">
      <div class="kpi-card">
        <div class="kpi-icon-box kpi-icon-primary">
          <i class="fa-solid fa-file-invoice"></i>
        </div>
        <div class="kpi-info">
          <span class="kpi-value"><?php echo $total_ajuan; ?></span>
          <span class="kpi-label"><?php echo ($sess_level == 'user') ? 'Permintaan Saya' : 'Total Permintaan'; ?></span>
        </div>
      </div>

      <div class="kpi-card">
        <div class="kpi-icon-box kpi-icon-warning">
          <i class="fa-solid fa-hourglass-half"></i>
        </div>
        <div class="kpi-info">
          <span class="kpi-value"><?php echo $total_pending; ?></span>
          <span class="kpi-label">Menunggu Penyerahan</span>
        </div>
      </div>

      <div class="kpi-card">
        <div class="kpi-icon-box kpi-icon-success">
          <i class="fa-solid fa-circle-check"></i>
        </div>
        <div class="kpi-info">
          <span class="kpi-value"><?php echo $total_selesai; ?></span>
          <span class="kpi-label">Selesai Diserahkan</span>
        </div>
      </div>

      <div class="kpi-card">
        <div class="kpi-icon-box kpi-icon-indigo">
          <i class="fa-solid fa-boxes-stacked"></i>
        </div>
        <div class="kpi-info">
          <span class="kpi-value"><?php echo $total_barang; ?></span>
          <span class="kpi-label">Katalog ATK/ART</span>
        </div>
      </div>
    </div>

    <!-- 3. Alur Pelayanan Permintaan ATK/ART (Modern Stepper) -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4><i class="fa-solid fa-route" style="color: var(--primary);"></i> Alur Pelayanan Permintaan ATK &amp; ART</h4>
        <div class="panel-action">
          <button type="button" class="btn btn-default btn-xs" data-toggle="collapse" data-target="#baganKlasikBox">
            <i class="fa-solid fa-image"></i> Lihat Bagan Asli
          </button>
        </div>
      </div>
      <div class="panel-body">
        
        <!-- Modern 4-Step Cards -->
        <div class="workflow-grid">
          <div class="workflow-card">
            <span class="workflow-step-num">Langkah 01</span>
            <div class="workflow-icon"><i class="fa-solid fa-cart-plus"></i></div>
            <h5 class="workflow-title">Ajukan Permintaan</h5>
            <p class="workflow-desc">Pilih jenis barang ATK/ART dan masukkan kuantitas kebutuhan kantor melalui menu <strong>Ajukan Permintaan</strong>.</p>
          </div>

          <div class="workflow-card">
            <span class="workflow-step-num">Langkah 02</span>
            <div class="workflow-icon"><i class="fa-solid fa-clipboard-check"></i></div>
            <h5 class="workflow-title">Verifikasi Subbag Umum</h5>
            <p class="workflow-desc">Petugas memeriksa ketersediaan stok fisik gudang dan memvalidasi permintaan yang diajukan.</p>
          </div>

          <div class="workflow-card">
            <span class="workflow-step-num">Langkah 03</span>
            <div class="workflow-icon"><i class="fa-solid fa-box-open"></i></div>
            <h5 class="workflow-title">Penyerahan Barang</h5>
            <p class="workflow-desc">Pemohon dapat mengambil barang di ruang logistik dan petugas menandai barang telah diserahkan.</p>
          </div>

          <div class="workflow-card">
            <span class="workflow-step-num">Langkah 04</span>
            <div class="workflow-icon"><i class="fa-solid fa-print"></i></div>
            <h5 class="workflow-title">Cetak Bukti Tanda Terima</h5>
            <p class="workflow-desc">Cetak bukti formulir tanda terima sebagai kelengkapan arsip dan pertanggungjawaban persediaan.</p>
          </div>
        </div>

        <!-- Collapsible Original Chart -->
        <div id="baganKlasikBox" class="collapse" style="margin-top: 20px;">
          <div style="border-top: 1px dashed var(--border-subtle); padding-top: 18px; text-align: center;">
            <p style="font-size: 12px; color: var(--text-muted); margin-bottom: 12px;">Diagram alur layanan klasik SIMANTIK:</p>
            <img src="<?php echo base_url(); ?>___/img/alur_simantik.jpg" alt="Alur Layanan SIMANTIK" style="max-width: 100%; height: auto; border-radius: 12px; border: 1px solid var(--border-subtle); box-shadow: var(--shadow-sm);" />
          </div>
        </div>

      </div>
    </div>

    <!-- 4. Riwayat Permintaan Terakhir -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4><i class="fa-solid fa-clock-rotate-left" style="color: var(--primary);"></i> Riwayat Permintaan Terkini</h4>
        <div class="panel-action">
          <a href="<?php echo base_url(); ?>adm/<?php echo ($sess_level == 'user') ? 'permintaan_barang' : 'kelola_permintaan_barang'; ?>" class="btn btn-default btn-xs">
            Lihat Semua <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>
      <div class="panel-body" style="padding: 0;">
        <div class="table-responsive">
          <table class="table table-hover" style="margin-bottom: 0;">
            <thead>
              <tr>
                <th width="8%" class="ctr">No</th>
                <th width="24%">Kode Permintaan</th>
                <th width="22%">Waktu Pengajuan</th>
                <?php if ($sess_level != 'user'): ?>
                  <th width="24%">Nama Pemohon</th>
                <?php endif; ?>
                <th width="22%" class="ctr">Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                if (!empty($recent_permintaan)) {
                  $no = 1;
                  foreach ($recent_permintaan as $rp) {
                    $isDone = !empty($rp->diserahkan);
                    $tglFormatted = !empty($rp->tgl) ? date('d M Y, H:i', strtotime($rp->tgl)) : '-';
              ?>
                <tr>
                  <td class="ctr" style="font-weight: 600; color: #64748b;"><?php echo $no; ?></td>
                  <td><span style="font-weight: 700; color: #0f172a;"><?php echo $rp->id_permintaan; ?></span></td>
                  <td style="color: #475569; font-size: 13px;"><?php echo $tglFormatted; ?></td>
                  <?php if ($sess_level != 'user'): ?>
                    <td style="font-weight: 600; color: #334155;"><?php echo !empty($rp->nama) ? $rp->nama : '-'; ?></td>
                  <?php endif; ?>
                  <td class="ctr">
                    <?php if ($isDone): ?>
                      <span class="stock-badge stock-badge-available"><i class="fa-solid fa-circle-check"></i> Sudah Diserahkan</span>
                    <?php else: ?>
                      <span class="stock-badge stock-badge-warning"><i class="fa-solid fa-hourglass-half"></i> Menunggu Penyerahan</span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php 
                    $no++;
                  }
                } else {
              ?>
                <tr>
                  <td colspan="<?php echo ($sess_level != 'user') ? '5' : '4'; ?>" class="ctr" style="padding: 30px; color: #94a3b8;">
                    <i class="fa-solid fa-box-open" style="font-size: 30px; margin-bottom: 8px; display: block;"></i>
                    Belum ada riwayat aktivitas permintaan barang.
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>
</div>