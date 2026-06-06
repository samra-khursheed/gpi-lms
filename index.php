<?php
if (isset($_POST['enroll_course'])) {
    if (!isset($_SESSION)) { session_start(); }
    
    if (isset($_SESSION['user_id'])) {
        $student_id = (int)$_SESSION['user_id'];
        $course_id = (int)$_POST['course_id'];
        

        $check_duplicate = mysqli_query($conn, "SELECT id FROM lms_enrollments WHERE student_id = $student_id AND course_id = $course_id");
        
        if (mysqli_num_rows($check_duplicate) == 0) {
      
            mysqli_query($conn, "INSERT INTO lms_enrollments (student_id, course_id) VALUES ($student_id, $course_id)");
            echo "<script>alert('Mubarak ho! Aap is course mein enroll ho chukay hain.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Aap is course mein pehle se hi enroll hain!');</script>";
        }
    } else {
        echo "<script>alert('Enroll karne kay liyay pehle login karein.'); window.location.href='login.php';</script>";
    }
}
?>

<?php $active_page = 'home'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GPI H-8 Islamabad — LMS</title>
<?php include 'includes/navbar.php'; ?>
<style>
/* HERO */
.hero {
  background: linear-gradient(135deg, #0a0f2c 0%, #1a2456 60%, #1a56db 100%);
  min-height: 88vh;
  display: flex; align-items: center; justify-content: center;
  text-align: center; padding: 60px 24px;
  position: relative; overflow: hidden;
}
.hero::before {
  content: '';
  position: absolute; top: -100px; right: -100px;
  width: 500px; height: 500px;
  background: radial-gradient(circle, rgba(245,158,11,0.12) 0%, transparent 70%);
  border-radius: 50%;
}
.hero::after {
  content: '';
  position: absolute; bottom: -80px; left: -80px;
  width: 400px; height: 400px;
  background: radial-gradient(circle, rgba(26,86,219,0.25) 0%, transparent 70%);
  border-radius: 50%;
}
.hero-content { position: relative; z-index: 1; max-width: 720px; }
.hero-badge {
  display: inline-block; padding: 6px 18px;
  background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.3);
  border-radius: 20px; color: #f59e0b; font-size: 13px; font-weight: 600;
  margin-bottom: 24px; letter-spacing: 0.3px;
}
.hero h1 {
  font-family: 'Syne', sans-serif; font-size: 52px; font-weight: 800;
  color: white; line-height: 1.1; margin-bottom: 20px;
}
.hero h1 span { color: #f59e0b; }
.hero p { color: rgba(255,255,255,0.72); font-size: 17px; line-height: 1.7; margin-bottom: 36px; max-width: 560px; margin-left: auto; margin-right: auto; }
.hero-btns { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
.btn-primary {
  padding: 14px 32px; background: #1a56db; color: white;
  border-radius: 10px; font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700;
  text-decoration: none; transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
  display: inline-block;
}
.btn-primary:hover { background: #1740a8; box-shadow: 0 8px 24px rgba(26,86,219,0.4); transform: translateY(-2px); }
.btn-outline {
  padding: 14px 32px; background: transparent;
  border: 2px solid rgba(255,255,255,0.25); color: white;
  border-radius: 10px; font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 600;
  text-decoration: none; transition: border-color 0.2s, background 0.2s;
  display: inline-block;
}
.btn-outline:hover { border-color: rgba(255,255,255,0.6); background: rgba(255,255,255,0.07); }

/* STATS BAR */
.stats-bar {
  background: white;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  padding: 28px 40px;
  display: flex; justify-content: center; gap: 60px; flex-wrap: wrap;
}
.stat-item { text-align: center; }
.stat-item .num { font-family: 'Syne', sans-serif; font-size: 32px; font-weight: 800; color: #1a56db; }
.stat-item .lbl { font-size: 13px; color: #94a3b8; margin-top: 4px; }

/* FEATURES */
.section { padding: 80px 40px; max-width: 1100px; margin: 0 auto; }
.section-tag { font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: #1a56db; font-weight: 700; margin-bottom: 10px; }
.section-title { font-family: 'Syne', sans-serif; font-size: 34px; font-weight: 800; color: #0a0f2c; margin-bottom: 14px; }
.section-sub { color: #64748b; font-size: 16px; line-height: 1.6; max-width: 520px; }

.features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px,1fr)); gap: 22px; margin-top: 48px; }
.feature-card {
  background: white; border-radius: 16px; padding: 28px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.06);
  border: 1px solid #f1f5f9;
  transition: transform 0.2s, box-shadow 0.2s;
}
.feature-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); }
.feature-icon { width: 52px; height: 52px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 18px; }
.feature-icon.blue { background: #eff6ff; }
.feature-icon.amber { background: #fffbeb; }
.feature-icon.green { background: #f0fdf4; }
.feature-icon.purple { background: #faf5ff; }
.feature-card h3 { font-family: 'Syne', sans-serif; font-size: 17px; font-weight: 700; color: #0a0f2c; margin-bottom: 10px; }
.feature-card p { color: #64748b; font-size: 14px; line-height: 1.6; }

/* HOW IT WORKS */
.how-section { background: #f8fafc; padding: 80px 40px; }
.how-inner { max-width: 1100px; margin: 0 auto; }
.steps { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap: 30px; margin-top: 48px; }
.step { text-align: center; }
.step-num { width: 50px; height: 50px; border-radius: 50%; background: #1a56db; color: white; font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 800; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.step h4 { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 700; color: #0a0f2c; margin-bottom: 8px; }
.step p { color: #64748b; font-size: 13.5px; line-height: 1.6; }

/* CTA */
.cta-section {
  background: linear-gradient(135deg, #1a56db 0%, #0a0f2c 100%);
  padding: 80px 40px; text-align: center; margin-top: 0;
}
.cta-section h2 { font-family: 'Syne', sans-serif; font-size: 36px; font-weight: 800; color: white; margin-bottom: 14px; }
.cta-section p { color: rgba(255,255,255,0.7); font-size: 16px; margin-bottom: 32px; }

@media (max-width: 600px) {
  .hero h1 { font-size: 34px; }
  .stats-bar { gap: 30px; padding: 24px 20px; }
  .section { padding: 60px 20px; }
}
</style>
</head>
<body>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-badge">🏛 Government Polytechnic Institute H-8, Islamabad</div>
    <h1>Learn Smarter,<br>Grow <span>Faster</span></h1>
    <p>A modern Learning Management System designed for students and faculty of Government Polytechnic Institute H-8, Islamabad. Access courses, track progress, and connect with teachers — all in one place.</p>
    <div class="hero-btns">
      <a href="register.php" class="btn-primary">Get Started →</a>
      <a href="about.php" class="btn-outline">Learn More</a>
    </div>
  </div>
</section>

<!-- STATS -->
<div class="stats-bar">
  <div class="stat-item"><div class="num">3</div><div class="lbl">User Roles</div></div>
  <div class="stat-item"><div class="num">100%</div><div class="lbl">Free Access</div></div>
  <div class="stat-item"><div class="num">24/7</div><div class="lbl">Available Online</div></div>
  <div class="stat-item"><div class="num">GPI</div><div class="lbl">H-8, Islamabad</div></div>
</div>

<!-- FEATURES -->
<div class="section">
  <div class="section-tag">Why Choose Us</div>
  <div class="section-title">Everything You Need to Learn</div>
  <div class="section-sub">Our LMS brings together all the tools students and faculty need in one easy-to-use platform.</div>

  <div class="features-grid">
    <div class="feature-card">
      <div class="feature-icon blue">📚</div>
      <h3>Course Management</h3>
      <p>Browse and access all available courses. Faculty can manage course content and materials with ease.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon amber">👩‍🎓</div>
      <h3>Student Portal</h3>
      <p>Students get a dedicated dashboard to track their enrolled courses and academic progress.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon purple">👨‍🏫</div>
      <h3>Faculty Panel</h3>
      <p>Faculty members can view their profile, department details, and manage course-related activities.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon green">🔒</div>
      <h3>Secure Access</h3>
      <p>Role-based login ensures each user only sees what they are supposed to — admin, faculty, or student.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon blue">📊</div>
      <h3>Admin Dashboard</h3>
      <p>Admins can manage all students, faculty, and courses from a single clean dashboard.</p>
    </div>
    <div class="feature-card">
      <div class="feature-icon amber">🌐</div>
      <h3>Always Accessible</h3>
      <p>Available 24/7 on any device — desktop, tablet, or mobile. Learn from anywhere, anytime.</p>
    </div>
  </div>
</div>

<!-- HOW IT WORKS -->
<div class="how-section">
  <div class="how-inner">
    <div style="text-align:center;">
      <div class="section-tag" style="display:inline-block;">How It Works</div>
      <div class="section-title">Simple Steps to Get Started</div>
    </div>
    <div class="steps">
      <div class="step">
        <div class="step-num">1</div>
        <h4>Register</h4>
        <p>Create your account using your email. Registration is quick and free.</p>
      </div>
      <div class="step">
        <div class="step-num">2</div>
        <h4>Login</h4>
        <p>Sign in with your credentials. The system will take you to your role-based dashboard.</p>
      </div>
      <div class="step">
        <div class="step-num">3</div>
        <h4>Explore Courses</h4>
        <p>Browse all available courses and access learning materials uploaded by faculty.</p>
      </div>
      <div class="step">
        <div class="step-num">4</div>
        <h4>Learn & Grow</h4>
        <p>Stay connected with your institute and track your academic progress easily.</p>
      </div>
    </div>
  </div>
</div>

<!-- CTA -->
<div class="cta-section">
  <h2>Ready to Start Learning?</h2>
  <p>Join Government Polytechnic Institute H-8 LMS today — it's free!</p>
  <a href="register.php" class="btn-primary" style="font-size:16px;padding:16px 40px;">Register Now →</a>
</div>

<!-- FOOTER -->
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
