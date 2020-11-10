<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
if ( ! isset($notices) ) {
	return;
}
?>
<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-info"<?php echo wc_get_notice_data_attr( $notice ); ?>>
		<?php echo wc_kses_notice( $notice['notice'] ); ?>
	</div>
<?php endforeach; ?>
