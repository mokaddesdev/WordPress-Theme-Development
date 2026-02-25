<?php
/**
 * 404 Not Found Page
 */
get_header();
?>

<div class="error-page-wrapper">
    <div class="error-page-container">

        <header class="error-page-header">
            <h1 class="error-page-title">
                <?php _e('404', 'lessonlms'); ?>
            </h1>
            <p class="error-page-subtitle">
                <?php _e('Page Not Found', 'lessonlms'); ?>
            </p>
        </header>

        <div class="error-page-content">
            <h2 class="error-page-heading">
                <?php _e('Oops! This page can’t be found.', 'lessonlms'); ?>
            </h2>

            <p class="error-page-description">
                <?php _e('The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'lessonlms'); ?>
            </p>

            <form class="error-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <input
                    type="search"
                    class="error-search-input"
                    name="s"
                    placeholder="<?php esc_attr_e('Search here...', 'lessonlms'); ?>"
                >
                <button type="submit" class="error-search-button">
                    <?php _e('Search', 'lessonlms'); ?>
                </button>
            </form>

            <a href="<?php echo esc_url(home_url('/')); ?>" class="error-back-home">
                <?php _e('Back to Home', 'lessonlms'); ?>
            </a>
        </div>

    </div>
</div>

<?php
get_footer();
?>
