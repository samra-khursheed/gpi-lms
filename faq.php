<?php $active_page = 'faq'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FAQ — GPI H-8 LMS</title>
<?php include 'includes/navbar.php'; ?>
<style>
.page-hero {
  background: linear-gradient(135deg, #0a0f2c 0%, #1a2456 100%);
  padding: 80px 40px; text-align: center; color: white;
}
.page-hero h1 { font-family: 'Syne', sans-serif; font-size: 42px; font-weight: 800; margin-bottom: 14px; }
.page-hero h1 span { color: #f59e0b; }
.page-hero p { color: rgba(255,255,255,0.7); font-size: 16px; max-width: 520px; margin: 0 auto; line-height: 1.7; }

.faq-section { max-width: 780px; margin: 0 auto; padding: 70px 24px; }
.section-tag { font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: #1a56db; font-weight: 700; margin-bottom: 10px; text-align: center; }
.section-title { font-family: 'Syne', sans-serif; font-size: 30px; font-weight: 800; color: #0a0f2c; margin-bottom: 40px; text-align: center; }

.faq-item {
  background: white; border-radius: 14px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  margin-bottom: 14px; overflow: hidden;
  border: 1px solid #f1f5f9;
}
.faq-question {
  padding: 20px 24px;
  display: flex; justify-content: space-between; align-items: center;
  cursor: pointer; user-select: none;
  transition: background 0.15s;
}
.faq-question:hover { background: #f8fafc; }
.faq-question h4 { font-family: 'Syne', sans-serif; font-size: 15px; font-weight: 700; color: #0a0f2c; padding-right: 16px; }
.faq-icon { width: 28px; height: 28px; border-radius: 50%; background: #eff6ff; color: #1a56db; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 700; flex-shrink: 0; transition: transform 0.2s; }
.faq-answer { padding: 0 24px; max-height: 0; overflow: hidden; transition: max-height 0.3s ease, padding 0.3s ease; }
.faq-answer p { color: #475569; font-size: 14.5px; line-height: 1.7; padding-bottom: 20px; }
.faq-item.open .faq-answer { max-height: 300px; }
.faq-item.open .faq-icon { transform: rotate(45deg); background: #1a56db; color: white; }

.faq-cta {
  background: linear-gradient(135deg, #1a56db, #0a0f2c);
  border-radius: 16px; padding: 40px; text-align: center; margin-top: 50px;
}
.faq-cta h3 { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800; color: white; margin-bottom: 10px; }
.faq-cta p { color: rgba(255,255,255,0.7); font-size: 14px; margin-bottom: 22px; }
.btn-primary {
  padding: 12px 28px; background: #f59e0b; color: #0a0f2c;
  border-radius: 9px; font-family: 'Syne', sans-serif; font-size: 14px; font-weight: 700;
  text-decoration: none; display: inline-block; transition: opacity 0.2s;
}
.btn-primary:hover { opacity: 0.88; }

@media (max-width: 600px) {
  .page-hero h1 { font-size: 28px; }
  .page-hero { padding: 60px 20px; }
}
</style>
</head>
<body>

<div class="page-hero">
  <h1>Frequently Asked <span>Questions</span></h1>
  <p>Have questions about the GPI H-8 LMS? Find quick answers below.</p>
</div>

<div class="faq-section">
  <div class="section-tag">Help Center</div>
  <div class="section-title">Common Questions</div>

  <div class="faq-item">
    <div class="faq-question" onclick="toggle(this)">
      <h4>What is the GPI H-8 LMS?</h4>
      <div class="faq-icon">+</div>
    </div>
    <div class="faq-answer">
      <p>The GPI H-8 LMS (Learning Management System) is an online platform for Government Polytechnic Institute H-8, Islamabad. It allows students to access courses, faculty to manage teaching, and admins to oversee the entire system.</p>
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question" onclick="toggle(this)">
      <h4>How do I register as a student?</h4>
      <div class="faq-icon">+</div>
    </div>
    <div class="faq-answer">
      <p>Click the "Register" button on the login page or homepage. Fill in your name, username, email, and password. Once registered, you will automatically be assigned the Student role and can log in immediately.</p>
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question" onclick="toggle(this)">
      <h4>I forgot my password. What should I do?</h4>
      <div class="faq-icon">+</div>
    </div>
    <div class="faq-answer">
      <p>Please contact your institute admin to reset your password. You can reach out via the Contact page or visit the admin office at GPI H-8, Islamabad.</p>
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question" onclick="toggle(this)">
      <h4>What is the difference between Student, Faculty, and Admin roles?</h4>
      <div class="faq-icon">+</div>
    </div>
    <div class="faq-answer">
      <p><strong>Students</strong> can view available courses and their profile. <strong>Faculty</strong> members can view courses and student information. <strong>Admins</strong> have full control — they can add/edit/delete students, faculty, and courses.</p>
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question" onclick="toggle(this)">
      <h4>How do I access my dashboard after login?</h4>
      <div class="faq-icon">+</div>
    </div>
    <div class="faq-answer">
      <p>After logging in with your email and password, the system automatically detects your role and redirects you to your dashboard — Student Dashboard, Faculty Portal, or Admin Panel.</p>
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question" onclick="toggle(this)">
      <h4>Can I use the LMS on my mobile phone?</h4>
      <div class="faq-icon">+</div>
    </div>
    <div class="faq-answer">
      <p>Yes! The LMS is fully responsive and works on all devices including mobile phones, tablets, and desktop computers. Simply open it in your browser.</p>
    </div>
  </div>

  <div class="faq-item">
    <div class="faq-question" onclick="toggle(this)">
      <h4>Who do I contact for technical issues?</h4>
      <div class="faq-icon">+</div>
    </div>
    <div class="faq-answer">
      <p>For technical issues, please visit the Contact page and fill out the form, or directly contact the GPI H-8 IT department at the institute.</p>
    </div>
  </div>

  <div class="faq-cta">
    <h3>Still have questions?</h3>
    <p>Contact us and we'll get back to you as soon as possible.</p>
    <a href="contact.php" class="btn-primary">Contact Us →</a>
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

<script>
function toggle(el) {
  const item = el.parentElement;
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}
</script>
</body>
</html>
