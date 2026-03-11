jQuery(document).ready(function($) {
    const showMessage = ( message, type = 'success' ) => {
    const msgDiv = $(`<div class="lessonlms-message ${type}">${message}</div>`);
        $('body').append( msgDiv );
        msgDiv.fadeIn( 200 );
        setTimeout( () => {
            msgDiv.fadeOut( 200, function () {
                $(this).remove();
            } );
        }, 3000);
    }

    $('#lessonlms-module-form').on('submit', function (e) {
        e.preventDefault();

        const form      = $(this);
        const btn       = form.find( '#submit-course-module' );
        const action    = 'lessonlms_add_module_ajax';
        const nonce     = form.data( 'nonce' );
        const course    = form.find( '#select_course' ).val();
        const module    = form.find( '#module_name' ).val();
        const status    = form.find( '#module_status' ).is( ':checked' ) ? 'enabled' : 'disabled';

        if ( ! course ) {
             showMessage( 'Select Course is required', 'error' );
             return;
        }

        if ( ! module ) {
            showMessage( 'Module name is required', 'error' );
            return;
        }

        const data = {
                action          : action,
                nonce           : nonce,
                select_course   : course,
                module_name     : module,
                module_status   : status,
            }

        $.ajax( {
            url      : ajaxurl,
            type     : 'POST',
            data     : data,
            dataType : 'json',
            beforeSend: function () {
                btn.prop( 'disabled', true ).text( 'Saving...' );
                $( ".course-module-table" ).html(`
                <tr>
                    <td colspan="3" rowspan="3">
                        <div class="lessonlms-table-loader">
                            <div class="lessonlms-spinner"></div>
                            <span>Loading modules...</span>
                        </div>
                    </td>
                </tr>
                ` );
            },
            success: function ( res ) {
                if ( res.success ) {
                    $( '.course-module-table' ).html( res.data.html );
                    form.trigger( 'reset' );
                    showMessage( res.data.message, 'success' );
                } else {
                    showMessage( res.data || 'Save failed!', 'error' );
                }
            },
            error: function () {
                showMessage( 'Request failed!', 'error' );
            },
            complete: function () {
                btn.prop( 'disabled', false ).text( 'Save Module' );
            }
        } );
    } );
} );