<?php
/**
 * Home Page Template
 * 
 * @package lessonlms
 */
   get_header();
   ?>
   <main>
<?php
   if ( is_front_page() ) :
   get_template_part( "template-parts/home/home" );
   endif;
   ?>
   </main>
<?php
   get_footer();
?>
