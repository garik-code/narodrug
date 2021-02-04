<?php
/**
 * Add form field
 *
 * @package Post Category Image With Grid and Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$prefix = PCIWGAS_META_PREFIX; // Taking metabox prefix
?>

<div class="form-field pciwgas-term-img-wrap">
    <label for="pciwgas-thumb"><?php _e('Choose Category Image', 'post-category-image-with-grid-and-slider'); ?></label>      
	<input type="button" name="post-category-image-with-grid-and-slider_pcimg_url_btn" id="pciwgas-thumb" class="button button-secondary pciwgas-image-upload" value="<?php _e( 'Upload Image', 'post-category-image-with-grid-and-slider'); ?>" /> <input type="button" name="post-category-image-with-grid-and-slider_pcimg_url_clear" id="pciwgas-catimage-url-clear" class="button button-secondary pciwgas-image-clear pciwgas-image-clear" value="<?php _e( 'Clear', 'post-category-image-with-grid-and-slider'); ?>" /> <br/>
	
    <input type="hidden" name="<?php echo $prefix; ?>cat_thumb_id" value="" class="pciwgas-cat-thumb-id pciwgas-thumb-id" />
	<p class="description"><?php _e( 'Upload / Choose category image.', 'post-category-image-with-grid-and-slider' ); ?></p>
	<div class="pciwgas-img-preview pciwgas-img-view pciwgas-img-view"></div>
</div>