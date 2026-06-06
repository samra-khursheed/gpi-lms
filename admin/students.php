<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
include '../includes/db.php';

$msg = '';

// ADD student
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $mobile   = mysqli_real_escape_string($conn, $_POST['mobile']);
    $address  = mysqli_real_escape_string($conn, $_POST['address']);
    $date     = date('Y-m-d');

    $check = mysqli_query($conn, "SELECT id FROM lms_user WHERE email='$email' OR username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $msg = '<div class="alert error">Email or username already exists.</div>';
    } else {
        $sql = "INSERT INTO lms_user (name,username,password,email,mobile,address,permission,date,admin_)
                VALUES ('$name','$username','$password','$email','$mobile','$address','student','$date',0)";
        if (mysqli_query($conn, $sql)) {
            $msg = '<div class="alert success">✅ Student added successfully!</div>';
        } else {
            $msg = '<div class="alert error">Error: ' . mysqli_error($conn) . '</div>';
        }
    }
}

// DELETE student
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM lms_user WHERE id=$id AND permission='student'");
    header("Location: students.php?deleted=1"); exit();
}
if (isset($_GET['deleted'])) $msg = '<div class="alert success">Student deleted.</div>';

$students = mysqli_query($conn, "SELECT * FROM lms_user WHERE permission='student' ORDER BY id DESC");
$active_nav = 'students';
$page_title = 'Students';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — Students</title>
<?php include '../includes/admin_style.php'; ?>
</head>
<body>
<?php include '../includes/admin_sidebar.php'; ?>

<div class="main">
  <div class="topbar">
    <h1>Students</h1>
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

    <!-- ADD STUDENT FORM -->
    <div class="form-card" style="margin-bottom:28px;">
      <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#0a0f2c;margin-bottom:20px;">➕ Add New Student</h3>
      <form method="POST">
        <input type="hidden" name="action" value="add">
        <div class="form-row">
          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="Sara Ahmed" required>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" placeholder="sara123" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="sara@example.com" required>
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="••••••••" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Mobile</label>
            <input type="text" name="mobile" placeholder="03001234567">
          </div>
          <div class="form-group">
            <label>Address</label>
            <input type="text" name="address" placeholder="Islamabad">
          </div>
        </div>
        <button type="submit" class="btn-submit">Add Student</button>
      </form>
    </div>

    <!-- STUDENTS TABLE -->
    <div class="table-card">
      <div class="table-header">
        <h3>All Students (<?= mysqli_num_rows($students) ?>)</h3>
      </div>
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Registered</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i=1; while ($s = mysqli_fetch_assoc($students)): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($s['name']) ?></td>
            <td><?= htmlspecialchars($s['username']) ?></td>
            <td><?= htmlspecialchars($s['email']) ?></td>
            <td><?= htmlspecialchars($s['mobile']) ?></td>
            <td><?= $s['date'] ?></td>
            <td>
              <a href="edit_student.php?id=<?= $s['id'] ?>" class="btn-sm btn-edit">Edit</a>
              <a href="students.php?delete=<?= $s['id'] ?>" class="btn-sm btn-del"
                 onclick="return confirm('Delete this student?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if (mysqli_num_rows($students) == 0): ?>
          <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:30px">No students found. Add one above!</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
