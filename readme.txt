=== Plugin Name ===

Contributors:      Beer
Plugin Name:       IPB Comments for WordPress
Plugin URI:        http://wordpress.org/extend/plugins/ipb-comments-for-wordpress/
Tags:              ipb, comments, ip.board, invision, forum, crosspost
Author URI:        http://wordpress.org/extend/plugins/profile/beer
Author:            Beer
Donate link:       http://bit.ly/hYv2Ly
Requires at least: 3.0
Tested up to:      3.1.1
Stable tag:        1.2.6
Version:           1.2.6

Use IP.Board to manage your comments.

== Description ==

IP.Board Comments for WordPress allows you to use IPB (IP.Board or Invision Power Board) to replace or enhance your WordPress comments. When a new WordPress post is created in a mapped category, it will cross-post to your IPB forum with a link back to the WordPress post. The IPB forum link is saved in a custom field and will appear in the footer of your post.

You may find it much easier to manage comments and users on the forum, rather than using the minimal WordPress comment system.

Your IPB installation must reside on the same server as your WordPress installation.

Requires at least: IP.Board 3.0 and PHP 5.2.6

== Installation ==

I would recommend installing the plugin from your WP Plugins menu.  Do a search for "ipb" and it should come up.  You can update easier in the future this way.  If you prefer to install it manually, see the comments below.

1. Upload all files into the `/wp-content/plugins/ipb-comments-for-wordpress` directory
2. Activate the plugin through the Plugins menu in WordPress
3. Open Settings / IPB Comments submenu and add or edit the settings.

You will need to edit the Base Url, Base Path, Member ID, and enter the IPB category # that corresponds to at least one WordPress category.  The Base Url should lead to your forum's main front page.  The Base Path should be the server path to the same location for your IPB root files.  This will be the directory path to the directory where the initdata.php file is located.  The Member ID should be a valid member ID from your IPB forum, with access to post HTML and access to post in the categories.  Usually, you can enter 1 and it will post as your default admin user.  Create any WordPress categories you need for the blog, and return to the IPB Comments submenu if needed.  You'll notice a list of each WordPress category printed to the right of some empty input blocks.  Enter the IPB category where you wish the new topics to be entered, whenever a WordPress post is made in the WP category shown directly to the right.

== Screenshots ==

1. Screenshot of the IPB Comments menu
2. Creating a new post in WordPress
3. The new post created in WordPress
4. The new topic created in the IP.Board forum category

== Changelog ==

= 1.2.5 =
* fixed an ipb redirect issue

= 1.2.4 =
* fixed an ipb url issue when furl is not active

= 1.2.3 =
* removed the friendly url requirement

= 1.2.2 =
* readme.txt update, still learning SVN

= 1.2 =
* Added support for IP.Board Topic replies to show as WP post comments
* Added post styling to plugin stylesheet

= 1.1.4 =
* Removed excess debug statements left in from testing

= 1.1.3 =
* Improved the topic creation url
* Fixed a critical bug introduced in 1.1 that failed to get the category ID

= 1.1.2 =
* Separate stylesheet ipb-comments-for-wordpress.css

= 1.1 =
* Added screenshots
* Fixed readme.txt

= 1.0 =
* First release

== Frequently Asked Questions ==

See Other Notes for the To do list.

== Other Notes ==

= Donations =
Donations are accepted.
<http://bit.ly/hYv2Ly>

= To Do =
* move ttl to main settings 
* move last replies to main settings
* strip the session id from forum topic url that sometimes gets displayed
* allow to configure most recent X forum replies to show on WordPress post comments
* add ability to override/select a specific IPB category per post (Dashboard / New Post)
* add ability to map specific WP Author/Editor/Admin users to IPB users (Dashboard / Users)
* add ability to work with an IPB forum on a different server than WordPress install
* add ability to cross-post old WP posts to forum
* add a post template to be parsed when cross-posting (title, date, excerpt, slug, content)
* buy more beer

= Thanks =
* Martin A. from IPB forums for vital IPB assistance
* Christophe from IPB forums for valuable feedback and suggestions
