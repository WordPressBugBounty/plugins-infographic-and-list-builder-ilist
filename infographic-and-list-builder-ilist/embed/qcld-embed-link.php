<?php 
defined('ABSPATH') or die("No direct script access!");
wp_head();

$order      = isset($_GET['order']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['order'])))) : esc_attr('ASC');
$mode       = isset($_GET['mode']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['mode'])))) : esc_attr('one');
$column     = isset($_GET['column']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['column'])))) : esc_attr('2');
$style      = isset($_GET['style']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['style'])))) : esc_attr('simple');
$search     = isset($_GET['search']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['search'])))) : '';
$category   = isset($_GET['category']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['category'])))) : '';
$upvote     = isset($_GET['upvote']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['upvote'])))) : esc_attr('off');
$list_id    = isset($_GET['list_id']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['list_id'])))) : '';
$capture    = isset($_GET['capture']) ? preg_replace('/[^A-Za-z0-9 !@#$%^&*().]/u','', strip_tags(sanitize_text_field(wp_unslash($_GET['capture'])))) : '';


echo do_shortcode('[qcld-ilist mode="'.esc_attr($mode).'" style="'.esc_attr($style).'" column="'.esc_attr($column).'" upvote="'.esc_attr($upvote).'" list_id="'.esc_attr($list_id).'" capture="'.esc_attr($capture).'" order="'.esc_attr($order).'" category="'.esc_attr($category).'"][/qcld-ilist]'); 

wp_footer();

?>
