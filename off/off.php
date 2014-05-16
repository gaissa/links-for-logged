<?php
/*
Plugin Name: Off
Plugin URL:
Description:
Version: 0.1
Author:
Author URI:
Contributors:
*/

function redirect()
{
    // static page home
    if(is_front_page()) {
        //header('Location: <URL>') ;
    }
    if(is_home()) {
    }
}

add_action('wp_head', 'redirect');