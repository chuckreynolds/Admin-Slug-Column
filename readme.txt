=== Admin Slug Column ===
Contributors: ryno267
Donate link: https://buymeacoffee.com/chuck
Tags: slug, admin columns, permalink, url path, page titles
Requires at least: 5.2
Tested up to: 6.9.1
Stable tag: 2.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds a URL path column to all admin post type edit screens. Works with posts, pages, and any custom post type including WooCommerce products.

== Description ==
This plugin adds a URL path column to the edit screens for all post types — posts, pages, and any custom post type including WooCommerce products. Child pages show the full nested path. For drafts, pending, and scheduled content the URL path is shown slightly greyed out since it isn't an official URL yet. Multibyte characters in slugs (non-latin languages) are fully supported.

I initially built this out of necessity to quickly identify pages by their slug/path as sometimes the titles that clients used did't match up nicely with the URL slug on the front-end of the site; so here's a fast way to do that. Nothing fancy, just does what it does.

Do you have a feature you'd like or a bug you've found? Feel free to [make an issue on the github repo](https://github.com/chuckreynolds/Admin-Slug-Column/issues).

== Installation ==
1. Upload the `admin-slug-column` directory to the `/wp-content/plugins/` directory
1. Activate the Admin Slug Column plugin through the 'Plugins' menu in WordPress
1. Go to Posts or Pages and see the column showing your slug
1. Choose to hide/show the slug column in "Screen Options" tab up top

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==
= 2.0.0 =

Release Date - 2026-03-09

* [breaking] PHP requirement bumped to 8.0
* [refactor] Full OOP refactor — dynamic hooks based on current screen post type
* [refactor] Column now inserts after "Title" instead of appending to end
* [refactor] Split display logic into private methods for draft and published posts
* [security] Proper output escaping on all column output paths
* [fix] Draft slug now correctly resolves placeholder for any CPT rewrite tag, not just %postname%/%pagename%
* [fix] Added WP_Post instanceof check and permalink string check before output
* Confirmed working with custom post types and WooCommerce products
* Tested up to WordPress 6.9.1

= 1.6.1 =

Release Date - 2024-09-19

* tested to 6.6.x https://github.com/chuckreynolds/Admin-Slug-Column/issues/17

= 1.6.0 =

Release Date - 2022-05-21

* tested on 6.0-RC4
* [feature] Multibyte characters are now supported
* [feature] Now on draft, pending, or scheduled posts/pages instead of the ?page_id= showing we display the URL path.
* [fix] Made sure child pages displayed the URL path correctly in all instances
* [411] Regarding the version bump from 0.5 to 1.6. The plugin's been in production forever, I always joked that nothing is every fully not-beta but that joke isn't always appreciated SO... it's a v1 release and .6 major change since inception. It's only coincidence that 1.6.0 matches with WordPress 6.0 release (didn't plan that).

= 0.5.0 =

Release Date - 2019-06-15

* [fix] pages now show the full URL path now after the domain.tld, posts still just the slug
* tested on 5.2.2

= 0.4.0 =

Release Date - 2018-10-26

* [fix]     a sorting issue (sadly doesn't work with parent slug feature (below))
* [feature] pages now have a root slash and will show the /parent/child slug now
* added plugin banner and icon for WordPress repo
* tested to 5.0-beta

= 0.3.1 =

Release Date - 2017-11-14

* tested to 4.9

= 0.3.0 =

Release Date - 2017-06-14

* tested to 4.8.x
* [feature]  makes the slug column sortable in posts/pages screens
* [fix]      swapped out deprecated wp function get_page
* [security] escape output
* [security] only load in admin

= 0.2.2 =

Release Date - 2015-04-27

* wp code formatting
* tested to 4.2

= 0.2.1 =

Release Date - 2014-09-04

* basic cleanup
* tested to 4.0

= 0.2 =

Release Date - 2013-05-07

* make oop and class

= 0.1 =
* Initial version to github; rough; makes slug columns yay
