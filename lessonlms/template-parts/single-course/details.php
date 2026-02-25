  <?php
    /**
     * Template Name: Details
     * 
     * @package lessonlms
     */

    $video_hours  = get_post_meta(get_the_ID(), "video_hours", true) ?: '0.00';
    $language  = get_post_meta(get_the_ID(), "language", true) ?: 'English';
    $sub_title_language  = get_post_meta(get_the_ID(), "sub_title_language", true) ?: 'English';
  
    ?>

  <div class="course-right-info-card1">
      <h2>Course Details</h2>
      <div class="course-right-info-card1-items item1">
         <svg>
            <use href="#video-time-icon"/>
        </svg>
          <div class="text">
              <span>
                  <?php echo esc_html_e('Duration', 'lessonlms') ?>
              </span>
              <?php if ($video_hours): ?>
                  <p>
                      <?php echo esc_html($video_hours) . ' ' . __('hours', 'lessonlms'); ?>
                  </p>
              <?php endif; ?>
          </div>
      </div>

      <div class="course-right-info-card1-items item2">
        <svg>
            <use href="#updated-date-icon"/>
        </svg>
          <div class="text">
              <span>
                <?php echo esc_html_e('Last Updated', 'lessonlms'); ?>
            </span>
              <p>
                <?php echo get_the_modified_date('M j, Y') ?>
            </p>
          </div>
      </div>

      <div class="course-right-info-card1-items item3">
        <svg>
            <use width="30" height="30" href="#language-icon"/>
        </svg>
          <div class="text">
              <span>
                <?php echo esc_html_e('Language', 'lessonlms'); ?>
              </span>
              <?php if ($language): ?>
                  <p>
                      <?php echo esc_html($language); ?>
                  </p>
              <?php endif; ?>
          </div>
      </div>

      <div class="course-right-info-card1-items item4">
        <svg >
            <use width="32" height="32" href="#subtitle-icon"/>
        </svg>
          <div class="text">
              <span>
                <?php echo esc_html_e('Sub titles', 'lessonlms'); ?>
             </span>
              <?php if ( $sub_title_language ) : ?>
                  <p>
                      <?php echo esc_html( $sub_title_language ); ?>
                  </p>
              <?php endif; ?>
          </div>
      </div>
  </div>