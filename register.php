<?php
session_start();
include 'includes/db.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $mobile   = mysqli_real_escape_string($conn, $_POST['mobile']);
    $permission = 'student'; // default role

    // Check duplicate email
    $check = mysqli_query($conn, "SELECT id FROM lms_user WHERE email='$email' OR username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = "Email or username already exists.";
    } else {
        $date = date('Y-m-d');
        $sql = "INSERT INTO lms_user (name, username, password, email, mobile, permission, date, admin_)
                VALUES ('$name','$username','$password','$email','$mobile','$permission','$date',0)";
        if (mysqli_query($conn, $sql)) {
            $success = "Account created! <a href='login.php'>Sign in now</a>";
        } else {
            $error = "Registration failed: " . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LMS — Register</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --navy: #0a0f2c; --blue: #1a56db; --accent: #f59e0b;
    --white: #ffffff; --light: #f1f5f9; --muted: #94a3b8; --error: #ef4444; --green: #10b981;
  }
  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--navy);
    min-height: 100vh;
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
  }
  body::before {
    content: ''; position: fixed; top: -30%; right: -20%;
    width: 60vw; height: 60vw;
    background: radial-gradient(circle, rgba(26,86,219,0.3) 0%, transparent 70%);
    border-radius: 50%; animation: drift 8s ease-in-out infinite alternate;
  }
  @keyframes drift { from{transform:translate(0,0)} to{transform:translate(30px,20px)} }

  .card {
    background: white; border-radius: 20px;
    padding: 48px 44px; width: 460px; max-width: 95vw;
    position: relative; z-index: 1;
    box-shadow: 0 40px 80px rgba(0,0,0,0.4);
    animation: slideUp 0.6s cubic-bezier(.22,1,.36,1) both;
  }
  @keyframes slideUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }

  .logo { display:flex; align-items:center; gap:10px; margin-bottom:28px; }
  .logo-icon { width:38px; height:38px; background:var(--blue); border-radius:10px; display:flex; align-items:center; justify-content:center; font-size:18px; }
  .logo-name { font-family:'Syne',sans-serif; font-weight:800; font-size:18px; color:var(--navy); }
  .logo-name span { color:var(--blue); }

  h2 { font-family:'Syne',sans-serif; font-size:24px; font-weight:700; color:var(--navy); margin-bottom:6px; }
  .sub { color:var(--muted); font-size:14px; margin-bottom:28px; }

  .row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
  .form-group { margin-bottom:16px; }
  label { display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:6px; }
  input {
    width:100%; padding:11px 14px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-size:14px; font-family:'DM Sans',sans-serif;
    background:var(--light); color:var(--navy); outline:none;
    transition:border-color 0.2s, box-shadow 0.2s;
  }
  input:focus { border-color:var(--blue); background:white; box-shadow:0 0 0 3px rgba(26,86,219,0.1); }

  .msg {
    border-radius:9px; padding:11px 14px;
    font-size:13.5px; margin-bottom:18px;
    display:flex; align-items:center; gap:8px;
  }
  .msg.error { background:#fef2f2; border:1px solid #fecaca; color:var(--error); }
  .msg.success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
  .msg.success a { color:var(--blue); font-weight:600; }

  .btn {
    width:100%; padding:13px; background:var(--blue); color:white;
    border:none; border-radius:9px; font-size:15px; font-weight:600;
    font-family:'Syne',sans-serif; cursor:pointer; margin-top:6px;
    transition:background 0.2s, transform 0.1s, box-shadow 0.2s;
  }
  .btn:hover { background:#1740a8; box-shadow:0 8px 20px rgba(26,86,219,0.3); transform:translateY(-1px); }

  .login-link { text-align:center; margin-top:20px; font-size:13.5px; color:var(--muted); }
  .login-link a { color:var(--blue); font-weight:600; text-decoration:none; }
  .login-link a:hover { text-decoration:underline; }
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <div class="logo-icon">🎓</div>
    <div class="logo-name">Learn<span>MS</span></div>
  </div>
  <h2>Create Account</h2>
  <p class="sub">Register as a student to get started</p>

  <?php if ($error): ?>
    <div class="msg error">⚠️ <?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <?php if ($success): ?>
    <div class="msg success">✅ <?= $success ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="row">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" placeholder="Sara Ahmed" required>
      </div>
      <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" placeholder="sara123" required>
      </div>
    </div>
    <div class="form-group">
      <label>Email Address</label>
      <input type="email" name="email" placeholder="sara@example.com" required>
    </div>
    <div class="row">
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <div class="form-group">
        <label>Mobile</label>
        <input type="text" name="mobile" placeholder="03001234567">
      </div>
    </div>
    <button type="submit" class="btn">Create Account →</button>
  </form>
  <div class="login-link">Already have an account? <a href="login.php">Sign In</a></div>
</div>
</body>
</html>
