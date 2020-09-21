<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Nels
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

use Pikart\Nels\DependencyInjection\Service;

if ( post_password_required() ) :
	return;
endif;

$isCommentsNavigationEnabled = get_comment_pages_count() > 1 && get_option( 'page_comments' );
$commentsNumber              = get_comments_number();

$siteWidth = '';
$itemId    = Service::templatesUtil()->getItemId();

if ( $itemId ):
	$postOptions = Service::postOptionsLoader()->loadCommonPostOptions( $itemId );
	$siteWidth   = sprintf( 'max-width: %spx', $postOptions->getSiteWidth() );
endif;
?>

<div id="comments" class="entry-footer__item comments" style="<?php echo esc_attr( $siteWidth ) ?>">

	<?php if ( have_comments() ) : ?>

		<a class="comments__switch">
			<span class="comments__switch-button">
				<span class="closed">
					<?php echo esc_html__( 'Close Comments', 'nels' ) ?>
				</span>
				<span class="opened">
					<?php printf( esc_html( _n( 'Show %s Comment', 'Show %s Comments',
						(int) $commentsNumber, 'nels' ) ), (int) $commentsNumber ) ?>
				</span>
			</span>
		</a>

		<ul class="comments__list">
			<?php
			wp_list_comments( array(
				'style'       => 'ul',
				'short_ping'  => true,
				'avatar_size' => '72',
				'walker'      => Service::customWalkerComment(),
			) );
			?>
		</ul>

		<?php if ( $isCommentsNavigationEnabled ) :
			set_query_var( 'commentsNavigationPosition', 'below' );
			Service::util()->partial( 'comments/navigation' );
		endif;

	endif;

	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'nels' ); ?></p>

	<?php endif;

	Service::util()->partial( 'forms/comment-form' ); ?>

</div>
