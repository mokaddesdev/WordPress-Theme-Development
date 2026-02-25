<?php
/**
 * Template Name: Start Your Learning Page
 * 
 * @package lessonlms
 */

get_header();
get_template_part("template-parts/student-dashboard/student", "breadcrumb");
the_content();
the_title();

get_footer();
?>