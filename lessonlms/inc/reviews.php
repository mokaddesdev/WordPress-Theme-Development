<?php

/**
 * Course Reviews System Function
 */

function lessonlms_get_user_review($course_id, $user_id) {
    $reviews = get_post_meta($course_id, '_course_reviews', true);

    if (empty($reviews) || !is_array($reviews)) return false;

    foreach ($reviews as $review) {
        if (isset($review['user_id']) && intval($review['user_id']) === intval($user_id)) {
            return $review; 
        }
    }
    return false;
}


/*============= User Review Submit Process and Save =============*/ 
function lessonlms_handle_review_submission() {

    if (isset($_POST['submit_review']) && isset($_POST['course_id'])) {

        $course_id = intval($_POST['course_id']);
        $rating = intval($_POST['rating']);
        $review_text = sanitize_text_field($_POST['review_text']);
        $reviewer_name = sanitize_text_field($_POST['reviewer_name']);
        $user_id = get_current_user_id();

        // If user not login
        if ($user_id == 0) {
            wp_die('Please login to submit a review.');
        }

        // Validate
        if ($rating >= 1 && $rating <= 5 && !empty($review_text) && !empty($reviewer_name)) {

            $reviews = get_post_meta($course_id, '_course_reviews', true);
            if (!is_array($reviews)) {
                $reviews = [];
            }

            $updated = false;

            // Check if this user already reviewed?
            foreach ($reviews as &$review) {
                if ($review['user_id'] == $user_id) {

                    // Update old review
                    $review['rating'] = $rating;
                    $review['review'] = $review_text;
                    $review['name'] = $reviewer_name;
                    $review['date'] = current_time('mysql');

                    $updated = true;
                    break;
                }
            }

            // If no previous review, insert new
            if (!$updated) {
                $reviews[] = [
                    'rating' => $rating,
                    'review' => $review_text,
                    'name'   => $reviewer_name,
                    'user_id' => $user_id,
                    'date' => current_time('mysql'),
                ];
            }

            // Save meta
            update_post_meta($course_id, '_course_reviews', $reviews);

            // Update counts + avg rating
            lessonlms_update_review_stats($course_id);

            wp_redirect(add_query_arg('review_submitted', 'true', get_permalink($course_id)));
            exit;
        }
    }
}
add_action('init', 'lessonlms_handle_review_submission');

/*==== Course Review Total Count and get Average Rating Update ====*/
function lessonlms_update_review_stats($course_id)
{
    $reviews = get_post_meta($course_id, '_course_reviews', true);

    if (is_array($reviews) && !empty($reviews)) {
        $total_rating = 0;
        $review_count = count($reviews);

        foreach ($reviews as $review) {
            $total_rating = $total_rating + $review['rating'];
        }
        $average_rating = round($total_rating / $review_count, 1);

        update_post_meta($course_id, '_total_reviews', $review_count);
        update_post_meta($course_id, '_average_rating', $average_rating);
    }
}


/*====== Return Total Course Review and Average Rating =======*/
function lessonlms_get_review_stats($course_id)
{
    $total_reviews = get_post_meta($course_id, '_total_reviews', true) ?: 0;
    $average_rating = get_post_meta($course_id, '_average_rating', true) ?: 0;

    return array(
        'total_reviews' => $total_reviews,
        'average_rating' => $average_rating
    );
}


/*======== Return All Course Review in A Array ========*/
function lessonlms_get_total_course_reviews($course_id)
{
    $reviews = get_post_meta($course_id, '_course_reviews', true);
    return is_array($reviews) ? $reviews : array();
}


add_action('admin_menu', function() {
    add_menu_page(
        'Course Reviews',
        'Reviews',
        'manage_options',
        'course-reviews',
        'lessonlms_reviews_list_page',
        'dashicons-star-filled',
        25
    );
});

