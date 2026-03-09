jQuery(document).ready(function($){
      $("#select-course").on('change', function(){
        // console.log("click working");
        const course_id = $(this).val();
        const nonce     = $(this).data('nonce');
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: {
                action: 'lessonlms_fetch_modules',
                course_id: course_id,
                nonce: nonce
            },
            headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
            success: function(res) {
                $('#select-module').html(res);
                // console.log(res);
            },
            error: function() {
                console.log("ajax not working");
            },
            complete: function() {
                console.log("Already all done");
            } 
        })
    })
})