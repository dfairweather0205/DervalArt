<?php
/**
 * @var \Pikart\WpBase\Shortcode\ShortcodeRenderer $this
 * @var array $data
 */

use Pikart\WpCore\Shortcode\ShortcodeFilterName;

$name        = trim( $data['name'] );
$socialLinks = array(
	'twitter'   => $data['twitter'],
	'facebook'  => $data['facebook'],
	'linkedin'  => $data['linkedin'],
	'pinterest' => $data['pinterest'],
);

$backgroundColor = apply_filters(
	ShortcodeFilterName::teamMemberHeaderBrandingBackgroundColor(), '#ffffff', get_the_ID() );

$headerBrandingStyle = $this->style( array( $this->styleItem( 'background-color', esc_attr( $backgroundColor ) ) ) );
?>

<div class="pikode  pikode--team-member team-member <?php echo esc_attr( trim( $data['css_class'] ) ) ?>">

	<?php if ( ! empty( $data['image_link'] ) ) : ?>
	<a href="<?php echo esc_url( $data['image_link'] ) ?>" class="team-member__wrapper-link"
		<?php echo( $this->getBoolean( $data['new_tab'] ) ? 'target="_blank"' : '' ) ?>>
		<?php endif; ?>

		<div class="team-member__header">

			<?php if ( ! empty( $data['image'] ) ) : ?>

				<div class="team-member__header__image">
					<div class="image__wrapper">
						<img src="<?php echo esc_url( $data['image'] ); ?>"
							 alt="<?php echo esc_attr( $data['name'] ) ?>">
					</div>
				</div>

			<?php endif; ?>

			<div class="team-member__header__branding" <?php print( $headerBrandingStyle ) ?> >

				<?php if ( ! empty( $data['name'] ) ) : ?>
					<h4 class="team-member__header__branding__title"><?php echo esc_html( $data['name'] ); ?></h4>
				<?php endif; ?>

				<?php if ( ! empty( $data['title'] ) ) : ?>
					<div class="team-member__header__branding__position"><?php echo esc_html( $data['title'] ); ?></div>
				<?php endif; ?>

				<?php if ( ! empty( $data['description'] ) ) : ?>
					<div class="team-member__header__description"><?php echo esc_html( $data['description'] ); ?></div>
				<?php endif; ?>

			</div>

		</div>

		<?php if ( ! empty( $data['image_link'] ) ) : ?>
	</a>
<?php endif; ?>

	<div class="team-member__footer">
		<ul class="footer__social-list">
			<?php foreach ( $socialLinks as $networkName => $socialLink ) :
				if ( ! empty( $socialLink ) ) : ?>
					<li class="social-list__item">
						<a class="item__link" href="<?php echo esc_url( $socialLink ); ?>" target="_blank">
							<i class="fa fa-<?php echo esc_attr( $networkName ) ?>"></i>
						</a>
					</li>
				<?php
				endif;
			endforeach; ?>
		</ul>
	</div>

</div>