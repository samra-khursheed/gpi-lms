<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
include '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
$course = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_courses WHERE id=$id"));
if (!$course) { header("Location: dashboard.php"); exit(); }

// YouTube videos mapped to course codes
$videos = [
    'CIT-223' => [
        ['title' => 'Data Structures & Algorithms — Full Course', 'url' => 'https://www.youtube.com/embed/pkYVOmU3MgA'],
        ['title' => 'Stacks and Queues Explained', 'url' => 'https://www.youtube.com/embed/wjI1WNcIntg'],
        ['title' => 'Arrays & Memory Allocation', 'url' => 'https://www.youtube.com/embed/B31LgI4Y4DQ'],
    ],
    'CIT-151' => [
        ['title' => 'HTML5 Full Course for Beginners', 'url' => 'https://www.youtube.com/embed/pQN-pnXPaVg'],
        ['title' => 'CSS3 Complete Tutorial', 'url' => 'https://www.youtube.com/embed/yfoY53QXEnI'],
        ['title' => 'JavaScript Full Course', 'url' => 'https://www.youtube.com/embed/W6NZfCO5SIk'],
    ],
    'CIT-242' => [
        ['title' => 'Java OOP Full Course', 'url' => 'https://www.youtube.com/embed/6T_HgnjoYwM'],
        ['title' => 'Polymorphism & Encapsulation in Java', 'url' => 'https://www.youtube.com/embed/9YOdMJGVMxY'],
        ['title' => 'Java Programming Masterclass', 'url' => 'https://www.youtube.com/embed/eIrMbAQSU34'],
    ],
    'CIT-324' => [
        ['title' => 'Database Management Systems Full Course', 'url' => 'https://www.youtube.com/embed/ztHopE5Wnpc'],
        ['title' => 'SQL Tutorial — Full Course', 'url' => 'https://www.youtube.com/embed/HXV3zeQKqGY'],
        ['title' => 'Relational Database Design', 'url' => 'https://www.youtube.com/embed/UrYLYV7WSHM'],
    ],
    'CIT-313' => [
        ['title' => 'PHP & MySQL Full Course', 'url' => 'https://www.youtube.com/embed/OK_JCtrrv-c'],
        ['title' => 'Build Dynamic Website with PHP', 'url' => 'https://www.youtube.com/embed/2eebptXfEvw'],
        ['title' => 'PHP Admin Panel Tutorial', 'url' => 'https://www.youtube.com/embed/3OPd7vs3tFY'],
    ],
];

$course_videos = $videos[$course['course_code']] ?? [];
$active_video = (int)($_GET['v'] ?? 0);
if ($active_video >= count($course_videos)) $active_video = 0;

