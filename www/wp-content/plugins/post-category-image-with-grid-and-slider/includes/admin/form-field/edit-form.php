<?php
/**
 * Edit form field
 *
 * @package Post Category Image With Grid and Slider
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$prefix = PCIWGAS_META_PREFIX; // Taking metabox prefix
	    
//getting term ID
$term_id = $term->term_id;

// Getting stored values
$cat_thumb_id 			= get_term_meta($term_id, $prefix.'cat_thumb_id', true);

$cat_thum_image			=pciwgas_term_image($term_id,'thumbnail');
?>

<tr class="form-field">
    <th scope="row" valign="top"><label for="pciwgas-cat-image"><?php _e('Upload Image', 'post-category-image-with-grid-and-slider'); ?></label></th>
    <td>
    	<input type="button" name="pciwgas_url_btn" id="pciwgas-thumb" class="button button-secondary pciwgas-image-upload" value="<?php _e( 'Upload Image', 'post-category-image-with-grid-and-slider'); ?>" /> <input type="button" name="pciwgas_url_clear" id="pciwgas-catimage-url-clear" class="button button-secondary pciwgas-image-clear pciwgas-image-clear" value="<?php _e( 'Clear', 'post-category-image-with-grid-and-slider'); ?>" /> <br/>
	
    <input type="hidden" name="<?php echo $prefix; ?>cat_thumb_id" value="<?php echo $cat_thumb_id;?>" class="pciwgas-cat-thumb-id pciwgas-thumb-id" />
	<p class="description"><?php _e( 'Upload / Choose category image.', 'post-category-image-with-grid-and-slider' ); ?></p>
	<div class="pciwgas-img-preview pciwgas-img-view pciwgas-img-view">
		<?php 
		if(!empty($cat_thum_image)){			
			?>
			<img src="<?php echo $cat_thum_image;?>"/>
			<?php
		}
		?>
	</div>
	</td>
</tr>