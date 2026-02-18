<?php
/*
Template Name: Student Dashboard
*/
get_header();
if ( ! is_user_logged_in() ) {
    wp_redirect(  wp_login_url() );
    exit;
}
$path = 'template-parts/student-dashboard/';
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

@media (max-width: 600px) {
  .std-sidebar, .std-data {
    width: 100%;
    height: auto;
  }
}
</style>

<section>
    <?php get_template_part( $path . 'sidebar');?>
  
  <article class="std-data">
    <div class="std-sidebar-tab student-active student-dashboard-main" id="dashboard">'
    <?php get_template_part( $path . 'dashboard'); ?>

</div>';
<div class="std-sidebar-tab" id="profile">
    <?php get_template_part( $path . 'profile'); ?>
</div>
<div class="std-sidebar-tab" id="enrollments">
    <?php get_template_part( $path . 'enroll-course'); ?>
</div>
  </article>
</section>

<?php
get_footer(); ?>
