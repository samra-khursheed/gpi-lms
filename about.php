<?php $active_page = 'about'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About — GPI H-8 LMS</title>
<?php include 'includes/navbar.php'; ?>
<style>
.page-hero {
  background: linear-gradient(135deg, #0a0f2c 0%, #1a2456 100%);
  padding: 80px 40px; text-align: center; color: white;
}
.page-hero h1 { font-family: 'Syne', sans-serif; font-size: 42px; font-weight: 800; margin-bottom: 14px; }
.page-hero h1 span { color: #f59e0b; }
.page-hero p { color: rgba(255,255,255,0.7); font-size: 16px; max-width: 560px; margin: 0 auto; line-height: 1.7; }

.section { padding: 70px 40px; max-width: 1100px; margin: 0 auto; }
.section-tag { font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: #1a56db; font-weight: 700; margin-bottom: 10px; }
.section-title { font-family: 'Syne', sans-serif; font-size: 30px; font-weight: 800; color: #0a0f2c; margin-bottom: 16px; }

.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
.about-text p { color: #475569; font-size: 15px; line-height: 1.8; margin-bottom: 16px; }
.about-image {
  background: linear-gradient(135deg, #eff6ff, #e0e7ff);
  border-radius: 20px; padding: 48px;
  display: flex; flex-direction: column; gap: 20px;
}
.about-stat { display: flex; align-items: center; gap: 16px; }
.about-stat .icon { width: 48px; height: 48px; border-radius: 12px; background: white; display: flex; align-items: center; justify-content: center; font-size: 22px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); flex-shrink: 0; }
.about-stat .info .num { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800; color: #1a56db; }
.about-stat .info .lbl { font-size: 13px; color: #64748b; }

.mission-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px,1fr)); gap: 22px; margin-top: 40px; }
.mission-card { background: white; border-radius: 14px; padding: 26px; box-shadow: 0 2px 10px rgba(0,0,0,0.06); border-left: 4px solid #1a56db; }
.mission-card h4 { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 700; color: #0a0f2c; margin-bottom: 10px; }
.mission-card p { color: #64748b; font-size: 14px; line-height: 1.6; }

.roles-section { background: #f8fafc; padding: 70px 40px; }
.roles-inner { max-width: 1100px; margin: 0 auto; }
.roles-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; margin-top: 40px; }
.role-card { background: white; border-radius: 16px; padding: 30px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.06); }
.role-icon { font-size: 40px; margin-bottom: 14px; }
.role-card h3 { font-family: 'Syne', sans-serif; font-size: 18px; font-weight: 700; color: #0a0f2c; margin-bottom: 10px; }
.role-card p { color: #64748b; font-size: 14px; line-height: 1.6; }

@media (max-width: 700px) {
  .about-grid, .roles-grid { grid-template-columns: 1fr; }
  .page-hero h1 { font-size: 28px; }
  .section { padding: 50px 20px; }
}
</style>
</head>
<body>

<div class="page-hero">
  <h1>About <span>GPI H-8 LMS</span></h1>
  <p>Learn about Government Polytechnic Institute H-8, Islamabad and our Learning Management System built to empower students and faculty.</p>
</div>

<!-- ABOUT -->
<div class="section">
  <div class="about-grid">
    <div class="about-text">
      <div class="section-tag">Who We Are</div>
      <div class="section-title">Government Polytechnic Institute H-8, Islamabad</div>
      <p>Government Polytechnic Institute (GPI) H-8, Islamabad is one of Pakistan's leading technical education institutions, dedicated to providing quality technical and vocational education to students across the region.</p>
      <p>Our Learning Management System (LMS) is designed to bridge the gap between students and faculty, making education more accessible, organized, and effective in the digital age.</p>
      <p>The LMS allows students to access course information, connect with faculty, and manage their academic journey — all from one convenient platform.</p>
    </div>
    <div class="about-image">
      <div class="about-stat">
        <div class="icon">🏛</div>
        <div class="info"><div class="num">GPI H-8</div><div class="lbl">Islamabad, Pakistan</div></div>
      </div>
      <div class="about-stat">
        <div class="icon">🎓</div>
        <div class="info"><div class="num">DAE Programs</div><div class="lbl">Diploma of Associate Engineering</div></div>
      </div>
      <div class="about-stat">
        <div class="icon">👩‍💻</div>
        <div class="info"><div class="num">CIT & More</div><div class="lbl">Computer Information Technology</div></div>
      </div>
      <div class="about-stat">
        <div class="icon">📍</div>
        <div class="info"><div class="num">H-8/1</div><div class="lbl">Islamabad, Pakistan</div></div>
      </div>
    </div>
  </div>
</div>

<!-- MISSION -->
<div style="background:#f8fafc; padding: 70px 40px;">
  <div style="max-width:1100px; margin:0 auto;">
    <div class="section-tag">Our Purpose</div>
    <div class="section-title">Mission & Vision</div>
    <div class="mission-grid">
      <div class="mission-card">
        <h4>🎯 Our Mission</h4>
        <p>To provide accessible, high-quality technical education and empower students with digital tools that prepare them for the modern workforce.</p>
      </div>
      <div class="mission-card" style="border-left-color:#f59e0b;">
        <h4>🔭 Our Vision</h4>
        <p>To become a leading technical institute where every student has equal access to learning resources and opportunities through technology.</p>
      </div>
      <div class="mission-card" style="border-left-color:#10b981;">
        <h4>💡 Our Values</h4>
        <p>Excellence in education, inclusivity, integrity, and a commitment to bridging the digital divide for students across Pakistan.</p>
      </div>
    </div>
  </div>
</div>

<!-- ROLES -->
<div class="roles-section">
  <div class="roles-inner">
    <div style="text-align:center; margin-bottom: 0;">
      <div class="section-tag" style="display:inline-block;">System Users</div>
      <div class="section-title" style="text-align:center;">Who Uses This LMS?</div>
    </div>
    <div class="roles-grid">
      <div class="role-card">
        <div class="role-icon">👩‍🎓</div>
        <h3>Students</h3>
        <p>Register, login, and access all available courses. View course details, faculty information, and manage your academic profile.</p>
      </div>
      <div class="role-card">
        <div class="role-icon">👨‍🏫</div>
        <h3>Faculty</h3>
        <p>Faculty members get a dedicated portal to view their profile, department, courses, and connect with students effectively.</p>
      </div>
      <div class="role-card">
        <div class="role-icon">🛡</div>
        <h3>Admin</h3>
        <p>Administrators manage the entire system — adding students, faculty, courses, and overseeing all platform activities.</p>
      </div>
    </div>
  </div>
</div>

<footer>
  <div class="footer-logo">GPI <span>H-8</span> LMS</div>
  <div class="footer-links">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="faq.php">FAQ</a>
    <a href="contact.php">Contact</a>
    <a href="login.php">Login</a>
  </div>
  <p>© 2024 Government Polytechnic Institute H-8, Islamabad. All rights reserved.</p>
</footer>
</body>
</html>
