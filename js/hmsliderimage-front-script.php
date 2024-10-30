<?php
header('Content-Type: application/javascript');
$uid        = $_GET['uid'];
$transition = isset($_GET['transition']) ? $_GET['transition'] : 'fade';
$navType    = isset($_GET['navtype']) ? $_GET['navtype'] : 'controls';
$easing     = isset($_GET['easing']) ? $_GET['easing'] : 'easeInOutExpo';
$speed      = isset($_GET['speed']) ? intval($_GET['speed']) : 300;
$duration   = isset($_GET['duration']) ? intval($_GET['duration']) : 3000;
$stretch    = ( isset($_GET['stretch']) && $_GET['stretch'] == true ) ? 'true' : 'false';
$autoplay   = ( isset($_GET['autoplay']) && $_GET['autoplay'] == true ) ? 'true' : 'false';
$loop       = ( isset($_GET['loop']) && $_GET['loop'] == true ) ? 'true' : 'false';
$resize     = ( isset($_GET['resize']) && $_GET['resize'] == true ) ? 'true' : 'false';
$autosize   = ( isset($_GET['autosize']) && $_GET['autosize'] == true ) ? 'true' : 'false';
echo <<<JS
jQuery(document).ready(function ($) {
    $("#$uid").billboard({
        transition  : "$transition", 
        navType     : "$navType",
        stretch     : $stretch,
        duration    : $duration,
        loop        : $loop,
        autoplay    : $autoplay,
        resize      : $resize,
        ease        : "$easing", 
        speed       : $speed,
        //includeFooter: false,
        resize      : $resize 
    });
});
JS;
