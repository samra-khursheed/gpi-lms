<?php
session_start();
include '../includes/db.php';

// Enroll action
if (isset($_POST['enroll_course'])) {
    $student_id = (int)$_SESSION['user_id'];
    $course_id  = (int)$_POST['course_id'];
    $check = mysqli_query($conn, "SELECT id FROM lms_enrollments WHERE student_id=$student_id AND course_id=$course_id");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO lms_enrollments (student_id, course_id) VALUES ($student_id, $course_id)");
        echo "<script>alert('Enrolled successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Already enrolled!'); window.location.href='dashboard.php';</script>";
    }
    exit();
}

if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }

$user_id = $_SESSION['user_id'];
$user    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_user WHERE id=$user_id"));

// All active courses
$all_courses = mysqli_query($conn, "SELECT * FROM lms_courses WHERE course_status='active' ORDER BY id DESC");
$total_courses = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM lms_courses WHERE course_status='active'"))['c'];

// Enrolled courses
$enrolled_query = mysqli_query($conn, "SELECT c.* FROM lms_courses c 
    JOIN lms_enrollments e ON c.id = e.course_id 
    WHERE e.student_id = $user_id ORDER BY e.id DESC");
$total_enrolled = mysqli_num_rows($enrolled_query);

// Enrolled IDs array for quick check
$enrolled_ids = [];
$enrolled_courses_list = [];
while ($ec = mysqli_fetch_assoc($enrolled_query)) {
    $enrolled_ids[] = $ec['id'];
    $enrolled_courses_list[] = $ec;
}
// Reset pointer
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Student Dashboard — GPI H-8 LMS</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing:border-box; margin:0; padding:0; }
  :root { --navy:#0a0f2c; --blue:#1a56db; --accent:#f59e0b; --teal:#2ec4b6; --white:#fff; --light:#f1f5f9; --muted:#94a3b8; }
  body { font-family:'DM Sans',sans-serif; background:#f8fafc; color:#1e293b; }

  .header { background:linear-gradient(135deg,var(--navy) 0%,#1a2456 100%); padding:0 32px; display:flex; align-items:center; justify-content:space-between; height:64px; position:sticky; top:0; z-index:50; }
  .header-logo { display:flex; align-items:center; gap:10px; }
  .header-logo .ico { width:32px; height:32px; background:var(--accent); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:16px; }
  .header-logo .name { font-family:'Syne',sans-serif; font-weight:800; font-size:16px; color:white; }
  .header-logo .name span { color:var(--accent); }
  .header-right { display:flex; align-items:center; gap:16px; }
  .welcome { color:rgba(255,255,255,0.7); font-size:14px; }
  .welcome strong { color:white; }
  .btn-logout { padding:7px 16px; background:rgba(255,255,255,0.1); color:white; border:1px solid rgba(255,255,255,0.2); border-radius:7px; font-size:13px; text-decoration:none; }
  .btn-logout:hover { background:rgba(255,255,255,0.2); }

  .hero { background:linear-gradient(135deg,#1a56db 0%,var(--navy) 100%); padding:48px 32px; color:white; }
  .hero h1 { font-family:'Syne',sans-serif; font-size:32px; font-weight:800; margin-bottom:8px; }
  .hero h1 span { color:var(--accent); }
  .hero p { color:rgba(255,255,255,0.7); font-size:15px; }
  .hero-stats { display:flex; gap:20px; margin-top:28px; flex-wrap:wrap; }
  .hstat { background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:12px; padding:14px 20px; }
  .hstat-num { font-family:'Syne',sans-serif; font-size:24px; font-weight:800; color:var(--accent); }
  .hstat-label { font-size:12px; color:rgba(255,255,255,0.6); margin-top:2px; }

  .main { padding:32px; max-width:1100px; margin:0 auto; }

  .profile-card { background:white; border-radius:14px; padding:24px; box-shadow:0 2px 8px rgba(0,0,0,0.06); margin-bottom:32px; display:flex; align-items:center; gap:20px; }
  .profile-avatar { width:60px; height:60px; border-radius:50%; background:var(--blue); color:white; display:flex; align-items:center; justify-content:center; font-family:'Syne',sans-serif; font-size:24px; font-weight:800; flex-shrink:0; }
  .profile-info h3 { font-family:'Syne',sans-serif; font-size:18px; font-weight:700; color:var(--navy); }
  .profile-info p { color:var(--muted); font-size:14px; margin-top:3px; }
  .profile-badge { margin-top:8px; display:inline-block; padding:3px 12px; background:#eff6ff; color:var(--blue); border-radius:20px; font-size:12px; font-weight:600; }

  .section-title { font-family:'Syne',sans-serif; font-size:18px; font-weight:700; color:var(--navy); margin-bottom:18px; }

  .courses-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(290px,1fr)); gap:18px; margin-bottom:40px; }

  .course-card { background:white; border-radius:14px; box-shadow:0 2px 8px rgba(0,0,0,0.06); overflow:hidden; transition:transform 0.2s,box-shadow 0.2s; display:flex; flex-direction:column; }
  .course-card:hover { transform:translateY(-3px); box-shadow:0 8px 24px rgba(0,0,0,0.1); }

  /* Enrolled card — teal top border */
  .course-card.enrolled { border-top:4px solid var(--teal); }
  .course-card.enrolled .course-top { background:linear-gradient(135deg,#e6fffc,#ccfbf1); }
  .course-card.enrolled .course-code { color:#0f766e; }

  /* Available card */
  .course-card.available .course-top { background:linear-gradient(135deg,#eff6ff,#e0e7ff); }
  .course-card.available .course-code { color:var(--blue); }

  .course-top { padding:20px; position:relative; }
  .course-code { font-family:'Syne',sans-serif; font-size:20px; font-weight:800; }
  .course-title { font-size:13px; color:#475569; margin-top:4px; font-weight:500; }
  .level-badge { position:absolute; top:16px; right:16px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:600; }
  .level-badge.Intermediate { background:white; color:var(--blue); }
  .level-badge.Advanced { background:white; color:#7c3aed; }
  .level-badge.Beginner { background:white; color:#059669; }
  .joined-badge { position:absolute; top:16px; right:16px; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; background:var(--teal); color:white; }

  .course-body { padding:14px 20px; flex:1; }
  .course-desc { font-size:13.5px; color:var(--muted); line-height:1.5; margin-bottom:12px; }
  .course-meta { display:flex; gap:12px; font-size:12px; color:#64748b; }

  .course-footer { padding:14px 20px; border-top:1px solid #f1f5f9; }

  .btn-goto { display:block; width:100%; padding:11px; background:var(--blue); color:white; text-align:center; border-radius:9px; font-family:'Syne',sans-serif; font-size:13.5px; font-weight:700; text-decoration:none; transition:background 0.2s; }
  .btn-goto:hover { background:#1740a8; }

  .btn-joined { display:block; width:100%; padding:11px; background:var(--teal); color:white; text-align:center; border-radius:9px; font-family:'Syne',sans-serif; font-size:13.5px; font-weight:700; cursor:not-allowed; border:none; }

  .btn-enroll { display:block; width:100%; padding:11px; background:var(--light); color:var(--navy); text-align:center; border-radius:9px; font-family:'Syne',sans-serif; font-size:13.5px; font-weight:700; cursor:pointer; border:none; transition:background 0.2s; }
  .btn-enroll:hover { background:#e2e8f0; }

  .empty-msg { color:var(--muted); font-size:15px; padding:24px; background:white; border-radius:12px; text-align:center; grid-column:1/-1; }
</style>
</head>
<body>

<header class="header">
  <div class="header-logo">
    <div class="ico">🎓</div>
    <div class="name">Learn<span>MS</span></div>
  </div>
  <div class="header-right">
    <span class="welcome">Welcome, <strong><?= htmlspecialchars($user['name']) ?></strong></span>
    <a href="../logout.php" class="btn-logout">Sign Out</a>
  </div>
</header>

<div class="hero">
  <h1>Hello, <span><?= htmlspecialchars(explode(' ',$user['name'])[0]) ?></span> 👋</h1>
  <p>Manage your courses and track your learning journey</p>
  <div class="hero-stats">
    <div class="hstat">
      <div class="hstat-num"><?= $total_courses ?></div>
      <div class="hstat-label">Available Courses</div>
    </div>
    <div class="hstat">
      <div class="hstat-num"><?= $total_enrolled ?></div>
      <div class="hstat-label">Enrolled Courses</div>
    </div>
  </div>
</div>

<div class="main">

  <!-- PROFILE -->
  <div class="profile-card">
    <div class="profile-avatar"><?= strtoupper(substr($user['name'],0,1)) ?></div>
    <div class="profile-info">
      <h3><?= htmlspecialchars($user['name']) ?></h3>
      <p><?= htmlspecialchars($user['email']) ?></p>
      <span class="profile-badge">Student</span>
    </div>
  </div>

  <!-- ENROLLED COURSES -->
  <div class="section-title">🎓 My Enrolled Courses</div>
  <div class="courses-grid">
    <?php if ($total_enrolled == 0): ?>
      <div class="empty-msg">📭 You haven't enrolled in any courses yet. Browse below and enroll!</div>
    <?php else: ?>
      <?php foreach ($enrolled_courses_list as $ec): ?>
      <div class="course-card enrolled">
        <div class="course-top">
          <div class="course-code"><?= htmlspecialchars($ec['course_code']) ?></div>
          <div class="course-title"><?= htmlspecialchars($ec['course_title'] ?? '') ?></div>
          <span class="joined-badge">✓ Joined</span>
        </div>
        <div class="course-body">
          <div class="course-desc"><?= htmlspecialchars(substr($ec['course_description'] ?? '', 0, 90)) ?>...</div>
          <div class="course-meta">
            <span>🌐 <?= htmlspecialchars($ec['language'] ?? 'English') ?></span>
            <span>📗 <?= htmlspecialchars($ec['course_level'] ?? '') ?></span>
          </div>
        </div>
        <div class="course-footer">
          <a href="course.php?id=<?= $ec['id'] ?>" class="btn-goto">Go to Course →</a>
        </div>
      </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>

  <!-- AVAILABLE COURSES -->
  <div class="section-title">📚 Available Courses</div>
  <div class="courses-grid">
    <?php while ($c = mysqli_fetch_assoc($all_courses)): ?>
    <?php $is_enrolled = in_array($c['id'], $enrolled_ids); ?>
    <div class="course-card available">
      <div class="course-top">
        <div class="course-code"><?= htmlspecialchars($c['course_code']) ?></div>
        <div class="course-title"><?= htmlspecialchars($c['course_title'] ?? '') ?></div>
        <span class="level-badge <?= $c['course_level'] ?>"><?= htmlspecialchars($c['course_level'] ?? '') ?></span>
      </div>
      <div class="course-body">
        <div class="course-desc"><?= htmlspecialchars(substr($c['course_description'] ?? '', 0, 90)) ?>...</div>
        <div class="course-meta">
          <span>🌐 <?= htmlspecialchars($c['language'] ?? 'English') ?></span>
          <span>📗 <?= htmlspecialchars($c['course_level'] ?? '') ?></span>
        </div>
      </div>
      <div class="course-footer">
        <?php if ($is_enrolled): ?>
          <button class="btn-joined" disabled>✓ Joined</button>
        <?php else: ?>
          <form method="POST">
            <input type="hidden" name="course_id" value="<?= $c['id'] ?>">
            <button type="submit" name="enroll_course" class="btn-enroll">Enroll Now</button>
          </form>
        <?php endif; ?>
      </div>
    </div>
    <?php endwhile; ?>
    <?php if ($total_courses == 0): ?>
    <div class="empty-msg">No active courses available yet.</div>
    <?php endif; ?>
  </div>

</div>
</body>
</html>
