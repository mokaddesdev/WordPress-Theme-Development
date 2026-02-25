<?php 
/**
 * Template Name: Explore Category
 * 
 * @package lessonlms
 */
?>

<div class="explore-section">
    <div class="container">

        <!-- category heading -->
        <div class="explore-category-heading">
            <h1>Explore Categories</h1>
            <p>Discover categories designed to help you excel in your professional and personal growth.</p>
        </div>

       <!-- category card  -->
        <div class="explore-category-cards">

        <?php 
            $categories = get_terms(array(
                'taxonomy' => 'course_category',
                'hide_empty' => true,
            )); 
            if( !empty($categories) && is_array($categories)):
                
           foreach ($categories as $catagory): ?>

<a class="home-category-link" data-category-id="<?php echo esc_attr($catagory->term_id); ?>" href="<?php echo esc_url(
    get_post_type_archive_link('courses')); ?>">
    <div class="explore-category-single-card">
        <h3><?php echo esc_html($catagory->name); ?></h3>
    </div>
</a>

            <?php 
        endforeach; 
        endif;?>
        </div>
    </div>
</div>