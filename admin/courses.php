<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
include '../includes/db.php';

$msg = '';

// DELETE
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    mysqli_query($conn, "DELETE FROM lms_courses WHERE id=$id");
    header("Location: courses.php?deleted=1"); exit();
}
if (isset($_GET['deleted'])) $msg = '<div class="alert success">Course deleted.</div>';

// ADD
if (isset($_POST['action']) && $_POST['action'] == 'add') {
    $code  = mysqli_real_escape_string($conn, $_POST['course_code']);
    $name  = mysqli_real_escape_string($conn, $_POST['course_name'] ?? '');
    $desc  = mysqli_real_escape_string($conn, $_POST['course_description']);
    $level = mysqli_real_escape_string($conn, $_POST['course_level']);
    $lang  = mysqli_real_escape_string($conn, $_POST['language']);
    $stat  = mysqli_real_escape_string($conn, $_POST['course_status']);
    $faculty_id = isset($_POST['faculty_id']) ? (int)$_POST['faculty_id'] : 0;
    $cat   = mysqli_real_escape_string($conn, $_POST['course_category'] ?? '');

    // Build dynamic insert based on what columns exist
    $sql = "INSERT INTO lms_courses (course_code, course_description, course_level, language, course_status, faculty_id) 
        VALUES ('$code','$desc','$level','$lang','$stat','$faculty_id')";
    if (mysqli_query($conn, $sql)) {
        $msg = '<div class="alert success">✅ Course added!</div>';
    } else {
        $msg = '<div class="alert error">Error: ' . mysqli_error($conn) . '</div>';
    }
}

// Fetch columns to handle dynamic course table
$cols_result = mysqli_query($conn, "SHOW COLUMNS FROM lms_courses");
$col_names = [];
while ($c = mysqli_fetch_assoc($cols_result)) $col_names[] = $c['Field'];

$courses = mysqli_query($conn, "SELECT * FROM lms_courses ORDER BY id DESC");
$faculty_list = mysqli_query($conn, "SELECT id, first_name, last_name FROM lms_faculty ORDER BY first_name");
$active_nav = 'courses'; $page_title = 'Courses';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin — Courses</title>
<?php include '../includes/admin_style.php'; ?>
</head>
<body>
<?php include '../includes/admin_sidebar.php'; ?>
<div class="main">
  <div class="topbar">
    <h1>Courses</h1>
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
      <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#0a0f2c;margin-bottom:20px;">➕ Add New Course</h3>
      <form method="POST">
        <input type="hidden" name="action" value="add">
        <div class="form-row">
          <div class="form-group"><label>Course Code</label><input type="text" name="course_code" placeholder="CS101" required></div>
          <div class="form-group">
            <label>Level</label>
            <select name="course_level">
              <option value="Beginner">Beginner</option>
              <option value="Intermediate">Intermediate</option>
              <option value="Advanced">Advanced</option>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Language</label>
            <input type="text" name="language" value="English">
          </div>
          <div class="form-group">
            <label>Status</label>
            <select name="course_status">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
       <div class="form-group">
        <label>Assign Teacher</label>
        <select name="faculty_id" required>
        <option value="">Select Faculty Member</option>
        <?php 
        $faculty_list = mysqli_query($conn, "SELECT id, first_name, last_name FROM lms_faculty ORDER BY first_name");
        while($f = mysqli_fetch_assoc($faculty_list)): 
        ?>
            <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['first_name'] . ' ' . $f['last_name']) ?></option>
        <?php endwhile; ?>
    </select>
</div>

        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea name="course_description" placeholder="Brief course description..."></textarea>
        </div>
        <button type="submit" class="btn-submit">Add Course</button>
      </form>
    </div>

    <div class="table-card">
      <div class="table-header">
        <h3>All Courses (<?= mysqli_num_rows($courses) ?>)</h3>
      </div>
      <table>
        <thead>
           <tr><th>#</th><th>Code</th><th>Level</th><th>Language</th><th>Teacher</th><th>Status</th><th>Action</th></tr>
        </thead>
        <tbody>
          <?php $i=1; while ($c = mysqli_fetch_assoc($courses)): ?>
          <tr>
            <td><?= $i++ ?></td>
            <td><strong><?= htmlspecialchars($c['course_code']) ?></strong></td>
            <td><?= htmlspecialchars($c['course_level'] ?? '') ?></td>
            <td><?= htmlspecialchars($c['language'] ?? '') ?></td>
            <td>
    <?php
    $t_id = isset($c['faculty_id']) ? $c['faculty_id'] : null;
    if (!empty($t_id)) {
        $t_res = mysqli_query($conn, "SELECT first_name, last_name FROM lms_faculty WHERE id = $t_id");
        if ($t_res && mysqli_num_rows($t_res) > 0) {
            $t_data = mysqli_fetch_assoc($t_res);
            echo htmlspecialchars($t_data['first_name'] . ' ' . $t_data['last_name']);
        } else {
            echo '<span style="color:#94a3b8; font-style:italic;">Unassigned</span>';
        }
    } else {
        echo '<span style="color:#94a3b8; font-style:italic;">Unassigned</span>';
    }
    ?>
</td>
            <td>
              <span class="badge <?= ($c['course_status'] ?? '') == 'active' ? 'active' : 'inactive' ?>">
                <?= htmlspecialchars($c['course_status'] ?? 'N/A') ?>
              </span>
            </td>
            <td>
              <a href="edit_course.php?id=<?= $c['id'] ?>" class="btn-sm btn-edit">Edit</a>
              <a href="courses.php?delete=<?= $c['id'] ?>" class="btn-sm btn-del"
                 onclick="return confirm('Delete this course?')">Delete</a>
            </td>
          </tr>
          <?php endwhile; ?>
          <?php if (mysqli_num_rows($courses) == 0): ?>
          <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:30px">No courses found.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
