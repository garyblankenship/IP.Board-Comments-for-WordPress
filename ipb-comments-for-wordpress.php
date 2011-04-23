<?php
/*
Plugin Name: IP.Board Comments
Plugin URI: http://wordpress.org/extend/plugins/ipb-comments-for-wordpress/
Description: Uses IP.Board for your comments.  When a new post is published, it creates a new topic with your IP.Board and adds the link to the new topic at the end of your post.
Version: 1.1.2
Author: Beer
Author URI: http://wordpress.org/extend/plugins/profile/beer
License: GPLv3
Donate Link: https://github.com/darkness
Disclaimer: No warranty is provided. IP.Board 3.0, PHP 5.2 are required.
Requires at least: 3.0
Tested up to: 3.1.1
*/

// ========================================
// == IPB COMMENTS ========================
// ========================================

/**
 * IP.Board Comments for WordPress
 * Using IP.Board for WordPress comments, and forum cross-posting.
 *
 * See Github for more information and installation details
 * https://github.com/darkness/IP.Board-Comments-for-WordPress
 */

class WP_IPB {


	function add_topic ( $post_ID ) {

		$options = get_option('ipb_comments_options');

		/**
		 * checking for required option values before continuing
		 */
		if ( ! isset($options['ipb_field_path']) OR ! file_exists($options['ipb_field_path']) ) {
			// the required path to the initdata.php folder is missing
			// wp_die( __( 'Missing ipb_field_path.' ) );
			return FALSE;
		}

		if ( ! isset($options['ipb_field_member_id']) ) {
			// the required member id to post from is missing
			// wp_die( __( 'Missing ipb_field_member_id.' ) );
			return FALSE;
		}

		foreach ( get_the_category($wp->ID) as $cat ) {
			if ( ! empty($options['categories'][$cat->slug]) ) {
				$forumID = intval($options['categories'][$cat->slug]);
				break;
			}
		}

		// we haven't found a matching category, do nothing
		if ( ! isset($forumID) ) return FALSE;

		// http://codex.wordpress.org/Function_Reference/get_post
		$wp = get_post($post_ID);

		// http://community.invisionpower.com/resources/documentation/index.html/_/developer-resources/custom-applications/
		// http://community.invisionpower.com/resources/doxygen/annotated.html
		require_once($options['ipb_field_path'].'/initdata.php');

		require_once(IPS_ROOT_PATH.'sources/base/ipsController.php');
		require_once(IPS_ROOT_PATH.'sources/base/ipsRegistry.php');

		$registry = ipsRegistry::instance();
		$registry->init();

		require_once(IPSLib::getAppDir('forums').'/sources/classes/post/classPost.php');
		$postClass = new classPost($registry);

		$postClass->setForumID($forumID);
		$postClass->setForumData($registry->class_forums->allForums[$forumID]);

		$postClass->setAuthor($options['ipb_field_member_id']);
		$postClass->setTopicTitle($wp->post_title);

		// option to use excerpt or content
		$content = nl2br($wp->post_content)
			.'<br><br><a href="'.get_permalink($wp->ID).'">Read the full story here</a></p>';

		$postClass->setPostContentPreFormatted( $content );

		$postClass->setIsPreview(false);
		$postClass->setTopicState('open');
		$postClass->setPublished(true);

		try {

			if ( $postClass->addTopic() ) {
				$topicData = $postClass->getTopicData();
				// add custom fields to our post
				$topicUrl = sprintf("%s/topic/%s-%s",
					$options['ipb_field_url'], $topicData['tid'], $topicData['title_seo']);
				update_post_meta($wp->ID, 'forum_topic_url', htmlentities($topicUrl));
			} else {
				// var_dump($postClass->_postErrors);
				// var_dump($content);
			}
		}
		catch (Exception $error) {
			print $error->getMessage();
		}

	 }

}

// below triggers the cross-posting on update too, leave commented except while testing
// add_action('publish_post', array('WP_IPB', 'add_topic'));

// use post publish status transitions to ensure this only posts in case of a new file
// and not whenever a post is edited or updated
add_action('new_to_publish', array('WP_IPB', 'add_topic'));
add_action('future_to_publish', array('WP_IPB', 'add_topic'));
add_action('draft_to_publish', array('WP_IPB', 'add_topic'));


// ========================================
// == IPB ADMIN MENU ======================
// ========================================

/**
 * Dashboard Admin Menu for IPB Comments
 * Settings > IPB Comments
 * 
 * Settings API
 * http://codex.wordpress.org/Settings_API
 * http://ottopress.com/2009/wordpress-settings-api-tutorial/
 */

/**
 * Create the IPB Comments menu under Dashboard Settings
 * http://codex.wordpress.org/Function_Reference/add_options_page
 */
