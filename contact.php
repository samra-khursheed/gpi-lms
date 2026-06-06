<?php $active_page = 'contact'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact — GPI H-8 LMS</title>
<?php include 'includes/navbar.php'; ?>
<style>
.page-hero {
  background: linear-gradient(135deg, #0a0f2c 0%, #1a2456 100%);
  padding: 80px 40px; text-align: center; color: white;
}
.page-hero h1 { font-family: 'Syne', sans-serif; font-size: 42px; font-weight: 800; margin-bottom: 14px; }
.page-hero h1 span { color: #f59e0b; }
.page-hero p { color: rgba(255,255,255,0.7); font-size: 16px; max-width: 520px; margin: 0 auto; line-height: 1.7; }

.contact-section { max-width: 1100px; margin: 0 auto; padding: 70px 24px; display: grid; grid-template-columns: 1fr 1.4fr; gap: 50px; align-items: start; }

/* INFO SIDE */
.contact-info { }
.section-tag { font-size: 12px; text-transform: uppercase; letter-spacing: 1.5px; color: #1a56db; font-weight: 700; margin-bottom: 10px; }
.section-title { font-family: 'Syne', sans-serif; font-size: 28px; font-weight: 800; color: #0a0f2c; margin-bottom: 16px; }
.contact-info p { color: #475569; font-size: 15px; line-height: 1.7; margin-bottom: 32px; }

.info-cards { display: flex; flex-direction: column; gap: 16px; }
.info-card {
  background: white; border-radius: 14px; padding: 20px 22px;
  display: flex; align-items: center; gap: 16px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.06);
  border: 1px solid #f1f5f9;
}
.info-icon { width: 46px; height: 46px; border-radius: 12px; background: #eff6ff; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; }
.info-text .label { font-size: 11.5px; text-transform: uppercase; letter-spacing: 0.5px; color: #94a3b8; font-weight: 600; margin-bottom: 3px; }
.info-text .value { font-size: 14.5px; font-weight: 600; color: #0a0f2c; }

/* FORM SIDE */
.contact-form-card {
  background: white; border-radius: 18px; padding: 36px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}
.contact-form-card h3 { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 700; color: #0a0f2c; margin-bottom: 6px; }
.contact-form-card .sub { color: #94a3b8; font-size: 14px; margin-bottom: 28px; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.form-group { margin-bottom: 18px; }
.form-group label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 6px; }
.form-group input, .form-group select, .form-group textarea {
  width: 100%; padding: 11px 14px;
  border: 1.5px solid #e2e8f0; border-radius: 9px;
  font-size: 14px; font-family: 'DM Sans', sans-serif;
  background: #f8fafc; color: #0a0f2c; outline: none;
  transition: border-color 0.2s, box-shadow 0.2s;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
  border-color: #1a56db; background: white; box-shadow: 0 0 0 3px rgba(26,86,219,0.1);
}
.form-group textarea { resize: vertical; min-height: 110px; }
.btn-submit {
  width: 100%; padding: 13px; background: #1a56db; color: white;
  border: none; border-radius: 9px; font-size: 15px; font-weight: 700;
  font-family: 'Syne', sans-serif; cursor: pointer;
  transition: background 0.2s, box-shadow 0.2s, transform 0.15s;
}
.btn-submit:hover { background: #1740a8; box-shadow: 0 8px 20px rgba(26,86,219,0.3); transform: translateY(-1px); }

.alert { padding: 12px 16px; border-radius: 9px; margin-bottom: 20px; font-size: 13.5px; }
.alert.success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }

@media (max-width: 768px) {
  .contact-section { grid-template-columns: 1fr; }
  .page-hero h1 { font-size: 28px; }
  .page-hero { padding: 60px 20px; }
  .form-row { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<?php
$sent = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // In a real system you would send email here
  // For now just show success message
  $sent = true;
}
?>

<div class="page-hero">
  <h1>Get In <span>Touch</span></h1>
  <p>Have a question or need help? Reach out to Government Polytechnic Institute H-8, Islamabad.</p>
</div>

<div class="contact-section">
  <!-- INFO -->
  <div class="contact-info">
    <div class="section-tag">Contact Info</div>
    <div class="section-title">We're Here to Help</div>
    <p>For any questions about the LMS, course registration, or technical support — don't hesitate to reach out. Our team at GPI H-8 is happy to assist.</p>

    <div class="info-cards">
      <div class="info-card">
        <div class="info-icon">📍</div>
        <div class="info-text">
          <div class="label">Address</div>
          <div class="value">H-8/1, Islamabad, Pakistan</div>
        </div>
      </div>
      <div class="info-card">
        <div class="info-icon">🏛</div>
        <div class="info-text">
          <div class="label">Institute</div>
          <div class="value">Govt. Polytechnic Institute H-8</div>
        </div>
      </div>
      <div class="info-card">
        <div class="info-icon">🕐</div>
        <div class="info-text">
          <div class="label">Office Hours</div>
          <div class="value">Mon – Sat: 8:00 AM – 4:00 PM</div>
        </div>
      </div>
      <div class="info-card">
        <div class="info-icon">💻</div>
        <div class="info-text">
          <div class="label">LMS Support</div>
          <div class="value">IT Department, GPI H-8</div>
        </div>
      </div>
    </div>
  </div>

  
  <!-- FORM -->
  <div class="contact-form-card">
    <h3>Send a Message</h3>
    <p class="sub">Fill out the form and we'll get back to you shortly.</p>

    <?php if ($sent): ?>
    <div class="alert success">✅ Your message has been sent! We will get back to you soon.</div>
    <?php endif; ?>

    <form method="POST">
      <div class="form-row">
        <div class="form-group">
          <label>Full Name</label>
          <input type="text" name="name" placeholder="Sara Ahmed" required>
        </div>
        <div class="form-group">
          <label>Email Address</label>
          <input type="email" name="email" placeholder="sara@example.com" required>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Phone (Optional)</label>
          <input type="text" name="phone" placeholder="03001234567">
        </div>
        <div class="form-group">
          <label>Role</label>
          <select name="role">
            <option value="">Select your role</option>
            <option value="student">Student</option>
            <option value="faculty">Faculty</option>
            <option value="other">Other</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Subject</label>
        <input type="text" name="subject" placeholder="e.g. Login issue, Course query..." required>
      </div>
      <div class="form-group">
        <label>Message</label>
        <textarea name="message" placeholder="Describe your issue or question in detail..." required></textarea>
      </div>
      <button type="submit" class="btn-submit">Send Message →</button>
    </form>
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
