<?php
/*
  Plugin Name:  Admin Slug Column
  Plugin URI:   http://wordpress.org/extend/plugins/admin-slug-column/
  Description:  put the slug of post and page in the admin columns
  Version:      0.2
  Author:       Chuck Reynolds
  Author URI:   http://chuckreynolds.us
  Text Domain:  admin-slug-column
  License:      GPL v3
  License URI:  http://www.gnu.org/licenses/gpl-3.0.html
*/
/*
  Copyright 2013 WordPress Admin Slug Column plugin (email: chuck@rynoweb.com)

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, version 3 of the License.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see http://www.gnu.org/licenses/gpl-3.0.html
*/

class wpAdminSlugColumn {
  public function __construct() {
    add_filter('manage_posts_columns', array($this, 'SAC_posts') );
    add_action('manage_posts_custom_column', array($this, 'SAC_posts_data'), 10, 2);
    add_filter('manage_pages_columns', array($this, 'SAC_pages') );
    add_action('manage_pages_custom_column', array($this, 'SAC_pages_data'), 10, 2);
  }

  // Add slug to Posts column with option
  public function SAC_posts($defaults) {
    $defaults['SAC_Slug'] = __('Post Slug');
    return $defaults;
  }
  public function SAC_posts_data($column_name, $id) {
    if( $column_name == 'SAC_Slug' ) {
      $post_slug = get_post($ID = $id)->post_name;
      echo $post_slug;
    }
  }

  // Add slug to Pages column with option
  public function SAC_pages($defaults) {
    $defaults['SAC_Slug'] = __('Page Slug');
    return $defaults;
  }
  public function SAC_pages_data($column_name, $id) {
    if( $column_name == 'SAC_Slug' ) {
        $page_slug = get_page($ID = $id)->post_name;
        echo $page_slug;
    }
  }

}
$wpAdminSlugColumn = new wpAdminSlugColumn();