<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
$perm = strtolower($_SESSION['permission'] ?? '');
if ($perm != 'admin' && ($_SESSION['admin_'] ?? 0) != 1) { header("Location: ../login.php"); exit(); }

include '../includes/db.php';

$total_students = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM lms_user WHERE permission='student'"))['c'];
$total_faculty  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM lms_faculty"))['c'];
$total_courses  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM lms_courses"))['c'];
$total_users    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM lms_user"))['c'];

$recent_students = mysqli_query($conn, "SELECT name, email, date FROM lms_user WHERE permission='student' ORDER BY id DESC LIMIT 5");
$active_nav = 'dashboard';
$page_title = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — Dashboard</title>
<?php include '../includes/admin_style.php'; ?>
</head>
<body>
<?php include '../includes/admin_sidebar.php'; ?>

<div class="main">
  <div class="topbar">
    <h1>Dashboard</h1>
    <div class="topbar-user">
      <div class="avatar"><?= strtoupper(substr($_SESSION['user_name'],0,1)) ?></div>
      <div class="user-info">
        <div class="uname"><?= htmlspecialchars($_SESSION['user_name']) ?></div>
        <div class="urole">Administrator</div>
      </div>
    </div>
  </div>

  <div class="content">
    <div class="stat-cards">
      <div class="stat-card">
        <div class="stat-icon blue">👩‍🎓</div>
        <div>
          <div class="stat-num"><?= $total_students ?></div>
          <div class="stat-label">Total Students</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon purple">👨‍🏫</div>
        <div>
          <div class="stat-num"><?= $total_faculty ?></div>
          <div class="stat-label">Faculty Members</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon amber">📚</div>
        <div>
          <div class="stat-num"><?= $total_courses ?></div>
          <div class="stat-label">Total Courses</div>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon green">👤</div>
        <div>
          <div class="stat-num"><?= $total_users ?></div>
          <div class="stat-label">All Users</div>
        </div>
      </div>
    </div>

    <div class="table-card">
      <div class="table-header">
        <h3>Recently Registered Students</h3>
        <a href="students.php" class="btn-add">View All</a>
      </div>
      <table>
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Registered</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($s = mysqli_fetch_assoc($recent_students)): ?>
          <tr>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= $s['date'] ?></td>
          </tr>
          <?php endwhile; ?>
          <?php if (mysqli_num_rows($recent_students) == 0): ?>
          <tr><td colspan="3" style="text-align:center;color:#94a3b8;padding:30px">No students yet.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
