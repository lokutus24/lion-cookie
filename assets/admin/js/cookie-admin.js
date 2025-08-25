jQuery(document).ready(function($) {
    // Színválasztók inicializálása
    $('.my-color-field').wpColorPicker();

    // Képfeltöltő gomb működése
    var mediaUploader;
    $('.upload_image_button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Válassz egy képet',
            button: { text: 'Kép kiválasztása' },
            multiple: false
        });

        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#popup_image').val(attachment.url); // URL beállítása
            $('.popup-image-preview').html('<img src="' + attachment.url + '" alt="Popup Image Preview" />');
        });

        mediaUploader.open();
    });
});