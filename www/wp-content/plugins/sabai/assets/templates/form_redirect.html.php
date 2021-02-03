<script type="text/javascript">
<?php if (isset($script)):?>
<?php   echo $script;?>
<?php else:?>
jQuery('document').ready(function() {
    setTimeout(function () {
        window.location.replace("<?php echo $url;?>");
    }, 1000);
});
<?php endif;?>
</script>
<p class="sabai-form-redirect"><?php echo $message;?></p>
<div class="sabai-form-redirect-btn">
    <p><?php echo __('If you are not redirected automatically, please click the button below:', 'sabai');?></p>
    <div>
        <a class="sabai-btn sabai-btn-primary" href="<?php echo $url;?>"><?php echo __('Continue', 'sabai');?></a>
    </div>
</div>