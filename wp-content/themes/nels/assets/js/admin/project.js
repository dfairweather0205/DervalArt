(function ($) {
    'use strict';

    $(document).ready(function () {
        manageProjectMetaBoxes();

        $('#_pikart_meta_project_type').on('change', function () {
            manageProjectMetaBoxes();
        });

        $('.pikart-metabox-date').datepicker({
            dateFormat: 'yy-mm-dd'
        });

        function manageProjectMetaBoxes() {
            var selectedProjectType = $('#_pikart_meta_project_type').val();

            ['slider', 'masonry', 'carousel'].forEach(function (projectType) {
                var metaBox = $('#project_' + projectType + '_options');

                if (selectedProjectType === projectType) {
                    metaBox.show();
                } else {
                    metaBox.hide();
                }
            });
        }
    });

})(jQuery);