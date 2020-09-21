<?php
/**
 * @var \Pikart\WpBase\Widget\Type\TwitterWidget $this
 * @var array $data
 *
 * @since 1.6.2
 */

?>

<div class="widget_pikart_tweets">
	<?php
	printf( '<a class="twitter-timeline" href="https://twitter.com/%s" data-tweet-limit="%d"
							data-theme="%s"></a>',
		esc_attr( $this->getOptionValue( 'twitter_user', $data ) ),
		esc_attr( absint( $this->getOptionValue( 'tweets_number', $data ) ) ),
		esc_attr( $this->getOptionValue( 'theme', $data ) )
	);
	?>
</div>
