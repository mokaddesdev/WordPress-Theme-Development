<div class="right">

    <?php
  // dynamic_sidebar('blog-sidebar');
  ?>


    <div class="card">
        <h4 class="blog-detail-right-heading">
            <?php
              echo esc_html__('Search Posts', 'lessonlms');
             ?>
        </h4>
        <div class="sidebar-divider"></div>
        <form role="search" action="<?php echo esc_url(home_url('/')); ?>" method="get" class="search-box">
            <input type="search" name="s" placeholder="<?php esc_attr_e('Search here...', 'lessonlms') ?>"
                value="<?php get_search_query(); ?>" required>
                 <input type="hidden" name="post_type" value="post" />
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>

    </div>

    <div class="card">
        <h4 class="blog-detail-right-heading"><?php echo __('Recent Posts', 'lessonlms') ?>
       </h4>
        <div class="sidebar-divider"></div>

        <?php
             $recent_posts = wp_get_recent_posts([
             'numberposts' => 3,
             'orderby'     => 'date',
            'order'       => 'DESC',
            'post_status' => 'publish'
             ]);
            foreach ($recent_posts as $post):
            setup_postdata($post);
        ?>
        <div class="recent-post">
            <a href="<?php the_permalink($post['ID']);; ?>">
                <?php
          if (has_post_thumbnail($post['ID'])) {
            echo get_the_post_thumbnail($post['ID'], 'thumbnail');
          } else { ?>
                <img src="https://via.placeholder.com/60" alt="<?php echo esc_attr($post['post_title']); ?>">
                <?php } ?>
            </a>
            <div class="recent-post-info">
                <div class="recent-title">
                    <a href="<?php echo get_permalink($post['ID']); ?>">
                        <?php echo esc_html($post['post_title']); ?>
                    </a>
                </div>
                <div class="recent-date">
                    <?php echo get_the_date('M d, Y', $post['ID']); ?>
                </div>
            </div>
        </div>

        <?php endforeach;
    wp_reset_postdata();
    ?>
    </div>


    <div class="card category-widget">
        <h4 class="blog-detail-right-heading"><?php echo __('Categories', 'lessonlms'); ?></h4>
        <div class="sidebar-divider"></div>

        <div class="category-list">
            <ul class="category-list-items">
                <?php
                    wp_list_categories([
                    'title_li'   => '',
                    'show_count' => true,
                    ]);
                    ?>
            </ul>
        </div>
    </div>

    <div class="card">
        <h4 class="blog-detail-right-heading"><?php echo __('Tags', 'lessonlms'); ?></h4>
        <div class="sidebar-divider"></div>

        <div class="tags">
            <?php
      wp_tag_cloud([
        'smallest' => 12,
        'largest'  => 12,
        'unit'     => 'px',
        'number'   => 10,
        'format'   => 'flat',
        'separator' => " ",
      ]);
      ?>
        </div>

    </div>

    <div class="card">
        <h4 class="blog-detail-right-heading">
            <?php
      echo __('Follow Us', 'lessonlms')
      ?>
        </h4>
        <div class="sidebar-divider"></div>
        <div class="social-icons">
            <!-- Facebook -->
            <a href="#" class="icon facebook"><i class="fa-brands fa-facebook-f"></i></a>

            <!-- Twitter/X -->
            <a href="#" class="icon twitter"><i class="fa-brands fa-x-twitter"></i></a>

            <!-- LinkedIn -->
            <a href="#" class="icon linkedin"><i class="fa-brands fa-linkedin-in"></i></a>

            <!-- Instagram -->
            <a href="#" class="icon instagram"><i class="fa-brands fa-instagram"></i></a>
        </div>


    </div>
</div>