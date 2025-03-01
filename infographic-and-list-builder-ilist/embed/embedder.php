<?php
defined('ABSPATH') or die("No direct script access!");

/*Load Global Scripts*/
add_action('wp_enqueue_scripts', 'qcld_load_embed_scripts');

function qcld_load_embed_scripts()
{
    //FontAwesome
    wp_enqueue_style('ilist-embed-form-css', QCOPD_iList_URL1 . '/embed/css/embed-form.css');
    //Scripts
    wp_enqueue_script('ilist-embed-form-script', QCOPD_iList_URL1 . '/embed/js/embed-form.js', array('jquery'));

}


if(!function_exists('qcilist_embed_load_all_scripts')){
    function qcilist_embed_load_all_scripts(){
        wp_enqueue_style( 'ilist_embed_fontawesome-css', QCOPD_iList_ASSETS_URL1 . '/css/font-awesome.css');
        wp_enqueue_style( 'ilist_embed_custom-css', QCOPD_iList_ASSETS_URL1 . '/css/sl-directory-style.css');
        wp_enqueue_style( 'ilist_embed_custom-rwd-css', QCOPD_iList_ASSETS_URL1 . '/css/sl-directory-style-rwd.css');
        wp_enqueue_style( 'ilist_custom-rwd-embed', QCOPD_iList_URL1 . '/embed/css/embed-form.css');

        // Scripts
        wp_enqueue_script( 'jquery', 'jquery');
        wp_enqueue_script( 'ilist_embed_grid-packery',    QCOPD_iList_ASSETS_URL1 . '/js/packery.pkgd.js', array('jquery'));
        wp_enqueue_script( 'ilist_embed_custom-script', QCOPD_iList_ASSETS_URL1 . '/js/directory-script.js', array('jquery', 'ilist_embed_grid-packery'));
        wp_enqueue_script( 'ilist_embed_custom-embed_form', QCOPD_iList_URL1 . '/embed/js/embed-form.js', array('jquery', 'ilist_embed_grid-packery'));

        wp_add_inline_script( 'ilist_embed_custom-script', 
            'var ajaxurl = "'.admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ).'";
            var qcld_ajax_nonce = "'.wp_create_nonce( 'qcld-ilist' ).'";
            var qc_ilist_get_ajax_nonce = "'.wp_create_nonce( 'qc-opd' ).'";
            ', 'before');

        $css = '.button-link-ilist,
                #wpadminbar,
                .sld-add .sld-add-btn {
                    display: none !important;
                }';

        wp_add_inline_style( 'ilist_embed_custom-css', $css );


    }
}


// Load template for embed link page url
function qcld_load_embed_link_template($template)
{
    if (is_page('embed-ilist')) {
        add_action('wp_enqueue_scripts', 'qcilist_embed_load_all_scripts');

        return dirname(__FILE__) . '/qcld-embed-link.php';
    }
    return $template;
}

add_filter('template_include', 'qcld_load_embed_link_template', 99);


// Create embed page when plugin install or activate

add_action('init', 'qcld_create_embed_page');
function qcld_create_embed_page()
{

    $query = new WP_Query(
        array(
            'post_type'              => 'page',
            'title'                  => 'Embed iList',
            'post_status'            => 'all',
            'posts_per_page'         => 1,
            'no_found_rows'          => true,
            'ignore_sticky_posts'    => true,
            'update_post_term_cache' => false,
            'update_post_meta_cache' => false,
            'orderby'                => 'post_date ID',
            'order'                  => 'ASC',
        )
    );
     
    $page_got_by_title = ! empty( $query->post ) ? $query->post : null;

    if ( $page_got_by_title == NULL && FALSE === get_post_status( get_option('ilisthclpage') )) {
        //post status and options
        $post = array(
            'comment_status'    => 'closed',
            'ping_status'       => 'closed',
            'post_author'       => get_current_user_id(),
            'post_date'         => date('Y-m-d H:i:s'),
            'post_status'       => 'publish',
            'post_title'        => 'Embed iList',
            'post_type'         => 'page',
        );
        //insert page and save the id
        $embedPost = wp_insert_post($post, false);
        //save the id in the database
        update_option('ilisthclpage', $embedPost);
    }
}

