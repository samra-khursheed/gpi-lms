<?php
session_start();
include 'includes/db.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM lms_user WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Support both plain text and md5 passwords
        if ($user['password'] === $password || $user['password'] === md5($password)) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email']= $user['email'];
            $_SESSION['permission']= $user['permission'];

            $perm = strtolower(trim($user['permission']));
            if ($perm == 'admin' || $user['admin_'] == 1) {
                header("Location: admin/dashboard.php");
            } elseif ($perm == 'faculty' || $perm == 'teacher') {
                header("Location: faculty/dashboard.php");
            } else {
                header("Location: student/dashboard.php");
            }
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with this email.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LMS — Sign In</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --navy:   #0a0f2c;
    --blue:   #1a56db;
    --sky:    #60a5fa;
    --accent: #f59e0b;
    --white:  #ffffff;
    --light:  #f1f5f9;
    --muted:  #94a3b8;
    --error:  #ef4444;
  }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--navy);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
  }

  /* Animated background blobs */
  body::before {
    content: '';
    position: fixed;
    top: -30%;
    right: -20%;
    width: 60vw;
    height: 60vw;
    background: radial-gradient(circle, rgba(26,86,219,0.35) 0%, transparent 70%);
    border-radius: 50%;
    animation: drift 8s ease-in-out infinite alternate;
  }
  body::after {
    content: '';
    position: fixed;
    bottom: -20%;
    left: -15%;
    width: 50vw;
    height: 50vw;
    background: radial-gradient(circle, rgba(245,158,11,0.15) 0%, transparent 70%);
    border-radius: 50%;
    animation: drift 10s ease-in-out infinite alternate-reverse;
  }
  @keyframes drift {
    from { transform: translate(0,0) scale(1); }
    to   { transform: translate(30px,20px) scale(1.05); }
  }

  .wrapper {
    display: flex;
    width: 900px;
    max-width: 95vw;
    min-height: 520px;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 40px 80px rgba(0,0,0,0.5);
    position: relative;
    z-index: 1;
    animation: slideUp 0.7s cubic-bezier(.22,1,.36,1) both;
  }
  @keyframes slideUp {
    from { opacity:0; transform: translateY(40px); }
    to   { opacity:1; transform: translateY(0); }
  }

  /* LEFT PANEL */
  .panel-left {
    flex: 1;
    background: linear-gradient(145deg, #1a56db 0%, #0a0f2c 100%);
    padding: 56px 48px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
  }
  .panel-left::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    border: 2px solid rgba(255,255,255,0.08);
    border-radius: 50%;
  }
  .panel-left::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 180px; height: 180px;
    border: 2px solid rgba(255,255,255,0.06);
    border-radius: 50%;
  }
  .brand {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .brand-icon {
    width: 44px; height: 44px;
    background: var(--accent);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
  }
  .brand-name {
    font-family: 'Syne', sans-serif;
    font-weight: 800;
    font-size: 22px;
    color: white;
    letter-spacing: -0.5px;
  }
  .brand-name span { color: var(--accent); }

  .hero-text { position: relative; z-index: 1; }
  .hero-text h1 {
    font-family: 'Syne', sans-serif;
    font-size: 38px;
    font-weight: 800;
    color: white;
    line-height: 1.15;
    margin-bottom: 16px;
  }
  .hero-text h1 span { color: var(--accent); }
  .hero-text p {
    color: rgba(255,255,255,0.65);
    font-size: 15px;
    line-height: 1.6;
  }

  .stats {
    display: flex;
    gap: 24px;
    position: relative;
    z-index: 1;
  }
  .stat {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 12px;
    padding: 14px 18px;
  }
  .stat-num {
    font-family: 'Syne', sans-serif;
    font-size: 22px;
    font-weight: 800;
    color: var(--accent);
  }
  .stat-label {
    font-size: 11px;
    color: rgba(255,255,255,0.55);
    margin-top: 2px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  /* RIGHT PANEL */
  .panel-right {
    width: 380px;
    background: var(--white);
    padding: 52px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .panel-right h2 {
    font-family: 'Syne', sans-serif;
    font-size: 26px;
    font-weight: 700;
    color: var(--navy);
    margin-bottom: 6px;
  }
  .panel-right p {
    color: var(--muted);
    font-size: 14px;
    margin-bottom: 32px;
  }

  .error-box {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: var(--error);
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 13.5px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .form-group { margin-bottom: 20px; }
  .form-group label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: #374151;
    margin-bottom: 7px;
    letter-spacing: 0.2px;
  }
  .form-group input {
    width: 100%;
    padding: 12px 16px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    color: var(--navy);
    background: var(--light);
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
  }
  .form-group input:focus {
    border-color: var(--blue);
    background: white;
    box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
  }

  .btn {
    width: 100%;
    padding: 14px;
    background: var(--blue);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 600;
    font-family: 'Syne', sans-serif;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s, box-shadow 0.2s;
    letter-spacing: 0.3px;
    margin-top: 8px;
  }
  .btn:hover {
    background: #1740a8;
    box-shadow: 0 8px 20px rgba(26,86,219,0.35);
    transform: translateY(-1px);
  }
  .btn:active { transform: translateY(0); }

  .register-link {
    text-align: center;
    margin-top: 22px;
    font-size: 13.5px;
    color: var(--muted);
  }
  .register-link a {
    color: var(--blue);
    font-weight: 600;
    text-decoration: none;
  }
  .register-link a:hover { text-decoration: underline; }

  @media (max-width: 700px) {
    .panel-left { display: none; }
    .panel-right { width: 100%; padding: 40px 28px; }
  }
</style>
</head>
<body>
<div class="wrapper">
  <!-- LEFT -->
  <div class="panel-left">
    <div class="brand">
      <div class="brand-icon">🎓</div>
      <div class="brand-name">Learn<span>MS</span></div>
    </div>
    <div class="hero-text">
      <h1>Your Learning<br><span>Starts Here</span></h1>
      <p>Access your courses, assignments, and academic progress all in one place.</p>
    </div>
    <div class="stats">
      <div class="stat">
        <div class="stat-num">3</div>
        <div class="stat-label">Roles</div>
      </div>
      <div class="stat">
        <div class="stat-num">∞</div>
        <div class="stat-label">Courses</div>
      </div>
      <div class="stat">
        <div class="stat-num">24/7</div>
        <div class="stat-label">Access</div>
      </div>
    </div>
  </div>

  <!-- RIGHT -->
  <div class="panel-right">
    <h2>Welcome back</h2>
    <p>Sign in to your account to continue</p>

    <?php if ($error): ?>
      <div class="error-box">⚠️ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" placeholder="you@example.com" required
               value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
      </div>
      <div class="form-group">
        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="btn">Sign In →</button>
    </form>

    <div class="register-link">
      Don't have an account? <a href="register.php">Register</a>
    </div>
  </div>
</div>
</body>
</html>
