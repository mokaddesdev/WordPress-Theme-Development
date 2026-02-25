jQuery(document).ready(function ($) {
    $('#lessonlms-module-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const btn = form.find('#submit-course-module');
        const action = 'lessonlms_add_module';
        const modName = $('#module_name').val();
        const modStatus = $('#module_status').is(':checked') ? 'enabled' : 'disabled';
        const course = $('#select_course').val();
        const nonce = $('input[name="add_module_nonce_field"]').val();

        const formData = {
            action: action,
            select_course: course,
            module_name: modName,
            module_status: modStatus,
            add_module_nonce_field: nonce
        };
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            beforeSend: function () {
                btn.prop('disabled', true).text('Saving...');
            },
            success: function (response) {
                if (response.success) {
                    $('#course-modules-table-wrapper').html(response.data.html);
                    form.trigger('reset');
                    showMessage(response.data.message, 'success');
                } else {
                    showMessage(response.data || 'Save failed!', 'error');

                }
            },
            error: function () {
                showMessage('Request failed!', 'error');
            },
            complete: function () {
                btn.prop('disabled', false).text('Save Module');
            }
        });
    });

    function showMessage(message, type = 'success') {
        const msgDiv = $(`<div class="lessonlms-message ${type}">${message}</div>`);
        $('body').append(msgDiv);
        msgDiv.fadeIn(200);

        setTimeout(() => {
            msgDiv.fadeOut(200, function () {
                $(this).remove();
            });
        }, 3000);
    }
});
