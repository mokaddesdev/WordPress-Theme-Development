jQuery(document).ready(function ($) {
  const $menuItem = $(".std-side-menu li[data-sidetab]");
  $menuItem.on("click", function () {
    const hasClass = $(this).hasClass('side-tab-active');
    if ( hasClass ) {
      return;
    }
    let activeTab = $('side-tab-active').attr('data-sidetab');
    $('side-tab-active').removeClass( 'side-tab-active' );
     $(`tab-content=${activeTab}`).hide();

    let tabClick = $(this).attr("data-sidetab");
    $(this).addClass( 'side-tab-active' );
    $(`tab-content=${tabClick}`).show();
    
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
