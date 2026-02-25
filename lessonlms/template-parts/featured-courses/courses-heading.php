  <?php
    /**
     * Featured Courses Heading
     * 
     * @package lessonlms
     */
    $course_section_title       = get_theme_mod('course_section_title', 'Featured Courses');
    $course_section_description = get_theme_mod('course_section_description', 'Discover courses designed to help you excel in your professional and personal growth.');
    ?>
  <div class="heading courses-heading">
      <?php if ( $course_section_title ) : ?>
          <h2><?php echo esc_html( $course_section_title ); ?></h2>
      <?php endif; ?>

      <?php if ( $course_section_description ) : ?>
          <p><?php echo esc_html( $course_section_description ); ?></p>
      <?php endif; ?>
  </div>