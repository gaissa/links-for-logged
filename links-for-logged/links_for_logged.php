<?php
/*
Plugin Name: Links For Logged
Plugin URL: 
Description: Add a link for logged users to a text widget via shortcode.
Version: 0.1
Author: Janne Kähkönen
Author URI: 
Contributors:
*/

/*
Usage:
    [link_for_logged page="<page>" title="<title>"]
    [link_for_logged url="<url>" title="<title>"]
*/

// Tell WP to register the shortcode to the widgets.
add_filter('widget_text', 'do_shortcode');

// Show or hide the links.
function lfl_show_links_to_logged($atts)
{
    // Get WP installation folder.
    $WP_PATH = implode("/", (explode("/", $_SERVER["PHP_SELF"], -1)));

    $a = shortcode_atts(
         array(
               'page'  => '',
               'url'   => '',
               'title' => 'Untitled'
    ), $atts );

    // If any user is logged in.
    if (is_user_logged_in())
    {
        // Return WP page.
        if ($a['page'] !== "")
        {
            return "<h4 align='center'><a href='" . $WP_PATH .
                   "/" . $a['page'] . "'>" . $a['title'] .
                   "</a></h4>";
        }
        // Return external URL.
        else if ($a['url'] !== "")
        {
            return "<h4 align='center'><a href='" . $a['url'] .
                   "'>" . $a['title'] . "</a></h4>";
        }
    }
    else
    {
        // Unregister widget(s).
        function lfl_unregister_default_widgets()
        {
            unregister_widget('WP_Widget_Text');
        }

        // Return nothing, remove widget(s).
        add_action('widgets_init', 'lfl_unregister_default_widgets', 0);
    }
}

// Add the shortcode.
add_shortcode('link_for_logged', 'lfl_show_links_to_logged');

?>