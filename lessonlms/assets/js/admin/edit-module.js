jQuery(document).ready(function ($) {
    const showMessage = (message, type = 'success') => {

        const msgDiv = $(`<div class="lessonlms-message ${type}">${message}</div>`);
        $('body').append(msgDiv);

        msgDiv.fadeIn(200);
        setTimeout(() => {
            msgDiv.fadeOut(200, function () {
                $(this).remove();
            });
        }, 3000);
    };

   $('.table-wrapper').on('click', '.cancel-module', function() {
        $(this).closest('.edit-module-popup').removeClass('show-modal');
    });

    $('.table-wrapper').on('click', '.module-edit', function () {

        const row = $(this).closest('tr');
        const popup = row.find('.edit-module-popup');
        const module_id = $(this).data('id');
        const module_name = $(this).data('name');
        const module_status = $(this).data('module_status');

        popup.addClass('show-modal');
        popup.find('.module_id').val(module_id);
        popup.find('.module_name').val(module_name);

        if (module_status === 'enabled') {
            popup.find('#module_status').prop('checked', true);
        } else {
            popup.find('#module_status').prop('checked', false);
        }
    });

    $('.table-wrapper').on('submit', '.edit-module-form', function (e) {

        e.preventDefault();
        const form = $(this);
        const btn = form.find('.update-module');
        const module_id = form.find('.module_id').val();
        const module_name = form.find('.module_name').val();
        const module_status = form.find('#module_status').is(':checked') ? 'enabled' : 'disabled';

        $.ajax({

            url: ajaxurl,
            type: 'POST',

            data: {
                action: 'lessonlms_update_module_ajax',
                module_id: module_id,
                module_name: module_name,
                module_status: module_status,
                course_id: $('#course_id').val(),
                paged: 1
            },

            beforeSend: function () {
                btn.prop('disabled', true).text('Updating...');
                $(".table-wrapper").html(`
                <div class="lessonlms-loading">
                    <div class="loader"></div>
                    <p>Loading...</p>
                </div>
            `);
            },

            success: function (res) {
                if (res.success) {
                    form.closest('.edit-module-popup').removeClass('show-modal');
                    $(".table-wrapper").html(res.data.html);
                    showMessage(res.data.message, 'success');
                } else {
                    showMessage(res.data.message || 'Update failed', 'error');
                }
            },
            error: function () {
                showMessage('Request Failed!', 'error');
            },

            complete: function () {
                btn.prop('disabled', false).text('Update Module');
            }
        });
    });
});
