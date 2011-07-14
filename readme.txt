=== Plugin Name ===
Contributors: fcc, benbalter
Donate link: 
Tags: counting, statistics, shortcode, data, queries, links
Requires at least: 3.2
Tested up to: 3.2
Stable tag: 1.0

Shortcode to count number of posts that match a given set of criteria; provides link to query to display list of matching posts

== Description ==

Shortcode to count number of posts that match a given set of criteria; provides link to query to display list of matching posts.

Works with both built in post types (pages, posts) and taxonomies (tags, categories), as well as custom post types and custom taxonomies.

**Example**

You have a car custom post type and would like a count of all the red cars in your inventory, as well as a link to a listing of those cars.

Red Cars in Inventory: [count color=red]

Would return the number of cars, as well as a link to yoursite.com/?color=red (which may rewrite depending on your permalink structure)

**Usage**

Insert a shortcode in your post in the form of [count {taxonomy}={value}]. You can add as many or as fiew taxonomies as you would like.

You can also use the post_type argument to specify a post type (page, post, car, etc.)

== Installation ==

1. Install the plugin as you would any other plugin

= 1.0 =
* Initial Release
