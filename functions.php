<?php
/**
 * SSBGmbH Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package SSBGmbH
 * @since 1.0.0
 */
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );
/**
 * Define Constants
 */
define( 'CHILD_THEME_SSBGMBH_VERSION', '1.0.0' );

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'ssbgmbh-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_SSBGMBH_VERSION, 'all' );
	wp_register_script( 'mncjs', FL_CHILD_THEME_URL . '/js/mnc.js', array('jquery'), false, true);
	wp_enqueue_script( 'mncjs' );
} );

add_shortcode('mi_show_children', function ($atts) {

    global $post;
    extract(shortcode_atts(array(
        'title' => '',
        'sort_order' => '',
        'orderby' => '',
        'exclude_page_id' => '',
        'depth' => '',
        'sort_order_parent' => ''
    ), $atts));

    $title = empty($title) ? 'Pages' : $title;
    $sort_order = empty($sort_order) ? 'ASC' : $sort_order;
    $orderby = empty($orderby) ? 'post_title ' : $orderby;
    $exclude_page_id = empty($exclude_page_id) ? ' ' : $exclude_page_id;
    $depth = empty($depth) ? '1' : $depth;
    $sort_order_parent = empty($sort_order_parent) ? 'ASC' : $sort_order_parent;
    $ls_str = '';
    $ls_str .= '<div class="mi_show_children">';
    // WIDGET CODE GOES HERE
    $page_id = $post->ID;
    $args = array(
        'order' => $sort_order,
        'post_parent' => $page_id,
        'orderby' => $orderby,
        'post_status' => 'publish',
        'post_type' => 'page',
    );

    $attachments = get_children($args);

    $ls_str .= '<ul class="mi_show_children">';
    if ($attachments) {
        foreach ($attachments as $attachment) {
            $ls_str .= '<li><a href="' . $attachment->guid . '">' . $attachment->post_title . '</a></li>';
        }
    } else {
        $args = array(
            'depth' => $depth,
            'title_li' => '',
            'echo' => 0,
            'sort_order' => $sort_order_parent,
            'sort_column' => $orderby,
            'post_type' => 'page',
            'post_status' => 'publish',
            'exclude' => $exclude_page_id,
        );
        $pages = wp_list_pages($args);

        $ls_str .= $pages;
    }

    $ls_str .= '</ul>';
    $ls_str .= '</div>';

    return $ls_str;
});

add_shortcode('mnc-vlist-broschueren', function() {
	/**
	 * @var WP_Post $post
	 */
	global $post;
	return $post->post_title;

});

