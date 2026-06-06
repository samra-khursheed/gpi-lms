<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
include '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
$msg = '';

$student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_user WHERE id=$id AND permission='student'"));
if (!$student) { header("Location: students.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = mysqli_real_escape_string($conn, $_POST['name']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile  = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $pass_sql = '';
    if (!empty($_POST['password'])) {
        $p = mysqli_real_escape_string($conn, $_POST['password']);
        $pass_sql = ", password='$p'";
    }
    mysqli_query($conn, "UPDATE lms_user SET name='$name',email='$email',mobile='$mobile',address='$address'$pass_sql WHERE id=$id");
    $msg = '<div class="alert success">✅ Student updated!</div>';
    $student = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_user WHERE id=$id"));
}

$active_nav = 'students'; $page_title = 'Edit Student';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><title>Edit Student</title>
<?php include '../includes/admin_style.php'; ?>
</head>
<body>
<?php include '../includes/admin_sidebar.php'; ?>
<div class="main">
  <div class="topbar">
    <h1>Edit Student</h1>
    <div class="topbar-user">
      <div class="avatar"><?= strtoupper(substr($_SESSION['user_name'],0,1)) ?></div>
      <div class="user-info"><div class="uname"><?= htmlspecialchars($_SESSION['user_name']) ?></div><div class="urole">Administrator</div></div>
    </div>
  </div>
  <div class="content">
    <?= $msg ?>
    <div class="form-card">
      <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#0a0f2c;margin-bottom:20px;">
        Editing: <?= htmlspecialchars($student['name']) ?>
      </h3>
      <form method="POST">
        <div class="form-row">
          <div class="form-group"><label>Full Name</label><input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required></div>
          <div class="form-group"><label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Mobile</label><input type="text" name="mobile" value="<?= htmlspecialchars($student['mobile']) ?>"></div>
          <div class="form-group"><label>New Password (leave blank to keep)</label><input type="password" name="password" placeholder="••••••••"></div>
        </div>
        <div class="form-group"><label>Address</label><input type="text" name="address" value="<?= htmlspecialchars($student['address']) ?>"></div>
        <div style="display:flex;gap:12px;align-items:center;margin-top:8px;">
          <button type="submit" class="btn-submit">Save Changes</button>
          <a href="students.php" style="color:#94a3b8;font-size:14px;text-decoration:none;">← Back to Students</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
