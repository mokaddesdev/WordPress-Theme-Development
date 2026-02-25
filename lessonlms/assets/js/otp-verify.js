jQuery(document).ready(function($){
    const sendOTPBtn = $('#send-otp-btn');
    const verifyOTPBtn = $('#verify-otp-btn');
    const otpExpireElem = $('#otp-expires-id');
    const otpBoxes = $('#otp-box-list-id .otp-box');
    const resendLink = $('#resend-otp-link');
    const otpMessage = $('#otp-message');
    
    let intervalId, timeoutId;
    let expiresIn = 300;
    
    // Get user ID from hidden field
    let currentUserId = $('#lessonlms-user-id').val();
    
    console.log('Current User ID:', currentUserId);
    
    // If user ID exists, show verify button immediately
    if (currentUserId && currentUserId > 0) {
        sendOTPBtn.hide();
        verifyOTPBtn.show();
        startTimer(); // Start timer immediately
    }

    // Digit-by-digit auto-focus
    otpBoxes.on('input', function(){
        let val = $(this).val();
        if (isNaN(val)) {
            $(this).val('');
        } else {
            if ($(this).next('.otp-box').length > 0) {
                $(this).next('.otp-box').focus();
            }
        }
    });

    // Allow backspace navigation
    otpBoxes.on('keydown', function(e){
        if(e.keyCode === 8 && $(this).val() === '' && $(this).prev('.otp-box').length > 0){
            $(this).prev('.otp-box').focus();
        }
    });

    // Generic send OTP function
    function sendOTP(userId){
        showMessage('Sending OTP...', 'info');
        
        $.ajax({
            url: lessonlms_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'lessonlms_resend_otp',
                security: lessonlms_ajax_object.nonce,
                user_id: userId
            },
            success: function(res){
                if(res.success){
                    showMessage(res.data.message, 'success');
                    expiresIn = res.data.expires_in || 300;
                    startTimer();
                    sendOTPBtn.hide();
                    verifyOTPBtn.show();
                    otpBoxes.val('');
                    otpBoxes.first().focus();
                } else {
                    showMessage(res.data.message, 'error');
                }
            },
            error: function(){
                showMessage('Network error. Please try again.', 'error');
            }
        });
    }

    // Show message function
    function showMessage(message, type){
        otpMessage.removeClass('alert-success alert-danger alert-info')
                 .addClass('alert-' + (type === 'error' ? 'danger' : type))
                 .text(message)
                 .show();
        
        setTimeout(function(){
            otpMessage.fadeOut();
        }, 5000);
    }

    // Send / Resend OTP click
    sendOTPBtn.on('click', function(){
        if(!currentUserId || currentUserId <= 0){
            showMessage('User ID missing. Please try again.', 'error');
            return;
        }
        
        sendOTPBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
        sendOTP(currentUserId);
        
        setTimeout(function() {
            sendOTPBtn.prop('disabled', false).html('<i class="fas fa-paper-plane"></i> Send OTP');
        }, 3000);
    });

    // Resend OTP link
    resendLink.on('click', function(e){
        e.preventDefault();
        
        if(!currentUserId || currentUserId <= 0){
            showMessage('User ID missing. Please try again.', 'error');
            return;
        }
        
        sendOTP(currentUserId);
    });

    // Verify OTP
    verifyOTPBtn.on('click', function(){
        if(!currentUserId || currentUserId <= 0){
            showMessage('User ID missing. Please try again.', 'error');
            return;
        }

        let otp = '';
        otpBoxes.each(function(){ 
            otp += $(this).val(); 
        });

        if(!otp || otp.length !== otpBoxes.length){
            showMessage('Please enter complete OTP.', 'error');
            otpBoxes.first().focus();
            return;
        }

        verifyOTPBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Verifying...');
        
        $.ajax({
            url: lessonlms_ajax_object.ajax_url,
            type: 'POST',
            data: {
                action: 'lessonlms_verify_otp',
                security: lessonlms_ajax_object.nonce,
                user_id: currentUserId,
                otp: otp
            },
            success: function(res){
                if(res.success){
                    showMessage(res.data.message, 'success');
                    
                    // Redirect after 2 seconds
                    setTimeout(function(){
                        if(res.data.redirect_url){
                            window.location.href = res.data.redirect_url;
                        } else {
                            window.location.href = '<?php echo home_url("/student-dashboard/"); ?>';
                        }
                    }, 2000);
                    
                    sendOTPBtn.hide();
                    verifyOTPBtn.hide();
                    otpExpireElem.text('');
                } else {
                    showMessage(res.data.message, 'error');
                    verifyOTPBtn.prop('disabled', false).html('<i class="fas fa-check"></i> Verify OTP');
                }
            },
            error: function(){
                showMessage('Network error. Please try again.', 'error');
                verifyOTPBtn.prop('disabled', false).html('<i class="fas fa-check"></i> Verify OTP');
            }
        });
    });

    // Timer function
    function startTimer(){
        clearInterval(intervalId);
        clearTimeout(timeoutId);

        // Reset expiresIn if needed
        if (expiresIn <= 0) {
            expiresIn = 300;
        }

        intervalId = setInterval(function(){
            let minutes = Math.floor(expiresIn / 60);
            let seconds = expiresIn % 60;
            otpExpireElem.text(`OTP expires in ${minutes}:${seconds < 10 ? '0' : ''}${seconds}`);
            expiresIn--;
            
            if(expiresIn < 0) {
                clearInterval(intervalId);
            }
        }, 1000);

        timeoutId = setTimeout(function(){
            otpExpireElem.text('OTP expired. Click "Send OTP" to get a new one.');
            sendOTPBtn.show();
            verifyOTPBtn.hide();
            clearInterval(intervalId);
        }, expiresIn * 1000);
    }

    // Auto-focus first OTP box
    if (currentUserId && currentUserId > 0) {
        otpBoxes.first().focus();
        otpExpireElem.text('Enter the OTP sent to your email');
    }
});