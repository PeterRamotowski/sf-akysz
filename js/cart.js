/**
 * Cart related modifications
 */

jQuery(function($) {

  // Scroll to header mini cart after product's added to cart
  var cart = $('#site-header-cart');
  $('body').on('added_to_cart wc_cart_button_updated', function( fragment, data ) {
    if (window.innerWidth < 768) {
      return;
    }
    window.scrollTo({
      top: cart.offset().top - 20,
      left: 0,
      behavior: 'smooth'
    });
    cart.addClass('active');
  });

  // Hide mini cart after mouseout
  $('#site-header-cart').on('mouseleave', function() {
    $(this).removeClass('active');
  });

  // AJAX'ify add to cart on product page
  $('form.cart').on('submit', function(e) {
    e.preventDefault();

    var form = $(this);
    form.block({
      message: null,
      overlayCSS: {
        background: '#fff',
        opacity: 0.6
      }
    });

    var formData = new FormData(form.context);
    formData.append('add-to-cart', form.find('[name=add-to-cart]').val());

    $.ajax({
      url: wc_add_to_cart_params.wc_ajax_url.toString().replace('%%endpoint%%', 'ace_add_to_cart'),
      data: formData,
      type: 'POST',
      processData: false,
      contentType: false,
      complete: function(response) {
        response = response.responseJSON;

        if (!response) {
          return;
        }

        if (response.error && response.product_url) {
          window.location = response.product_url;
          return;
        }

        // Redirect to cart option
        if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
          window.location = wc_add_to_cart_params.cart_url;
          return;
        }

        // 'View cart' button
        //var $thisbutton = form.find('.single_add_to_cart_button'); //
        var $thisbutton = null; 

        // Trigger event so themes can refresh other areas.
        $(document.body).trigger('added_to_cart', [ response.fragments, response.cart_hash, $thisbutton ]);

        // Remove existing notices
        $('.woocommerce-error, .woocommerce-message, .woocommerce-info').remove();

        // Add new notices
        form.closest('.product').before(response.fragments.notices_html)

        form.unblock();
      }
    });
  });

});
