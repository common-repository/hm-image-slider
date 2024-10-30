<div class="wrap">
    <p>
        <?php _e('Use this shortcode in post:', 'hm-image-slider');?>
        <br><hr>
        <div style="color: red;" class="ltr left-align">
            [hmslider id=<?php echo $post->ID;?>]
        </div>
        <br><hr>
            <?php _e('Or use below code in your functions.php', 'hm-image-slider'); ?>
        <br><hr>
        <div style="color: red;" class="ltr left-align">
            &lt;?php do_shortcode('[hmslider id=<?php echo $post->ID;?>]');?&gt;
        </div>
    </p>
</div>