=== Plugin Name ===

Contributors:      Beer
Plugin Name:       IPB Comments for WordPress
Plugin URI:        http://wordpress.org/extend/plugins/ipb-comments-for-wordpress/
Tags:              invision, ipb, comments, ip.board, forum, crosspost
Author URI:        http://wordpress.org/extend/plugins/profile/beer
Author:            Beer
Donate link:       http://bit.ly/hYv2Ly
Requires at least: 3.0
Tested up to:      3.1.1
Stable tag:        1.1.2
Version:           1.1.2

Use IP.Board to manage your comments.

== Description ==

IP.Board Comments for WordPress allows you to use IPB (IP.Board or Invision Power Board) to replace or enhance your WordPress comments. When a new WordPress post is created in a mapped category, it will cross-post to your IPB forum with a link back to the WordPress post. The IPB forum link is saved in a custom field and will appear in the footer of your post.

You may find it much easier to manage comments and users on the forum, rather than using the minimal WordPress comment system.

Your IPB installation must reside on the same server as your WordPress installation.

Requires at least: IP.Board 3.0 and PHP 5.2

== Installation ==

1. Upload `ipb-comments-for-wordpress.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the Plugins menu in WordPress
3. In the IPB Comments menu, enter the Base Url and Base Path to your forums.
4. Enter the Member ID from your IPB forum to post as.
5. Enter IPB category numbers that match your existing WordPress categories.


== Upgrade Notice ==

Nothing to do.

== Screenshots ==

1. Screenshot of the IPB Comments menu
2. Creating a new post in WordPress
3. The new post created in WordPress
4. The new topic created in the IP.Board forum category

== Changelog ==

= 1.1.2 =
* Separate stylesheet ipb-comments-for-wordpress.css

= 1.1 =
* Added screenshots
* Fixed readme.txt

= 1.0 =
* First release

== Frequently Asked Questions ==

Coming soon.

== Donations ==

Donations are accepted.
<http://bit.ly/hYv2Ly>

== To Do ==

= To Do =
* add ability to display most recent X replies on WordPress post
* add ability to override/select a specific IPB category per post (Dashboard / New Post)
* add ability to map specific WP Author/Editor/Admin users to IPB users (Dashboard / Users)
* add ability to work with an IPB forum on a different server than WordPress install
* add ability to cross-post old WP posts to forum
* add a post template to be parsed when cross-posting (title, date, excerpt, slug, content)
* buy more beer
