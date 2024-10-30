<?php

add_action('init', 'hmis_add_image_slider_post_type');

function hmis_add_image_slider_post_type() {

    $labels = array(
        'name' => _x('Sliders', 'post type general name', 'hm-image-slider'),
        'singular_name' => _x('Slider', 'post type singular name', 'hm-image-slider'),
        'menu_name' => _x('Sliders', 'admin menu', 'hm-image-slider'),
        'name_admin_bar' => _x('Slider', 'add new on admin bar', 'hm-image-slider'),
        'add_new' => _x('Add New', 'slider', 'hm-image-slider'),
        'add_new_item' => __('Add New Slider', 'hm-image-slider'),
        'new_item' => __('New Slider', 'hm-image-slider'),
        'edit_item' => __('Edit Slider', 'hm-image-slider'),
        'view_item' => __('View Slider', 'hm-image-slider'),
        'all_items' => __('All Sliders', 'hm-image-slider'),
        'search_items' => __('Search Sliders', 'hm-image-slider'),
        'parent_item_colon' => __('Parent Sliders:', 'hm-image-slider'),
        'not_found' => __('No Sliders found.', 'hm-image-slider'),
        'not_found_in_trash' => __('No Sliders found in Trash.', 'hm-image-slider')
    );

    $args = array(
        'labels' => $labels,
        'description' => __('Description.', 'hm-image-slider'),
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => false,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'excerpt'),
        'register_meta_box_cb' => 'hmis_slider_metabox'
    );

    register_post_type('hm-image-slider', $args);
    
    //Register slider taxonomy
    // Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Subjects', 'taxonomy general name', 'hm-image-slider' ),
		'singular_name'              => _x( 'Subject', 'taxonomy singular name', 'hm-image-slider' ),
		'search_items'               => __( 'Search Subjects', 'hm-image-slider' ),
		'popular_items'              => __( 'Popular Subjects', 'hm-image-slider' ),
		'all_items'                  => __( 'All Subject', 'hm-image-slider' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Subject', 'hm-image-slider' ),
		'update_item'                => __( 'Update Subject', 'hm-image-slider' ),
		'add_new_item'               => __( 'Add New Subject', 'hm-image-slider' ),
		'new_item_name'              => __( 'New Subject Name', 'hm-image-slider' ),
		'separate_items_with_commas' => __( 'Separate Subjects with commas', 'hm-image-slider' ),
		'add_or_remove_items'        => __( 'Add or remove Subjects', 'hm-image-slider' ),
		'choose_from_most_used'      => __( 'Choose from the most used Subjects', 'hm-image-slider' ),
		'not_found'                  => __( 'No Subjects found.', 'hm-image-slider' ),
		'menu_name'                  => __( 'Subjects', 'hm-image-slider' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => 'null',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'slider-subject' ),
	);

	register_taxonomy( 'slider-subject', 'hm-image-slider', $args );
    
}

function hmis_slider_metabox($post) {
    
    wp_register_script('lightboxme', HMIS_JS . 'jquery.lightbox_me.js', array('jquery'));
    
    wp_enqueue_script('hmis-metabox-script', HMIS_JS . 'metabox-script.js', array('jquery', 'media-upload', 'thickbox', 'lightboxme', 'jquery-ui-sortable'));
    wp_localize_script('hmis-metabox-script', 'hmis_data', array(
        'default_image_url' => HMIS_IMAGES . 'select.png',
        'no_image_select'   => __('You select no image slide', 'hm-image-slider'),
        'edit_text'   => __('Edit', 'hm-image-slider'),
        'insert_text'   => __('Insert', 'hm-image-slider'),
        ));
    wp_enqueue_style('thickbox');
    wp_enqueue_style('hmis-metabox-style', HMIS_CSS . 'metabox-style.css');
    
    add_meta_box(
            'hmis-metabox', __('Slides', 'hm-image-slider'), function($post) {
        include(HMIS_INC . 'slider-metabox.php');
    }
    );
    
    add_meta_box(
            'hmis-metabox_slider_setting', __('Slider settings', 'hm-image-slider'), function($post) {
        include(HMIS_INC . 'slider-metabox-setting.php');
    }
    );
    
    add_meta_box(
            'hmis-metabox_slider_how_use', __('Slider how use', 'hm-image-slider'), function($post) {
        include(HMIS_INC . 'slider-metabox-how-use.php');
    }, null, 'side'
    );
    
}

