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
/* Style the header */
header {
  background-color: #666;
  padding: 30px;
  text-align: center;
  font-size: 35px;
  color: white;
}

/* Create two columns/boxes that floats next to each other */
nav {
  float: left;
  width: 30%;
  height: 300px; /* only for demonstration, should be removed */
  background: #ccc;
  padding: 20px;
}

/* Style the list inside the menu */
nav ul {
  list-style-type: none;
  padding: 0;
}

article {
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

/* Style the footer */
footer {
  background-color: #777;
  padding: 10px;
  text-align: center;
  color: white;
}

/* Responsive layout - makes the two columns/boxes stack on top of each other instead of next to each other, on small screens */
@media (max-width: 600px) {
  nav, article {
    width: 100%;
    height: auto;
  }
}
</style>

<body>


<section>
  <nav>
    <?php get_template_part('template-parts/student-dashboard/student', 'sidebar');?>
    <ul>
      <li><a href="#">London</a></li>
      <li><a href="#">Paris</a></li>
      <li><a href="#">Tokyo</a></li>
    </ul>
  </nav>
  
  <article>
    <h1>London</h1>
    <p>London is the capital city of England. It is the most populous city in the  United Kingdom, with a metropolitan area of over 13 million inhabitants.</p>
    <p>Standing on the River Thames, London has been a major settlement for two millennia, its history going back to its founding by the Romans, who named it Londinium.</p>
  </article>
</section>

<div class="student-sidebar-tab student-active student-dashboard-main" id="dashboard">'
    <?php get_template_part('template-parts/student-dashboard/student', 'dashboard'); ?>

</div>';
<div class="student-sidebar-tab" id="profile">
    <?php get_template_part('template-parts/student-dashboard/student', 'profile'); ?>
</div>
<div class="student-sidebar-tab" id="enrollments">
    <?php get_template_part('template-parts/student-dashboard/student', 'enrollemts'); ?>
</div>
</div>
</div>

<?php
get_footer(); ?>
