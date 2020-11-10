<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>

<?php do_action( 'woocommerce_product_meta_start' ); ?>

<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
  <p class="sku_wrapper">
    <span class="label">
      <?php esc_html_e( 'SKU:', 'woocommerce' ); ?>
    </span>
    <span class="value">
      <?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'woocommerce' ); ?>
    </span>
  </p>
<?php endif; ?>

<?php 
  echo wc_get_product_category_list( 
    $product->get_id(),
    ', ',
    '<p class="posted_in"><span class="label">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'woocommerce' ) . '</span> <span class="value">',
    '</span></p>'
  );
?>

<?php
  echo wc_get_product_tag_list( 
    $product->get_id(),
    ', ',
    '<p class="tagged_as"><span class="label">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'woocommerce' ) . '</span> <span class="value">',
    '</span></p>'
  );
?>

<?php do_action( 'woocommerce_product_meta_end' ); ?>
