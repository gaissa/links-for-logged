<?php
/*
Plugin Name: Links For Logged
Plugin URI: https://github.com/sugardrunk/WP-Links-For-Logged-Plugin/
Description: Add a link for logged users to a text widget via shortcode.
Version: 0.1
Author: Janne Kähkönen
Author URI: https://github.com/gaissa
Text Domain: links-for-logged
License: GPLv2 or later
*/

/*
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
        add_shortcode('link', array($this, 'show_links_for_logged'));
        add_filter('widget_text', 'do_shortcode');
    }

    /** 
     * Show the link for post or a page.
     * 
     * @param string $type Type of the request.
     * @param array $a The shortcode parameters.
     *
     * @return string
     *
     */
    function show_page_or_post($type, $a)
    {
        if ($a[$type] !== '')
        {
            $page = get_page_by_title($a[$type], OBJECT, $type);

            if (is_null($page))
            {
                return '<' . $a['size'] . '>' .
                       __('incorrect title!', 'links-for-logged') .
                       '</' . $a['size'] . '>';
            }
            else
            {
                return '<' . $a['size'] . '><a href="' . 
                       get_permalink($page->ID) .
                       '">' . $a['title'] .
                       '</a></' . $a['size'] . '>';
            }
        }
    }

    /** 
     * Show the link for URL.
     * 
     * @param array $a The shortcode parameters.
     *
     * @return string
     *
     */
    function show_url($a)
    {
        if (filter_var($a['url'], FILTER_VALIDATE_URL))
        {
            return '<' . $a['size'] . '>' .
                   __('incorrect url!', 'links-for-logged') .
                   '</' . $a['size'] . '>';
        }
        else
        {
            return '<' . $a['size'] . '><a href="' . $a['url'] .
                   '">' . $a['title'] .
                   '</a></' . $a['size'] . '>';
        }
    }

    /** 
     * Show the links for the logged in users.
     * 
     * @param array $params The shorcode parameters.
     *
     * @return string
     *
     */
    function show_links_for_logged($params)
    {
        if (is_user_logged_in())
        {   
            $a = shortcode_atts(
                     array(
                         'page'  => '',
                         'post'  => '',
                         'url'   => '',
                         'title' =>  __('Untitled', 'links-for-logged'),
                         'size'  => 'p'
                     ), $params
                 );

            if ($a['page'] !== '')
            {
                echo $this->show_page_or_post('page', $a);
            }

            else if ($a['post'] !== '')
            {
                 echo $this->show_page_or_post('post', $a);
            }

            else if ($a['url'] !== '')
            {
                echo $this->show_url($a);
            }
        }
    }
}
new WordPressLinksForLoggedPlugin();

?>
