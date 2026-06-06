<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
include '../includes/db.php';

$id = (int)($_GET['id'] ?? 0);
$msg = '';
$c = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_courses WHERE id=$id"));
if (!$c) { header("Location: courses.php"); exit(); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $code  = mysqli_real_escape_string($conn, $_POST['course_code']);
    $desc  = mysqli_real_escape_string($conn, $_POST['course_description']);
    $level = mysqli_real_escape_string($conn, $_POST['course_level']);
    $lang  = mysqli_real_escape_string($conn, $_POST['language']);
    $stat  = mysqli_real_escape_string($conn, $_POST['course_status']);
    $faculty_id = isset($_POST['faculty_id']) ? (int)$_POST['faculty_id'] : 0;
   mysqli_query($conn, "UPDATE lms_courses SET course_code='$code', course_description='$desc', course_level='$level', language='$lang', course_status='$stat', faculty_id='$faculty_id' WHERE id=$id");
    $msg = '<div class="alert success">✅ Course updated!</div>';
    $c = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM lms_courses WHERE id=$id"));
}
$active_nav = 'courses'; $page_title = 'Edit Course';
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Edit Course</title><?php include '../includes/admin_style.php'; ?></head>
<body>
<?php include '../includes/admin_sidebar.php'; ?>
<div class="main">
  <div class="topbar"><h1>Edit Course</h1></div>
  <div class="content">
    <?= $msg ?>
    <div class="form-card">
      <h3 style="font-family:'Syne',sans-serif;font-size:16px;font-weight:700;color:#0a0f2c;margin-bottom:20px;">
        Editing: <?= htmlspecialchars($c['course_code']) ?>
      </h3>
      <form method="POST">
        <div class="form-row">
          <div class="form-group"><label>Course Code</label><input type="text" name="course_code" value="<?= htmlspecialchars($c['course_code']) ?>" required></div>
          <div class="form-group">
            <label>Level</label>
            <select name="course_level">
              <?php foreach(['Beginner','Intermediate','Advanced'] as $l): ?>
              <option value="<?= $l ?>" <?= ($c['course_level']==$l)?'selected':'' ?>><?= $l ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group"><label>Language</label><input type="text" name="language" value="<?= htmlspecialchars($c['language']) ?>"></div>
          <div class="form-group">
            <label>Status</label>
            <select name="course_status">
              <option value="active" <?= ($c['course_status']=='active')?'selected':'' ?>>Active</option>
              <option value="inactive" <?= ($c['course_status']=='inactive')?'selected':'' ?>>Inactive</option>
            </select>
            <div class="form-group">
    <label>Assign Teacher</label>
    <select name="faculty_id" required>
        <option value="">Select Faculty Member</option>
        <?php 
        $faculty_list = mysqli_query($conn, "SELECT id, first_name, last_name FROM lms_faculty ORDER BY first_name");
        while($f = mysqli_fetch_assoc($faculty_list)): 
            // Agar is course ko pehle se yeh teacher mila hua thha, toh woh select rahega
            $selected = ($f['id'] == ($c['faculty_id'] ?? 0)) ? 'selected' : '';
        ?>
            <option value="<?= $f['id'] ?>" <?= $selected ?>><?= htmlspecialchars($f['first_name'] . ' ' . $f['last_name']) ?></option>
        <?php endwhile; ?>
    </select>
</div>
          </div>
              </div>
        <div class="form-group"><label>Description</label><textarea name="course_description"><?= htmlspecialchars($c['course_description'] ?? '') ?></textarea></div>
        <div style="display:flex;gap:12px;align-items:center;margin-top:8px;">
          <button type="submit" class="btn-submit">Save Changes</button>
          <a href="courses.php" style="color:#94a3b8;font-size:14px;text-decoration:none;">← Back to Courses</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