$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_user WHERE id=" . $_SESSION['user_id']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($course['course_code']) ?> — GPI H-8 LMS</title>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root { --navy:#0a0f2c; --blue:#1a56db; --accent:#f59e0b; --white:#fff; --light:#f1f5f9; --muted:#94a3b8; }
  body { font-family: 'DM Sans', sans-serif; background: #f8fafc; color: #1e293b; }

  /* HEADER */
  .header { background: var(--navy); padding: 0 28px; display: flex; align-items: center; justify-content: space-between; height: 62px; position: sticky; top: 0; z-index: 100; }
  .header-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
  .header-logo .ico { width: 32px; height: 32px; background: var(--accent); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
  .header-logo .name { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 16px; color: white; }
  .header-logo .name span { color: var(--accent); }
  .header-right { display: flex; align-items: center; gap: 14px; }
  .header-right .welcome { color: rgba(255,255,255,0.7); font-size: 13.5px; }
  .header-right .welcome strong { color: white; }
  .btn-back { padding: 7px 16px; background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.2); border-radius: 7px; font-size: 13px; text-decoration: none; transition: background 0.15s; }
  .btn-back:hover { background: rgba(255,255,255,0.2); }

  /* COURSE HERO */
  .course-hero {
    background: linear-gradient(135deg, var(--navy) 0%, #1a2456 100%);
    padding: 36px 32px; color: white;
  }
  .breadcrumb { font-size: 13px; color: rgba(255,255,255,0.5); margin-bottom: 14px; }
  .breadcrumb a { color: rgba(255,255,255,0.6); text-decoration: none; }
  .breadcrumb a:hover { color: white; }
  .breadcrumb span { margin: 0 8px; }
  .course-hero h1 { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; margin-bottom: 10px; }
  .course-hero h1 span { color: var(--accent); }
  .course-meta-row { display: flex; gap: 20px; flex-wrap: wrap; margin-top: 14px; }
  .meta-tag { display: flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.1); border-radius: 20px; padding: 5px 14px; font-size: 13px; color: rgba(255,255,255,0.85); }

  /* LAYOUT */
  .course-layout { display: grid; grid-template-columns: 1fr 320px; gap: 24px; max-width: 1200px; margin: 0 auto; padding: 28px 28px; }

  /* VIDEO PLAYER */
  .video-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
  .video-wrapper { position: relative; padding-bottom: 56.25%; height: 0; background: #000; }
  .video-wrapper iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none; }
  .video-info { padding: 20px 24px; }
  .video-info h2 { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: var(--navy); margin-bottom: 8px; }
  .video-info p { color: var(--muted); font-size: 14px; line-height: 1.6; }

  /* COURSE DESC */
  .desc-card { background: white; border-radius: 14px; padding: 22px 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-top: 20px; }
  .desc-card h3 { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 700; color: var(--navy); margin-bottom: 12px; }
  .desc-card p { color: #475569; font-size: 14.5px; line-height: 1.7; }

  /* SIDEBAR */
  .sidebar { }
  .playlist-card { background: white; border-radius: 14px; overflow: hidden; box-shadow: 0 2px 12px rgba(0,0,0,0.08); }
  .playlist-header { padding: 16px 18px; background: var(--navy); color: white; }
  .playlist-header h3 { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; }
  .playlist-header p { font-size: 12px; color: rgba(255,255,255,0.6); margin-top: 3px; }

  .playlist-item { display: flex; align-items: center; gap: 12px; padding: 14px 16px; text-decoration: none; border-bottom: 1px solid #f1f5f9; transition: background 0.15s; }
  .playlist-item:last-child { border-bottom: none; }
  .playlist-item:hover { background: #f8fafc; }
  .playlist-item.active { background: #eff6ff; border-left: 3px solid var(--blue); }
  .playlist-num { width: 30px; height: 30px; border-radius: 50%; background: #f1f5f9; color: var(--muted); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; flex-shrink: 0; }
  .playlist-item.active .playlist-num { background: var(--blue); color: white; }
  .playlist-item.playing .playlist-num { background: #10b981; color: white; }
  .playlist-title { font-size: 13px; font-weight: 500; color: #334155; line-height: 1.4; }
  .playlist-item.active .playlist-title { color: var(--blue); font-weight: 600; }

  /* INFO CARD */
  .info-card { background: white; border-radius: 14px; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); margin-top: 16px; }
  .info-card h4 { font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700; color: var(--navy); margin-bottom: 14px; }
  .info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f1f5f9; font-size: 13.5px; }
  .info-row:last-child { border-bottom: none; }
  .info-row .key { color: var(--muted); }
  .info-row .val { font-weight: 600; color: var(--navy); }
  .badge-level { padding: 3px 10px; border-radius: 20px; font-size: 11.5px; font-weight: 600; }
  .badge-level.Intermediate { background: #eff6ff; color: #1e40af; }
  .badge-level.Advanced { background: #faf5ff; color: #6b21a8; }
  .badge-level.Beginner { background: #f0fdf4; color: #166534; }

  @media (max-width: 900px) {
    .course-layout { grid-template-columns: 1fr; }
    .course-hero h1 { font-size: 22px; }
  }
</style>
</head>
<body>

<!-- HEADER -->
<header class="header">
  <a href="dashboard.php" class="header-logo">
    <div class="ico">🎓</div>
    <div class="name">Learn<span>MS</span></div>
  </a>
  <div class="header-right">
    <span class="welcome">Welcome, <strong><?= htmlspecialchars($user['name']) ?></strong></span>
    <a href="dashboard.php" class="btn-back">← Dashboard</a>
  </div>
</header>

<!-- COURSE HERO -->
<div class="course-hero">
  <div class="breadcrumb">
    <a href="dashboard.php">Dashboard</a>
    <span>›</span>
    Courses
    <span>›</span>
    <?= htmlspecialchars($course['course_code']) ?>
  </div>
  <h1><span><?= htmlspecialchars($course['course_code']) ?></span> — <?= htmlspecialchars($course['course_title'] ?? '') ?></h1>
  <div class="course-meta-row">
    <span class="meta-tag">📗 <?= htmlspecialchars($course['course_level'] ?? 'General') ?></span>
    <span class="meta-tag">🌐 <?= htmlspecialchars($course['language'] ?? 'English') ?></span>
    <span class="meta-tag">⏱ <?= $course['course_hours'] ?? 40 ?> Hours</span>
    <span class="meta-tag">⭐ <?= $course['credit_hours'] ?? 3 ?> Credit Hours</span>
    <span class="meta-tag">📹 <?= count($course_videos) ?> Videos</span>
  </div>
</div>

<!-- LAYOUT -->
<div class="course-layout">
  <!-- LEFT: VIDEO + DESC -->
  <div>
    <?php if (!empty($course_videos)): ?>
    <div class="video-card">
      <div class="video-wrapper">
        <iframe src="<?= $course_videos[$active_video]['url'] ?>?rel=0&modestbranding=1"
                allowfullscreen allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
        </iframe>
      </div>
      <div class="video-info">
        <h2>📹 <?= htmlspecialchars($course_videos[$active_video]['title']) ?></h2>
        <p>Video <?= $active_video + 1 ?> of <?= count($course_videos) ?> — <?= htmlspecialchars($course['course_code']) ?></p>
      </div>
    </div>
    <?php else: ?>
    <div class="video-card" style="padding:60px;text-align:center;color:var(--muted);">
      <div style="font-size:48px;margin-bottom:16px;">🎬</div>
      <p style="font-size:16px;">Videos coming soon for this course!</p>
    </div>
    <?php endif; ?>

    <div class="desc-card">
      <h3>📋 About This Course</h3>
      <p><?= htmlspecialchars($course['course_description'] ?? '') ?></p>
    </div>
  </div>

  <!-- RIGHT: PLAYLIST + INFO -->
  <div class="sidebar">
    <div class="playlist-card">
      <div class="playlist-header">
        <h3>Course Videos</h3>
        <p><?= count($course_videos) ?> lessons available</p>
      </div>
      <?php foreach ($course_videos as $i => $vid): ?>
      <a href="course.php?id=<?= $id ?>&v=<?= $i ?>"
         class="playlist-item <?= $i == $active_video ? 'active' : '' ?>">
        <div class="playlist-num"><?= $i == $active_video ? '▶' : ($i + 1) ?></div>
        <div class="playlist-title"><?= htmlspecialchars($vid['title']) ?></div>
      </a>
      <?php endforeach; ?>
    </div>

    <div class="info-card">
      <h4>📊 Course Details</h4>
      <div class="info-row"><span class="key">Course Code</span><span class="val"><?= htmlspecialchars($course['course_code']) ?></span></div>
      <div class="info-row"><span class="key">Level</span><span class="val"><span class="badge-level <?= $course['course_level'] ?>"><?= htmlspecialchars($course['course_level'] ?? '') ?></span></span></div>
      <div class="info-row"><span class="key">Language</span><span class="val"><?= htmlspecialchars($course['language'] ?? 'English') ?></span></div>
      <div class="info-row"><span class="key">Hours</span><span class="val"><?= $course['course_hours'] ?? 40 ?> hrs</span></div>
      <div class="info-row"><span class="key">Credit Hours</span><span class="val"><?= $course['credit_hours'] ?? 3 ?></span></div>
      <div class="info-row"><span class="key">Status</span><span class="val" style="color:#10b981;">● Active</span></div>
    </div>
  </div>
</div>

</body>
</html>