function lessonlms_reviews_list_page() {
    echo '<div class="wrap"><h1 class="wp-heading-inline">Course Reviews</h1>';

    $courses = get_posts(['post_type' => 'courses', 'numberposts' => -1]);

    echo '<table class="wp-list-table widefat fixed striped comments">';
    echo '<thead>
            <tr>
                <th>Author</th>
                <th>Review</th>
                <th>In Response To</th>
                <th>Rating</th>
                <th>Status</th>
                <th>Submitted On</th>
            </tr>
          </thead>';
    echo '<tbody>';

    foreach ($courses as $course) {
        $reviews = get_post_meta($course->ID, '_course_reviews', true);

        if (!empty($reviews)) {
            foreach ($reviews as $key => $review) {

                $user = get_user_by('id', $review['user_id']);
                $avatar = get_avatar($review['user_id'], 50);

                echo '<tr>';

                // AUTHOR COLUMN
                echo '<td class="author column-author">
                        '.$avatar.'
                        <strong>'.$review['name'].'</strong><br>
                        <span>'.$user->user_email.'</span>
                      </td>';

                // COMMENT / MESSAGE COLUMN
                echo '<td class="comment column-comment">
                        <p>'.$review['review'].'</p>
                      </td>';

                // COURSE TITLE COLUMN
                echo '<td class="response column-response">
                        <strong><a href="'.get_permalink($course->ID).'">'.$course->post_title.'</a></strong>
                        <p><a href="'.get_permalink($course->ID).'" target="_blank">View Course</a></p>
                      </td>';

                // RATING COLUMN
                echo '<td class="rating column-rating">
                        '.str_repeat('★', $review['rating']).'
                      </td>';

                // STATUS
                echo '<td>'.$review['status'].'</td>';

                // DATE COLUMN
                echo '<td>'.date('F j, Y - g:i a', strtotime($review['date'])).'<br>';

                echo '<div class="row-actions">
                        <span class="approve"><a href="'.add_query_arg(['course'=>$course->ID,'approve'=>$key]).'">Approve</a> | </span>
                        <span class="reject"><a href="'.add_query_arg(['course'=>$course->ID,'reject'=>$key]).'">Reject</a> | </span>
                        <span class="trash"><a href="'.add_query_arg(['course'=>$course->ID,'delete'=>$key]).'" style="color:red;">Delete</a></span>
                      </div>';

                echo '</td>';
                echo '</tr>';
            }
        }
    }

    echo '</tbody></table></div>';
}

add_action('admin_init', function(){

    if(isset($_GET['course'])){
        $course_id = intval($_GET['course']);
        $reviews = get_post_meta($course_id, '_course_reviews', true);
        if (!is_array($reviews)) $reviews = [];

        // Approve
        if(isset($_GET['approve'])){
            $reviews[intval($_GET['approve'])]['status'] = 'approved';
        }

        // Reject
        if(isset($_GET['reject'])){
            $reviews[intval($_GET['reject'])]['status'] = 'rejected';
        }

        // Delete
        if(isset($_GET['delete'])){
            unset($reviews[intval($_GET['delete'])]);
            $reviews = array_values($reviews);
        }

        update_post_meta($course_id, '_course_reviews', $reviews);

        wp_redirect(admin_url('admin.php?page=course-reviews'));
        exit;
    }
});


// Review submit with ajax


function lessonlms_ajax_review(){

    check_ajax_referer('lessonlms_ajax_review_nonce', 'security');

    $course_id = intval($_POST['course_id']);
    $rating = intval($_POST['rating']);
    $review_text = sanitize_text_field($_POST['review_text']);
    $reviewer_name = sanitize_text_field($_POST['reviewer_name']);
    $user_id = get_current_user_id();

    if ($user_id == 0) {
        wp_send_json_error("Please login to submit a review.");
    }

    if (empty($rating) || $rating < 1 || $rating > 5) {
    wp_send_json_error("Please provide a rating between 1 and 5.");
   }


     if (empty($reviewer_name)) {
        wp_send_json_error("Name field are required.");
    }

     if (empty($review_text)) {
        wp_send_json_error("Message field are required.");
    }

    $reviews = get_post_meta($course_id, '_course_reviews', true);
    if (!is_array($reviews)) $reviews = [];

    $updated = false;

    // update review
    foreach ($reviews as &$review) {
        if ($review['user_id'] == $user_id) {
            $review['rating'] = $rating;
            $review['review'] = $review_text;
            $review['name'] = $reviewer_name;
            $review['date'] = current_time('mysql');
            $updated = true;
            break;
        }
    }

    // new review
    if (!$updated) {
        $reviews[] = [
            'rating' => $rating,
            'review' => $review_text,
            'name'   => $reviewer_name,
            'user_id' => $user_id,
            'date' => current_time('mysql'),
            'status' => 'approve'
        ];
    }

    update_post_meta($course_id, '_course_reviews', $reviews);
    lessonlms_update_review_stats($course_id);

    // return updated list
    ob_start();
    $all_reviews = lessonlms_get_total_course_reviews($course_id);

    foreach (array_reverse($all_reviews) as $review) { ?>
        <div class="single-review">
            <div class="review-header">
                <div class="reviewer-name"><?php echo esc_html($review['name']); ?></div>
                <div class="review-rating">
                    <?php for ($i = 1; $i <= 5; $i++) {
                        echo ($i <= $review['rating']) ? '<span> ★ </span>' : '<span> ☆ </span>';
                    } ?>
                </div>
            </div>
            <div class="review-text"><?php echo esc_html($review['review']); ?></div>
            <div class="review-date"><?php echo date('F j, Y', strtotime($review['date'])); ?></div>
        </div>
    <?php }

    $html = ob_get_clean();

    wp_send_json_success([
    "message" => $updated ? "Review updated successfully!" : "Review submitted successfully!",
    "html"    => $html,
    "name"    => $reviewer_name,
    "review"  => $review_text,
    "rating"  => $rating,
     "stats"   => lessonlms_get_review_stats($course_id) 
]);


    wp_die();
}
add_action('wp_ajax_lessonlms_ajax_review', 'lessonlms_ajax_review');
add_action('wp_ajax_nopriv_lessonlms_ajax_review', 'lessonlms_ajax_review');


