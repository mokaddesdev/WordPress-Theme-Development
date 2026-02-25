jQuery(document).ready(function($){
    /*----- menu icon toggle -----*/
    $("#navPhone").hide();
    $(".menu-btn").click(function(){
        $("#navPhone").fadeToggle();
    });

    //scroll button

    $(window).on('load scroll', function () {
        if($(this).scrollTop() > 200){
          $('.scroll-top-btn').addClass('show');
    } else {
      $('.scroll-top-btn').removeClass('show');
    }
    });

     $('.scroll-top-btn').click(function () {
    $('html, body').animate({ scrollTop: 0 }, 60);
    return false;
  });


    /*----- courses section slick add -----*/
    $(".slick-items").slick({ 
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: false,
        autoplaySpeed: 2000,
        dots: false,
        arrows: true,
        prevArrow: "<span class='left-arrow'><i class='bx bx-chevron-left'></i></span>",
        nextArrow: "<span class='right-arrow'><i class='bx bx-chevron-right'></i></span>",
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    /*----- testimonial section slick -----*/
    $(".testimonial-items").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        dots: true,
        arrows: false
    });

    /*----- blog section slick add -----*/
    $(".blog-wrapper").slick({ 
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        dots: true,
        arrows: false,
        pauseOnHover: false,
          responsive: [
        {
            breakpoint: 1280,
            settings: {
                slidesToShow: 2
            }
        },
        {
            breakpoint: 1024, 
            settings: {
                slidesToShow: 2
            }
        },
        {
            breakpoint: 768, 
            settings: {
                slidesToShow: 2
            }
        },
        {
            breakpoint: 480, 
            settings: {
                slidesToShow: 1
            }
        }
    ]
    });


//  Initial active tab
  $('.courses-tab').first().addClass('active');
  $('.courses-tab-content').first().addClass('active');
  updateDivider($('.courses-tab.active'));

  $('.courses-tab').click(function(){
    $('.courses-tab').removeClass('active');
    $(this).addClass('active');

    $('.courses-tab-content').removeClass('active');
    $('#' + $(this).data('tab')).addClass('active');

    updateDivider($(this));
  });

  function updateDivider(tab){
    var width = tab.outerWidth();
    var left = tab.position().left;
    $('.tab-divider').css({width: width + 'px', left: left + 'px'});
  }


  // Form submission validation
$('.review-form').on('submit', function(e) {
  var rating = $('#rating-value').val();
  if (rating == '0' || rating == '') {
    e.preventDefault();
    alert('Please select a rating before submitting.');
    return false;
  }
});


  // default open
  $('.course-structure-module-block.open')
  .find('.course-structure-lecture-list')
   .show();

  // Accordion Toggle
  $('.course-structure-module-header').on('click', function(){
    let module = $(this).closest('.course-structure-module-block');
    let list = module.find('.course-structure-lecture-list');

    if (list.is(':visible')) {
      list.slideUp(200);
      module.removeClass('open');
    } else {
      list.slideDown(200);
      module.addClass('open');
    }
  });

  // Video Popup
  $('.preview-video').magnificPopup({
    type:'iframe',
    callbacks:{
      elementParse:function(item){
        let video = item.el.attr('data-video');
        if(video.includes("youtube.com")){
          let id = video.split("v=")[1];
          item.src = "https://www.youtube.com/embed/" + id + "?autoplay=1&rel=0";
        } else {
          item.src = video;
        }
      }
    }
  });
});
