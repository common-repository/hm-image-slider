<?php

function hmis_get_slider($slider_id, $uid) {
    
    if( $slider_id == 0 ){
        ?>
        <div class="hmis-billboard-slider" id="<?php echo uniqid();?>">
            <ul>
                <li title="<?php esc_attr_e('No slider selected', 'hm-image-slider'); ?>">
                    <a href="#">
                        <img src="<?php echo HMIS_NO_IMAGE; ?>" />
                    </a>
                </li>
            </ul>
        </div>
        <?php
        return;
    }

    $args = array(
        'post_type'         => 'hm-image-slider',
        'p'                 => $slider_id,
        'posts_per_page'    => 1,
    );

    $the_query = new WP_Query($args);
    ?>

    <?php if ($the_query->have_posts()) : ?>


        <!-- the loop -->
        <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <?php $hmis_slides = get_post_meta(get_the_ID(), 'hmis_post_slides', true);?>
            <div class="hmis-billboard-slider" id="<?php echo $uid;?>">
                <ul>
                    <?php foreach ($hmis_slides as $slide): ?>
                        <li title="<?php echo $slide['caption'];?>">
                            <a href="<?php echo esc_url($slide['url']); ?>">
                                <img src="<?php echo esc_url($slide['image']); ?>" />
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endwhile; ?>
        <!-- end of the loop -->


        <?php wp_reset_postdata(); ?>

    <?php
    endif;
}
