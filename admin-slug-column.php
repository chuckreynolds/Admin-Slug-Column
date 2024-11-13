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
 * Description:       Adds the post URL slug and page URL path to the admin columns on edit screens.
 * Version:           1.6.2
 * Requires at least: 5.2
 * Requires PHP:      7.4
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
	return;
}

/**
 * Class WPAdminSlugColumn
 */
class WPAdminSlugColumn {

	/**
	 * Constructor for WPAdminSlugColumn Class
	 */
	public function __construct() {
		add_action( 'current_screen', [ $this, 'init' ] );
	}

	/**
	 * Initialize the plugin
	 *
	 * @param WP_Screen $current_screen The current screen object.
	 */
	public function init( $current_screen ) {
		if ( ! $current_screen->base === 'edit' ) {
			return;
		}

		add_filter( "manage_{$current_screen->post_type}_posts_columns", [ $this, 'add_column' ] );
		add_action( "manage_{$current_screen->post_type}_posts_custom_column", [ $this, 'display_column' ], 10, 2 );
	}

	/**
	 * Adds Slug column to Posts list column
	 *
	 * @param array $columns An array of column names.
	 * @return array Modified array of column names.
	 */
	public function add_column( $columns ) {
		$columns['wpasc-slug'] = __( 'URL Path', 'admin-slug-column' );
		return $columns;
	}

	/**
	 * Displays the slug and/or path in the custom column
	 *
	 * @param string $column_name Name of the column.
	 * @param int    $post_id     Post ID.
	 */
	public function display_column( $column_name, $post_id ) {
		if ( 'wpasc-slug' !== $column_name ) {
			return;
		}

		$post = get_post( $post_id );
		$post_status = $post->post_status;

		if ( in_array( $post_status, [ 'draft', 'pending', 'future' ], true ) ) {
			$this->display_draft_slug( $post_id );
		} else {
			$this->display_published_slug( $post_id );
		}
	}

	/**
	 * Displays the slug for draft, pending, or future posts
	 *
	 * @param int $post_id Post ID.
	 */
	private function display_draft_slug( $post_id ) {
		$post_draft_url_array = get_sample_permalink( $post_id );
		$post_draft_url_pre = str_replace( home_url(), '', $post_draft_url_array[0] );
		$post_slug = str_replace( [ '%pagename%', '%postname%' ], $post_draft_url_array[1], $post_draft_url_pre );
		echo '<span style="color: #999;">' . esc_html( $post_slug ) . '</span>';
	}

	/**
	 * Displays the slug for published posts
	 *
	 * @param int $post_id Post ID.
	 */
	private function display_published_slug( $post_id ) {
		$post_slug = str_replace( home_url(), '', get_permalink( $post_id ) );
		echo esc_html( urldecode( $post_slug ) );
	}
}

new WPAdminSlugColumn();
