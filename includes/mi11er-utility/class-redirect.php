<?php
/**
 * Redirect OLD URLs for a particular post.
 *
 * @package Mi11er\Utility
 */

namespace Mi11er\Utility;

use Mi11er\Utility\Template_Tags as TT;

/**
 * This class provides looking up old URLs and redirecting requests for those
 * URLs to the current URL for the associated post.
 *
 * @todo get settings from DB in addtion to using filters.
 * @todo allow deletion
 */
class Redirect extends Plugin_Abstract
{
	const META_FIELD  = '_mu_old_url_redirect';
	const META_BOX    = 'mu-old-url-redirect';
	const CACHE_GROUP = 'mu-old-url-redirect';


	/**
	 * Run whatever is needed for plugin setup
	 */
	public function setup() {
		if ( is_admin() ) {
			// Admin Actions.
			add_action( 'add_meta_boxes',        [ $this, 'add_meta_boxes_action' ],     10, 2 );
		}

		// Actions.
		add_action( 'template_redirect', [ $this, 'template_redirect_action' ], 0, 0 );
	}


	/**
	 * ================Actions
	 */

	/**
	 * Add the OLD URL Meta Box to all post types.
	 *
	 * @param string  $post_type Post type.
	 * @param WP_Post $post      Post object.
	 */
	function add_meta_boxes_action( $post_type, $post ) {
		if ( ! empty( get_post_meta( $post->ID, self::META_FIELD, false ) ) ) {
			add_meta_box(
				self::META_BOX,
				__( 'Old URL Redirect', 'mi11er-utility' ),
				[ $this, 'old_url_redirect_meta_box' ],
				$post_type
			);
		}
	}

	/**
	 * Call back for the template_redirect action hook.
	 * Needs to run early to prevent Wordpresses URL guessing on mangled URLs
	 *
	 * Determine the orginally requested uri
	 * Determine if a new URI exists
	 * Redirect to the new URI
	 */
	public function template_redirect_action() {
		global $wpdb;

		if ( ! is_404() ) {
			return;
		}

		$request_url = TT::get_the_request_url();
		if ( null === $request_url ) {
			return;
		}

		$request_path = trim( $request_url['path'], '/' ); // Remove leading and trailing slashes.

		$cache_key = md5( $request_path );
		if ( false === $link = wp_cache_get( $cache_key, self::CACHE_GROUP ) ) {
			$id = (int) $wpdb->get_var( $wpdb->prepare(
				"
					SELECT post_id
					FROM $wpdb->postmeta
					WHERE ( meta_key = %s )
					  AND ( meta_value = %s )
				"
				,self::META_FIELD
				,$request_path
			)); // WPCS: db call ok.

			if ( $id ) {
				$link = get_permalink( $id );
			}
			wp_cache_set( $cache_key, $link, self::CACHE_GROUP, 5 * MINUTE_IN_SECONDS );
		}

		if ( ! $link ) {
			return;
		}

		// Add back original query string.
		if ( array_key_exists( 'query', $request_url ) ) {
			parse_str( $request_url['query'], $request_query );
			$link = add_query_arg( $request_query, $link );
		}

		wp_redirect( $link, 301 );
		exit;
	}

	/**
	 * ================Misc
	 */

	/**
	 * Display the Old URL Redirect Meta Box
	 *
	 * @todo allow update?
	 *
	 * @param \WP_Post $post The post we're working on.
	 */
	public function old_url_redirect_meta_box( $post ) {
		?>
		<ul>
			<?php foreach ( get_post_meta( $post->ID, self::META_FIELD, false ) as $value ) : ?>
				<li><?php echo esc_html( $value ); ?></li>
			<?php endforeach; ?>
		</ul>
		<?php
	}
}

