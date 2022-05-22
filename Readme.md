# Admin Slug Column - a WordPress Plugin

This is the working development repo for the Admin Slug Column WordPress plugin located here: https://wordpress.org/plugins/admin-slug-column/

This plugin adds a column to wp-admin "All Posts" and "All Pages" views displaying the URL path and Slug for each one. This will also show the nested path if a page is a child post of a parent. If a post or page is not published we'll do our best to determine the url path and display that slightly greyed out for quick reference as it's technically not an official URL path or Slug yet. This should also work for custom post types of type page or post, and furthermore this should now, as of v1.6, also display Multibyte characters in slugs for non-latin languages too.

I initially built this out of necessity to quickly identify pages by their slug/path as sometimes the titles that clients used did't match up nicely with the URL slug on the front-end of the site; so here's a fast way to do that. Nothing fancy, just does what it does.

Do you have a feature you'd like or a bug you've found? Feel free to [make an issue](https://github.com/chuckreynolds/Admin-Slug-Column/issues) or see if it already exists.