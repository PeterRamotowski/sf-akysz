/**
 * Number input field controls replacement
 */

jQuery(function($) {

  $('body').on('click', 'span[data-action="decrement"]', function(e) {
    const input = $(this).parent().find('input')[0];
    const min = Number(input.min);
    let value = Number(input.value);
    value--;
    if (value < 1 || value < min) {
      return;
    }
    input.value = value;
    $("[name='update_cart']").prop('disabled', false);
    $("[name='update_cart']").trigger("click");
  });

  $('body').on('click', 'span[data-action="increment"]', function(e) {
    const input = $(this).parent().find('input')[0];
    const max = Number(input.max);
    let value = Number(input.value);
    value++;
    if (max != 0 && value > max) {
      return;
    }
    input.value = value;
    $("[name='update_cart']").prop('disabled', false);
    $("[name='update_cart']").trigger("click");
  });

  var timeout;
  $('div.woocommerce').on('change keyup mouseup', 'input.qty', function(){
    if (timeout != undefined) clearTimeout(timeout);
    if ($(this).val() == '') return;
    timeout = setTimeout(function() {
      $('[name="update_cart"]').trigger('click');
    }, 1000 );
  });

});
