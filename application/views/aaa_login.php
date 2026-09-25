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
  background-color: #0f172a;
  background-image: 
    radial-gradient(at 0% 0%, rgba(37, 99, 235, 0.25) 0px, transparent 50%),
    radial-gradient(at 100% 100%, rgba(99, 102, 241, 0.2) 0px, transparent 50%),
    radial-gradient(at 50% 50%, rgba(14, 165, 233, 0.12) 0px, transparent 60%);
  min-height: 100vh;
  margin: 0;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  padding: 30px 16px;
  position: relative;
  overflow-x: hidden;
}

/* Subtle glowing background orbs */
.orb-glow-1 {
  position: absolute;
  top: -100px;
  left: -100px;
  width: 450px;
  height: 450px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(37, 99, 235, 0.18) 0%, rgba(37, 99, 235, 0) 70%);
  pointer-events: none;
  z-index: 0;
}

.orb-glow-2 {
  position: absolute;
  bottom: -100px;
  right: -100px;
  width: 420px;
  height: 420px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(14, 165, 233, 0.15) 0%, rgba(14, 165, 233, 0) 70%);
  pointer-events: none;
  z-index: 0;
}

/* Main Login Container Card */
.login-card-container {
  position: relative;
  z-index: 1;
  width: 100%;
  max-width: 440px;
}

.login-card {
  background: #ffffff;
  border: 1px solid rgba(226, 232, 240, 0.9);
  border-radius: 24px;
  padding: 40px 36px 36px;
  box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.35), 0 0 0 1px rgba(255, 255, 255, 0.1);
  transition: all 0.25s ease;
}

/* Header & Logo */
.login-header {
  text-align: center;
  margin-bottom: 28px;
}

.login-logo-wrapper {
  width: 72px;
  height: 72px;
  margin: 0 auto 16px;
  border-radius: 20px;
  background: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 12px 28px -6px rgba(37, 99, 235, 0.22), 0 0 0 1px rgba(37, 99, 235, 0.1);
  padding: 8px;
}

.login-logo-wrapper img {
  width: 54px;
  height: 54px;
  object-fit: contain;
}

.login-title {
  font-size: 24px;
  font-weight: 800;
  color: #0f172a;
  letter-spacing: -0.025em;
  margin: 0 0 6px;
}

.login-subtitle {
  font-size: 13.5px;
  color: #64748b;
  margin: 0;
  font-weight: 500;
  line-height: 1.45;
}

/* Alert Notification */
.login-alert-box {
  border-radius: 12px;
  font-size: 13px;
  font-weight: 500;
  padding: 12px 16px;
  margin-bottom: 22px;
  display: flex;
  align-items: center;
  gap: 10px;
  animation: slideInDown 0.25s ease forwards;
}

.login-alert-danger {
  background-color: #fef2f2;
  border: 1px solid #fecaca;
  color: #b91c1c;
}

.login-alert-info {
  background-color: #eff6ff;
  border: 1px solid #bfdbfe;
  color: #1d4ed8;
}

.login-alert-success {
  background-color: #ecfdf5;
  border: 1px solid #a7f3d0;
  color: #047857;
}

/* Form Fields */
.form-field-group {
  margin-bottom: 20px;
}

.field-label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: #334155;
  margin-bottom: 8px;
  letter-spacing: -0.01em;
}

.input-container {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon-left {
  position: absolute;
  left: 15px;
  color: #94a3b8;
  font-size: 15px;
  pointer-events: none;
  transition: color 0.15s ease;
  z-index: 2;
}

.modern-input {
  width: 100%;
  height: 48px;
  background: #f8fafc;
  border: 1px solid #cbd5e1;
  border-radius: 12px;
  padding: 0 46px 0 44px;
  font-size: 14px;
  color: #0f172a;
  font-weight: 500;
  transition: all 0.2s ease;
}

.modern-input:focus {
  background: #ffffff;
  border-color: #2563eb;
  outline: none;
  box-shadow: 0 0 0 3.5px rgba(37, 99, 235, 0.15);
}

.modern-input:focus ~ .input-icon-left {
  color: #2563eb;
}

.toggle-password-btn {
  position: absolute;
  right: 12px;
  background: none;
  border: none;
  color: #94a3b8;
  font-size: 15px;
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
  color: #1e293b;
}

/* Submit Action Button */
.btn-login-submit {
  width: 100%;
  height: 50px;
  background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
  color: #ffffff;
  border: none;
  border-radius: 12px;
  font-size: 14.5px;
  font-weight: 700;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  box-shadow: 0 10px 22px -4px rgba(37, 99, 235, 0.4);
  transition: all 0.2s ease;
  margin-top: 12px;
}

.btn-login-submit:hover {
  background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
  box-shadow: 0 12px 26px -4px rgba(37, 99, 235, 0.5);
  transform: translateY(-1px);
}

.btn-login-submit:active {
  transform: translateY(0);
}

.btn-login-submit:disabled {
  opacity: 0.75;
  cursor: not-allowed;
  transform: none;
}

/* Footer Section */
.login-footer {
  text-align: center;
  margin-top: 24px;
  font-size: 12.5px;
  color: #94a3b8;
  position: relative;
  z-index: 1;
}

.login-footer a {
  color: #60a5fa;
  font-weight: 600;
  text-decoration: none;
  transition: color 0.15s ease;
}

.login-footer a:hover {
  color: #93c5fd;
  text-decoration: underline;
}

@keyframes slideInDown {
  from {
    opacity: 0;
    transform: translateY(-8px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>
</head>
<body class="login-canvas">

<div class="orb-glow-1"></div>
<div class="orb-glow-2"></div>

<div class="login-card-container">
  <div class="login-card">

    <!-- Brand Header -->
    <div class="login-header">
      <div class="login-logo-wrapper">
        <img src="<?php echo base_url(); ?>___/img/logo_simantik.svg" alt="SIMANTIK Logo" width="54" height="54" />
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
    &copy; <?php echo date('Y'); ?> <a href="<?php echo base_url(); ?>adm">SIMANTIK</a> &bull; BPS Provinsi Jawa Tengah
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