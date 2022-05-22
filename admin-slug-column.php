<?php
/**
 * Admin Slug Column
 *
 * @package           Admin_Slug_Column
 * @author            Chuck Reynolds
 * @link              https://chuckreynolds.com
 * @copyright         2013 Rynoweb LLC
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Admin Slug Column
 * Plugin URI:        https://github.com/chuckreynolds/Admin-Slug-Column
 * Description:       Adds the post url slug and page url path to the admin columns on edit screens.
 * Version:           0.6.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Chuck Reynolds
 * Author URI:        https://chuckreynolds.com
 * Text Domain:       admin-slug-column
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
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
		add_action( 'current_screen',             array( $this, 'WPASC_post_type' ) );
		add_filter( 'manage_posts_columns',       array( $this, 'WPASC_posts' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'WPASC_posts_data' ), 10, 2 );
		add_filter( 'manage_pages_columns',       array( $this, 'WPASC_posts' ) );
		add_action( 'manage_pages_custom_column', array( $this, 'WPASC_posts_data' ), 10, 2 );
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
			$post_info        = get_post( $id, 'string', 'display' );
			$post_status      = $post_info->post_status;
			$draft_slug_names = array( '%pagename%', '%postname%' );

			if ( 'draft' === $post_status || 'pending' === $post_status || 'future' === $post_status ) {
				// unpublished status don't technically a slug yet so we have to use another function
				$post_draft_url_array = get_sample_permalink( $id );
				// grab the sample url path from the array and remove host and scheme
				$post_draft_url_pre = str_replace( get_home_url(), '', $post_draft_url_array[0] );
				// swap the draft %pagename% or %postname% holder with the sample permalink
				$post_slug = str_replace( $draft_slug_names, $post_draft_url_array[1], $post_draft_url_pre );
				// fyi: mb decoding is already done for us by the get_sample_permalink() array [1]
				// now that we have the actual url path, because it's a draft lets make it gray
				$post_slug = '<span style="color: #999;">' . $post_slug . '</span>';
			} else {
				// for published and everything else just use the post name and remove host and scheme
				$post_slug = str_replace( get_home_url(), '', get_permalink( $id ) );
				// decode for multibyte character support
				$post_slug = esc_html( urldecode( $post_slug ) );
			}

			// output the slug
			echo $post_slug;
		}
	}

}

$WPAdminSlugColumn = new WPAdminSlugColumn();
