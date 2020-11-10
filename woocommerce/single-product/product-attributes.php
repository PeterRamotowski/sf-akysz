<?php
defined( 'ABSPATH' ) || exit;

if ( ! $product_attributes ) {
	return;
}
?>
<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
	<p class="<?php echo esc_attr( $product_attribute_key ); ?>">
		<span class="label"><?php echo wp_kses_post( $product_attribute['label'] ); ?>:</span>
		<span class="value"><?php echo wp_kses( $product_attribute['value'], [ 'a', 'em', 'i' ] ); ?></span>
	</p>
<?php endforeach; ?>
