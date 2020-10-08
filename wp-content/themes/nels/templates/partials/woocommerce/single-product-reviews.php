<?php

use Pikart\Nels\Shop\ShopTemplateHelper;
use Pikart\WpThemeCore\Shop\ShopUtil;

if ( ! comments_open() ) :
	return;
endif;

$product       = ShopUtil::getGlobalProduct();
$reviewAllowed = get_option( 'woocommerce_review_rating_verification_required' ) === 'no'
                 || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ); ?>

<div id="reviews" class="woocommerce-Reviews">

	<div id="comments" class="comments">

		<?php if ( have_comments() ) : ?>

			<ul class="comments__list">
				<?php wp_list_comments( apply_filters(
					'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ul>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

				<nav class="nav nav--woocommerce">
					<div class="nav-links">
						<?php paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
							'prev_text' => '',
							'next_text' => '',
							'type'      => 'list',
						) ) ); ?>
					</div>
				</nav>

			<?php endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'nels' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( $reviewAllowed ) : ?>

		<div id="review-form-wrapper">
			<div id="review-form">

				<?php
				$commentFormArguments = ShopTemplateHelper::getCommentFormArguments();
				comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $commentFormArguments ) );
				?>

			</div>
		</div>

	<?php else : ?>

		<p class="woocommerce-verification-required">
			<?php esc_html_e(
				'Only logged in customers who have purchased this product may leave a review.', 'nels' ); ?>
		</p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
