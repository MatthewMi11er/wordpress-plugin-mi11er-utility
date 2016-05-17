<?php
/**
 * Replaces the author slug (user_nicename) with a sanitized version of the user's display name.
 *
 * @see https://wordpress.org/plugins/wp-author-slug/
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

/**
 * The Author_Slug Class
 *
 * This replaces the WP-Author-Slug plugin.
 * WARNING: This will change the permalink for author pages. Also updating a user outside of the admin interface may cause this to break.
 *
 * @TODO refactor using more robust methods.
 */
class Author_Slug implements Plugin_Interface
{
	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup() {
		add_filter( 'pre_user_nicename', [ $this, 'pre_user_nicename_filter' ], 10, 1 );
	}

	/**
	 * Run whatever is needed ofr plugin activation
	 *
	 * Overwrites the users' nicenames with the users' display name.
	 */
	public function activate() {
		$users = get_users(array(
			'blog_id' => '',
			'fields'  => array( 'ID', 'display_name' ),
		) );

		foreach ( $users as $user ) {
			if ( $user->display_name ) {
				wp_update_user( array(
					'ID'            => $user->ID,
					'user_nicename' => sanitize_title( $user->display_name ),
				) );
			}
		}
	}

	/**
	 * Callback for the `pre_user_nicename` filter hook
	 *
	 * Runs on user save or update.
	 *
	 * @param string $user_nicename The user's nicename.
	 *
	 * @return string
	 */
	public function pre_user_nicename_filter( $user_nicename ) {
		return isset( $_REQUEST['display_name'] ) ? sanitize_title( wp_unslash( $_REQUEST['display_name'] ) ) : $user_nicename; // WPCS: input var ok.
	}
}
