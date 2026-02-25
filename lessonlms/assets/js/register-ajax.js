jQuery("document").ready(function ($) {
  const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    customClass: {
      popup: "custom-toast",
    },
    didOpen: (toast) => {
      toast.onmouseenter = Swal.stopTimer;
      toast.onmouseleave = Swal.resumeTimer;
    },
  });

  $("#registerform").on("submit", function (e) {
    e.preventDefault();
    const form = $(this);
    let data = form.serialize();
    const submitButton = $("#wp-submit");

    data += "&action=lessonlms_custom_register_validation_action";
    data += "&security=" + lessonlms_ajax_register_object.nonce;

    $.ajax({
      url: lessonlms_ajax_register_object.ajax_url,
      type: "POST",
      data: data,
      beforeSend: function () {
              submitButton.prop("disabled", true);
              submitButton.val("Submitting...");
      },

      success: function (response) {
         submitButton.prop("disabled", false);
          submitButton.val("Register");
        if (response.success) {
                  window.location.href = response.data.redirect_url;
        return;
        } else {
          Toast.fire({
            icon: "error",
            title: response.data.message,
          });
        }
      },
      error: function () {
        submitButton.prop("disabled", false);
        submitButton.val("Register");
        Toast.fire({
          icon: "error",
          title: "Something went wrong",
        });
      },
    });
  });
});
