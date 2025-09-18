<?php
/* PUBLIC_HEADER_CANONICAL */
if (function_exists('ob_get_level') && ob_get_level() === 0) { ob_start(); }
$islogin    = isset($islogin) ? (bool)$islogin
           : ((isset($login) && is_object($login) && method_exists($login,'isLogin')) ? $login->isLogin() : false);
$page_title = $page_title ?? 'Home';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="/css/style.css?v=<?= time() ?>">
  <link rel="stylesheet" href="/css/styletiny.css?v=<?= time() ?>">
  <link rel="stylesheet" href="/css/lightbox.css?v=<?= time() ?>">
  <link rel="stylesheet" href="/css/blinking.css?v=<?= time() ?>">
</head>
<body>
<header class="site-header" style="padding:10px 0;border-bottom:1px solid #eee;">
  <div class="container" style="max-width:1080px;margin:0 auto;display:flex;align-items:center;gap:16px;">
    <a class="brand" href="/" style="font-weight:bold;text-decoration:none;">AFSOH</a>
    <nav class="site-nav" style="display:flex;gap:12px;">
      <a href="/" style="text-decoration:none;">Home</a>
      <a href="/conferences.php" style="text-decoration:none;">Conferences</a>
      <a href="/membership.php" style="text-decoration:none;">Membership</a>
      <a href="/contact.php" style="text-decoration:none;">Contact</a>
      <a href="/admin/login.php" style="text-decoration:none;">Admin</a>
    </nav>
<!-- AUTH_ACTIONS_START -->
<div class="auth-actions" style="margin-left:auto;display:flex;gap:12px;align-items:center;">
  <?php if (!empty($islogin)) : ?>
    <a href="/logout.php" style="text-decoration:none;">Logout</a>
  <?php else: ?>
    <a href="/login.php" style="text-decoration:none;">Login</a>
    <a href="#" id="open-login" style="text-decoration:none;">Quick login</a>
  <?php endif; ?>
</div>
<!-- AUTH_ACTIONS_END -->

  </div>
</header>
<!-- LOGIN_MODAL_START -->
<div id="login-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:1000;">
  <div class="modal-dialog" role="dialog" aria-modal="true"
       style="background:#fff;max-width:420px;margin:10vh auto;padding:24px;border-radius:10px;box-shadow:0 10px 30px rgba(0,0,0,0.2);position:relative;">
    <button type="button" id="close-login" aria-label="Close"
            style="position:absolute;right:12px;top:10px;border:0;background:transparent;font-size:22px;line-height:1;cursor:pointer">&times;</button>
    <h2 style="margin:0 0 12px 0;">Member login</h2>
    <form method="post" action="/login.php" autocomplete="off" style="display:grid;gap:12px;">
      <label style="display:grid;gap:6px;">
        <span>Username</span>
        <input type="text" name="username" required
               style="padding:10px;border:1px solid #ccc;border-radius:8px;width:100%;">
      </label>
      <label style="display:grid;gap:6px;">
        <span>Password</span>
        <input type="password" name="passwd" required
               style="padding:10px;border:1px solid #ccc;border-radius:8px;width:100%;">
      </label>
      <button type="submit" style="padding:10px 14px;border:0;border-radius:8px;cursor:pointer;">
        Sign in
      </button>
    </form>
    <p style="margin-top:8px;font-size:.9rem;">
      <a href="/forgotpassword.php">Forgot password?</a>
    </p>
  </div>
</div>
<script>
(function(){
  var open = document.getElementById('open-login');
  var modal = document.getElementById('login-modal');
  var close = document.getElementById('close-login');
  function show(){ if(modal){ modal.style.display='block'; document.body.style.overflow='hidden'; } }
  function hide(){ if(modal){ modal.style.display='none'; document.body.style.overflow=''; } }
  if (open)  open.addEventListener('click', function(e){ e.preventDefault(); show(); });
  if (close) close.addEventListener('click', hide);
  if (modal) modal.addEventListener('click', function(e){ if(e.target===modal){ hide(); }});
  document.addEventListener('keydown', function(e){ if(e.key==='Escape'){ hide(); }});
})();
</script>
<!-- LOGIN_MODAL_END -->