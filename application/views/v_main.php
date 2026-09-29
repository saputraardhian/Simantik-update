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

$banner_img = file_exists(FCPATH . '___/img/banner.png') ? '___/img/banner.png' : '___/img/alur_simantik.jpg';
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
        <h2 class="hero-title"><?php echo $sapaan; ?>, <?php echo htmlspecialchars($sess_nama); ?>!</h2>
        <p class="hero-subtitle">
          Selamat datang di <strong>SIMANTIK</strong>. Portal pengajuan kebutuhan perlengkapan kantor (ATK/ART) BPS Provinsi Jawa Tengah secara transparan dan tertib administrasi.
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

    <!-- 3. Alur Pelayanan Permintaan ATK/ART (Banner Infografis Resmi) -->
    <div class="panel panel-default">
      <div class="panel-heading" style="display: flex; align-items: center; justify-content: space-between;">
        <h4><i class="fa-solid fa-route" style="color: var(--primary);"></i> Alur Layanan Permintaan Barang ATK/ART</h4>
        <a href="<?php echo base_url(); ?>adm/permintaan_barang" class="btn btn-primary btn-xs">
          <i class="fa-solid fa-cart-plus"></i> Ajukan Permintaan
        </a>
      </div>
      <div class="panel-body text-center" style="padding: 16px;">
        <div style="background: #ffffff; border-radius: 14px; padding: 10px; display: inline-block; max-width: 100%; border: 1px solid #e2e8f0; box-shadow: 0 4px 16px -2px rgba(15, 23, 42, 0.06); cursor: pointer;" data-toggle="modal" data-target="#modalZoomBanner" title="Ketuk untuk melihat ukuran penuh">
          <img src="<?php echo base_url($banner_img); ?>?v=<?php echo time(); ?>" alt="Alur Layanan SIMANTIK" class="img-responsive" style="margin: 0 auto; max-width: 100%; height: auto; border-radius: 8px;">
        </div>

        <div style="margin-top: 10px;">
          <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalZoomBanner" style="border-radius: 20px; font-weight: 600; padding: 5px 14px; color: #334155;">
            <i class="fa-solid fa-magnifying-glass-plus" style="color: var(--primary);"></i> Ketuk untuk Perbesar Gambar HD
          </button>
        </div>

        <!-- Panduan 6 Langkah Teks Ringkas Khusus Layar HP (Sangat Nyaman Dibaca) -->
        <div class="visible-xs" style="margin-top: 20px; text-align: left;">
          <div style="font-weight: 700; font-size: 13px; color: #1e293b; margin-bottom: 10px; display: flex; align-items: center; gap: 6px;">
            <i class="fa-solid fa-list-check" style="color: var(--primary);"></i> Rincian 6 Langkah Alur Layanan:
          </div>

          <div style="display: flex; flex-direction: column; gap: 8px;">
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; display: flex; gap: 10px; align-items: flex-start;">
              <span style="background: #2563eb; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">1</span>
              <div>
                <strong style="font-size: 12.5px; color: #0f172a;">Login ke SIMANTIK</strong>
                <p style="margin: 2px 0 0; font-size: 11.5px; color: #64748b;">Buka SIMANTIK. Masukkan Username & Password (centang <em>Login PPNPN</em> bila Non-PNS).</p>
              </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; display: flex; gap: 10px; align-items: flex-start;">
              <span style="background: #2563eb; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">2</span>
              <div>
                <strong style="font-size: 12.5px; color: #0f172a;">Pilih Menu Ajukan Permintaan</strong>
                <p style="margin: 2px 0 0; font-size: 11.5px; color: #64748b;">Masuk ke menu <strong>Ajukan Permintaan</strong>, lalu klik tombol hijau <strong>+ Jenis Barang</strong>.</p>
              </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; display: flex; gap: 10px; align-items: flex-start;">
              <span style="background: #2563eb; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">3</span>
              <div>
                <strong style="font-size: 12.5px; color: #0f172a;">Cari & Pilih Barang ATK</strong>
                <p style="margin: 2px 0 0; font-size: 11.5px; color: #64748b;">Ketik nama barang pada kolom pencarian. Status ketersediaan stok fisik gudang divalidasi otomatis.</p>
              </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; display: flex; gap: 10px; align-items: flex-start;">
              <span style="background: #2563eb; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">4</span>
              <div>
                <strong style="font-size: 12.5px; color: #0f172a;">Tentukan Jumlah & Simpan</strong>
                <p style="margin: 2px 0 0; font-size: 11.5px; color: #64748b;">Masukkan kuantitas barang yang diperlukan, lalu klik tombol biru <strong>Simpan</strong>.</p>
              </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; display: flex; gap: 10px; align-items: flex-start;">
              <span style="background: #2563eb; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">5</span>
              <div>
                <strong style="font-size: 12.5px; color: #0f172a;">Cetak Bukti Permintaan</strong>
                <p style="margin: 2px 0 0; font-size: 11.5px; color: #64748b;">Pada tabel Riwayat Permintaan, klik tombol kuning <strong>Cetak</strong> untuk mengunduh/mencetak formulir A4.</p>
              </div>
            </div>

            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 10px 12px; display: flex; gap: 10px; align-items: flex-start;">
              <span style="background: #2563eb; color: #fff; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; flex-shrink: 0;">6</span>
              <div>
                <strong style="font-size: 12.5px; color: #0f172a;">Ambil Barang di Gudang</strong>
                <p style="margin: 2px 0 0; font-size: 11.5px; color: #64748b;">Bawa formulir cetak ke pengelola gudang BPS Jateng untuk diverifikasi dan diserahterimakan fisik barangnya.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- Modal Zoom Infografis HD -->
    <div class="modal fade" id="modalZoomBanner" tabindex="-1" role="dialog" aria-labelledby="modalZoomBannerLabel">
      <div class="modal-dialog modal-lg" role="document" style="max-width: 95%;">
        <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
          <div class="modal-header" style="background: #ffffff; padding: 14px 20px; border-bottom: 1px solid #e2e8f0;">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="font-size: 24px;">&times;</button>
            <h4 class="modal-title" id="modalZoomBannerLabel" style="font-size: 15px; font-weight: 700; color: #0f172a;">
              <i class="fa-solid fa-route" style="color: var(--primary);"></i> Alur Layanan SIMANTIK (Ukuran Penuh)
            </h4>
          </div>
          <div class="modal-body text-center" style="padding: 10px; overflow-x: auto; background: #0f172a;">
            <img src="<?php echo base_url($banner_img); ?>?v=<?php echo time(); ?>" alt="Alur Layanan SIMANTIK HD" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.3);">
          </div>
          <div class="modal-footer" style="padding: 10px 16px; background: #f8fafc; border-top: 1px solid #e2e8f0;">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa-solid fa-xmark"></i> Tutup</button>
            <a href="<?php echo base_url($banner_img); ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa-solid fa-arrow-up-right-from-square"></i> Buka Gambar Asli</a>
          </div>
        </div>
      </div>
    </div>

    <!-- 4. Riwayat Permintaan Terakhir -->
    <div class="panel panel-default">
      <div class="panel-heading" style="display: flex; align-items: center; justify-content: space-between;">
        <h4><i class="fa-solid fa-clock-rotate-left" style="color: var(--primary);"></i> Riwayat Permintaan Terkini</h4>
        <div class="panel-action">
          <a href="<?php echo base_url(); ?>adm/<?php echo ($sess_level == 'user') ? 'permintaan_barang' : 'kelola_permintaan_barang'; ?>" class="btn btn-default btn-xs">
            Lihat Semua <i class="fa-solid fa-arrow-right"></i>
          </a>
        </div>
      </div>
      <div class="panel-body" style="padding: 0;">
        <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch; border: none;">
          <table class="table table-hover" style="margin-bottom: 0; min-width: 540px; white-space: nowrap;">
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
                  <td colspan="<?php echo ($sess_level != 'user') ? '5' : '4'; ?>" class="ctr" style="padding: 30px; color: #475569;">
                    <i class="fa-solid fa-box-open" style="font-size: 30px; margin-bottom: 8px; display: block; color: #94a3b8;"></i>
                    <span style="font-size: 13.5px; font-weight: 500;">Belum ada riwayat aktivitas permintaan barang.</span>
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