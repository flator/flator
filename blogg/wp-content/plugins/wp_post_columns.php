<?php
/*
Plugin Name: WP Post Columns
Plugin URI: http://www.samburdge.co.uk/plugins/wp-post-columns-plugin
Description: Allows you to easily create columns within your posts for a magazine / newspaper style layout.
Version: 1.2
Author: Sam Burdge
Author URI: http://www.samburdge.co.uk
*/

/* UPDATES

24/4/2008
added extra preg_replace code to remove implicit <p> tags inserted by wordpress

27/4/2008
added priority of 13 to add_filter to make compatible with 2.5.1 - preg_replace is called after shortcodes have been processed (priority 11)

*/

function wp_post_columns($post_column_content) {

//Set up your columns width and right padding (px, %, em, etc)

$column1width = '45%';
$column1paddingright = '0em';

$column2width = '45%';
$column2paddingright = '0px';

//End of setup


$column_1 = '<div style="width:'.$column1width.'; float: left; padding-right: '.$column1paddingright.'; display: inline;" class="post_column_left">';
$end_column_1 = '</div>';

$column_2 = '<div style="width:'.$column2width.'; float: right; padding-right: '.$column2paddingright.';">';
$end_column_2 = '</div><div style="clear: both;"></div>';

$post_column_content = preg_replace('/{column1}/',$column_1, $post_column_content);

$post_column_content = preg_replace('/{\/column1}/',$end_column_1, $post_column_content);

$post_column_content = preg_replace('/{column2}/',$column_2, $post_column_content);

$post_column_content = preg_replace('/{\/column2}/',$end_column_2, $post_column_content);

$post_column_content = preg_replace('/<p><div/','<div', $post_column_content);
$post_column_content = preg_replace('/div><\/p>/','div>', $post_column_content);
$post_column_content = preg_replace('/<p><\/div>/','</div>', $post_column_content);

echo $post_column_content;
}

add_filter('the_content', 'wp_post_columns',13);

?>