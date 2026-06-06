<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
include '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
$msg = '';
$f = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_faculty WHERE id=$id"));
if (!$f) { header("Location: faculty.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fn  = mysqli_real_escape_string($conn, $_POST['first_name']);
    $ln  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $em  = mysqli_real_escape_string($conn, $_POST['email']);
    $ph  = mysqli_real_escape_string($conn, $_POST['phone']);
    $des = mysqli_real_escape_string($conn, $_POST['designation']);
    $dep = mysqli_real_escape_string($conn, $_POST['department']);
    $exp = (int)$_POST['experience_years'];
    mysqli_query($conn, "UPDATE lms_faculty SET first_name='$fn',last_name='$ln',email='$em',phone='$ph',designation='$des',department='$dep',experience_years=$exp WHERE id=$id");
    $msg = '<div class="alert success">✅ Faculty updated!</div>';
    $f = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_faculty WHERE id=$id"));
}
$active_nav = 'faculty'; $page_title = 'Edit Faculty';
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Edit Faculty</title><?php include '../includes/admin_style.php'; ?></head>
<body>
<?php include '../includes/admin_sidebar.php'; ?>
<div class="main">
  <div class="topbar"><h1>Edit Faculty</h1></div>
  <div class="content">
    <?= $msg ?>
    <div class="form-card">
      <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#0a0f2c;margin-bottom:20px;">
        Editing: <?= htmlspecialchars($f['first_name'].' '.$f['last_name']) ?>
      </h3>
      <form method="POST">
        <div class="form-row">
          <div class="form-group"><label>First Name</label><input type="text" name="first_name" value="<?= htmlspecialchars($f['first_name']) ?>" required></div>
          <div class="form-group"><label>Last Name</label><input type="text" name="last_name" value="<?= htmlspecialchars($f['last_name']) ?>" required></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Email</label><input type="email" name="email" value="<?= htmlspecialchars($f['email']) ?>"></div>
          <div class="form-group"><label>Phone</label><input type="text" name="phone" value="<?= htmlspecialchars($f['phone']) ?>"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Designation</label><input type="text" name="designation" value="<?= htmlspecialchars($f['designation']) ?>"></div>
          <div class="form-group"><label>Department</label><input type="text" name="department" value="<?= htmlspecialchars($f['department']) ?>"></div>
        </div>
        <div class="form-group" style="max-width:200px;"><label>Experience (Years)</label><input type="number" name="experience_years" value="<?= $f['experience_years'] ?>"></div>
        <div style="display:flex;gap:12px;align-items:center;margin-top:8px;">
          <button type="submit" class="btn-submit">Save Changes</button>
          <a href="faculty.php" style="color:#94a3b8;font-size:14px;text-decoration:none;">← Back to Faculty</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
