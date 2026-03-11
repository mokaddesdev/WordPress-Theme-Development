jQuery(document).ready(function ($) {

    const showMessage = ( message, type = 'success' ) => {
        const msgDiv = $( `<div class="lessonlms-message ${type}">${message}</div>` );
        $( 'body' ).append( msgDiv );
        msgDiv.fadeIn( 200 );

        setTimeout( () => {
            msgDiv.fadeOut( 200, function () {
                $( this ).remove();
            } );
        }, 1500 );
    };

   function showConfirm(callback) {
    const modal = $('#confirm-modal');
    modal.addClass('show-modal'); // use class for animation

    $(document).one('click', '#confirm-yes', function () {
        modal.removeClass('show-modal');
        callback(true);
    });

    $(document).one('click', '#confirm-no', function () {
        modal.removeClass('show-modal');
        callback(false);
    });
}

    $('.table-wrapper').on( 'click', '.module-delete', function ( e ) {
        e.preventDefault();

        const btn     = $( this );
        const dataId  = btn.data( 'id' );
        const nonce   = btn.data( 'nonce' );

        if ( ! dataId ) {
            return;
        }

        showConfirm( function ( result ) {
            if ( result ) {
                $.ajax( {
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action    : 'lessonlms_delete_module',
                        module_id : dataId,
                        course_id : $('#course_id').val(),
                        paged     : 1,
                        nonce     : nonce
                    },

                    beforeSend: function () {
                        btn.prop( 'disabled', true ).text( 'Deleting...' );
                        $( ".table-wrapper" ).html(`
                            <div class="lessonlms-loading">
                                <div class="loader"></div>
                                <p>Loading...</p>
                            </div>
                        `);
                    },

                    success: function ( res ) {
                        if (res.success ) {
                            $( ".table-wrapper" ).html( res.data.html );
                            showMessage( res.data.msg, 'success' );
                        } else {
                            showMessage( res.data.msg || 'Delete failed!', 'error' );
                        }
                    },

                    error: function () {
                        showMessage( 'Request failed', 'error' );
                        setTimeout( function () {
                            $( ".table-wrapper" ).html('');
                        }, 1500);
                    },

                    complete: function () {
                        btn.prop( 'disabled', false ).text( 'Delete' );
                    }
                } );
            }
        } );
    } );
} );