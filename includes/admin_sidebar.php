<?php
$active_nav = $active_nav ?? '';
$initials = strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1));
?>
<div class="sidebar">
  <div class="sidebar-logo">
    <div class="icon">🎓</div>
    <div class="name">Learn<span>MS</span></div>
  </div>

  <div class="sidebar-section">Main Menu</div>
  <nav>
    <a href="dashboard.php" class="<?= $active_nav=='dashboard'?'active':'' ?>">
      <span class="ico">📊</span> Dashboard
    </a>
    <a href="students.php" class="<?= $active_nav=='students'?'active':'' ?>">
      <span class="ico">👩‍🎓</span> Students
    </a>
    <a href="faculty.php" class="<?= $active_nav=='faculty'?'active':'' ?>">
      <span class="ico">👨‍🏫</span> Faculty
    </a>
    <a href="courses.php" class="<?= $active_nav=='courses'?'active':'' ?>">
      <span class="ico">📚</span> Courses
    </a>
  </nav>

  <div class="sidebar-footer">
    <div style="display:flex;align-items:center;gap:10px;padding:10px 12px;margin-bottom:4px;">
      <div class="avatar"><?= $initials ?></div>
      <div class="user-info">
        <div class="uname"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></div>
        <div class="urole">Admin</div>
      </div>
    </div>
    <a href="../logout.php">🚪 Sign Out</a>
  </div>
</div>
