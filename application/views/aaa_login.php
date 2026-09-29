<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Login - SIMANTIK</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">

<!-- Google Fonts: Plus Jakarta Sans -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Font Awesome 6 Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<!-- Core Bootstrap & Base CSS -->
<link href="<?php echo base_url(); ?>___/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>___/css/style.css" rel="stylesheet">

<style>
* {
  box-sizing: border-box;
}

body.login-canvas {
  font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
  background-color: #f1f5f9;
  background-image: 
    radial-gradient(#cbd5e1 0.75px, transparent 0.75px),
    radial-gradient(#cbd5e1 0.75px, #f1f5f9 0.75px);
  background-size: 30px 30px;
  background-position: 0 0, 15px 15px;
  min-height: 100vh;
  margin: 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 32px 16px;
  position: relative;
}

/* Card Container */
.login-card-container {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 440px;
}

.login-card {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  padding: 36px 32px 32px;
  box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
}

/* Header & Logo */
.login-header {
  text-align: center;
  margin-bottom: 24px;
}

.login-logo-wrapper {
  width: 68px;
  height: 68px;
  margin: 0 auto 14px;
  border-radius: 16px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 10px;
}

.login-logo-wrapper img {
  width: 48px;
  height: 48px;
  object-fit: contain;
}

.login-institution-badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-size: 11.5px;
  font-weight: 700;
  color: #1e40af;
  background: #dbeafe;
  padding: 3px 10px;
  border-radius: 12px;
  margin-bottom: 8px;
  letter-spacing: 0.02em;
}

.login-title {
  font-size: 22px;
  font-weight: 800;
  color: #0f172a;
  letter-spacing: -0.02em;
  margin: 0 0 6px;
}

.login-subtitle {
  font-size: 13px;
  color: #475569;
  margin: 0;
  font-weight: 500;
  line-height: 1.45;
}

/* Alert Notification */
.login-alert-box {
  border-radius: 10px;
  font-size: 13px;
  font-weight: 500;
  padding: 12px 14px;
  margin-bottom: 20px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.login-alert-danger {
  background-color: #fef2f2;
  border: 1px solid #fecaca;
  color: #991b1b;
}

.login-alert-info {
  background-color: #eff6ff;
  border: 1px solid #bfdbfe;
  color: #1e40af;
}

.login-alert-success {
  background-color: #ecfdf5;
  border: 1px solid #a7f3d0;
  color: #065f46;
}

/* Form Fields */
.form-field-group {
  margin-bottom: 18px;
}

.field-label {
  display: block;
  font-size: 13px;
  font-weight: 700;
  color: #334155;
  margin-bottom: 6px;
}

.input-container {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon-left {
  position: absolute;
  left: 14px;
  color: #64748b;
  font-size: 14px;
  pointer-events: none;
  z-index: 2;
}

.modern-input {
  width: 100%;
  height: 44px;
  background: #ffffff;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  padding: 0 42px 0 40px;
  font-size: 13.5px;
  color: #0f172a;
  font-weight: 500;
  transition: border-color 0.15s ease, box-shadow 0.15s ease;
}

.modern-input:focus {
  border-color: #2563eb;
  outline: none;
  box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
}

.toggle-password-btn {
  position: absolute;
  right: 8px;
  background: none;
  border: none;
  color: #64748b;
  font-size: 14px;
  cursor: pointer;
  padding: 6px 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 6px;
  transition: color 0.15s ease;
  z-index: 2;
}

.toggle-password-btn:hover {
  color: #0f172a;
}

/* Submit Action Button */
.btn-login-submit {
  width: 100%;
  height: 44px;
  background: #1d4ed8;
  color: #ffffff;
  border: none;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  transition: background 0.15s ease, box-shadow 0.15s ease;
  margin-top: 10px;
}

.btn-login-submit:hover {
  background: #1e40af;
  box-shadow: 0 4px 12px rgba(29, 78, 216, 0.25);
}

.btn-login-submit:focus-visible {
  outline: 2px solid #1d4ed8;
  outline-offset: 2px;
}

.btn-login-submit:disabled {
  opacity: 0.75;
  cursor: not-allowed;
}

/* Footer Section */
.login-footer {
  text-align: center;
  margin-top: 20px;
  font-size: 12.5px;
  color: #475569;
  font-weight: 500;
}

.login-footer a {
  color: #1d4ed8;
  font-weight: 700;
  text-decoration: none;
}

.login-footer a:hover {
  text-decoration: underline;
}
</style>
</head>
<body class="login-canvas">

<div class="login-card-container">
  <div class="login-card">

    <!-- Brand Header -->
    <div class="login-header">
      <div class="login-logo-wrapper">
        <img src="<?php echo base_url(); ?>___/img/logo-bps.svg" alt="Logo BPS" width="48" height="48" />
      </div>
      <div class="login-institution-badge">
        <i class="fa-solid fa-building-columns"></i> BPS PROVINSI JAWA TENGAH
      </div>
      <h1 class="login-title">SIMANTIK</h1>
      <p class="login-subtitle">Sistem Informasi Permintaan ATK / ART Kantor</p>
    </div>

    <!-- Alert Container -->
    <div id="konfirmasi"></div>

    <!-- Login Form -->
    <form action="" method="post" name="fl" id="f_login">
      
      <div class="form-field-group">
        <label for="username" class="field-label">Username</label>
        <div class="input-container">
          <input type="text" id="username" name="username" autofocus value="" placeholder="Masukkan username Anda" class="modern-input" autocomplete="username" required />
          <i class="fa-regular fa-user input-icon-left"></i>
        </div>
      </div>

      <div class="form-field-group">
        <label for="password" class="field-label">Password</label>
        <div class="input-container">
          <input type="password" id="password" name="password" value="" placeholder="Masukkan password Anda" class="modern-input" autocomplete="current-password" required />
          <i class="fa-solid fa-lock input-icon-left"></i>
          <button type="button" class="toggle-password-btn" onclick="togglePasswordVisibility();" title="Tampilkan/Sembunyikan Password" tabindex="-1">
            <i class="fa-regular fa-eye" id="eyeIcon"></i>
          </button>
        </div>
      </div>

      <button type="submit" id="btn_submit" class="btn-login-submit">
        <span>Masuk ke Akun</span>
        <i class="fa-solid fa-arrow-right"></i>
      </button>

    </form>

  </div>

  <!-- Footer -->
  <div class="login-footer">
    &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url(); ?>adm">SIMANTIK</a> &bull; Badan Pusat Statistik Provinsi Jawa Tengah
  </div>
</div>

<!-- Placed at the end so the pages load faster -->
<script src="<?php echo base_url(); ?>___/js/jquery-1.11.3.min.js"></script> 
<script src="<?php echo base_url(); ?>___/js/bootstrap.js"></script>

<script type="text/javascript">
function togglePasswordVisibility() {
  var pwdInput = document.getElementById("password");
  var eyeIcon = document.getElementById("eyeIcon");
  if (pwdInput.type === "password") {
    pwdInput.type = "text";
    eyeIcon.classList.remove("fa-eye");
    eyeIcon.classList.add("fa-eye-slash");
  } else {
    pwdInput.type = "password";
    eyeIcon.classList.remove("fa-eye-slash");
    eyeIcon.classList.add("fa-eye");
  }
}

$("#f_login").submit(function(event) {
  event.preventDefault();
  var data = $('#f_login').serialize();
  var submitBtn = $('#btn_submit');
  
  submitBtn.prop('disabled', true).html('<i class="fa-solid fa-circle-notch fa-spin"></i> Memverifikasi...');
  $("#konfirmasi").html('');

  $.ajax({
    type: "POST",
    data: data,
    url: "<?php echo base_url(); ?>adm/act_login",
    dataType: "json",
    success: function(r) {
      if (!r || !r.log || r.log.status == 0) {
        submitBtn.prop('disabled', false).html('<span>Masuk ke Akun</span> <i class="fa-solid fa-arrow-right"></i>');
        var msg = (r && r.log && r.log.keterangan) ? r.log.keterangan : "Username atau password tidak sesuai";
        $("#konfirmasi").html('<div class="login-alert-box login-alert-danger"><i class="fa-solid fa-circle-exclamation"></i> <span>' + msg + '</span></div>');
      } else {
        submitBtn.html('<i class="fa-solid fa-check"></i> Berhasil Masuk...');
        $("#konfirmasi").html('<div class="login-alert-box login-alert-success"><i class="fa-solid fa-circle-check"></i> <span>' + r.log.keterangan + '. Mengalihkan...</span></div>');
        setTimeout(function() {
          window.location.assign("<?php echo base_url(); ?>adm"); 
        }, 500);
      }
    },
    error: function() {
      submitBtn.prop('disabled', false).html('<span>Masuk ke Akun</span> <i class="fa-solid fa-arrow-right"></i>');
      $("#konfirmasi").html('<div class="login-alert-box login-alert-danger"><i class="fa-solid fa-triangle-exclamation"></i> <span>Gagal menghubungi server. Silakan coba lagi.</span></div>');
    }
  });
});
</script>
</body>
</html>