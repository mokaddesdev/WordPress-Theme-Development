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

});
