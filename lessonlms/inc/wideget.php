<?php 
/**
 * Wideget
 */

function lessonlms_register_sidebar() {
          register_sidebar([
            'name' => __('Blog Sidebar', 'lessonlms'),
             'id' => 'blog-sidebar',
              'description'   => __( 'Add widgets here to appear in your sidebar.', 'lessonlms' ),
              'before_widget' => ' <div class="card">',
              'after_widget'  => '</div>',
              'before_title'  => '<h4 class="blog-detail-right-heading">', 
             'after_title'   => '</h4><div class="sidebar-divider"></div>',


          ]);
}
add_action('widgets_init', 'lessonlms_register_sidebar');