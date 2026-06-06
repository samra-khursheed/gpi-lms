# 🎓 GPI H-8 LMS — Learning Management System

> A fully functional, role-based Learning Management System built for **Government Polytechnic Institute H-8, Islamabad, Pakistan.**

🌐 **Live Demo:** [https://gpi-lms.free.nf](https://gpi-lms.free.nf)

---

## 📌 About The Project

This LMS was designed and developed as a complete web-based platform to digitize the learning experience at Government Polytechnic Institute H-8, Islamabad. It enables students to enroll in courses and access video lectures, faculty to manage their profiles and courses, and administrators to oversee the entire system — all from one clean, modern interface.

The project reflects my long-term goal of building affordable digital learning tools for students in Pakistan, bridging the gap between traditional education and modern technology.





---

## 🌟 Features

### 👩‍🎓 Student Portal
- Register & login with secure role-based authentication
- View and enroll in available courses
- Track enrolled courses separately with "Joined" status
- Watch embedded YouTube video lectures per course
- Responsive dashboard accessible on mobile & desktop

### 👨‍🏫 Faculty Portal
- Dedicated faculty dashboard
- View profile details (designation, department, experience)
- Browse all active courses and student stats

### 🛡️ Admin Panel
- Full CRUD for Students — Add, Edit, Delete
- Full CRUD for Faculty — Add, Edit, Delete
- Full CRUD for Courses — Add, Edit, Delete
- Dashboard with live stats (total students, faculty, courses)
- Role-based access control

### 🌐 Public Pages
- **Home** — Hero section, features, how it works, CTA
- **About** — Institute info, mission, vision, roles overview
- **FAQ** — Interactive accordion with common questions
- **Contact** — Contact form with institute details
- Sticky navbar with mobile hamburger menu
- Shared header & footer across all pages

---

## 🛠️ Tech Stack

| Technology | Usage |
|------------|-------|
| **PHP** | Backend logic, sessions, authentication |
| **MySQL** | Database (via XAMPP / phpMyAdmin) |
| **HTML5** | Page structure and semantics |
| **CSS3** | Styling, animations, responsive design |
| **JavaScript** | Interactive UI (FAQ accordion, hamburger menu) |
| **YouTube iFrame API** | Embedded video lectures |
| **Google Fonts** | Syne + DM Sans typography |

---

## 🗄️ Database Structure

**Database:** `lms_db`

| Table | Description |
|-------|-------------|
| `lms_user` | All users — students, faculty, admin (role via `permission` field) |
| `lms_faculty` | Faculty profiles — designation, department, experience |
| `lms_courses` | Course catalog — code, title, level, description, status |
| `lms_enrollments` | Student-course enrollment records |

---

## 📁 Project Structure

lms/
├── index.php              # Home page
├── about.php              # About page
├── faq.php                # FAQ page
├── contact.php            # Contact page
├── login.php              # Login (role-based redirect)
├── register.php           # Student registration
├── logout.php             # Session destroy
│
├── includes/
│   ├── db.php             # Database connection
│   ├── navbar.php         # Shared header/navbar
│   ├── admin_style.php    # Admin panel CSS
│   └── admin_sidebar.php  # Admin sidebar
│
├── admin/
│   ├── dashboard.php      # Admin dashboard + stats
│   ├── students.php       # Manage students
│   ├── faculty.php        # Manage faculty
│   ├── courses.php        # Manage courses
│   ├── edit_student.php   # Edit student
│   ├── edit_faculty.php   # Edit faculty
│   └── edit_course.php    # Edit course
│
├── student/
│   ├── dashboard.php      # Student dashboard + enrollment
│   └── course.php         # Course detail + video player
│
└── faculty/
└── dashboard.php      # Faculty portal

---

## 🔐 Demo Access & Screenshots

| Role | Email / Username | Password |
|------|-------|----------|
| **Student** | `sara@gmail.com` | `123` |
| **Faculty** | *Available upon request* | *Available upon request* |
| **Admin** | *Available upon request* | *Available upon request* |

### 🛡️ Admin Dashboard Preview
Here is a preview of the secure Admin Panel interface:

![Admin Dashboard]("img width="1922" height="935" alt="admin_ss" src="https://github.com/user-attachments/assets/3d8dc98a-3bbc-4e4e-ba18-a08108fdfb62")



---


👩‍💻 Developer
Samra Khursheed
DAE — Computer Information Technology
Government Polytechnic Institute for Women, H-8/1, Islamabad, Pakistan

🔗 GitHub: github.com/samra-khursheed
🌐 Portfolio: samra-khursheed.github.io/Portfolio

💡 Motivation
This project was built with a purpose beyond a college assignment. Growing up in Pakistan and witnessing the lack of digital learning tools in technical institutes, I wanted to create something practical and impactful — a platform that real students and teachers could actually use.

My long-term vision is to build affordable, accessible digital education tools for underserved students across Pakistan, and this LMS is a step in that direction.

📄 License
This project is open source and available under the MIT License.

⭐ If this project inspired you or was helpful, please consider giving it a star!
It means a lot and helps others discover this work. Thank you! 🙏






























