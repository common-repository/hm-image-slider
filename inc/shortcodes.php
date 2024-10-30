<?php

add_action('wp_enqueue_scripts', function(){
    
    wp_register_script('swipe', HMIS_JS . 'jquery.event.swipe.js', array('jquery'));
    wp_register_script('billboard', HMIS_JS . 'jquery.billboard.js', array('jquery', 'swipe'));
    wp_register_script('easing', HMIS_JS . 'jquery.easing.min.js', array('jquery'));
    
    wp_register_style('billboard', HMIS_CSS . 'jquery.billboard.css');
    wp_enqueue_style('billboard');
    
});

add_action('init', 'hmis_slider_shortcode');

function hmis_slider_shortcode(){
    
    add_shortcode('hmslider', 'hmis_slider_shortocde_callback');
    
}

function hmis_slider_shortocde_callback($atts, $content = null){
    
    extract(shortcode_atts(array(
        "id" => 0
    ), $atts));
    
    $uid = 'shortcode-slider-' . uniqid();
    
    $hmis_slider_settings = get_post_meta($id , 'hmis_post_slider_settings', true);
    global $hmis_slider_default_settings;
    $hmis_slider_settings = is_array($hmis_slider_settings) ? $hmis_slider_settings : $hmis_slider_default_settings;
    
    $hmis_slider_settings['uid'] = $uid;
    $suffix = build_query($hmis_slider_settings);
    
    wp_enqueue_script('hmis-script' . $uid , HMIS_JS . 'hmsliderimage-front-script.php?' . $suffix, array('jquery', 'easing' , 'billboard', 'swipe'), true);
    
    ob_start();
    hmis_get_slider($id, $uid);
    return ob_get_clean();
    
}