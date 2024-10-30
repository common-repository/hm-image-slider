<?php
/*
Plugin Name: HM image slider
Plugin URI: http://example.com/plugins/hm-image-slider
Description: this is simple image slider
Version: 1.0.3
Author: Hamed Moodi
Author URI: http://ircodex.ir/tutorial/author/4dmin/
License: GPLv2
Text Domain: hm-image-slider
Domain Path: /languages
*/
/*
This plugin is a simple file shoping for Ecommerecing
Copyright (C) 2016  Hamed Moodi

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
Also add information on how to contact you by electronic and paper mail.

If the program is interactive, make it output a short notice like this when it starts in an interactive mode:

Gnomovision version 69, Copyright (C) year name of author
Gnomovision comes with ABSOLUTELY NO WARRANTY; for details
type `show w'.  This is free software, and you are welcome
to redistribute it under certain conditions; type `show c' 
for details.
*/

defined('ABSPATH') || exit;

add_action('plugins_loaded', function(){
    load_plugin_textdomain('hm-image-slider', false, basename(plugin_dir_path(__FILE__)) . '/languages/');
});

define('HMIS_INC', plugin_dir_path(__FILE__) . 'inc/');
define('HMIS_CSS', plugin_dir_url(__FILE__) . 'css/');
define('HMIS_JS', plugin_dir_url(__FILE__) . 'js/');
define('HMIS_IMAGES', plugin_dir_url(__FILE__) . 'images/');

define('HMIS_NO_IMAGE', HMIS_IMAGES . 'no-image.jpg');

global $hmis_slider_default_settings;
$hmis_slider_default_settings = array(
        'speed'         => 600,
        'duration'      => 5000,
        'autoplay'      => true,
        'resize'        => true,
        'stretch'       => true,
        'loop'          => true,
        'autosize'      => true,
        'transition'    => 'fade',
        'navtype'       => 'controls',
        'easing'        => 'easeInOutExpo'
    );

include(HMIS_INC . 'slider-post-type.php');
include(HMIS_INC . 'slider-functions.php');
include(HMIS_INC . 'shortcodes.php');
include(HMIS_INC . 'slider-widget.php');