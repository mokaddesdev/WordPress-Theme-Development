<?php
get_header();

    // <!-- section heading -->
get_template_part('template-parts/search/search' ,'heading'); ?>

<section >
  <div class="container">
    <!-- left bloge search details -->
    <div class="blog-details">
    <?php
    if (have_posts()) :
      while ( have_posts() ) : the_post();
      get_template_part("template-parts/commom/blog", "card");
      endwhile;
    ?>
       <!-- Pagination -->
       <?php lessonlms_all_pagination(); ?>

   <?php else : ?>
    <div class="no-results-box">
        <h2 class="no-results-title">
            <?php _e( 'No Results Found', 'lessonlms' ); ?>
        </h2>
        <p class="no-results-text">
            <?php _e( 'Your search for', 'lessonlms' ); ?>
            <strong class="no-results-query">"<?php echo esc_html( get_search_query() ); ?>"</strong>
            <?php _e( 'did not match any results.', 'lessonlms' ); ?>
        </p>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="no-results-btn">
            <?php _e( 'Go Back Home', 'lessonlms' ); ?>
        </a>
    </div>
<?php endif; ?>


</div>
    
<?php  
get_sidebar();
?>
  </div>
</section>

<?php 
get_footer();
?>