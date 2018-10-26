<?php
/**
 * @link         https://chuckreynolds.us
 * @since        0.3.0
 * @package      Admin_Slug_Column
 *
 * Plugin Name:  Admin Slug Column
 * Plugin URI:   http://wordpress.org/plugins/admin-slug-column/
 * Description:  Adds the post/page url slug in the admin columns of the edit screens.
 * Version:      0.4.0
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
		add_action( 'current_screen',                    array( $this, 'WPASC_post_type' ) );
		add_filter( 'manage_posts_columns',              array( $this, 'WPASC_posts' ) );
		add_action( 'manage_posts_custom_column',        array( $this, 'WPASC_posts_data' ), 10, 2 );
		add_filter( 'manage_pages_columns',              array( $this, 'WPASC_posts' ) );
		add_action( 'manage_pages_custom_column',        array( $this, 'WPASC_posts_data' ), 10, 2 );
		add_filter( 'manage_edit-post_sortable_columns', array( $this, 'WPASC_sort_posts' ) );
		add_filter( 'manage_edit-page_sortable_columns', array( $this, 'WPASC_sort_posts' ) );
		add_action( 'pre_get_posts',                     array( $this, 'WPASC_sort_posts_orderby' ) );
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
		$defaults['wpasc-slug'] = __( 'Slug', 'admin-slug-column' );
		return $defaults;
	}

	/**
	 * Gets the post info from get_post function and displays the slug
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
			$post_parent = $post_info->post_parent;
			$post_status = $post_info->post_status;

			// if post-type is page type we're going to do some extra stuff
			if ( $post_type === 'page' ) {

				// add root slash but only for published pages; ignore drafts
				if ( $post_status === 'publish' ) {
					$post_slug = '/' . $post_slug;
				}

				// add the parent slug in there too if this is a child page
				if ( $post_parent > 0 ) {
					$pre_post_slug = get_post_field( 'post_name', $post_parent, 'raw' );
					$post_slug = '/' . $pre_post_slug . $post_slug;
				}

			}

			// if this is the front page then just show root slash
			$frontpage_id = get_option( 'page_on_front' );
			if ( $frontpage_id == $id ) {
				$post_slug = '/';
			}

			echo esc_attr( $post_slug );
		}
	}

	/**
	 * Adds Slug column to Posts/Pages sortable detection
	 *
	 * @param array $sortable_columns An array of sortable column names.
	 */
	public function WPASC_sort_posts( $sortable_columns ) {
		$sortable_columns[ 'wpasc-slug' ] = 'wpasc-slug';
		return $sortable_columns;
	}

	/**
	 * Function to handle the sort ordering conditions
	 *
	 * @param array $query An array of admin url params
	 */
	public function WPASC_sort_posts_orderby( $query ) {
		if ( ! $query->is_main_query() ) {
			return;
		}
		if ( 'wpasc-slug' === $query->get( 'orderby') ) {
			$query->set( 'orderby', 'post_name' );
		}
	}

}

$WPAdminSlugColumn = new WPAdminSlugColumn();
