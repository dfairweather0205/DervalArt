<?php

use Pikart\WpBase\DependencyInjection\Service;

$products     = Service::productsCompareHelper()->getCompareListWithProductsDetails();
$templateUtil = Service::productsCompareTemplateUtil();
$fields       = $templateUtil->getCompareFields();
?>
<div class="products-compare__list">
	<table>
		<thead>
		<tr>
			<th>&nbsp;</th>

			<?php foreach ( array_keys( $products ) as $productId ): ?>
				<th>
					<a class="products-compare-button-remove" href="#"
					   data-product-id="<?php echo esc_attr( $productId ) ?>">
						<?php esc_html_e( 'Remove', 'pikart-base' ); ?></a>
				</th>
			<?php endforeach;
			?>
		</tr>
		</thead>

		<tbody>

		<?php foreach ( $fields as $field => $fieldLabel ): ?>
			<tr>
				<td><?php echo( empty( $fieldLabel ) ? '&nbsp;' : esc_html( $fieldLabel ) ) ?></td>

				<?php foreach ( $products as $productId => $product ) :
					$GLOBALS['product'] = $product; ?>

					<td><?php print( $templateUtil->getFieldValue( $product, $field ) ) ?></td>

				<?php endforeach; ?>

			</tr>
		<?php endforeach; ?>

		</tbody>
	</table>
</div>
