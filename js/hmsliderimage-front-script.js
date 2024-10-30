jQuery(document).ready(function ($) {
    $(".hmis-billboard-slider").billboard({
        transition: "fade", 
        navType: "list",
        stretch: true,
        ease: "easeInOutExpo", 
        speed: 2000,
        //includeFooter: false,
        resize: true 
    });
});