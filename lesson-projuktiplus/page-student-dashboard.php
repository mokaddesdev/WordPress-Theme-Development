<?php
/*
Template Name: Student Dashboard
*/
get_header();
if ( ! is_user_logged_in() ) {
    wp_redirect(  wp_login_url() );
    exit;
}
?>
<style>
.std-sidebar {
  float: left;
  width: 30%;
  height: 300px; /* only for demonstration, should be removed */
  background: #ccc;
  padding: 20px;
}

/* Style the list inside the menu */
.std-sidebar ul {
  list-style-type: none;
  padding: 0;
}

.std-data {
  float: left;
  padding: 20px;
  width: 70%;
  background-color: #f1f1f1;
  height: 300px; /* only for demonstration, should be removed */
}

/* Clear floats after the columns */
section::after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive layout - makes the two columns/boxes stack on top of each other instead of next to each other, on small screens */
@media (max-width: 600px) {
  .std-sidebar, .std-data {
    width: 100%;
    height: auto;
  }
}
</style>

<section>
    <?php get_template_part('template-parts/student-dashboard/student', 'sidebar');?>
  
  <article class="std-data">
    <div class="student-sidebar-tab student-active student-dashboard-main" id="dashboard">'
    <?php get_template_part('template-parts/student-dashboard/student', 'dashboard'); ?>

</div>';
<div class="student-sidebar-tab" id="profile">
    <?php get_template_part('template-parts/student-dashboard/student', 'profile'); ?>
</div>
<div class="student-sidebar-tab" id="enrollments">
    <?php get_template_part('template-parts/student-dashboard/student', 'enrollemts'); ?>
</div>
  </article>
</section>

<?php
get_footer(); ?>
