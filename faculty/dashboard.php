<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
include '../includes/db.php';

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_user WHERE id=$user_id"));

// Try to find matching faculty record by email
$faculty = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_faculty WHERE email='" . mysqli_real_escape_string($conn, $user['email']) . "'"));

$total_courses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM lms_courses WHERE course_status='active'"))['c'];
$total_students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM lms_user WHERE permission='student'"))['c'];
$courses = mysqli_query($conn, "SELECT * FROM lms_courses WHERE course_status='active' ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Faculty Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
  :root { --navy:#0a0f2c; --blue:#1a56db; --accent:#f59e0b; --purple:#7c3aed; --white:#fff; --light:#f1f5f9; --muted:#94a3b8; }
  body { font-family:'DM Sans',sans-serif; background:#f8fafc; color:#1e293b; }

  .header { background:linear-gradient(135deg,var(--navy) 0%,#2d1b69 100%); padding:0 32px; display:flex; align-items:center; justify-content:space-between; height:64px; position:sticky; top:0; z-index:50; }
  .header-logo { display:flex; align-items:center; gap:10px; }
  .header-logo .ico { width:32px; height:32px; background:var(--purple); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:16px; }
  .header-logo .name { font-family:'Syne',sans-serif; font-weight:800; font-size:16px; color:white; }
  .header-logo .name span { color:#a78bfa; }
  .header-right { display:flex; align-items:center; gap:16px; }
  .welcome { color:rgba(255,255,255,0.7); font-size:14px; }
  .welcome strong { color:white; }
  .btn-logout { padding:7px 16px; background:rgba(255,255,255,0.1); color:white; border:1px solid rgba(255,255,255,0.2); border-radius:7px; font-size:13px; cursor:pointer; text-decoration:none; }
  .btn-logout:hover { background:rgba(255,255,255,0.2); }

  .hero { background:linear-gradient(135deg,#7c3aed 0%,#0a0f2c 100%); padding:48px 32px; color:white; }
  .hero h1 { font-family:'Syne',sans-serif; font-size:30px; font-weight:800; margin-bottom:6px; }
  .hero h1 span { color:#c4b5fd; }
  .hero p { color:rgba(255,255,255,0.7); font-size:15px; }
  .hero-stats { display:flex; gap:20px; margin-top:24px; }
  .hstat { background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:12px; padding:14px 20px; }
  .hstat-num { font-family:'Syne',sans-serif; font-size:24px; font-weight:800; color:#c4b5fd; }
  .hstat-label { font-size:12px; color:rgba(255,255,255,0.6); margin-top:2px; }

  .main { padding:32px; max-width:1100px; margin:0 auto; }
  .section-title { font-family:'Syne',sans-serif; font-size:18px; font-weight:700; color:var(--navy); margin-bottom:18px; }

  .profile-card { background:white; border-radius:14px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.06); margin-bottom:28px; display:flex; align-items:center; gap:20px; }
  .profile-avatar { width:60px; height:60px; border-radius:50%; background:var(--purple); color:white; display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-size:24px; font-weight:800; flex-shrink:0; }
  .profile-info h3 { font-family:'Syne',sans-serif; font-size:18px; font-weight:700; color:var(--navy); }
  .profile-info p { color:var(--muted); font-size:14px; margin-top:3px; }
  .profile-badge { margin-top:8px; display:inline-block; padding:3px 12px; background:#faf5ff; color:var(--purple); border-radius:20px; font-size:12px; font-weight:600; }
  .profile-details { margin-top:8px; font-size:13px; color:#64748b; display:flex; gap:16px; flex-wrap:wrap; }

  .courses-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(280px,1fr)); gap:18px; }
  .course-card { background:white; border-radius:14px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden; transition:transform 0.2s,box-shadow 0.2s; }
  .course-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,0.1); }
  .course-top { padding:20px; background:linear-gradient(135deg,#faf5ff,#ede9fe); position:relative; }
  .course-code { font-family:'Syne',sans-serif; font-size:20px; font-weight:800; color:var(--purple); }
  .course-level-badge { position:absolute; top:16px; right:16px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; background:white; color:var(--purple); }
  .course-body { padding:16px 20px; }
  .course-desc { font-size:13.5px; color:var(--muted); line-height:1.5; margin-bottom:14px; min-height:40px; }
  .course-meta { display:flex; gap:12px; font-size:12px; color:#64748b; }
</style>
</head>
<body>
<header class="header">
  <div class="header-logo">
    <div class="ico">👨‍🏫</div>
    <div class="name">Learn<span>MS</span></div>
  </div>
  <div class="header-right">
    <span class="welcome">Welcome, <strong><?= htmlspecialchars($user['name']) ?></strong></span>
    <a href="../logout.php" class="btn-logout">Sign Out</a>
  </div>
</header>

<div class="hero">
  <h1>Faculty Portal <span>👋</span></h1>
  <p>Welcome back, <?= htmlspecialchars($user['name']) ?></p>
  <div class="hero-stats">
    <div class="hstat">
      <div class="hstat-num"><?= $total_courses ?></div>
      <div class="hstat-label">Active Courses</div>
    </div>
    <div class="hstat">
      <div class="hstat-num"><?= $total_students ?></div>
      <div class="hstat-label">Total Students</div>
    </div>
  </div>
</div>

<div class="main">
  <div class="profile-card">
    <div class="profile-avatar"><?= strtoupper(substr($user['name'],0,1)) ?></div>
    <div class="profile-info">
      <h3><?= htmlspecialchars($user['name']) ?></h3>
      <p><?= htmlspecialchars($user['email']) ?></p>
      <?php if ($faculty): ?>
      <div class="profile-details">
        <?php if ($faculty['designation']): ?><span>🏷 <?= htmlspecialchars($faculty['designation']) ?></span><?php endif; ?>
        <?php if ($faculty['department']): ?><span>🏫 <?= htmlspecialchars($faculty['department']) ?></span><?php endif; ?>
        <?php if ($faculty['experience_years']): ?><span>⭐ <?= $faculty['experience_years'] ?> yrs experience</span><?php endif; ?>
      </div>
      <?php endif; ?>
      <span class="profile-badge">Faculty</span>
    </div>
  </div>

  <div class="section-title">📚 Active Courses</div>
  <div class="courses-grid">
    <?php while ($c = mysqli_fetch_assoc($courses)): ?>
    <div class="course-card">
      <div class="course-top">
        <div class="course-code"><?= htmlspecialchars($c['course_code']) ?></div>
        <span class="course-level-badge"><?= htmlspecialchars($c['course_level'] ?? 'General') ?></span>
      </div>
      <div class="course-body">
        <div class="course-desc"><?= htmlspecialchars(substr($c['course_description'] ?? 'No description.', 0, 90)) ?>...</div>
        <div class="course-meta">
          <span>🌐 <?= htmlspecialchars($c['language'] ?? 'English') ?></span>
          <span>📗 <?= htmlspecialchars($c['course_level'] ?? '') ?></span>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>
