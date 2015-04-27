<?php
/*
Plugin Name:  Admin Slug Column
Plugin URI:   http://wordpress.org/plugins/admin-slug-column/
Description:  put the slug of post and page in the admin columns
Version:      0.2.2
Author:       Chuck Reynolds
Author URI:   https://github.com/chuckreynolds/Admin-Slug-Column/
Text Domain:  admin-slug-column

License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2014 Chuck Reynolds (email : chuck@rynoweb.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

Class WPAdminSlugColumn {

	/**
	* This is the constructor for WPAdminSlugColumn Class
	*
	* @return void
	*/
	public function __construct() {
		add_filter( 'manage_posts_columns', array( $this, 'SAC_posts' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'SAC_posts_data' ), 10, 2);
		add_filter( 'manage_pages_columns', array( $this, 'SAC_pages' ) );
		add_action( 'manage_pages_custom_column', array( $this, 'SAC_pages_data' ), 10, 2);
	}

	/**
	* Adds slug to Posts column with option
	*
	* @return void
	*/
	public function SAC_posts( $defaults ) {
		$defaults['SAC_Slug'] = __( 'Post Slug' );
		return $defaults;
	}

	public function SAC_posts_data( $column_name, $id ) {
		if ( $column_name == 'SAC_Slug' ) {
			$post_slug = get_post( $id )->post_name;
			echo $post_slug;
		}
	}

	/**
	* Adds slug to Pages column with option
	*
	* @return void
	*/
	public function SAC_pages( $defaults ) {
		$defaults['SAC_Slug'] = __( 'Page Slug' );
		return $defaults;
	}

	public function SAC_pages_data( $column_name, $id ) {
		if ( $column_name == 'SAC_Slug' ) {
			$page_slug = get_page( $id )->post_name;
			echo $page_slug;
		}
	}

}

$WPAdminSlugColumn = new WPAdminSlugColumn();
