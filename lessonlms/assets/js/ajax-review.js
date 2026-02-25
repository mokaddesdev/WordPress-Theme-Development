jQuery(document).ready(function($){
    // console.log("working");

    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            popup: 'custom-toast'
        },
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

  
    $('#ajax-review-form').on('submit', function(e){
        e.preventDefault();

        let form = $(this);
        let data = form.serialize();
        let submit_btn = $('#review_submit_btn');
        //! php function name lessonlms_ajax_review

        //! lessonlms_ajax_review_obj wp localize register
        data += '&action=lessonlms_ajax_review'; 
        data += '&security=' + lessonlms_ajax_review_obj.nonce;

        $.ajax({
            url: lessonlms_ajax_review_obj.ajax_url,
            type: "POST",
            data: data,

            beforeSend: function(){
                submit_btn.prop('disabled', true).text('Submitting...');
            },

           success: function(response){
    submit_btn.prop('disabled', false);

    if(response.success){
        Toast.fire({
            icon: 'success',
            title: response.data.message
        });

        // Update review list
        $(".student-reviews").html(response.data.html);

        // Fill form with current values
        $('#reviewer_name').val(response.data.name);
        $('#review_text').val(response.data.review);
        $(`input[name="rating"][value="${response.data.rating}"]`).prop('checked', true);

        $('.total-reviews-count').text(response.data.stats.total_reviews);
        $('.average-rating-count').text(response.data.stats.average_rating);


        // Change button text to "Update Review"
        submit_btn.text('Update Review');

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: response.data || 'Please check errors'
                    });
                }
            },

            error: function(){
                submit_btn.prop('disabled', false).text('Submit Review');

                Toast.fire({
                    icon: 'error',
                    title: 'Something went wrong'
                });
            }
        });
    });
});