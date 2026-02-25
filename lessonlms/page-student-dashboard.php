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
  width: 15%;
  height: 300px; /* only for demonstration, should be removed */
  background: #ccc;
  padding: 20px;
}

/* Style the list inside the menu */
.std-sidebar ul {
  list-style-type: none;
  padding: 0;
}

.std-sidebar ul li{
  cursor: pointer;
  padding: 10px;
}

.std-sidebar ul li:hover{
  color: black;
  background-color: aquamarine;
  padding: 10px;
  border-radius: 20px;  
  cursor: pointer;
}
.side-tab-active{
  color: black;
  background-color: aquamarine;
  padding: 10px;
  border-radius: 20px;  
  cursor: pointer;
}

.std-data {
  float: left;
  padding: 20px;
  width: 85%;
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
  #dashboard{
        background-color: white;
        height: 300px;
        width: 85%;
    }
</style>
<section>
    <?php get_template_part( $path . 'sidebar');?>
    <?php get_template_part( $path . 'dashboard'); ?>
    <?php get_template_part( $path . 'profile'); ?>
    <?php get_template_part( $path . 'enroll-course'); ?>
</section>

<?php
get_footer(); ?>