add_action('admin_menu', 'ipb_comments_menu');

function ipb_comments_menu() {
	add_options_page( 'IPB Comments Options',   // page title tag
		'IPB Comments',                         // menu text
		'manage_options',                       // capability required to use this menu option
		'ipb-comments',                         // slug to refer to this menu item
		'ipb_comments_options_page'             // optional callback function
		);
}

/**
 * Callback function to display main options page
 */
function ipb_comments_options_page() {

	if ( ! current_user_can('manage_options') ) {
		wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	?>
	<div class="wrap" >
	<h2>IPB Comments</h2>
	<form method="post" action="options.php">
	<?php settings_fields('ipb_comments_options'); ?>
	<?php do_settings_sections('ipb_comments'); ?>
	<p><input name="Submit" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" /></p>
	</form>
	</div>
	<?php
}


/**
 * Settings init for Admin IPB Comments Page
 */
add_action('admin_init', 'ipb_comments_admin_init');

function ipb_comments_admin_init() {

	wp_enqueue_style('ipb_comments_style', plugins_url( 'ipb-comments-for-wordpress.css' , __FILE__ ) );

	// Create the IPB Main Settings section
	// http://codex.wordpress.org/Function_Reference/add_settings_section
	add_settings_section( 'ipb_section_main',       // string used for 'id' attribute
		'Main Forum Settings',                        // title of the section
		'ipb_section_main',                         // callback function
		'ipb_comments'                              // settings page type (general, reading, media, etc..)
		);
	add_settings_field( 'ipb_field_member_id',      // string used for 'id' attribute
		'IPB Member ID',                            // title of the field
		'ipb_setting_member_id',                    // callback function
		'ipb_comments'                              // settings page type
		);
	add_settings_field('ipb_field_path', 'IPB Base Path', 'ipb_setting_path', 'ipb_comments');
	add_settings_field('ipb_field_url', 'IPB Base Url', 'ipb_setting_url', 'ipb_comments');

	// Create the IPB Category Settings section
	add_settings_section('ipb_section_categories', 'Category Settings', 'ipb_section_categories', 'ipb_comments');
	add_settings_field('ipb_field_categories', 'IPB Category Options', 'ipb_setting_categories', 'ipb_comments');

	// Register the settings
	register_setting( 'ipb_comments_options',       // option group
		'ipb_comments_options'                      // option name
		);
}

/**
 * Main Settings callback function
 */
function ipb_section_main() { 
	// http://codex.wordpress.org/Function_Reference/get_option
	$options = get_option('ipb_comments_options');
	?>
	<ul class="forum_settings">
		<li>
		<label for="base_url">Base Url:</label>
		<input type="text" size="50" name="ipb_comments_options[ipb_field_url]" 
			value="<?php echo $options['ipb_field_url']; ?>" />
			<em>base url to your forum. ex. http://yourforum.com</em>
		</li>

		<li>
		<label for="base_path">Base Path:</label>
		<input type="text" size="50" name="ipb_comments_options[ipb_field_path]" 
			value="<?php echo $options['ipb_field_path']; ?>" />
			<em>full path to your forum where initdata.php is located. ex. /var/www/forum</em>
		</li>

		<li>
		<label for="member_id">Member ID:</label>
		<input type="text" size="5" name="ipb_comments_options[ipb_field_member_id]" 
			value="<?php echo $options['ipb_field_member_id']; ?>" />
			<em>forum member ID who will create the new topics. ex. 1</em>
		</li>
	</ul>
	<br style="clear:both;" />
<?php
}

/**
 * Category Settings callback function
 */
function ipb_section_categories() { 
	$options = get_option('ipb_comments_options');
	?>
	<p>To the left of each WordPress category below, enter the IPB forum # to use when making a new topic.</p>
	<ul class="category_settings">
	<?php
	// http://codex.wordpress.org/Function_Reference/get_categories
	$categories = get_categories(array('hide_empty'=>0));

	foreach( $categories as $cat ) {
		echo sprintf('<li><input type="text" size="2" name="ipb_comments_options[categories][%s]" value="%s" />%s</li>',
			$cat->slug,
			$options[categories][$cat->slug],
			$cat->name);
	}
	?>
	</ul>
<?php
}



// ========================================
// == IPB TOPIC VIEW ======================
// ========================================

/**
 * add topic url to end of post
 */
add_filter('the_content', 'ipb_add_topic_url');

function ipb_add_topic_url ( $content ) {
	$meta = get_post_custom_values('forum_topic_url');

	if ( empty($meta) ) return $content;

	$url = sprintf('<p class="discussion"><a href="%s">Follow the Discussion in Progress</a></p>', current($meta));
	return $content.$url;
}

