<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Dashboard - SIMANTIK</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">

<!-- Google Font: Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Font Awesome 6 Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Core CSS -->
<link href="<?php echo base_url(); ?>___/jquery-ui/jquery-ui.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>___/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>___/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo base_url(); ?>___/css/style.css" rel="stylesheet">

<!-- Core JS -->
<script src="<?php echo base_url(); ?>___/js/jquery-1.11.3.min.js"></script>
<script src="<?php echo base_url(); ?>___/jquery-ui/jquery-ui.js"></script>
<script src="<?php echo base_url(); ?>___/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>___/js/select2.min.js"></script>

<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function () {
  if ($("#tgl_mulai_laporan").length) {
    $("#tgl_mulai_laporan").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd'
    });
  }

  if ($("#tgl_selesai_laporan").length) {
    $("#tgl_selesai_laporan").datepicker({
      changeMonth: true,
      changeYear: true,
      dateFormat: 'yy-mm-dd'
    });
  }
});
</script>
</head>
<body>

<!-- Modern Fixed Top Navbar -->
<nav class="navbar navbar-simantik navbar-fixed-top">
  <div class="header-fluid-container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#simantikNavbar">
        <span class="sr-only">Toggle navigation</span>
        <i class="fa-solid fa-bars" style="color: #334155; font-size: 18px;"></i>
      </button>
      <a class="navbar-brand" href="<?php echo base_url(); ?>adm">
        <img src="<?php echo base_url(); ?>___/img/logo_simantik.svg" alt="SIMANTIK Logo" width="42" height="42" class="brand-logo-img" />
        <div class="brand-title-group">
          <span class="brand-name">SIMANTIK</span>
          <span class="brand-subtitle">Sistem Informasi Permintaan ATK/ART Kantor</span>
        </div>
      </a>
    </div>

    <div class="collapse navbar-collapse" id="simantikNavbar">
      <div class="navbar-right header-user-actions">
        <div class="user-profile-badge">
          <div class="user-avatar-circle">
            <?php 
              $nama_pendek = $this->session->userdata('admin_nama');
              echo strtoupper(substr($nama_pendek, 0, 1)); 
            ?>
          </div>
          <div class="user-info-text">
            <span class="user-name"><?php echo $this->session->userdata('admin_nama'); ?></span>
            <span class="user-meta">@<?php echo $this->session->userdata('admin_user'); ?> &bull; <?php echo strtoupper($this->session->userdata('admin_level')); ?></span>
          </div>
        </div>

        <div class="header-action-buttons" style="display: flex; gap: 8px;">
          <a href="#" onclick="return rubah_password();" class="btn btn-header-action" title="Ubah Password">
            <i class="fa-solid fa-key"></i> Ubah Password
          </a>
          <a href="<?php echo base_url(); ?>adm/logout" onclick="return confirm('Apakah Anda yakin ingin keluar dari SIMANTIK?');" class="btn btn-header-logout" title="Keluar">
            <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>

<?php 
$sess_level = $this->session->userdata('admin_level');
$uri2 = $this->uri->segment(2);

// Helper fungsi untuk menghasilkan ikon vektor outline modern (Lucide-style)
if (!function_exists('getNavSvgIcon')) {
  function getNavSvgIcon($key) {
    switch($key) {
      case 'dashboard':
        return '<svg class="nav-svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1.5"/><rect width="7" height="5" x="14" y="3" rx="1.5"/><rect width="7" height="9" x="14" y="12" rx="1.5"/><rect width="7" height="5" x="3" y="16" rx="1.5"/></svg>';
      case 'm_barang':
        return '<svg class="nav-svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>';
      case 'm_pegawai':
        return '<svg class="nav-svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>';
      case 'stok_barang':
        return '<svg class="nav-svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 8.35V20a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V8.35A2 2 0 0 1 3.26 6.5l8-3.2a2 2 0 0 1 1.48 0l8 3.2A2 2 0 0 1 22 8.35Z"/><path d="M6 18h12"/><path d="M6 14h12"/><rect width="12" height="12" x="6" y="10"/></svg>';
      case 'permintaan_barang':
        return '<svg class="nav-svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>';
      case 'kelola_permintaan_barang':
        return '<svg class="nav-svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>';
      case 'laporan_kumulatif':
        return '<svg class="nav-svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M8 18v-2"/><path d="M12 18v-4"/><path d="M16 18v-6"/></svg>';
      default:
        return '<svg class="nav-svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/></svg>';
    }
  }
}

$menu = array();

if ($sess_level == "user") {
  $menu = array(
    array("key"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
    array("key"=>"permintaan_barang", "url"=>"permintaan_barang", "text"=>"Ajukan Permintaan"),
  );
} else if ($sess_level == "admin_tu") {
  $menu = array(
    array("key"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
    array("key"=>"m_barang", "url"=>"m_barang", "text"=>"Master Barang"),
    array("key"=>"stok_barang", "url"=>"stok_barang", "text"=>"Stok Barang"),
    array("key"=>"permintaan_barang", "url"=>"permintaan_barang", "text"=>"Ajukan Permintaan"),
    array("key"=>"kelola_permintaan_barang", "url"=>"kelola_permintaan_barang", "text"=>"Kelola Permintaan"),
    array("key"=>"laporan_kumulatif", "url"=>"laporan_kumulatif", "text"=>"Laporan"),
  );
} else if ($sess_level == "admin") {
  $menu = array(
    array("key"=>"dashboard", "url"=>"", "text"=>"Dashboard"),
    array("key"=>"m_barang", "url"=>"m_barang", "text"=>"Master Barang"),
    array("key"=>"m_pegawai", "url"=>"m_pegawai", "text"=>"Master Pegawai"),
    array("key"=>"stok_barang", "url"=>"stok_barang", "text"=>"Stok Barang"),
    array("key"=>"permintaan_barang", "url"=>"permintaan_barang", "text"=>"Ajukan Permintaan"),
    array("key"=>"kelola_permintaan_barang", "url"=>"kelola_permintaan_barang", "text"=>"Kelola Permintaan"),
    array("key"=>"laporan_kumulatif", "url"=>"laporan_kumulatif", "text"=>"Laporan"),
  );
} else {
  $menu = array(
    array("key"=>"dashboard", "url"=>"", "text"=>"Dashboard")
  );
}
?>

<div class="container" style="margin-top: 90px;">

  <!-- Sleek Horizontal Navigation Bar -->
  <div class="simantik-nav-wrapper">
    <?php 
    foreach ($menu as $m) {
      $isActive = ($uri2 == $m['url']);
      $activeClass = $isActive ? 'active' : '';
      echo '<a href="'.base_url().'adm/'.$m['url'].'" class="simantik-nav-item '.$activeClass.'">';
      echo getNavSvgIcon($m['key']);
      echo '<span>'.$m['text'].'</span>';
      echo '</a>';
    }
    ?>
  </div>

  <!-- Page Content View -->
  <?php echo $this->load->view($p); ?>

  <!-- Clean Minimalist Footer -->
  <footer class="simantik-footer">
    &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url(); ?>adm">SIMANTIK</a> &bull; Sistem Informasi Permintaan Alat Tulis Kantor
  </footer>

  <!-- Container Modal -->
  <div id="tampilkan_modal"></div>

</div>

<!-- Core Application JS -->
<script src="<?php echo base_url(); ?>___/js/ajaxFileUpload.js"></script> 
<script src="<?php echo base_url(); ?>___/js/aplikasi.js"></script> 

</body>
</html>
