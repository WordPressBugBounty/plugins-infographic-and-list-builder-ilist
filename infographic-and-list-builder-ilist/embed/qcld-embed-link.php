<?php 
defined('ABSPATH') or die("No direct script access!");
wp_head();
add_action('wp_enqueue_scripts', 'qcilist_embed_load_all_scripts');
if(!function_exists('qcilist_embed_load_all_scripts')){
    function qcilist_embed_load_all_scripts(){
        wp_enqueue_style( 'ilist_embed_fontawesome-css', QCOPD_iList_ASSETS_URL1 . '/css/font-awesome.min.css');
        wp_enqueue_style( 'ilist_embed_custom-css', QCOPD_iList_ASSETS_URL1 . '/css/sl-directory-style.css');
        wp_enqueue_style( 'ilist_embed_custom-rwd-css', QCOPD_iList_ASSETS_URL1 . '/css/sl-directory-style-rwd.css');
        wp_enqueue_style( 'ilist_custom-rwd-embed', QCOPD_iList_URL1 . '/embed/css/embed-form.css');

        // Scripts

        wp_enqueue_script( 'ilist_embed_custom-script', QCOPD_iList_ASSETS_URL1 . '/js/directory-script.js', array('jquery', 'ilist_embed_grid-packery'));
        wp_enqueue_script( 'ilist_embed_custom-embed_form', QCOPD_iList_URL1 . '/embed/js/embed-form.js', array('jquery', 'ilist_embed_grid-packery'));
    }
}
?>

<script type="text/javascript">
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
</script>

<style>
    .button-link-ilist,
    .sld-add .sld-add-btn {
        display: none !important;
    }
</style>



<?php


$order = isset($_GET['order']) ? sanitize_text_field(esc_html__($_GET['order'])):'ASC';
$mode = isset($_GET['mode']) ? sanitize_text_field(esc_html__($_GET['mode'])):'one';
$column = isset($_GET['column']) ? sanitize_text_field(esc_html__($_GET['column'])):'2';
$style = isset($_GET['style']) ? sanitize_text_field(esc_html__($_GET['style'])):'simple';
$search = isset($_GET['search']) ? sanitize_text_field(esc_html__($_GET['search'])):'';
$category = isset($_GET['category']) ? sanitize_text_field(esc_html__($_GET['category'])):'';
$upvote = isset($_GET['upvote']) ? sanitize_text_field(esc_html__($_GET['upvote'])):'';
$list_id = isset($_GET['list_id']) ? sanitize_text_field(esc_html__($_GET['list_id'])):'';
$capture = isset($_GET['capture']) ? sanitize_text_field(esc_html__($_GET['capture'])):'';

echo do_shortcode('[qcld-ilist mode=' . esc_attr($mode) . ' column="' . esc_attr($column) . '" upvote="' . esc_attr($upvote) . '" list_id='.esc_attr($list_id).' capture='.esc_attr($capture).'][/qcld-ilist]'); 

wp_footer();
//wp_head();
?>





