(function ($) {
    'use strict';

    /* global google */

    // generated in Shortcode/ShortcodesInitializer.php
    var pikartShortcodesOptions = window.hasOwnProperty('pikartShortcodesOptions') ?
        window.pikartShortcodesOptions : {googleMapsPinImage: ''};

    handleMapShortcode();

    $(document).ready(function () {
        handleHoverColors();
    });

    function handleHoverColors() {
        $('.pikode--button, .pikode--icon').each(function () {
            var self = $(this);

            var textColor = $(this).css('color'),
                backgroundColor = $(this).css('background-color'),
                borderColor = $(this).css('border-top-color');
            /* Mozilla fix: it does not take border-color as value */

            var setCssProperty = function (property, dataAttribute) {
                var value = self.data(dataAttribute);

                if (value === '') {
                    return;
                }

                self.css(property, value);
            };

            self.on('mouseenter', function () {
                setCssProperty('color', 'text-hover-color');
                setCssProperty('background-color', 'background-hover-color');
                setCssProperty('border-color', 'border-hover-color');
            });

            self.on('mouseleave', function () {
                self.css('color', textColor);
                self.css('background-color', backgroundColor);
                self.css('border-color', borderColor);
            });
        });
    }

    function handleMapShortcode() {

        var googleMapsPinImage = pikartShortcodesOptions.googleMapsPinImage ?
            pikartShortcodesOptions.googleMapsPinImage : 'https://maps.gstatic.com/mapfiles/ms2/micons/red-dot.png';

        var mapShortcodeConfig = {
            styles: [],
            markerIcon: {
                url: googleMapsPinImage
            }
        };

        window.pikartSetupMapShortcodeConfig = function (styles) {
            if (styles) {
                mapShortcodeConfig.styles = styles;
            }
        };

        function createZoomControl() {
            var zoomInButton = document.createElement('div'),
                zoomOutButton = document.createElement('div'),
                controlWrapper = document.createElement('div'),
                controlContainer = document.createElement('div');

            zoomInButton.className = 'map-control__zoom-in';
            zoomOutButton.className = 'map-control__zoom-out';
            controlWrapper.className = 'map-control';
            controlContainer.className = 'map-control-wrapper';
            controlContainer.index = 1;
            controlContainer.style.padding = '9px';

            controlWrapper.appendChild(zoomInButton);
            controlWrapper.appendChild(zoomOutButton);
            controlContainer.appendChild(controlWrapper);

            return {
                container: controlContainer,
                zoomInButton: zoomInButton,
                zoomOutButton: zoomOutButton
            };
        }

        window.gmap = {
            markers: []
        };

        window.initGMap = function () {
            $(document).ready(function () {

                var customGmap = {

                    run: function (config) {
                        var initMap = function () {
                            customGmap.init(config);
                        };

                        // required by parallax functions
                        google.maps.event.addDomListener(window, 'load', initMap);

                        initMap();
                    },

                    init: function (config) {
                        if (config.positions.lenght < 1) {
                            return;
                        }

                        var zoom = config.zoom || 8,
                            map = new google.maps.Map(
                                config.element,
                                {
                                    mapTypeId: 'roadmap',
                                    draggable: !('ontouchstart' in document.documentElement),
                                    scrollwheel: false,
                                    styles: config.styles || [],
                                    zoom: zoom,
                                    disableDefaultUI: true
                                }
                            );

                        var customZoomControl = createZoomControl();

                        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(customZoomControl.container);

                        google.maps.event.addDomListener(customZoomControl.zoomInButton, 'click', function () {
                            map.setZoom(map.getZoom() + 1);
                        });

                        google.maps.event.addDomListener(customZoomControl.zoomOutButton, 'click', function () {
                            map.setZoom(map.getZoom() - 1);
                        });

                        var bounds = new google.maps.LatLngBounds(),
                            infoWindow = new google.maps.InfoWindow();

                        config.positions.forEach(function (position, index) {
                            var latLng = new google.maps.LatLng(position.lat, position['long']);

                            bounds.extend(latLng);

                            var marker = new google.maps.Marker({
                                position: latLng,
                                map: map,
                                draggable: false,
                                title: config.titles[index],
                                icon: config.markerIcon
                            });

                            map.fitBounds(bounds);

                            var listener = google.maps.event.addListener(map, 'bounds_changed', function () {
                                map.setZoom(zoom);
                                google.maps.event.removeListener(listener);
                            });

                            google.maps.event.addListener(marker, 'click', function () {

                                if (!config.descriptions[index]) {
                                    return;
                                }

                                infoWindow.setContent(config.descriptions[index]);
                                infoWindow.open(map, marker);
                            });

                            window.gmap.markers.push(marker);
                        });
                    }
                };

                $('.pikode--map').each(function () {
                    var map = this;

                    customGmap.run({
                        element: map,
                        styles: mapShortcodeConfig.styles,
                        zoom: parseInt(map.dataset.zoom, 10),
                        positions: JSON.parse(map.dataset.positions),
                        titles: JSON.parse(map.dataset.titles),
                        descriptions: JSON.parse(map.dataset.descriptions),
                        markerIcon: mapShortcodeConfig.markerIcon
                    });
                });
            });
        };
    }
})(jQuery);
