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

       $('.course-add-to-cart').on('click', function(e){
        e.preventDefault(); // prevent form submit reload

        const $form = $(this).closest('form');
        const product_id = $form.find('input[name="add-to-cart"]').val();
        const quantity = 1;

        $.ajax({
            url: wc_add_to_cart_params.ajax_url,
            type: 'POST',
            data: {
                action: 'woocommerce_add_to_cart',
                product_id: product_id,
                quantity: quantity,
            },
            beforeSend: function() {
                $(".img-add-to-cart-btn").html(`<div class="preloader-add-to-cart">
                    <p></p> <span></span></div>`)
            },
            success: function(response) {
                if ( response.error && response.product_url ) {
                    window.location = response.product_url;
                    return;
                }

                // Trigger WC cart update
                $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $form]);
                $(".img-add-to-cart-btn").html(data.msg.html);
                console.log('added successfully');
                alert("successfully added")
            }
        });

    });
$(document).on("submit",".add-to-wishlist-form",function(e){

    e.preventDefault();

    const form = $(this);

    const nonce = form.find('[name="add_to_wishlist_nonce"]').val();
    const course_id = form.find('[name="course_id"]').val();

    $.ajax({
        url: lessonlms_ajax_review_obj.ajax_url,
        method: "POST",
        data:{
            action: "lessonlmsadd_to_wishlist_ajax",
            add_to_wishlist_nonce: nonce,
            course_id: course_id
        },
        success:function(res){

            if(res.success){
                alert(res.data);
            }else{
                alert(res.data);
            }

        },
        error:function(){
            alert("Something went wrong");
        }

    });

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
});
