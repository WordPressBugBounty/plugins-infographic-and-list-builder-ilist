<?php 
defined('ABSPATH') or die("No direct script access!");
wp_head();

$order      = isset($_GET['order']) ? sanitize_text_field(wp_unslash($_GET['order'])) : 'ASC';
$mode       = isset($_GET['mode']) ? sanitize_text_field(wp_unslash($_GET['mode'])) : 'one';
$column     = isset($_GET['column']) ? sanitize_text_field(wp_unslash($_GET['column'])) : '2';
$style      = isset($_GET['style']) ? sanitize_text_field(wp_unslash($_GET['style'])) : 'simple';
$search     = isset($_GET['search']) ? sanitize_text_field(wp_unslash($_GET['search'])) : '';
$category   = isset($_GET['category']) ? sanitize_text_field(wp_unslash($_GET['category'])) : '';
$upvote     = isset($_GET['upvote']) ? sanitize_text_field(wp_unslash($_GET['upvote'])) : '';
$list_id    = isset($_GET['list_id']) ? sanitize_text_field(wp_unslash($_GET['list_id'])) : '';
$capture    = isset($_GET['capture']) ? sanitize_text_field(wp_unslash($_GET['capture'])) : '';

echo do_shortcode('[qcld-ilist mode=' . esc_attr($mode) . ' style="' . esc_attr($style) . '" column="' . esc_attr($column) . '" upvote="' . esc_attr($upvote) . '" list_id='.esc_attr($list_id).' capture='.esc_attr($capture).' order='.esc_attr($order).' category='.esc_attr($category).'][/qcld-ilist]'); 

wp_footer();

?>





