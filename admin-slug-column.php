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
 * Description:       Adds the URL path to the admin columns on all post type edit screens.
 * Version:           2.0.0
 * Requires at least: 5.2
 * Requires PHP:      8.0
 * Author:            Chuck Reynolds
 * Author URI:        https://chuckreynolds.com
 * Text Domain:       admin-slug-column
 * License:           GPLv2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

// If this file is called directly, abort.
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
	 * @return void
	 */
	public function init( WP_Screen $current_screen ): void {
		if ( 'edit' !== $current_screen->base ) {
			return;
		}

		add_filter( "manage_{$current_screen->post_type}_posts_columns", [ $this, 'add_column' ], 10, 1 );
		add_action( "manage_{$current_screen->post_type}_posts_custom_column", [ $this, 'display_column' ], 10, 2 );
	}

	/**
	 * Adds Slug column to Posts list column
	 *
	 * @param array<string, string> $columns An array of column names.
	 * @return array<string, string> Modified array of column names.
	 */
	public function add_column( array $columns ): array {
		$new_columns = [];
		$insert_after = 'title';

		foreach ( $columns as $key => $value ) {
			$new_columns[ $key ] = $value;
			if ( $key === $insert_after ) {
				$new_columns['wpasc-slug'] = __( 'URL Path', 'admin-slug-column' );
			}
		}

		return $new_columns;
	}

	/**
	 * Displays the slug and/or path in the custom column
	 *
	 * @param string $column_name Name of the column.
	 * @param int    $post_id     Post ID.
	 * @return void
	 */
	public function display_column( string $column_name, int $post_id ): void {
		if ( 'wpasc-slug' !== $column_name ) {
			return;
		}

		$post = get_post( $post_id );
		if ( ! $post instanceof WP_Post ) {
			return;
		}

		if ( in_array( $post->post_status, [ 'draft', 'pending', 'future' ], true ) ) {
			$this->display_draft_slug( $post );
		} else {
			$this->display_published_slug( $post );
		}
	}

	/**
	 * Displays the slug for draft, pending, or future posts
	 *
	 * @param WP_Post $post Post object.
	 * @return void
	 */
	private function display_draft_slug( WP_Post $post ): void {
		$post_draft_url_array = get_sample_permalink( $post );
		if ( ! is_array( $post_draft_url_array ) || count( $post_draft_url_array ) !== 2 ) {
			return;
		}

		$post_draft_url_pre = str_replace( home_url(), '', $post_draft_url_array[0] );
		// urldecode() not needed here; get_sample_permalink()[1] already handles multibyte decoding.
		// preg_replace handles any CPT rewrite tag placeholder, not just %postname%/%pagename%.
		$post_slug = preg_replace( '/%[^%]+%/', $post_draft_url_array[1], $post_draft_url_pre );
		printf(
			'<span style="color: #999;">%s</span>',
			esc_html( $post_slug )
		);
	}

	/**
	 * Displays the slug for published posts
	 *
	 * @param WP_Post $post Post object.
	 * @return void
	 */
	private function display_published_slug( WP_Post $post ): void {
		$permalink = get_permalink( $post );
		if ( ! is_string( $permalink ) ) {
			return;
		}

		$post_slug = str_replace( home_url(), '', $permalink );
		echo esc_html( urldecode( $post_slug ) );
	}
}

// Initialize the plugin
add_action( 'plugins_loaded', function() {
	new WPAdminSlugColumn();
} );

