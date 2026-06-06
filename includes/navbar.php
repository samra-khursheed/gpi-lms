<?php
$active_page = $active_page ?? '';
?>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
:root {
  --navy: #0a0f2c; --blue: #1a56db; --accent: #f59e0b;
  --white: #fff; --light: #f1f5f9; --muted: #94a3b8;
}
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'DM Sans', sans-serif; color: #1e293b; }

nav {
  background: var(--navy);
  padding: 0 40px;
  display: flex; align-items: center; justify-content: space-between;
  height: 66px;
  position: sticky; top: 0; z-index: 100;
  box-shadow: 0 2px 20px rgba(0,0,0,0.3);
}
.nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
.nav-logo .ico { width: 36px; height: 36px; background: var(--accent); border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; }
.nav-logo .txt { display: flex; flex-direction: column; }
.nav-logo .txt .top { font-family: 'Syne', sans-serif; font-size: 13px; font-weight: 800; color: white; line-height: 1.1; }
.nav-logo .txt .sub { font-size: 10px; color: rgba(255,255,255,0.5); letter-spacing: 0.3px; }

.nav-links { display: flex; align-items: center; gap: 4px; }
.nav-links a {
  padding: 8px 16px; border-radius: 8px;
  color: rgba(255,255,255,0.7); font-size: 14px; font-weight: 500;
  text-decoration: none; transition: color 0.15s, background 0.15s;
}
.nav-links a:hover { color: white; background: rgba(255,255,255,0.08); }
.nav-links a.active { color: white; background: rgba(255,255,255,0.12); }
.nav-links .btn-login {
  margin-left: 8px; padding: 9px 22px;
  background: var(--blue); color: white !important;
  border-radius: 9px; font-weight: 600;
  transition: background 0.2s, box-shadow 0.2s !important;
}
.nav-links .btn-login:hover { background: #1740a8 !important; box-shadow: 0 4px 14px rgba(26,86,219,0.4); }

/* Mobile Menu Toggle Button  */
.menu-toggle {
  display: none;
  flex-direction: column;
  gap: 5px;
  background: none;
  border: none;
  cursor: pointer;
}
.menu-toggle span {
  width: 25px;
  height: 3px;
  background: white;
  border-radius: 2px;
  transition: 0.3s;
}

/* FOOTER */
footer {
  background: var(--navy); color: rgba(255,255,255,0.6);
  padding: 40px; text-align: center; margin-top: 80px;
  font-size: 14px;
}
footer .footer-logo { font-family: 'Syne', sans-serif; font-size: 16px; font-weight: 800; color: white; margin-bottom: 8px; }
footer .footer-logo span { color: var(--accent); }
footer p { margin-top: 6px; font-size: 13px; }
footer .footer-links { display: flex; justify-content: center; gap: 24px; margin: 16px 0; flex-wrap: wrap; }
footer .footer-links a { color: rgba(255,255,255,0.5); text-decoration: none; font-size: 13px; transition: color 0.15s; }
footer .footer-links a:hover { color: white; }

/* RESPONSIVE DESIGN (MOBILE FIX) */
@media (max-width: 680px) {
  nav { padding: 0 16px; position: relative; }
  
  .menu-toggle { display: flex; } /* Show Hamburger Button */

  .nav-links {
    display: none; /* Hide by default on mobile */
    flex-direction: column;
    position: absolute;
    top: 66px; left: 0; width: 100%;
    background: var(--navy);
    padding: 20px;
    gap: 12px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    border-top: 1px solid rgba(255,255,255,0.1);
  }

  .nav-links.open {
    display: flex;
  }

  .nav-links a {
    width: 100%;
    text-align: center;
    padding: 12px;
  }
  
  .nav-links .btn-login {
    margin-left: 0;
    margin-top: 8px;
  }
}
</style>

<nav>
  <a href="index.php" class="nav-logo">
    <div class="ico">🎓</div>
    <div class="txt">
      <span class="top">GPI H-8 Islamabad</span>
      <span class="sub">Learning Management System</span>
    </div>
  </a>

  <button class="menu-toggle" id="mobile-menu-btn">
    <span></span>
    <span></span>
    <span></span>
  </button>

  <div class="nav-links" id="nav-links-container">
    <a href="index.php"   class="<?= $active_page=='home'?'active':'' ?>">Home</a>
    <a href="about.php"   class="<?= $active_page=='about'?'active':'' ?>">About</a>
    <a href="faq.php"     class="<?= $active_page=='faq'?'active':'' ?>">FAQ</a>
    <a href="contact.php" class="<?= $active_page=='contact'?'active':'' ?>">Contact</a>
    <a href="login.php"   class="btn-login">Login</a>
  </div>
</nav>

<script>
  const menuBtn = document.getElementById('mobile-menu-btn');
  const navLinks = document.getElementById('nav-links-container');

  menuBtn.addEventListener('click', () => {
    navLinks.classList.toggle('open');
  });
</script>