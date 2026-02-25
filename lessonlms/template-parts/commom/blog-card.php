 <?php
    /**
     * Template Name: Common Blog Card Design
     * 
     * @package lessonlms
     */
    $title     = get_the_title();
    $permalink = get_permalink();
    $the_date  = get_the_date('d F Y');
    $the_date  = ! empty($the_date) ? $the_date : '';

    $image_html = '';
 if (has_post_thumbnail()) {
    $image_html = get_the_post_thumbnail(
        get_the_ID(),
        'post_custom-thumb',
        array(
             'alt' => esc_attr($title),
         )
    );
 }

    ?>

 <div class="sngle-blog">
     <div class="img">
         <a href="<?php echo esc_url($permalink); ?>">
             <?php echo wp_kses_post($image_html); ?>
         </a>
     </div>
     <div class="single-blog-details">
         <div class="date">
             <div class="yellow-cercel"></div>
             <span><?php echo esc_html($the_date); ?></span>
         </div>

         <hr>

         <div class="blog-title">
             <span>
                 <?php if (! empty($title)) : ?>
                     <a href="<?php echo esc_url($permalink); ?>">
                         <?php echo esc_html($title); ?>
                     </a>
                 <?php endif; ?>
             </span>
         </div>

         <div class="black-btn read-more">
             <a href="<?php echo esc_url( $permalink ); ?>">
                 <?php echo esc_html__('Read More', 'lessonlms'); ?>
             </a>
         </div>
     </div>
 </div>