/**
 * Checkout improvements
 */

jQuery(function($) {
  $('body').on('change', '.shipping_method', function(){
    $(document.body).trigger("update_checkout");
  });
});
