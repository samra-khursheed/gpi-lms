<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
include '../includes/db.php';

$msg = '';

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM lms_faculty WHERE id=$id");
    header("Location: faculty.php?deleted=1"); exit();
}
if (isset($_GET['deleted'])) $msg = '<div class="alert success">Faculty member deleted.</div>';

// ADD
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $fn  = mysqli_real_escape_string($conn, $_POST['first_name']);
    $ln  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $em  = mysqli_real_escape_string($conn, $_POST['email']);
    $ph  = mysqli_real_escape_string($conn, $_POST['phone']);
    $eid = mysqli_real_escape_string($conn, $_POST['employee_id']);
    $des = mysqli_real_escape_string($conn, $_POST['designation']);
    $dep = mysqli_real_escape_string($conn, $_POST['department']);
    $gen = mysqli_real_escape_string($conn, $_POST['gender']);
    $exp = (int)$_POST['experience_years'];

    $sql = "INSERT INTO lms_faculty (first_name,last_name,email,phone,employee_id,designation,department,gender,experience_years)
            VALUES ('$fn','$ln','$em','$ph','$eid','$des','$dep','$gen',$exp)";
    if (mysqli_query($conn, $sql)) {
        $msg = '<div class="alert success">✅ Faculty member added!</div>';
    } else {
        $msg = '<div class="alert error">Error: ' . mysqli_error($conn) . '</div>';
    }
}

$faculty = mysqli_query($conn, "SELECT * FROM lms_faculty ORDER BY id DESC");
$active_nav = 'faculty'; $page_title = 'Faculty';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — Faculty</title>
<?php include '../includes/admin_style.php'; ?>
</head>
<body>
<?php include '../includes/admin_sidebar.php'; ?>
<div class="main">
  <div class="topbar">
    <h1>Faculty</h1>
    <div class="topbar-user">
      <div class="avatar"><?= strtoupper(substr($_SESSION['user_name'],0,1)) ?></div>
      <div class="user-info">
        <div class="uname"><?= htmlspecialchars($_SESSION['user_name']) ?></div>
        <div class="urole">Administrator</div>
      </div>
    </div>
  </div>
  <div class="content">
    <?= $msg ?>

    <div class="form-card" style="margin-bottom:28px;">
      <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#0a0f2c;margin-bottom:20px;">➕ Add Faculty Member</h3>
      <form method="POST">
        <input type="hidden" name="action" value="add">
        <div class="form-row">
          <div class="form-group"><label>First Name</label><input type="text" name="first_name" required></div>
          <div class="form-group"><label>Last Name</label><input type="text" name="last_name" required></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
          <div class="form-group"><label>Phone</label><input type="text" name="phone"></div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Employee ID</label><input type="text" name="employee_id"></div>
          <div class="form-group">
            <label>Gender</label>
            <select name="gender">
              <option value="">Select</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Designation</label><input type="text" name="designation" placeholder="e.g. Lecturer"></div>
          <div class="form-group"><label>Department</label><input type="text" name="department"></div>
        </div>
        <div class="form-group" style="max-width:200px;">
          <label>Experience (Years)</label>
          <input type="number" name="experience_years" value="0" min="0">
        </div>
        <button type="submit" class="btn-submit">Add Faculty</button>
      </form>
    </div>

    <div class="table-card">
      <div class="table-header">
        <h3>All Faculty (<?= mysqli_num_rows($faculty) ?>)</h3>
      </div>
      <table>
        <thead>
          <tr><th>#</th><th>Name</th><th>Email</th><th>Designation</th><th>Department</th><th>Exp.</th><th>Action</th></tr>
        </thead>
        <tbody>
          <?php $i=1; while ($f = mysqli_fetch_assoc($faculty)): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($f['first_name'].' '.$f['last_name']) ?></td>
            <td><?= htmlspecialchars($f['email']) ?></td>
            <td><?= htmlspecialchars($f['designation']) ?></td>
            <td><?= htmlspecialchars($f['department']) ?></td>
            <td><?= $f['experience_years'] ?> yrs</td>
            <td>
              <a href="edit_faculty.php?id=<?= $f['id'] ?>" class="btn-sm btn-edit">Edit</a>
              <a href="faculty.php?delete=<?= $f['id'] ?>" class="btn-sm btn-del"
                 onclick="return confirm('Delete this faculty member?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if (mysqli_num_rows($faculty) == 0): ?>
          <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:30px">No faculty found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
