<?php
/*
Plugin Name: IP.Board Comments
Plugin URI: http://wordpress.org/extend/plugins/ipb-comments-for-wordpress/
Description: Use IP.Board for your comments.  When a new post is published, it creates a new topic with your IP.Board and adds the link to the new topic at the end of your post.
Version: 1.2.6
Author: Beer
Author URI: http://wordpress.org/extend/plugins/profile/beer
Donate Link: http://bit.ly/hYv2Ly
Disclaimer: No warranty is provided. IP.Board 3.0, PHP 5.2 are required.
Requires at least: 3.0
Tested up to: 3.1.1
*/

require 'class.ipbcomments.php';
add_action('init',create_function('', 'new WP_IPBComments();'));
