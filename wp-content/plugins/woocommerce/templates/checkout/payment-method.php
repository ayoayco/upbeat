<?php
/**
 * Output a single payment method
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<h3>Payment Method</h3>
<li class="payment_method_<?php echo $gateway->id; ?>">
	<!--input id="payment_method_<?php echo $gateway->id; ?>" type="radio" class="input-radio" name="payment_method" value="<?php echo esc_attr( $gateway->id ); ?>" <?php checked( $gateway->chosen, true ); ?> data-order_button_text="<?php echo esc_attr( $gateway->order_button_text ); ?>" />

	<label for="payment_method_<?php echo $gateway->id; ?>">
		<?php echo $gateway->get_title(); ?> <?php echo $gateway->get_icon(); ?>
	</label-->
	<?php if ( $gateway->has_fields() || $gateway->get_description() ) : ?>
		<div class="payment_box payment_method_<?php echo $gateway->id; ?>" <?php if ( ! $gateway->chosen ) : ?>style="display:none;"<?php endif; ?>>
			<?php $gateway->payment_fields(); ?>
		</div>
	<?php endif; ?>
</li>

<table>
	<tr>
		<th>Items</th>
		<th>Courier Service Provider</th>
		<th>Price</th>
	</tr>
	<tr>
		<td>1 Shirt</td>
		<td>JRS</td>
		<td>140 Php</td>
	</tr>
	<tr>
		<td>2-4 Shirts or 1 Jacket</td>
		<td>LBC (Small Transpack)</td>
		<td>200 Php</td>
	</tr>
	<tr>
		<td>5-8 Shirts or 2 Jackets</td>
		<td>LBC (Large Transpack)</td>
		<td>300 Php</td>
	</tr>
</table>
*Prices are inclusive of the handler's fee