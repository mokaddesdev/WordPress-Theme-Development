jQuery(document).ready(function ($) {
  const $menuItem = $(".std-side-menu li[data-sidetab]");
  const $tabs = $(".std-sidebar-tab");
  $menuItem.on("click", function () {
    const tab = $(this).data("sidetab");
    const target = $("#" + tab);
    if ($target.hasClass("student-active")) {
      return;
    }
    $(".std-side-menu li").removeClass("active-menu");
    $(this).addClass("active-menu");

    $(".student-sidebar-tab").removeClass("student-active");
    $("#" + tab).addClass("student-active");

    $.ajax({
      url: studentDashboard.ajaxurl,
      type: "POST",
      data: {
        action: "sidebar_menu_ajax_action",
        nonce: studentDashboard.nonce,
        tab: tab,
      },
      beforeSend: function () {
        $("#" + tab).empty();
        $("#" + tab).html('<p class="loading">Loading...</p>');
      },
      success: function (response) {
        if (response.success) {
          $("#" + tab).empty();
          $("#" + tab).html(response.data);
        } else {
          $("#" + tab).html("<p>" + response.data + "</p>");
        }
      },
    });
  });
});
