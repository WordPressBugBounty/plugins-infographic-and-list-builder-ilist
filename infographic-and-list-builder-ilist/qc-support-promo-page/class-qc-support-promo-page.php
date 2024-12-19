<?php
/*
* QuantumCloud Promo + Support Page
* Revised On: 18-10-2023
*/

if ( ! defined( 'qcilist_support_path' ) ) {
    define('qcilist_support_path', plugin_dir_path(__FILE__));
}

if ( ! defined( 'qcilist_support_url' ) )
    define('qcilist_support_url', plugin_dir_url( __FILE__ ) );

if ( ! defined( 'qcilist_img_url' ) )
    define('qcilist_img_url', qcilist_support_url . "/images" );


/*Callback function to add the menu */
function qcilist_show_promo_page_callback_func(){

    add_submenu_page(
        "edit.php?post_type=ilist",
        esc_html('More WordPress Goodies for You!', 'iList'),
        esc_html('Support', 'iList'),
        'manage_options',
        "qcopd_ilist_supports",
        'qcilist_promo_support_page_callback_func'
    );
    
} //show_promo_page_callback_func

add_action( 'admin_menu', 'qcilist_show_promo_page_callback_func', 10 );


/*******************************
 * Main Class to Display Support
 * form and the promo pages
 *******************************/

if ( ! function_exists( 'qcilist_include_promo_page_scripts' ) ) {	
	function qcilist_include_promo_page_scripts( ) {   


        if( isset($_GET["page"]) && !empty($_GET["page"]) && (   $_GET["page"] == "qcopd_ilist_supports"  ) ){

            wp_enqueue_style( 'qcld-support-fontawesome-css', qcilist_support_url . "css/font-awesome.min.css");                              
            wp_enqueue_style( 'qcld-support-style-css', qcilist_support_url . "css/style.css");

            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'jquery-ui-core');
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_script( 'jquery-custom-form-processor', qcilist_support_url . 'js/support-form-script.js',  array('jquery', 'jquery-ui-core','jquery-ui-tabs') );

            wp_add_inline_script( 'jquery-custom-form-processor', 
                                    'var qcilist_ajaxurl    = "' . admin_url('admin-ajax.php') . '";
                                    var qcilist_ajax_nonce  = "'. wp_create_nonce( 'qc-clr' ).'";   
                                ', 'before');
            
        }
	   
	}
	add_action('admin_enqueue_scripts', 'qcilist_include_promo_page_scripts');
	
}
		
/*******************************
 * Callback function to show the HTML
 *******************************/

include_once qcilist_support_path . '/qc-clr-recommendbot-support-plugin.php';

if ( ! function_exists( 'qcilist_promo_support_page_callback_func' ) ) {

	function qcilist_promo_support_page_callback_func() {
		
?>


        <div class="qcilist-support qcld-support-new-page">
            <div class="support-btn-main justify-content-center">
                <div class="col text-center">
                    <h2 class="py-3"><?php esc_html_e('Check Out Some of Our Other Works that Might Make Your Website Better', 'iList'); ?></h2>
                    <h5><?php esc_html_e('All our Pro Version users get Premium, Guaranteed Quick, One on One Priority Support.', 'iList'); ?></h5>
                    <div class="support-btn">
                        <a class="premium-support" href="<?php echo esc_url('https://qc.ticksy.com/'); ?>" target="_blank"><?php esc_html_e('Get Priority Support ', 'iList'); ?></a>
                        <a style="width:282px" class="premium-support" href="<?php echo esc_url('https://www.quantumcloud.com/resources/kb-sections/comment-tools/'); ?>" target="_blank"><?php esc_html_e('Online KnowledgeBase', 'iList'); ?></a>
                    </div>
                </div>
            
                <div class="qc-column-12" >
                    <div class="support-btn">
                        
                        <a class="premium-support premium-support-free" href="<?php echo esc_url('https://www.quantumcloud.com/resources/free-support/','qc-clr') ?>" target="_blank"><?php esc_html_e('Get Support for Free Version','qc-clr') ?></a>
                    </div>
                </div>
            </div>
            
            <div class="qcld-plugins-lists">
                <div class="qcld-plugins-loading">
                    <img src="<?php echo esc_url(qcilist_img_url); ?>/loading.gif" alt="loading">
                </div>
            </div>
        </div>
			
		
<?php
            
       
    }
}


