<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
		<div class="woocommerce-panel--<?php echo esc_attr( $key ); ?> panel entry-content" aria-labelledby="panel-title-<?php echo esc_attr( $key ); ?>">
			<?php
			if ( isset( $product_tab['callback'] ) ) {
				call_user_func( $product_tab['callback'], $key, $product_tab );
			}
			?>
		</div>
	<?php endforeach; ?>

	<?php do_action( 'woocommerce_product_after_tabs' ); ?>

<?php endif; ?>
