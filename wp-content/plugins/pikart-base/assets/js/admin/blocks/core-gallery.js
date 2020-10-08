(function (element, components, editor, i18n) {

    var createElement = element.createElement,
        __ = i18n.__,
        galleryBlockName = 'core/gallery',
        galleryConfig = window.hasOwnProperty('pikartGalleryConfig') ? window.pikartGalleryConfig : {
            settings: {
                columnsSpacing: {}
            }
        },
        colSpacingConfig = galleryConfig.settings.columnsSpacing;

    var extendRegisterBlockType = function (settings, name) {
        if (name !== galleryBlockName) {
            return settings;
        }

        settings.attributes = lodash.assign(settings.attributes, {
            columnsSpacing: {
                type: 'number',
                'default': colSpacingConfig['default']
            }
        });

        return settings;
    };


    var extendBlockEdit = wp.compose.createHigherOrderComponent(function (BlockEdit) {
        return function (props) {

            if (props.name !== galleryBlockName || props.attributes.ids.length === 0) {
                return createElement(BlockEdit, props);
            }

            var colSpacingConfig = galleryConfig.settings.columnsSpacing;

            return createElement(
                element.Fragment,
                {},
                createElement(
                    BlockEdit,
                    props
                ),
                createElement(
                    editor.InspectorControls,
                    {},
                    createElement(
                        components.PanelBody, {
                            title: __('Custom Settings'),
                            initialOpen: true
                        },
                        createElement(components.TextControl, {
                            label: __('Columns spacing'),
                            type: 'number',
                            value: props.attributes.columnsSpacing,
                            min: colSpacingConfig.minimum,
                            max: colSpacingConfig.maximum,
                            onChange: function (value) {
                                props.setAttributes({columnsSpacing: parseInt(value, 10)});
                            }
                        })
                    )
                )
            );
        };
    }, 'extendCoreGalleryForBlockEdit');


    wp.hooks.addFilter('blocks.registerBlockType', 'pikart/core-gallery-register-block-type', extendRegisterBlockType);
    wp.hooks.addFilter('editor.BlockEdit', 'pikart/core-gallery-block-edit', extendBlockEdit);
})(
    window.wp.element,
    window.wp.components,
    window.wp.editor,
    window.wp.i18n
);