function ilist_embedoption_track(){
	$embed_link_button = get_option('sl_enable_embed_list');
	
	if ($embed_link_button == 'on') {
		add_action('qcsl_after_add_btn', 'qcld1_custom_embedder');
	}
}

add_action('init', 'ilist_embedoption_track');
//add_action('qcsl_after_add_btn', 'qcld1_custom_embedder');
function qcld1_custom_embedder($shortcodeAtts)
{
    global $post;
    $credit_title = get_option('sl_embed_title');
    $credit_link = get_option('sl_embed_link');

    $pagename = isset($post->post_name) ? $post->post_name : '';

    if ( isset($pagename) && ( $pagename != 'embed-link' ) ) {
        ?>

        <a style="float:right" class="button-link-ilist js-open-modal" href="#" data-modal-id="popup_ilist"
           data-url="<?php bloginfo('url'); ?>/embed-ilist"
           data-order="<?php echo esc_attr($shortcodeAtts['order']); ?>"
           data-mode="<?php echo esc_attr($shortcodeAtts['mode']); ?>"
           data-column="<?php echo esc_attr($shortcodeAtts['column']); ?>"
           data-style="<?php echo esc_attr($shortcodeAtts['style']); ?>"
           data-search="<?php   ?>"
           data-category="<?php echo esc_attr($shortcodeAtts['category']); ?>"
           data-listid="<?php echo esc_attr($shortcodeAtts['list_id']); ?>"
           data-ctitle="<?php echo esc_attr($credit_title); ?>"
           data-clink="<?php echo esc_attr($credit_link); ?>"
           data-upvote="<?php echo esc_attr($shortcodeAtts['upvote']); ?>"> 
			<?php 
				if(get_option('ilist_lan_share_list')!=''){
					echo get_option('ilist_lan_share_list');
				}else{
					echo esc_html('Generate Embed Code', 'iList') ;
				}
			 ?>
		   </a>
        <div id="popup_ilist" class="modal-box">
            <header>
                <a href="#" class="js-modal-close close">×</a>
                <h3><?php esc_html_e('Generate Embed Code For This List', 'iList'); ?></h3>
            </header>
			 <div class="modal-body">
                <div class="iframe-css">
                    <div class="iframe-main">
                        <div class="ifram-row">
                            <div class="ifram-sm">
                                <span><?php esc_html_e("Width: (in '%' or 'px')", 'iList'); ?></span>
                                <input style="height: 36px;" id="igwidth" name="igwidth" type="text" value="100">
                            </div>
                            <div class="ifram-sm" style="width: 70px;">
                                <span>&nbsp;</span>
                                <select name="igsizetype" class="iframe-main-select">
                                    <option value="%"><?php esc_html_e("%", 'iList'); ?></option>
									<option value="px"><?php esc_html_e("px", 'iList'); ?></option>
                                </select>
                            </div>
                            <div class="ifram-sm">
                                <span><?php esc_html_e("Height: (in 'px')", 'iList'); ?></span>
                                <input style="height: 36px;" id="igheight" name="igheight" type="text" value="400">
                            </div>
                            <div class="ifram-sm">
                                <span>&nbsp;</span>
                                <a class="btn icon icon-code" id="generate-igcode_ilist" onclick=""><?php esc_html_e('Generate & Copy', 'iList'); ?></a>
                                </select>
                            </div>
                        </div>

                        <div class="ifram-row">
							<div class="ifram-lg">
								<span class="qcld-span-label"><?php esc_html_e('Generated Code', 'iList'); ?></span>
								<br>
								<textarea id="ilist_igcode_textarea" class="ilist_igcode_textarea" name="igcode" style="width:100%; height:120px;"
										  readonly="readonly"></textarea>
								<p class="guideline"><?php esc_html_e('Hit "Generate & Copy" button to generate embed code. It will be copied
                                    to your Clipboard. You can now paste this embed code inside your website\'s HTML where
                                    you want to show the List.', 'iList'); ?></p>
							</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php }
}