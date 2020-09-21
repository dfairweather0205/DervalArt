<?php

use Pikart\WpBase\DependencyInjection\Service;
use Pikart\WpBase\OptionsPages\PageOption;

$googleAnalyticsTrackingId =
	Service::optionsPagesUtil()->getPikartBaseOption( PageOption::GOOGLE_ANALYTICS_TRACKING_ID );

if ( empty( $googleAnalyticsTrackingId ) ) :
	return;
endif;

?>
<script>
    (function (i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

    ga('create', '<?php echo esc_js( $googleAnalyticsTrackingId ) ?>', 'auto');
    ga('send', 'pageview');

</script>