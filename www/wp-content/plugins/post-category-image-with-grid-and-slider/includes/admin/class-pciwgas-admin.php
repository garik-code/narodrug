<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Post Category Image With Grid and Slider
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class Pciwgas_Admin {
	
	function __construct() {

		// Action to register admin menu
		add_action( 'admin_menu', array($this, 'pciwgas_register_menu') );

		// Action to register plugin settings
		add_action ( 'admin_init', array($this, 'pciwgas_register_settings') );

		//Action to add category columns
		add_action('admin_init',array($this, 'pciwgas_admin_init')); 	

	}

	/**
	 * Function to register admin menus
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
	function pciwgas_register_menu() {
		add_menu_page ( __('Category Image', 'post-category-image-with-grid-and-slider'), __('Category Image', 'post-category-image-with-grid-and-slider'), 'manage_options', 'pciwgas-settings', array($this, 'pciwgas_settings_page'), 'dashicons-feedback' );

		// Register plugin premium page
		add_submenu_page( 'pciwgas-settings', __('Upgrade to PRO - Post Category Image With Grid and Slider', 'post-category-image-with-grid-and-slider'), '<span style="color:#2ECC71">'.__('Upgrade to PRO', 'post-category-image-with-grid-and-slider').'</span>', 'manage_options', 'pciwgas-premium', array($this, 'pciwgas_premium_page') );
	}

	/**
	 * Function to handle the setting page html
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
	function pciwgas_settings_page() {
		include_once( PCIWGAS_DIR . '/includes/admin/settings/settings.php' );
	}

	/**
	 * Function to handle the upgrade to pro page html
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.3.1
	 */
	function pciwgas_premium_page() {
		include_once( PCIWGAS_DIR . '/includes/admin/settings/premium.php' );
	}

	/**
	 * Function register setings
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
	function pciwgas_register_settings() {

		// If plugin notice is dismissed
		if( isset($_GET['message']) && $_GET['message'] == 'pciwgas-plugin-notice' ) {
			set_transient( 'pciwgas_install_notice', true, 604800 );
		}

		register_setting( 'pciwgas_plugin_options', 'pciwgas_options', array($this, 'pciwgas_validate_options') );
	}


	/**
	 * Validate Settings Options
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
	function pciwgas_validate_options( $input ) {
		return $input;
	}	

	/**
	 * Add image column
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
	public function pciwgas_admin_init() {
        $taxonomies = pciwgas_get_option('pciwgas_category');
       
        if(!empty($taxonomies)){
        	foreach ((array) $taxonomies as $taxonomy) {
            	$this->pciwgas_add_custom_column_fields($taxonomy);
        	}
        }
    }

    /**
	 * Add custom column field
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
    public function pciwgas_add_custom_column_fields( $taxonomy ) {
        add_action("{$taxonomy}_add_form_fields", array($this, 'pciwgas_add_taxonomy_field'));
        add_action("{$taxonomy}_edit_form_fields", array($this, 'pciwgas_edit_taxonomy_field'));

        // Save taxonomy fields
		add_action('edited_'.$taxonomy, array($this, 'pciwgas_save_taxonomy_custom_meta'));
		add_action('create_'.$taxonomy, array($this, 'pciwgas_save_taxonomy_custom_meta'));

        // Add custom columns to custom taxonomies
        add_filter("manage_edit-{$taxonomy}_columns", array($this, 'pciwgas_manage_category_columns'));
        add_filter("manage_{$taxonomy}_custom_column", array($this, 'pciwgas_manage_category_columns_fields'), 10, 3);
    }

    /**
	 * Add form field on taxonomy page
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
    public function pciwgas_add_taxonomy_field( $taxonomy ) {
        include_once( PCIWGAS_DIR . '/includes/admin/form-field/add-form.php' );
    }

    /**
	 * Add form field on edit-taxonomy page
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
    public function pciwgas_edit_taxonomy_field($term){
        include_once( PCIWGAS_DIR . '/includes/admin/form-field/edit-form.php' );
    }

    /**
	 * Function to add term field on edit screen
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
	function pciwgas_save_taxonomy_custom_meta($term_id) {

		$prefix = PCIWGAS_META_PREFIX; // Taking metabox prefix

	   
	    $cat_thumb_id = !empty($_POST[$prefix.'cat_thumb_id']) ? pciwgas_escape_attr($_POST[$prefix.'cat_thumb_id']) : '';

	    update_term_meta($term_id, $prefix.'cat_thumb_id', $cat_thumb_id);
	}

    /**
	 * Add image column
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
    public function pciwgas_manage_category_columns($columns){
    	
    	$new_columns['pciwgas_image'] = __( 'Image', 'pwpc' );
		$columns = pciwgas_add_array( $columns, $new_columns, 1, true );
		
	    return $columns;
    }

    /**
	 * Add column data
	 * 
	 * @package Post Category Image With Grid and Slider
	 * @since 1.0.0
	 */
    public function pciwgas_manage_category_columns_fields($output, $column_name, $term_id)
    {
    	if( $column_name == 'pciwgas_image' ) {
	        $prefix = PCIWGAS_META_PREFIX; // Taking metabox prefix	    
		    
		    $cat_thum_image			= pciwgas_term_image($term_id,'thumbnail'); 
		    if(!empty($cat_thum_image)){
		    	$output .= '<img class="pwpc-cat-img" src="'.$cat_thum_image.'" height="70" width="70">';
		    }
		}
	    return $output;
    }
	
}

$pciwgas_admin = new Pciwgas_Admin();