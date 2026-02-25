<?php

/**
 * Default Pagination
 */

function lessonlms_all_pagination()
{
    global $wp_query, $wp_rewrite;
    $pages = '';
    $bigrandom = 999999999;
    $max = $wp_query->max_num_pages;
    $total = 1;
    $current = max(1, get_query_var('paged'));

    if ($max <= 1) return;
    if ($total == 1 && $max > 1) {
        $pages = '<p class="pages-count" style="color: black;" >Page <span class="current-page">' . $current . '</span> 
              <span class="sep">of</span> 
              <span class="total-page">' . $max . '</span></p>';
    }

    echo '<div class="pagination-info">' . $pages . '</div>';

    echo '<div class="pagination-wrapper">';

    $links = paginate_links(array(
        'base'      => str_replace($bigrandom, '%#%', esc_url(get_pagenum_link($bigrandom))),
        'format'    => '?paged=%#%',
        'current'   => $current,
        'total'     => $max,
        'prev_text' => '<div class="pagination-prev">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
</svg>
                 

                        </div>',
        'next_text' => '<div class="pagination-next">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
</svg>

                        </div>',
        'type'      => 'array',
    ));

    if (is_array($links)) {
        echo '<ul class="pagination">';
        foreach ($links as $link) {
            echo "<li>$link</li>";
        }
        echo '</ul>';
    }

    echo '</div>';
}

?>