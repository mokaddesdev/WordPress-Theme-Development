<div class="all-courses-sidebar">

 <div class="filter-actions">
    <span class="active-filter-count">0 Filters Applied</span>
    <button class="clear-filters-btn">Clear Filters</button>
</div>

    <!-- Category -->
    <div class="all-courses-category">
        <h1 class="common-heading">Category</h1>
        <ul class="all-courses-category-list">
            <?php 
            $categories = get_terms(array(
                'taxonomy' => 'course_category',
                'hide_empty' => true,
            )); 
            if( !empty($categories) && is_array($categories)):

            foreach($categories as $catagory): ?>
                <li class="all-courses-category-single">


  <input
    type="checkbox"
    class="all-courses-filter-category-input"
    value="<?php echo $catagory->term_id; ?>"
    id="catagory-<?php echo $catagory->term_id; ?>"
>



                    <label for="catagory-<?php echo $catagory->term_id; ?>"><?php echo $catagory->name; ?>
                </label>
                </li>
            <?php 
        endforeach; 
        endif;?>
        </ul>
    </div>

    <!-- Tag / Level -->
    <div class="all-courses-level">
        <h1 class="common-heading">Courses Level</h1>
        <ul>
            <?php 
            $courses_levels = get_terms(array(
                'taxonomy' => 'course_level',
                'hide_empty' => true,
            )); 
            if( !empty($courses_levels) && is_array($courses_levels)):
            foreach($courses_levels as $course): ?>
                <li>
                    <input type="checkbox" class="courses-filter" value="<?php echo $course->term_id; ?>" id="course-<?php echo $course->term_id; ?>">
                    <label for="course-<?php echo $course->term_id; ?>">
                        <?php echo $course->name; ?>
                </label>
                </li>
            <?php endforeach;
              endif; ?>
        </ul>
    </div>

    <!-- Language -->
    <div class="course-language">
        <h1 class="common-heading">Language</h1>
        <ul>
            <?php
            global $wpdb;
           $find_result = $wpdb->get_col("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key='language' ");
           if( !empty($find_result) && is_array($find_result) ):
            foreach($find_result as $language): ?>
                <li>
                    <input type="checkbox" class="filter-language" value="<?php echo esc_attr($language); ?>" id="language-<?php echo sanitize_title($language); ?>">
                    <label for="language-<?php echo sanitize_title($language); ?>">
                        <?php echo esc_html($language); ?>
                </label>
                </li>
            <?php
             endforeach; 
             endif;
            ?>
        </ul>
    </div>

</div>

