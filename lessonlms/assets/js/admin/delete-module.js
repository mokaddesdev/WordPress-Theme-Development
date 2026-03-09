jQuery(document).ready(function($) {

    $('.lessonlms-module-delete').on('click', function(e) {
        e.preventDefault();

        const deleteBtn = $(this);
        const dataId    = deleteBtn.data('id');
        const nonce     = deleteBtn.data('nonce');

        if (!dataId) return;

        if (!confirm('Are you sure? This module will be permanently deleted!')) return;

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'lessonlms_delete_module',
                module_id: dataId,
                nonce: nonce
            },
            beforeSend: function() {
                deleteBtn.prop('disabled', true).text('Deleting...');
            },
            success: function(response) {
                if (response.success) {
                    deleteBtn.closest('tr').fadeOut(300, function() {
                        $(this).remove();
                    });
                } else {
                    alert(response.data || 'Delete failed!');
                    deleteBtn.prop('disabled', false).text('Delete');
                }
            },
            error: function() {
                alert('Request failed');
                deleteBtn.prop('disabled', false).text('Delete');
            }
        });
        console.log('Deleting module', dataId, nonce);

    });

    $('#lessonlms-module-form').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const btn = form.find('#submit-course-module');
        const formData = {
    action: 'lessonlms_add_module',

    add_module_nonce_field: form.find('#add_module_nonce_field').val(),

    module_id: form.find('input[name="module_id"]').val(),

    /* FIX field names */
    select_course: form.find('#select_course').val(),
    module_name: form.find('#module_name').val(),
    module_status: form.find('#module_status').is(':checked') ? 'enabled' : 'disabled',
};

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function () { btn.prop('disabled', true).text('Saving...'); },
            success: function (response) {
                if (response.success) {
                    $('#course-modules-table-wrapper').html(response.data.html);
                    form.trigger('reset');
                    showMessage(response.data.message, 'success');
                } else {
                    showMessage(response.data || 'Save failed!', 'error');
                }
            },
            error: function () { showMessage('Request failed!', 'error'); },
            complete: function () { btn.prop('disabled', false).text('Save Module'); }
        });
    });

    function showMessage(message, type = 'success') {
        const msgDiv = $(`<div class="lessonlms-message ${type}">${message}</div>`);
        $('body').append(msgDiv);
        msgDiv.fadeIn(200);
        setTimeout(() => { msgDiv.fadeOut(200, function () { $(this).remove(); }); }, 3000);
    }

});
