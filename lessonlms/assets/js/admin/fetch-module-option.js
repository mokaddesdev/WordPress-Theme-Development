jQuery(document).ready(function($) {
    $("#select-course").on('change', function() {
        const course_id = $(this).val();
        const nonce = $(this).data('nonce');

        console.log("Course ID:", course_id);
        console.log("Nonce:", nonce);

        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                action: 'lessonlms_fetch_modules',
                select_nonce: nonce,
                course_id: course_id
            },
            success: function(res) {
                console.log("AJAX response:", res);
            },
            error: function(xhr, status, error) {
                console.log("AJAX error:", error);
            }
        });
    });
});