/*******************************
 * Handle Ajex Request for Form Processing
 *******************************/
add_action( 'wp_ajax_qcilist_process_qc_promo_form', 'qcilist_process_qc_promo_form' );

if( !function_exists('qcilist_process_qc_promo_form') ){

    function qcilist_process_qc_promo_form(){

        check_ajax_referer( 'qc-clr', 'security');
        
        $data['status']   = 'failed';
        $data['message']  = esc_html('Problem in processing your form submission request! Apologies for the inconveniences.<br> 
Please email to <span style="color:#22A0C9;font-weight:bold !important;font-size:14px "> quantumcloud@gmail.com </span> with any feedback. We will get back to you right away!', 'iList');

        $name         = isset($_POST['post_name']) ? trim(sanitize_text_field(wp_unslash($_POST['post_name']))) : '';
        $email        = isset($_POST['post_email']) ? trim(sanitize_email(wp_unslash($_POST['post_email']))) : '';
        $subject      = isset($_POST['post_subject']) ? trim(sanitize_text_field(wp_unslash($_POST['post_subject']))) : '';
        $message      = isset($_POST['post_message']) ? trim(sanitize_text_field(wp_unslash($_POST['post_message']))) : '';
        $plugin_name  = isset($_POST['post_plugin_name']) ? trim(sanitize_text_field(wp_unslash($_POST['post_plugin_name']))) : '';

        if( $name == "" || $email == "" || $subject == "" || $message == "" )
        {
            $data['message'] = esc_html('Please fill up all the requried form fields.', 'iList');
        }
        else if ( filter_var($email, FILTER_VALIDATE_EMAIL) === false ) 
        {
            $data['message'] = esc_html('Invalid email address.', 'iList');
        }
        else
        {

            //build email body

            $bodyContent = "";
                
            $bodyContent .= "<p><strong>".esc_html('Support Request Details:', 'iList')."</strong></p><hr>";

            $bodyContent .= "<p>".esc_html('Name', 'iList')." : ".$name."</p>";
            $bodyContent .= "<p>".esc_html('Email', 'iList')." : ".$email."</p>";
            $bodyContent .= "<p>".esc_html('Subject', 'iList')." : ".$subject."</p>";
            $bodyContent .= "<p>".esc_html('Message', 'iList')." : ".$message."</p>";

            $bodyContent .= "<p>".esc_html('Sent Via the Plugin', 'iList')." : ".$plugin_name."</p>";

            $bodyContent .="<p></p><p>".esc_html('Mail sent from:', 'iList')." <strong>".get_bloginfo('name')."</strong>, ".esc_html('URL:', 'iList')." [".get_bloginfo('url')."].</p>";
            $bodyContent .="<p>".esc_html('Mail Generated on:', 'iList')." " . date("F j, Y, g:i a") . "</p>";           
            
            $toEmail = "quantumcloud@gmail.com"; //Receivers email address
            //$toEmail = "qc.kadir@gmail.com"; //Receivers email address

            //Extract Domain
            $url = get_site_url();
            $url = wp_parse_url($url);
            $domain = $url['host'];
            

            $fakeFromEmailAddress = "wordpress@" . $domain;
            
            $to = $toEmail;
            $body = $bodyContent;
            $headers = array();
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $headers[] = 'From: '.esc_attr($name).' <'.esc_attr($fakeFromEmailAddress).'>';
            $headers[] = 'Reply-To: '.esc_attr($name).' <'.esc_attr($email).'>';

            $finalSubject = esc_html('From Plugin Support Page:', 'iList')." " . esc_attr($subject);
            
            $result = wp_mail( $to, $finalSubject, $body, $headers );

            if( $result )
            {
                $data['status'] = 'success';
                $data['message'] = esc_html('Your email was sent successfully. Thanks!', 'iList');
            }

        }

        ob_clean();

        
        echo wp_json_encode($data);
    
        die();
    }
}