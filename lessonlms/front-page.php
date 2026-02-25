<?php
/**
 * Home Page Template
 * 
 * @package lessonlms
 */
   get_header();
   echo '<main>';
   if ( is_front_page() ) :
   $sections = array(
    'hero-section/hero',
    'explore-category/category',
    'popular-courses/courses',
    'featured-courses/courses',
    'testimonial/testimonial',
    'features/features',
    'cta/cta',
    'blog/blog',
   );
   foreach ( $sections as $section ) :
   get_template_part("template-parts/$section", 'section');
   endforeach;
   endif;
   echo '</main>';
   get_footer();
