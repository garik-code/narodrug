<script type="text/javascript">
jQuery(document).ready(function ($) {
    var loadDirectory = function (center) {
        SABAI.ajaxLoader('<?php echo $CURRENT_CONTAINER;?> .sabai-directory-geolocate', true);
        SABAI.ajax({
            type: <?php if (defined('SABAI_FIX_URI_TOO_LONG') && SABAI_FIX_URI_TOO_LONG):?>'post'<?php else:?>'get'<?php endif;?>,
            container: '<?php echo $CURRENT_CONTAINER;?>',
            target: '.sabai-directory-geolocate',
            url: '<?php echo $this->Url('/sabai/directory', $url_params, '', '&');?>&is_geolocate=1&center=' + center,
            onError: function (error) {SABAI.flash(error.message, 'danger');}
        });
    };
    SABAI.ajaxLoader('<?php echo $CURRENT_CONTAINER;?> .sabai-directory-geolocate');
    if (navigator.geolocation
        && (document.location.protocol === 'https:' || document.location.hostname === 'localhost')
    ) {
        navigator.geolocation.getCurrentPosition(
            function (pos) {loadDirectory(pos.coords.latitude + "," + pos.coords.longitude);},
            function (error) {loadDirectory('');SABAI.flash(error.message, 'danger');},
            {enableHighAccuracy:true, timeout:5000}
        );
    } else {
        loadDirectory('');
    }
});
</script>
<div class="sabai-directory-geolocate"></div>
