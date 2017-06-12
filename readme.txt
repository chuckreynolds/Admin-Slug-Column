=== Admin Slug Column ===
Contributors: ryno267
Donate link: https://cash.me/$chuckreynolds
Tags: slug, admin columns, permalink, url, page titles
Requires at least: 3.5.0
Tested up to: 4.8
Stable tag: 0.3.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Puts the slug of posts and pages into an admin column on all posts/pages screen. It helps when page titles don't explain what the page is or too many are similar.

== Description ==
Simply put, this plugin adds the page and post slug into the admin columns on the All post and All pages view.
I built this quickly out of necessity to help identify pages and posts by their slug as sometimes the titles clients give them don't match up nicely with the url slug; so here's a fast way to do that. Nothing fancy, just does what it does.

== Installation ==
1. Upload the `admin-slug-column` directory to the `/wp-content/plugins/` directory
1. Activate the Admin Slug Column plugin through the 'Plugins' menu in WordPress
1. Go to Posts or Pages and see the column showing your slug
1. Choose to hide/show the slug column in "Screen Options" tab up top

== Frequently Asked Questions ==
= Why build this? =
Built quickly out of necessity to help identify pages and posts by their slug. Sometimes the titles clients have don't always match up nicely with the url slug; so here's a fast way to solve that. Nothing fancy, just does what it does.

== Screenshots ==


== Changelog ==
= 0.3.0 =

Release Date - 2017-06-12

* tested to 4.8x
* [fix] swapped out deprecated wp function get_page
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
