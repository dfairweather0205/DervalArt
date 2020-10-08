/**
 * @since 1.1.0
 */
(function ($) {
    'use strict';

    $(document).ready(function () {
        var socialLinksWidgetId = 'pikart-social-links';

        setupAddLinkEvent();
        setupDeleteLinkEvent();

        setupOnWidgetEvent('widget-added widget-updated', socialLinksWidgetId, function () {
            setupAddLinkEvent();
        });

        function setupAddLinkEvent() {
            $(document).on('click', '.widget-social-link-add', function () {
                var linkInput = '<input type="text" name="' + $(this).data('network-links-field') + '">',
                    deleteLinkButton = '<button type="button" class="widget-social-link-delete">Remove</button>';

                $(this).parent().before('<p>' + linkInput + deleteLinkButton + '</p>');

                setupDeleteLinkEvent();
            });
        }

        function setupDeleteLinkEvent() {
            $(document).on('click', '.widget-social-link-delete', function () {
                $(this).prev().trigger('change');
                $(this).parent().remove();
            });
        }

        function setupOnWidgetEvent(eventName, widgetIdBase, callback) {
            $(document).on(eventName, function (event, widget) {
                if (widget.find('input.id_base').val() === widgetIdBase) {
                    callback();
                }
            });
        }
    });
})(jQuery);