<?php

class HMIS_Widget extends WP_Widget {
     
  public $uid = '';
    
  // widget constructor
  public function __construct(){
     
      parent::__construct(
        'hmis_widget',
        __( 'Slider', 'hm-image-slider' ),
        array(
            'classname'   => 'hmis_image_slider_widget',
            'description' => __( 'Show slider from sliders', 'hm-image-slider' )
        )
      );
      
  }
  
    
  public function widget( $args, $instance ) {
    // outputs the content of the widget
      
      $this->uid = 'widget-slider-' . uniqid();
      
        extract( $args );
        
        $title = (!isset($instance['title']) || $instance['title'] == '') ? __('Slider', 'hm-image-slider') : $instance['title'] ;
        $slider_id = (!isset($instance['slider_id']) || $instance['slider_id'] == '') ? 0 : $instance['slider_id'] ;
     
      
        $hmis_slider_settings = get_post_meta($slider_id , 'hmis_post_slider_settings', true);
        global $hmis_slider_default_settings;
        $hmis_slider_settings = is_array($hmis_slider_settings) ? $hmis_slider_settings : $hmis_slider_default_settings;
        $hmis_slider_settings['uid'] = $this->uid;
        $suffix = build_query($hmis_slider_settings);
        wp_enqueue_script('hmis-script-' . $this->uid, HMIS_JS . 'hmsliderimage-front-script.php?' . $suffix, array('jquery', 'easing' , 'billboard', 'swipe'), true);
      
        //$title         = apply_filters( 'widget_title', $instance['title'] );
        //$message    = $instance['message'];

        echo $before_widget;

        //if ( $title ) {
            echo $before_title . esc_html($title) . $after_title;
        //}

        //echo $message;
            hmis_get_slider($slider_id, $this->uid);
            ?>


<?php
        echo $after_widget;
      
  }
    
  public function form( $instance ) {
    // creates the back-end form
      $title = (!isset($instance['title']) || $instance['title'] == '') ? __('Slider', 'hm-image-slider') : $instance['title'] ;
      $slider_id = (!isset($instance['slider_id']) || $instance['slider_id'] == '') ? 0 : $instance['slider_id'] ;
      
      ?>
      
      <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget name', 'hm-image-slider');?></label>
        <input type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title');?>" value="<?php echo esc_attr($title);?>" class="widefat"/>
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('slider_id');?>"><?php _e('Select slider', 'hm-image-slider');?></label>
        <select id="<?php echo $this->get_field_id('slider_id');?>" value="<?php echo esc_attr($slider_id);?>" name="<?php echo $this->get_field_name('slider_id');?>">
            <option value="0" <?php selected($slider_id, '0');?>><?php _e('Select slider', 'hm-image-slider');?></option>
            <?php
            $args = array(
                'post_type'         => 'hm-image-slider',
                'posts_per_page'    => -1,
            );

            $the_query = new WP_Query($args);
            ?>

            <?php if ($the_query->have_posts()) : ?>
                <!-- the loop -->
                <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                        <option value="<?php the_ID();?>" <?php selected($slider_id, get_the_ID());?>><?php the_title();?></option>
                <?php endwhile; ?>
                <!-- end of the loop -->
                <?php wp_reset_postdata(); ?>

            <?php
            endif;
            ?>
        </select>
    </p>

      <?php
      
  }
    
  // Updating widget replacing old instances with new
  public function update( $new_instance, $old_instance ) {
        // processes widget options on save
        $instance = $old_instance;
        $instance['title'] = wp_strip_all_tags($new_instance['title']);
        $instance[ 'slider_id' ] = absint($new_instance['slider_id']);
        return $instance;
  }
   
}

add_action('widgets_init', function(){
    register_widget('HMIS_Widget');
});
