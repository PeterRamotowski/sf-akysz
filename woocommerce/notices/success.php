<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! isset($notices) ) {
	return;
}
?>
<?php foreach ( $notices as $notice ) : ?>
	<div class="woocommerce-message"<?php echo wc_get_notice_data_attr( $notice ); ?> role="alert">
		<?php echo wc_kses_notice( $notice['notice'] ); ?>
	</div>
<?php endforeach; ?>
