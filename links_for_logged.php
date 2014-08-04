<?php
/*
Plugin Name: Links For Logged
Plugin URL: https://github.com/sugardrunk/WP-Links-For-Logged-Plugin/
Description: Add a link for logged users to a text widget via shortcode.
Version: 0.1
Author: Janne Kähkönen
Author URI: http://koti.tamk.fi/~c1jkahko/
Text Domain: links-for-logged
License: GPL2

Copyright 2014  Janne Kähkönen  (email : jannekahkonen@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
class WordPressLinksForLoggedPlugin
{
    /** 
     * The constructor.
     *
     */
    function __construct()
    {
        add_shortcode('link_for_logged', array($this, 'show_links_for_logged'));
        add_filter('widget_text', 'do_shortcode');
    }

    /** 
     * Show the links for the logged users.
     * 
     * @param array $params The shorcode parameters.
     *
     * @return string
     *
     */
    function show_links_for_logged($params)
    {   
        $default_title = __('Untitled', 'links-for-logged');

        $a = shortcode_atts(
                 array(
                     'page'  => '',
                     'url'   => '',
                     'title' =>  $default_title,
                     'size'  => 'p'
                 ), $params
             );

        if (is_user_logged_in())
        {
            if ($a['page'] !== '')
            {
                $page = get_page_by_title(strtolower($a['page']));

                if (is_null($page))
                {
                    return __('INCORRECT PAGE TITLE!', 'links-for-logged');
                }
                else if (!is_null($page))
                {   
                    $permalink = get_permalink($page->ID);

                    return '<' . $a['size'] . '><a href="' . $permalink .
                           '">' . $a['title'] .
                           '</a></' . $a['size'] . '>';
                }
            }
            else if ($a['url'] !== '')
            {
                return '<' . $a['size'] . '><a href="' . $a['url'] .
                       '">' . $a['title'] .
                       '</a></' . $a['size'] . '>';
            }
        }
    }
}
new WordPressLinksForLoggedPlugin();

?>