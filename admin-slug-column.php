<?php
/**
 * @link         https://chuckreynolds.us
 * @since        0.3.0
 * @package      Admin_Slug_Column
 *
 * Plugin Name:  Admin Slug Column
 * Plugin URI:   http://wordpress.org/plugins/admin-slug-column/
 * Description:  Adds the post/page url slug in the admin columns of the edit screens.
 * Version:      0.3.0
 * Author:       Chuck Reynolds
 * Author URI:   https://chuckreynolds.us
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:  admin-slug-column
 */

// If this file is called directly, abort.
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
		add_filter( 'manage_edit-post_sortable_columns', array( $this, 'WPASC_sort_posts' ) );
		add_filter( 'manage_edit-page_sortable_columns', array( $this, 'WPASC_sort_posts' ) );
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
	 * Adds Slug column to Posts/Pages list column
	 *
	 * @param array $defaults An array of column names.
	 */
	public function WPASC_posts( $defaults ) {
		$defaults['asc_slug'] = __( 'Slug', 'admin-slug-column' );
		return $defaults;
	}

	/**
	 * Gets the post name from
	 *
	 * @param string $column_name Name of the column
	 * @param int    $id          post id
	 *
	 * @see https://developer.wordpress.org/reference/functions/get_post/
	 */
	public function WPASC_posts_data( $column_name, $id ) {
		if ( $column_name == 'asc_slug' ) {
			$post_slug = get_post( $id, 'string', 'display' )->post_name;
			echo esc_attr( $post_slug );
		}
	}

	/**
	 * Adds Slug column to Posts/Pages sortable detection
	 *
	 * @param array $sortable_columns An array of sortable column names.
	 */
	public function WPASC_sort_posts( $sortable_columns ) {
		$sortable_columns[ 'asc_slug' ] = 'asc_slug';
		return $sortable_columns;
	}

}

$WPAdminSlugColumn = new WPAdminSlugColumn();