//Saving
add_action('save_post', 'hmis_save_slides');
add_action('edit_post', 'hmis_save_slides');

function hmis_save_slides($post_id){
    
    if( !isset( $_POST['hmis_slide_images'] ) ) {
        return;
    }
    
    if(!current_user_can('edit_posts') ){
        return;
    }
    
    $hmis_slides = array();
    
    for($i = 0; $i < count($_POST['hmis_slide_images']); $i++){
        $hmis_slides[$i]['image'] = esc_url_raw($_POST['hmis_slide_images'][$i]);
        $hmis_slides[$i]['caption'] = sanitize_text_field($_POST['hmis_slide_captions'][$i]);
        $hmis_slides[$i]['url'] = esc_url_raw($_POST['hmis_slide_urls'][$i]);
    }
    
    global $hmis_slider_default_settings ;
    
    $hmis_slider_settings = array(
        'speed'         => absint($_POST['hmis_setting_speed']) > 0 ? absint($_POST['hmis_setting_speed']) : $hmis_slider_default_settings['speed'] ,
        'duration'      => absint($_POST['hmis_setting_duration']) > 0 ? absint($_POST['hmis_setting_duration']) : $hmis_slider_default_settings['duration'] ,
        'autoplay'      => isset($_POST['hmis_setting_autoplay']) ? true : false,
        'resize'        => isset($_POST['hmis_setting_resize']) ? true : false,
        'stretch'       => isset($_POST['hmis_setting_stretch']) ? true : false,
        'loop'          => isset($_POST['hmis_setting_loop']) ? true : false,
        'autosize'      => isset($_POST['hmis_setting_autosize']) ? true : false,
        'transition'    => in_array($_POST['hmis_setting_transition'], array('top','right','down', 'left', 'fade')) ? $_POST['hmis_setting_transition'] : $hmis_slider_default_settings['duration'],
        'navtype'       => in_array($_POST['hmis_setting_navtype'], array('list','controls','both', 'none')) ? $_POST['hmis_setting_navtype'] : $hmis_slider_default_settings['navtype'],
        'easing'        => in_array($_POST['hmis_setting_easing'], array( 'easeInBack','easeInBounce','easeInCirc','easeInCubic','easeInElastic','easeInExpo','easeInOutBack','easeInOutBounce','easeInOutCirc','easeInOutCubic','easeInOutElastic','easeInOutExpo','easeInOutQuad','easeInOutQuart','easeInOutQuint','easeInOutSine','easeInQuad','easeInQuart','easeInQuint','easeInSine','easeOutBack','easeOutBounce','easeOutCirc','easeOutCubic','easeOutElastic','easeOutExpo','easeOutQuad','easeOutQuart','easeOutQuint','easeOutSine','linear','swing')) ? $_POST['hmis_setting_easing'] : $hmis_slider_default_settings['easing']
    );
    
    update_post_meta($post_id, 'hmis_post_slides', $hmis_slides);
    update_post_meta($post_id, 'hmis_post_slider_settings', $hmis_slider_settings);
    
}

add_filter('manage_hm-image-slider_posts_columns', function($columns){
    $columns['slider_excerpt'] = __('Excerpt', 'hm-image-slider');
    return $columns;
});

add_filter('manage_hm-image-slider_posts_custom_column', function($column_name, $post_id){
    if( $column_name == 'slider_excerpt' ){
        $post = get_post( $post_id );
        print_r( $post->post_excerpt );
    }
}, 10, 2);
