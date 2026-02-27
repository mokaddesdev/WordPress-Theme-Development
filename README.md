# Lesson LMS WordPress Theme

## Overview
**Lesson LMS** is a modern, responsive, and fully functional WordPress Learning Management System (LMS) theme. It is designed for online course platforms, supporting instructors, students, and administrators with role-based dashboards and a secure WooCommerce integration for course sales.

This theme is built following WordPress coding standards, SEO-friendly practices, and pixel-perfect conversion from Figma designs.

---

## Features

### Course Management
- Custom Post Type for courses
- WooCommerce integration for pricing, cart, and checkout
- Add to Cart functionality
- Wishlist support
- Real-time course data display on homepage banner
- Instructor/Admin course management

### User Management & Roles
- Role-based authentication system:
  - Student
  - Instructor
  - Admin
- Separate dashboards for each role
- User registration and login
- Student dashboard:
  - Purchased courses
  - Learning progress
  - Purchase history
- Instructor dashboard for course & post management

### Reviews & Testimonials
- Users can submit course reviews (rating, name, description)
- Testimonial system:
  - Only users with at least one purchased course can submit
  - Admin approval required
  - Prevents fake submissions

### WooCommerce Integration
- Cart system & checkout process
- Mini Cart in header (Go to Cart & Checkout)
- Course image/title redirect to Single Course page
- Empty cart redirects to all courses page
- “Enroll Now” button after purchase

### Learning & Progress
- Real-time progress tracking
- Mark course completion
- Leadership/ranking system per course

### Security & Validation
- Google reCAPTCHA integration
- Role-based access control
- Secure data validation & sanitization
- Admin approval for testimonials

### Design & UI/UX
- Pixel-perfect Figma to WordPress conversion
- Responsive layout
- Cross-browser compatible
- Animate.css animations
- SweetAlert v2 interactive messages

### SEO & Performance
- Semantic HTML structure
- Optimized CSS & JS loading
- Image optimization
- SEO-friendly permalinks
- Schema-ready structure

### Internationalization
- Translation-ready theme
- Compatible with multilingual plugins

---

## Technology Stack
- **HTML5, CSS3, JavaScript, jQuery, AJAX**
- **PHP & WordPress Theme/Plugin Development**
- **WooCommerce Integration**
- **Animate.css**
- **SweetAlert v2**
- **Google reCAPTCHA**

---

## Installation
1. Upload the theme folder to `/wp-content/themes/`  
2. Activate the theme in WordPress Admin  
3. Install and activate required plugins:
   - WooCommerce  
   - Custom LMS plugins (if any)  
4. Configure theme settings:
   - Dashboard setup for Students, Instructors, Admin  
   - Google reCAPTCHA keys  
5. Import demo content (optional)  
6. Start adding courses and content  

---

lesson-lms/
├─ assets/
│ ├─ css/
│ ├─ js/
│ └─ images/
├─ inc/
├─ templates/
├─ widgets/
├─ languages/
├─ functions.php
├─ style.css
└─ index.php

## Folder Structure


---

## Dashboard Summary

| Feature                 | Student | Instructor | Admin |
|-------------------------|---------|------------|-------|
| Register/Login          | ✅      | ✅         | ✅    |
| Course Purchase         | ✅      | ❌         | ❌    |
| Add to Wishlist         | ✅      | ❌         | ❌    |
| Submit Review           | ✅      | ❌         | ❌    |
| Submit Testimonial      | ✅      | ❌         | ❌    |
| Manage Courses          | ❌      | ✅         | ✅    |
| Approve Testimonials    | ❌      | ❌         | ✅    |
| View Analytics          | Limited | Yes        | Full  |

---

## Security Measures
- Google reCAPTCHA for spam prevention  
- Role-based authentication & access control  
- Admin approval for user-submitted content  
- Data sanitization & validation  

---

## License
This theme is proprietary and distributed for licensed use. Please contact the developer for commercial licensing or redistribution.

---

## Contact
For support or inquiries: **mokaddes.ru2000@gmail.com**

---