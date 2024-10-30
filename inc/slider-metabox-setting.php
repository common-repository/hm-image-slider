<?php
    $hmis_slider_settings = get_post_meta($post->ID, 'hmis_post_slider_settings', true);
    global $hmis_slider_default_settings;
    $hmis_slider_settings = is_array($hmis_slider_settings) ? $hmis_slider_settings : $hmis_slider_default_settings;
?>
<div class="wrap">
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_speed"><?php _e('Speed', 'hm-image-slider');?></label>
        <input type="number" step="100" max="2000" id="hmis_setting_speed" value="<?php echo esc_attr($hmis_slider_settings['speed']);?>" name="hmis_setting_speed"/>
        <span class="description"><?php _e('MiliSec', 'hm-image-slider');?></span>
    </p>
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_duration"><?php _e('Duration', 'hm-image-slider');?></label>
        <input type="number" step="100" max="50000" id="hmis_setting_duration" value="<?php echo esc_attr($hmis_slider_settings['duration']);?>" name="hmis_setting_duration"/>
        <span class="description"><?php _e('Time between slide changes - MiliSec', 'hm-image-slider');?></span>
    </p>
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_autoplay"><?php _e('Autoplay', 'hm-image-slider');?></label>
        <input type="checkbox" value="1" id="hmis_setting_autoplay" <?php checked($hmis_slider_settings['autoplay'], true);?> name="hmis_setting_autoplay"/>
    </p>
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_loop"><?php _e('Loop', 'hm-image-slider');?></label>
        <input type="checkbox" value="1" id="hmis_setting_loop" <?php checked($hmis_slider_settings['loop'], true);?> name="hmis_setting_loop"/>
    </p>
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_autosize"><?php _e('Autosize', 'hm-image-slider');?></label>
        <input type="checkbox" value="1" id="hmis_setting_autosize" <?php checked($hmis_slider_settings['autosize'], true);?> name="hmis_setting_autosize"/>
    </p>
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_resize"><?php _e('Resize', 'hm-image-slider');?></label>
        <input type="checkbox" value="1" id="hmis_setting_resize" <?php checked($hmis_slider_settings['resize'], true);?> name="hmis_setting_resize"/>
    </p>
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_stretch"><?php _e('Stretch', 'hm-image-slider');?></label>
        <input type="checkbox" value="1" id="hmis_setting_stretch" <?php checked($hmis_slider_settings['stretch'], true);?> name="hmis_setting_stretch"/>
    </p>
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_transition"><?php _e('Transition', 'hm-image-slider');?></label>
        <select name="hmis_setting_transition">
            <option value="fade" <?php selected($hmis_slider_settings['transition'], 'fade');?>><?php _e('Fade', 'hm-image-slider');?></option>
            <option value="right" <?php selected($hmis_slider_settings['transition'], 'right');?>><?php _e('Right', 'hm-image-slider');?></option>
            <option value="left" <?php selected($hmis_slider_settings['transition'], 'left');?>><?php _e('Left', 'hm-image-slider');?></option>
            <option value="up" <?php selected($hmis_slider_settings['transition'], 'up');?>><?php _e('Up', 'hm-image-slider');?></option>
            <option value="down" <?php selected($hmis_slider_settings['transition'], 'down');?>><?php _e('Down', 'hm-image-slider');?></option>
        </select>
    </p>
    <p>
        <label style="min-width: 100px; display: inline-block;" for="hmis_setting_navtype"><?php _e('Navigation type', 'hm-image-slider');?></label>
        <select name="hmis_setting_navtype">
            <option value="list" <?php selected($hmis_slider_settings['navtype'], 'list');?>><?php _e('List', 'hm-image-slider');?></option>
            <option value="controls" <?php selected($hmis_slider_settings['navtype'], 'controls');?>><?php _e('Controls', 'hm-image-slider');?></option>
            <option value="both" <?php selected($hmis_slider_settings['navtype'], 'both');?>><?php _e('Both', 'hm-image-slider');?></option>
            <option value="none" <?php selected($hmis_slider_settings['navtype'], 'none');?>><?php _ex('None', 'no slider navigation', 'hm-image-slider');?></option>
        </select>
    </p>
    <hr>
    <p>
        <label style="min-width: 100px; display: inline-block;"><?php _e('Easing', 'hm-image-slider');?></label>
        <ul style="display: inline-block">
            <?php 
                $easingList = array(
                    'easeInBack',
                    'easeInBounce',
                    'easeInCirc',
                    'easeInCubic',
                    'easeInElastic',
                    'easeInExpo',
                    'easeInOutBack',
                    'easeInOutBounce',
                    'easeInOutCirc',
                    'easeInOutCubic',
                    'easeInOutElastic',
                    'easeInOutExpo',
                    'easeInOutQuad',
                    'easeInOutQuart',
                    'easeInOutQuint',
                    'easeInOutSine',
                    'easeInQuad',
                    'easeInQuart',
                    'easeInQuint',
                    'easeInSine',
                    'easeOutBack',
                    'easeOutBounce',
                    'easeOutCirc',
                    'easeOutCubic',
                    'easeOutElastic',
                    'easeOutExpo',
                    'easeOutQuad',
                    'easeOutQuart',
                    'easeOutQuint',
                    'easeOutSine',
                    'linear',
                    'swing',
                );
            ?>
            <?php foreach( $easingList as $ease ):?>
            <li style="display: inline-block">
                <input type="radio" name="hmis_setting_easing" <?php checked($hmis_slider_settings['easing'], $ease);?> id="hmis_<?php echo $ease;?>" value="<?php echo $ease;?>"/>
                <label for="hmis_<?php echo esc_attr($ease);?>">
                    <img title="<?php echo esc_attr( $ease );?>" src="<?php echo esc_url(HMIS_IMAGES) . $ease ;?>.png"/>
                </label>
            </li>
            <?php endforeach;?>
        </ul>
    </p>
</div>