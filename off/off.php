<?php
/*
Plugin Name: Off
Plugin URL: 
Description:
Version: 0.0.1
Author: 
Author URI: 
Contributors:
*/

function redirect()
{
    // static page home
    if(is_front_page()) {
        //header( 'Location:  http://localhost/likioma01/events/' ) ;
    }
    if(is_home()) {
    }
}

add_action('wp_head', 'redirect');