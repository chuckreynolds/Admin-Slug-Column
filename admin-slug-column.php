<?php
/**
 * @link         https://chuckreynolds.com
 * @since        0.3.0
 * @package      Admin_Slug_Column
 *
 * Plugin Name:  Admin Slug Column
 * Plugin URI:   https://wordpress.org/plugins/admin-slug-column/
 * Description:  Adds the post url slug and page url path to the admin columns on edit screens.
 * Version:      0.5.0
 * Author:       Chuck Reynolds
 * Author URI:   https://chuckreynolds.com
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:  admin-slug-column
 */

// If this file is called directly, abort
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Only run plugin in the admin
if ( ! is_admin() ) {
	return false;
}

Class WPAdminSlugColumn {

	/**
	* Constructor for WPAdminSlugColumn Class
	*/
	public function __construct() {
		add_action( 'current_screen',                    array( $this, 'WPASC_post_type' ) );
		add_filter( 'manage_posts_columns',              array( $this, 'WPASC_posts' ) );
		add_action( 'manage_posts_custom_column',        array( $this, 'WPASC_posts_data' ), 10, 2 );
		add_filter( 'manage_pages_columns',              array( $this, 'WPASC_posts' ) );
		add_action( 'manage_pages_custom_column',        array( $this, 'WPASC_posts_data' ), 10, 2 );
	}

	/**
	 * Returns an object that includes the current screen's post type
	 *
	 * @see https://developer.wordpress.org/reference/functions/get_current_screen/
	 */
	public function WPASC_post_type() {
		return get_current_screen()->post_type;
	}

	/**
	 * Adds Slug column to Posts list column
	 *
	 * @param array $defaults An array of column names
	 */
	public function WPASC_posts( $defaults ) {
		$defaults['wpasc-slug'] = __( 'URL Path', 'admin-slug-column' );
		return $defaults;
	}

	/**
	 * Gets the post info from get_post function and displays the slug and/or path
	 *
	 * @param string $column_name Name of the column
	 * @param int    $id          post id
	 *
	 * @see https://developer.wordpress.org/reference/functions/get_post/
	 */
	public function WPASC_posts_data( $column_name, $id ) {
		if ( $column_name == 'wpasc-slug' ) {
			$post_info   = get_post( $id, 'string', 'display' );
			$post_slug   = $post_info->post_name;
			$post_type   = $post_info->post_type;
			$post_status = $post_info->post_status;

			if ( $post_type === 'page' ) {
				// Get full permalink but remove domain.tld
				$post_slug = str_replace( home_url(), '', get_permalink( $id ) );
			}

			if ( $post_type === 'post' ) {
				// Add root & trailing slash to slug only for published or scheduled pages; ignore drafts
				if ( $post_status === 'publish' || $post_status === 'future' ) {
					$post_slug = '/' . $post_slug . '/';
				}
			}

			// Echo out what we've got
			echo esc_attr( $post_slug );
		}
	}

}

$WPAdminSlugColumn = new WPAdminSlugColumn();
