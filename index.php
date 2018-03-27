<?php
/*
Plugin Name: Email Inliner
Description: Adds a box to posts. When published the set inliner url will return inlined and minified HTML. Inliner example at https://github.com/brandonlee781/email-inliner
Author: Brandon Lee
Author URI: https://branlee.me
Version: 1.0
License: GPLv2 or later
Text Domain: email_inliner
*/
defined('ABSPATH') or die('No script kiddies please!');
include(dirname(__FILE__) . '/options.php');

function email_inliner_add_custom_box() {
    wp_register_script('get_inlined', plugins_url('/js/main.js', __FILE__), array('jquery'));
    wp_register_style('email_inliner', plugins_url('/css/styles.css', __FILE__), array(), '20180327', 'all');
    $screens = ['post'];
    foreach ($screens as $screen) {
        add_meta_box(
            'email_inliner_box',
            'Email Inliner',
            'email_inliner_box_html',
            $screen
        );
    }
}
add_action('add_meta_boxes', 'email_inliner_add_custom_box');

function plugin_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=email_inliner">' . __('Settings') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'plugin_add_settings_link');

function email_inliner_box_html($post) {
    wp_enqueue_style('email_inliner');
    $options = get_option('email_inliner_group');
    $permalink = get_permalink($post->ID);
    $status = get_post_status($post->ID);

    if ($status === 'publish') {
        wp_enqueue_script('get_inlined');
    }


    echo "
      <div class='inliner_wrapper'>
        <input type='hidden' id='inliner_url' value='{$options[inliner_url]}' />
        <input type='hidden' id='permalink' value={$permalink} />
        <textarea id='inlined_text' rows='10'></textarea>
        <button id='copy_btn' data-copytarget='#inlined_text'>Copy</button>
      </div>
    ";
}
