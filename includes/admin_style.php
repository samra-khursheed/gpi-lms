<?php
?>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --navy: #0a0f2c; --blue: #1a56db; --sky: #60a5fa; --accent: #f59e0b;
    --white: #fff; --light: #f1f5f9; --muted: #94a3b8;
    --sidebar-w: 240px;
  }
  body { font-family: 'DM Sans', sans-serif; background: #f8fafc; color: #1e293b; }

  /* SIDEBAR */
  .sidebar {
    position: fixed; top: 0; left: 0;
    width: var(--sidebar-w); height: 100vh;
    background: var(--navy);
    display: flex; flex-direction: column;
    z-index: 100; overflow-y: auto;
  }
  .sidebar-logo {
    padding: 24px 20px;
    display: flex; align-items: center; gap: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.08);
  }
  .sidebar-logo .icon { width:36px; height:36px; background:var(--accent); border-radius:9px; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
  .sidebar-logo .name { font-family:'Syne',sans-serif; font-size:17px; font-weight:800; color:white; }
  .sidebar-logo .name span { color:var(--accent); }

  .sidebar-section { padding: 18px 14px 6px; font-size:10px; text-transform:uppercase; letter-spacing:1px; color:rgba(255,255,255,0.35); font-weight:600; }

  .sidebar nav a {
    display: flex; align-items: center; gap: 11px;
    padding: 11px 16px; margin: 2px 8px;
    border-radius: 9px;
    color: rgba(255,255,255,0.65);
    text-decoration: none; font-size: 14px; font-weight: 500;
    transition: background 0.15s, color 0.15s;
  }
  .sidebar nav a:hover { background: rgba(255,255,255,0.08); color: white; }
  .sidebar nav a.active { background: var(--blue); color: white; }
  .sidebar nav a .ico { font-size: 17px; width: 22px; text-align:center; }

  .sidebar-footer {
    margin-top: auto;
    padding: 16px 14px;
    border-top: 1px solid rgba(255,255,255,0.08);
  }
  .sidebar-footer a {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 9px;
    color: rgba(255,255,255,0.5); font-size: 13.5px;
    text-decoration: none; transition: color 0.15s, background 0.15s;
  }
  .sidebar-footer a:hover { background: rgba(255,0,0,0.1); color: #f87171; }

  /* MAIN */
  .main { margin-left: var(--sidebar-w); min-height: 100vh; }

  .topbar {
    background: white; border-bottom: 1px solid #e2e8f0;
    padding: 16px 28px;
    display: flex; align-items: center; justify-content: space-between;
    position: sticky; top: 0; z-index: 50;
  }
  .topbar h1 { font-family:'Syne',sans-serif; font-size:20px; font-weight:700; color:var(--navy); }
  .topbar-user { display:flex; align-items:center; gap:10px; }
  .avatar {
    width:36px; height:36px; border-radius:50%;
    background: var(--blue); color:white;
    display:flex; align-items:center; justify-content:center;
    font-weight:700; font-size:14px;
  }
  .user-info .uname { font-size:13.5px; font-weight:600; color:var(--navy); }
  .user-info .urole { font-size:11.5px; color:var(--muted); text-transform:capitalize; }

  .content { padding: 28px; }

  /* CARDS */
  .stat-cards { display:grid; grid-template-columns: repeat(auto-fit, minmax(200px,1fr)); gap:18px; margin-bottom:28px; }
  .stat-card {
    background: white; border-radius: 14px;
    padding: 22px 24px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    display: flex; align-items: center; gap: 16px;
  }
  .stat-icon { width:50px; height:50px; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:22px; flex-shrink:0; }
  .stat-icon.blue { background:#eff6ff; }
  .stat-icon.green { background:#f0fdf4; }
  .stat-icon.amber { background:#fffbeb; }
  .stat-icon.purple { background:#faf5ff; }
  .stat-num { font-family:'Syne',sans-serif; font-size:28px; font-weight:800; color:var(--navy); line-height:1; }
  .stat-label { font-size:13px; color:var(--muted); margin-top:3px; }

  /* TABLE */
  .table-card { background:white; border-radius:14px; box-shadow:0 1px 4px rgba(0,0,0,0.06); overflow:hidden; }
  .table-header { padding:18px 22px; display:flex; align-items:center; justify-content:space-between; border-bottom:1px solid #f1f5f9; }
  .table-header h3 { font-family:'Syne',sans-serif; font-size:16px; font-weight:700; color:var(--navy); }
  .btn-add {
    padding:9px 18px; background:var(--blue); color:white;
    border:none; border-radius:8px; font-size:13px; font-weight:600;
    font-family:'Syne',sans-serif; cursor:pointer; text-decoration:none;
    display:inline-flex; align-items:center; gap:6px;
    transition:background 0.2s;
  }
  .btn-add:hover { background:#1740a8; }
  table { width:100%; border-collapse:collapse; }
  thead th { padding:11px 16px; text-align:left; font-size:11.5px; text-transform:uppercase; letter-spacing:0.5px; color:var(--muted); font-weight:600; background:#fafafa; border-bottom:1px solid #f1f5f9; }
  tbody td { padding:13px 16px; font-size:14px; border-bottom:1px solid #f8fafc; color:#334155; }
  tbody tr:last-child td { border-bottom:none; }
  tbody tr:hover { background:#fafafa; }

  .badge {
    display:inline-block; padding:3px 10px; border-radius:20px;
    font-size:11.5px; font-weight:600; text-transform:capitalize;
  }
  .badge.active   { background:#dcfce7; color:#166534; }
  .badge.inactive { background:#fee2e2; color:#991b1b; }
  .badge.student  { background:#eff6ff; color:#1e40af; }
  .badge.faculty  { background:#faf5ff; color:#6b21a8; }
  .badge.admin    { background:#fff7ed; color:#9a3412; }

  .btn-sm {
    padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600;
    cursor:pointer; border:none; text-decoration:none; display:inline-block;
    transition:opacity 0.15s;
  }
  .btn-sm:hover { opacity:0.8; }
  .btn-edit  { background:#eff6ff; color:var(--blue); }
  .btn-del   { background:#fef2f2; color:#dc2626; }

  /* FORM */
  .form-card { background:white; border-radius:14px; box-shadow:0 1px 4px rgba(0,0,0,0.06); padding:28px 32px; max-width:650px; }
  .form-row { display:grid; grid-template-columns:1fr 1fr; gap:18px; }
  .form-group { margin-bottom:18px; }
  .form-group label { display:block; font-size:13px; font-weight:500; color:#374151; margin-bottom:6px; }
  .form-group input, .form-group select, .form-group textarea {
    width:100%; padding:10px 14px;
    border:1.5px solid #e2e8f0; border-radius:9px;
    font-size:14px; font-family:'DM Sans',sans-serif;
    background:#f8fafc; color:var(--navy); outline:none;
    transition:border-color 0.2s, box-shadow 0.2s;
  }
  .form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    border-color:var(--blue); background:white; box-shadow:0 0 0 3px rgba(26,86,219,0.1);
  }
  .form-group textarea { resize:vertical; min-height:80px; }
  .btn-submit {
    padding:12px 28px; background:var(--blue); color:white;
    border:none; border-radius:9px; font-size:14px; font-weight:600;
    font-family:'Syne',sans-serif; cursor:pointer;
    transition:background 0.2s, box-shadow 0.2s;
  }
  .btn-submit:hover { background:#1740a8; box-shadow:0 6px 16px rgba(26,86,219,0.3); }

  .alert { padding:12px 16px; border-radius:9px; margin-bottom:20px; font-size:13.5px; }
  .alert.success { background:#f0fdf4; border:1px solid #bbf7d0; color:#166534; }
  .alert.error   { background:#fef2f2; border:1px solid #fecaca; color:#dc2626; }
</style>
