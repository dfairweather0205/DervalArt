<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

$name        = trim( $data['name'] );
$socialLinks = array(
	'twitter'   => $data['twitter'],
	'facebook'  => $data['facebook'],
	'linkedin'  => $data['linkedin'],
	'pinterest' => $data['pinterest'],
);

?>
<div class="pikode  pikode--team-member team-member <?php echo esc_attr( trim( $data['css_class'] ) ) ?>">

	<div class="team-member__header">

		<?php if ( ! empty( $data['image'] ) ) :

			if ( ! empty( $data['image_link'] ) ) : ?>
				<a href="<?php echo esc_url( $data['image_link'] ) ?>" class="team-member__link"
				<?php echo( empty ( $data['new_tab'] ) ? '' : 'target="_blank"' ) ?> >
			<?php endif; ?>

			<div class="team-member__image">
				<img src="<?php echo esc_url( $data['image'] ); ?>" alt="<?php echo esc_attr( $data['name'] ) ?>">
			</div>

			<?php if ( ! empty( $data['image_link'] ) ) : ?>
			</a>
		<?php endif;

		endif; ?>

		<ul class="team-member__social-list">
			<?php foreach ( $socialLinks as $networkName => $socialLink ) :
				if ( ! empty( $socialLink ) ) : ?>
					<li class="social-list__item">
						<a class="item__link" href="<?php echo esc_url( $socialLink ); ?>"
						   target="_blank" title="<?php echo esc_attr( $networkName ) ?>" data-tooltip>
							<i class="fa fa-<?php echo esc_attr( $networkName ) ?>"></i>
						</a>
					</li>
				<?php
				endif;
			endforeach; ?>
		</ul>

	</div>

	<?php if ( ! empty( $data['name'] ) || ! empty( $data['title'] ) || ! empty( $data['description'] ) ) : ?>
		<div class="team-member__content">

			<?php if ( ! empty( $data['image_link'] ) ) : ?>
			<a href="<?php echo esc_url( $data['image_link'] ) ?>" class="team-member__link"
				<?php echo( empty ( $data['new_tab'] ) ? '' : 'target="_blank"' ) ?> >
				<?php endif; ?>

				<?php if ( ! empty( $data['name'] ) ) : ?>
					<h4 class="team-member__title"><?php echo esc_html( $data['name'] ); ?></h4>
				<?php endif; ?>

				<?php if ( ! empty( $data['title'] ) ) : ?>
					<div class="team-member__position"><?php echo esc_html( $data['title'] ); ?></div>
				<?php endif; ?>

				<?php if ( ! empty( $data['image_link'] ) ) : ?>
			</a>
		<?php endif; ?>

			<?php if ( ! empty( $data['description'] ) ) : ?>
				<div class="team-member__description"><?php echo esc_html( $data['description'] ); ?></div>
			<?php endif; ?>

		</div>
	<?php endif; ?>

</div>