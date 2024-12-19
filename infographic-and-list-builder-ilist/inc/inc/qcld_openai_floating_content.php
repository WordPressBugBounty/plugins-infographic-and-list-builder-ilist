<?php 

defined('ABSPATH') or die("You can't access this file directly.");


add_action( 'admin_enqueue_scripts', 'qcld_ilist_floating_openai_floating_admin_enqueue_styles' );
if ( ! function_exists( 'qcld_ilist_floating_openai_floating_admin_enqueue_styles' ) ) {
  function qcld_ilist_floating_openai_floating_admin_enqueue_styles() {


    wp_enqueue_script('qcld_ilist_floating_openai_bootstrap_script', QCOPD_INC_URL_INC. '/inc/bootstrap.js');

    wp_enqueue_style('qcld_ilist_floating_openai_floating_icon_css', QCOPD_INC_URL_INC. '/inc/qcld-floating-icons.css' );

    wp_enqueue_script('qcld_ilist_floating_openai_floating_icon', QCOPD_INC_URL_INC. '/inc/qcld-floating-icons.js' );

    wp_add_inline_script( 'qcld_ilist_floating_openai_floating_icon', 
        'var qcld_ilist_floating_ajaxurl               = "' . admin_url('admin-ajax.php') . '"; 
         var qcld_ilist_floating_ajax_nonce            = "'. wp_create_nonce( 'iList' ).'";  
         ', 'before');

  }
}

$qcld_disable_floating_icon = get_option('sl_openai_disable_ai_content_assistant');
if($qcld_disable_floating_icon !== "on" ){
add_action('admin_footer', 'qcld_ilist_floating_icon_content_html');
}
if ( ! function_exists( 'qcld_ilist_floating_icon_content_html' ) ) {
  function qcld_ilist_floating_icon_content_html(){


      $screen = get_current_screen();
      //var_dump( $screen->post_type );
      //wp_die();
      //if( isset( $screen->post_type ) && ( $screen->post_type == 'page' || $screen->post_type == 'post' ) ){

      ?>
      <div class="qcld_ilist_content_wrap">
          <label for="linkbait-post-class"><?php echo esc_html__( "AI", 'iList' ); ?></label>
          
          <div class="qcld_ilist_content_wrap_inn">
          <img src="<?php echo QCOPD_INC_URL_INC.'/inc/ai.png' ?>" alt="loading">
          <input type="button" class="button" id="qcld_ilist_content_generator" value="Generate">
          </div>
      </div>
    <div class="qcld_ilist_floating-outer">
        <div class="qcld_ilist_floating">
          
            <!-- Sidebar Right -->
            <div class="modal fade right" id="qcld_ilist_content_generator_modal" tabindex="-1" role="dialog" data-bs-backdrop="static" >
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="keywords_resultLabel"><?php echo esc_html__('Content Generator', 'iList' ); ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-list">  
                              <?php 


                                $open_ai_api_key = get_option('sl_openai_api_key');
                                if( empty($open_ai_api_key) ){ 

                              ?>
                              <p style="color:red;"><b><?php esc_html_e('Please add API key from'); ?> <a href="<?php echo esc_url(admin_url('edit.php?post_type=ilist&page=ilist_settings#openai_settings')); ?>" target="_blank"><?php esc_html_e('Settings.'); ?></a> <?php esc_html_e('Otherwise, AI will not work.', 'iList'); ?></b></p>
                              <?php } ?>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                              <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="article-tab" data-bs-toggle="tab" data-bs-target="#article-tab-pane" type="button" role="tab" aria-controls="article-tab-pane" aria-selected="true"><?php esc_html_e('Generate New Article', 'iList'); ?></button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#content-tab-pane" type="button" role="tab" aria-controls="content-tab-pane" aria-selected="false"><?php esc_html_e('Rewrite Contents', 'iList'); ?></button>
                              </li>
                              <li class="nav-item" role="presentation">
                                <button class="nav-link" id="content-tab" data-bs-toggle="tab" data-bs-target="#playground-tab-pane" type="button" role="tab" aria-controls="playground-tab-pane" aria-selected="false"><?php esc_html_e('Playground', 'iList'); ?></button>
                              </li>
                            </ul>

                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="article-tab-pane" role="tabpanel" aria-labelledby="article-tab" tabindex="0">
                                    <div class="qcld_ilist_floating">
                                        <div class="qcld_ilist_floating-input">
                                            <div class="qcld_ilist_floating-input-field">
                                                <label for="qcld_ilist_floating_openai_keyword_suggestion" class="form-label"><?php esc_html_e('Prompt', 'iList'); ?></label><br>
                                                <input type="text" id="qcld_ilist_floating_openai_keyword_suggestion_mf" class="form-control" data-press="qcld_ilist_floating_openai_keyword_suggestion" placeholder="<?php esc_html_e( "Write me a long article on how to make money online", 'iList' ); ?>"><br>
                                                <p><?php esc_html_e( "Ex: Write me a long article on how to make money online", 'iList' ); ?></p>
                                            </div>
                                           
                                        </div>
                                        <div class="qcld_ilist_floating-input qcld_ilist_floating_pro_feature_content">
                                            <div class="qcld_ilist_floating-input-field qcld_ilist_floating-input-field_ai_wrap">
                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_number_of_heading"><?php esc_html_e( "How many headings?", 'iList' ); ?> </label>
                                                    <input type="number" placeholder="e.g. 5" id="qcld_ilist_article_number_of_heading" class="qcld_ilist_article_number_of_heading" name="qcld_ilist_article_number_of_heading" value="">
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_heading_tag"><?php esc_html_e( "Heading Tag", 'iList' ); ?> </label>
                                                    <select name="qcld_ilist_article_heading_tag" id="qcld_ilist_article_heading_tag">
                                                        <option value="h1"><?php esc_html_e( "h1", 'iList' ); ?></option>
                                                        <option value="h2"><?php esc_html_e( "h2", 'iList' ); ?></option>
                                                        <option value="h3"><?php esc_html_e( "h3", 'iList' ); ?></option>
                                                        <option value="h4"><?php esc_html_e( "h4", 'iList' ); ?></option>
                                                        <option value="h5"><?php esc_html_e( "h5", 'iList' ); ?></option>
                                                        <option value="h6"><?php esc_html_e( "h6", 'iList' ); ?></option>
                                                    </select>
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_heading_style"><?php esc_html_e( "Writing Style", 'iList' ); ?> </label>
                                                    <select name="qcld_ilist_article_heading_style" id="qcld_ilist_article_heading_style">
                                                        <option value="infor"><?php esc_html_e( "Informative", 'iList' ); ?></option>
                                                        <option value="analy"><?php esc_html_e( "Analytical", 'iList' ); ?></option>
                                                        <option value="argum"><?php esc_html_e( "Argumentative", 'iList' ); ?></option>
                                                        <option value="creat"><?php esc_html_e( "Creative", 'iList' ); ?></option>
                                                        <option value="criti"><?php esc_html_e( "Critical", 'iList' ); ?></option>
                                                        <option value="descr"><?php esc_html_e( "Descriptive", 'iList' ); ?></option>
                                                        <option value="evalu"><?php esc_html_e( "Evaluative", 'iList' ); ?></option>
                                                        <option value="expos"><?php esc_html_e( "Expository", 'iList' ); ?></option>
                                                        <option value="journ"><?php esc_html_e( "Journalistic", 'iList' ); ?></option>
                                                        <option value="narra"><?php esc_html_e( "Narrative", 'iList' ); ?></option>
                                                        <option value="persu"><?php esc_html_e( "Persuasive", 'iList' ); ?></option>
                                                        <option value="refle"><?php esc_html_e( "Reflective", 'iList' ); ?></option>
                                                        <option value="simpl"><?php esc_html_e( "Simple", 'iList' ); ?></option>
                                                        <option value="techn"><?php esc_html_e( "Technical", 'iList' ); ?></option>
                                                        <option value="repor"><?php esc_html_e( "Report", 'iList' ); ?></option>
                                                        <option value="resea"><?php esc_html_e( "Research", 'iList' ); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="qcld_ilist_floating-input qcld_ilist_floating_pro_feature_content">
                                            <div class="qcld_ilist_floating-input-field qcld_ilist_floating-input-field_ai_wrap">

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_heading_tone"><?php esc_html_e( "Writing Tone", 'iList' ); ?> </label>
                                                    <select name="qcld_ilist_article_heading_tone" id="qcld_ilist_article_heading_tone">
                                                        <option value="formal"><?php esc_html_e( "Formal", 'iList' ); ?></option>
                                                        <option value="asser"><?php esc_html_e( "Assertive", 'iList' ); ?></option>
                                                        <option value="cheer"><?php esc_html_e( "Cheerful", 'iList' ); ?></option>
                                                        <option value="humor"><?php esc_html_e( "Humorous", 'iList' ); ?></option>
                                                        <option value="informal"><?php esc_html_e( "Informal", 'iList' ); ?></option>
                                                        <option value="inspi"><?php esc_html_e( "Inspirational", 'iList' ); ?></option>
                                                        <option value="neutr"><?php esc_html_e( "Neutral", 'iList' ); ?></option>
                                                        <option value="profe"><?php esc_html_e( "Professional", 'iList' ); ?></option>
                                                        <option value="sarca"><?php esc_html_e( "Sarcastic", 'iList' ); ?></option>
                                                        <option value="skept"><?php esc_html_e( "Skeptical", 'iList' ); ?></option>
                                                        <option value="curio"><?php esc_html_e( "Curious", 'iList' ); ?></option>
                                                        <option value="disap"><?php esc_html_e( "Disappointed", 'iList' ); ?></option>
                                                        <option value="encou"><?php esc_html_e( "Encouraging", 'iList' ); ?></option>
                                                        <option value="optim"><?php esc_html_e( "Optimistic", 'iList' ); ?></option>
                                                        <option value="surpr"><?php esc_html_e( "Surprised", 'iList' ); ?></option>
                                                        <option value="worry"><?php esc_html_e( "Worried", 'iList' ); ?></option>

                                        
                                                    </select>
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_img_size" ><?php esc_html_e('Image Size', 'iList'); ?> </label>
                                                    <select name="qcld_ilist_article_img_size" id="qcld_ilist_article_img_size">
                                                        <!-- <option value="256x256"><?php esc_html_e( "256x256", 'iList' ); ?> </option>
                                                        <option value="512x512"><?php esc_html_e( "512x512", 'iList' ); ?> </option> -->
                                                      <option value="1024x1024"><?php esc_html_e( "1024x1024", 'iList' ); ?> </option>
                                                      <option value="1792x1024"><?php esc_html_e('1792x1024', 'iList'); ?></option>
                                                      <option value="1024x1792"><?php esc_html_e('1024x1792', 'iList'); ?></option>
                                                    </select>
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_language"><?php esc_html_e( "Language", 'iList' ); ?> </label>
                                                    <select name="qcld_ilist_article_language" id="qcld_ilist_article_language">
                                                        <option value="en"><?php esc_html_e( "English", 'iList' ); ?> </option>
                                                        <option value="ar"><?php esc_html_e( "Arabic", 'iList' ); ?> </option>
                                                        <option value="bg"><?php esc_html_e( "Bulgarian", 'iList' ); ?> </option>
                                                        <option value="zh"><?php esc_html_e( "Chinese", 'iList' ); ?> </option>
                                                        <option value="cs"><?php esc_html_e( "Czech", 'iList' ); ?> </option>
                                                        <option value="nl"><?php esc_html_e( "Dutch", 'iList' ); ?> </option>
                                                        <option value="fr"> <?php esc_html_e( "French", 'iList' ); ?> </option>
                                                        <option value="de"> <?php esc_html_e( "German", 'iList' ); ?> </option>
                                                        <option value="el"> <?php esc_html_e( "Greek", 'iList' ); ?> </option>
                                                        <option value="hi"> <?php esc_html_e( "Hindi", 'iList' ); ?> </option>
                                                        <option value="hu"> <?php esc_html_e( "Hungarian", 'iList' ); ?> </option>
                                                        <option value="id"> <?php esc_html_e( "Indonesian", 'iList' ); ?> </option>
                                                        <option value="it"> <?php esc_html_e( "Italian", 'iList' ); ?> </option>
                                                        <option value="ja"> <?php esc_html_e( "Japanese", 'iList' ); ?> </option>
                                                        <option value="ko"> <?php esc_html_e( "Korean", 'iList' ); ?> </option>
                                                        <option value="pl"> <?php esc_html_e( "Polish", 'iList' ); ?> </option>
                                                        <option value="pt"> <?php esc_html_e( "Portuguese", 'iList' ); ?> </option>
                                                        <option value="ro"> <?php esc_html_e( "Romanian", 'iList' ); ?> </option>
                                                        <option value="ru"> <?php esc_html_e( "Russian", 'iList' ); ?> </option>
                                                        <option value="es"> <?php esc_html_e( "Spanish", 'iList' ); ?> </option>
                                                        <option value="sv"> <?php esc_html_e( "Swedish", 'iList' ); ?> </option>
                                                        <option value="tr"> <?php esc_html_e( "Turkish", 'iList' ); ?> </option>
                                                        <option value="uk"> <?php esc_html_e( "Ukranian", 'iList' ); ?> </option>
                                                    </select>
                                                </div>
                                            </div>        
                                        </div>        
                                        <div class="qcld_ilist_floating-input qcld_ilist_floating_pro_feature_content">
                                            <div class="qcld_ilist_floating-input-field qcld_ilist_floating-input-field_ai_wrap">

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_label_anchor_text"><?php esc_html_e( "Anchor Text", 'iList' ); ?> </label>
                                                    <input type="text" id="qcld_ilist_article_label_anchor_text" placeholder="e.g. battery life" class="qcld_ilist_article_label_anchor_text" name="qcld_ilist_article_label_anchor_text" >
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_target_url"><?php esc_html_e( "Target URL", 'iList' ); ?> </label>
                                                    <input type="url" id="qcld_ilist_article_target_url" placeholder="https://..." class="qcld_ilist_article_target_url" name="qcld_ilist_article_target_url">
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_target_label_cta"><?php esc_html_e( "Add Call-to-Action", 'iList' ); ?> </label>
                                                    <input type="url" id="qcld_ilist_article_target_label_cta" placeholder="https://..." class="qcld_ilist_article_target_label_cta" name="qcld_ilist_article_target_label_cta">
                                                </div>


                                            </div>
                                        </div>
                                        <div class="qcld_ilist_floating-input qcld_ilist_floating_pro_feature_content">
                                            <div class="qcld_ilist_floating-input-field qcld_ilist_floating-input-field_ai_wrap">


                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_cta_pos"><?php esc_html_e( "Call-to-Action Position", 'iList' ); ?> </label>
                                                    <select name="qcld_ilist_article_cta_pos" id="qcld_ilist_article_cta_pos">
                                                        <option value="beg"><?php esc_html_e( "Beginning", 'iList' ); ?></option>
                                                        <option value="end"><?php esc_html_e( "End", 'iList' ); ?></option>
                                                    </select>
                                                    <p><i><?php esc_html_e( "Use Call-to-Action Position", 'iList' ); ?></i></p>
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_label_keywords"><?php esc_html_e( "Add Keywords", 'iList' ); ?> </label>
                                                    <input type="text" id="qcld_ilist_article_label_keywords" placeholder="Write Keywords..." class="qcld_ilist_article_label_keywords" name="qcld_ilist_article_label_keywords">
                                                    <p><i><?php esc_html_e( "Use comma to seperate keywords", 'iList' ); ?></i></p>
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_label_word_to_avoid"><?php esc_html_e( "Keywords to Avoid", 'iList' ); ?> </label>
                                                    <input type="text" id="qcld_ilist_article_label_word_to_avoid" placeholder="Write Keywords..." class="qcld_ilist_article_label_word_to_avoid" name="qcld_ilist_article_label_word_to_avoid" value="">
                                                    <p><i><?php esc_html_e( "Use comma to seperate keywords", 'iList' ); ?></i></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="qcld_ilist_floating-input qcld_ilist_floating_pro_feature_content">
                                            <div class="qcld_ilist_floating-input-field qcld_ilist_floating-input-field_ai_wrap">

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_label_keywords_bold"><?php esc_html_e( "Make Keywords Bold", 'iList' ); ?> </label>
                                                    <input type="checkbox" id="qcld_ilist_article_label_keywords_bold" class="qcld_ilist_article_label_keywords_bold" name="qcld_ilist_article_label_keywords_bold" value="1">
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_heading_img"><?php esc_html_e( "Add Image", 'iList' ); ?> </label>
                                                    <input type="checkbox" name="qcld_ilist_article_heading_img" id="qcld_ilist_article_heading_img" class="qcld_ilist_article_heading_img" value="1"/>
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_heading_tagline"><?php esc_html_e( "Add Tagline", 'iList' ); ?> </label>
                                                    <input type="checkbox" id="qcld_ilist_article_heading_tagline"  name="qcld_ilist_article_heading_tagline" class="qcld_ilist_article_heading_tagline" value="1" />
                                                </div>


                                            </div>
                                        </div>
                                        <div class="qcld_ilist_floating-input qcld_ilist_floating_pro_feature_content">
                                            <div class="qcld_ilist_floating-input-field qcld_ilist_floating-input-field_ai_wrap">

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_heading_intro"><?php esc_html_e( "Add Introduction", 'iList' ); ?> </label>
                                                    <input type="checkbox" id="qcld_ilist_article_heading_intro" name="qcld_ilist_article_heading_intro" class="qcld_ilist_article_heading_intro" value="1"/>
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_heading_conclusion"><?php esc_html_e( "Add Conclusion", 'iList' ); ?> </label>
                                                    <input type="checkbox" id="qcld_ilist_article_heading_conclusion" name="qcld_ilist_article_heading_conclusion" class="qcld_ilist_article_heading_conclusion" value="1" />
                                                </div>

                                                <div class="qcld_ilist_ai_con">
                                                    <label for="qcld_ilist_article_heading_faq"><?php esc_html_e( "Add Faq", 'iList' ); ?> </label>
                                                    <input type="checkbox" id="qcld_ilist_article_heading_faq" name="qcld_ilist_article_heading_faq" class="qcld_ilist_article_heading_faq" value="1" />
                                                </div>

                                            </div>
                                        </div>
                                        <button id="qcld_ilist_floating_openai_keyword_suggestion" class="btn btn-info" ><?php esc_html_e('Generate', 'iList'); ?></button>
                                        <p style="color:red;"><b><?php esc_html_e('(Please'); ?> <a href="<?php echo esc_url('https://platform.openai.com/settings/organization/billing/'); ?>" target="_blank"><?php esc_html_e('Pre-purchase credit'); ?></a> <?php esc_html_e('from OpenAI API platform and increase the API usage limit. Otherwise, AI features will not work)'); ?></b></p>
                                        <hr/>
                                        <div class="qcld_ilist_floating_bait_single_field"> 
                                            <div id="qcld_ilist_floating_bait_article_keyword_data">
                                                <div class="qcld_copied-content-wrap">
                                                    <div class="qcld_copied-content_text btn d-none link-success"><?php esc_html_e("Copied", 'iList'); ?></div>
                                                    <a class="btn btn-sm btn-secondary qcld-copied-content_text"><span class="dashicons dashicons-admin-page"></span></a>
                                                </div>
                                                <?php
                                                    wp_editor('','qcld_ilist_floating_content_result_msg', array('media_buttons' => false, 'textarea_name' => 'qcld_ilist_floating_content_result_msg', 'editor_height' => 400 ) );
                                                ?>
                                                <div class="qcld_ilist_floating_content_result_wrap">
                                                    <div class="qcld_ilist_floating_rewrite_result_count"></div>
                                                </div>
                                            </div>

                                            <div class="qcld_seo-playground-buttons">
                                                <button class="button button-primary qcld_ilist_floating_openai_article_save" ><?php esc_html_e("Save as Draft", 'iList'); ?></button>
                                                <button class="button qcld_ilist_floating_openai_article_clear"><?php esc_html_e("Clear", 'iList'); ?></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>  
                                <div class="tab-pane fade" id="content-tab-pane" role="tabpanel" aria-labelledby="content-tab" tabindex="0">
                                    
                                  
                                    <div class="qcld_ilist_floating">
                                    <h5><?php esc_html_e( 'Rewrite Contents', 'iList' ); ?> </h5>
                                    <textarea id="qcld_ilist_floating_content_rewrite" class="form-control" data-press="qcld_ilist_floating_content_rewrite"></textarea>
                                    <div class="qcld_ilist_floating_content_rewrite_count_wrap"><span class="qcld_ilist_floating_content_rewrite_count">0</span></div>
                                    <button id="qcld_ilist_floating_openai_keyword_rewrite_article" class="btn btn-info"><?php esc_html_e( 'Generate', 'iList' ); ?></button>
                                    <div id="qcld_ilist_floating_content_rewrite_result">
                                        <div class="qcld_copied-content-wrap">
                                            <div class="qcld_copied-content btn d-none link-success"><?php esc_html_e("Copied", 'iList'); ?></div>
                                            <a class="btn btn-sm btn-secondary qcld-copied-content"><span class="dashicons dashicons-admin-page"></span></a>
                                        </div>
                                        <?php
                                            wp_editor('','qcld_ilist_floating_content_rewrite_result_msg', array('media_buttons' => false, 'textarea_name' => 'qcld_ilist_floating_content_rewrite_result_msg', 'editor_height' => 400 ) );
                                        ?>
                                        <div class="qcld_ilist_floating_rewrite_result_count_wrap">
                                            <div class="qcld_ilist_floating_rewrite_result_count"></div>
                                        </div>
                                    </div>
                                    </div>

                                </div>  
                                <div class="tab-pane fade" id="playground-tab-pane" role="tabpanel" aria-labelledby="content-tab" tabindex="0">
                                    
                                  
                                    <div class="qcld_ilist_floating qcld_ilist_floating-playground">
                                      <table class="form-table form-table-prompt">
                                          <tbody>
                                          <tr>
                                              <th scope="row"><?php esc_html_e("Enter your prompt", 'iList'); ?></th>
                                              <td>
                                                  <input type="text" class="regular-text qcld_ilist_floating_prompt" placeholder="Write Your Prompt">
                                                  &nbsp;<button class="btn btn-info qcld_ilist_floating_openai_generator_button"><?php esc_html_e("Generate", 'iList'); ?></button>
                                                  &nbsp;<button class="btn btn-info qcld_ilist_floating_openai_generator_stop"><?php esc_html_e("Stop", 'iList'); ?></button>
                                                  <p style="color:red;"><b><?php esc_html_e('(Please'); ?> <a href="<?php echo esc_url('https://platform.openai.com/settings/organization/billing/'); ?>" target="_blank"><?php esc_html_e('Pre-purchase credit'); ?></a> <?php esc_html_e('from OpenAI API platform and increase the API usage limit. Otherwise, AI features will not work)'); ?></b></p>
                                              </td>
                                          </tr>
                                          <tr>
                                              <th scope="row"><?php esc_html_e("Result", 'iList'); ?></th>
                                              <td>
                                                  <?php
                                                  wp_editor('','qcld_ilist_floating_generator_result', array('media_buttons' => false, 'textarea_name' => 'qcld_ilist_floating_generator_result'));
                                                  ?>
                                                  <p class="qcld_seo-playground-buttons">
                                                      <button class="button button-primary qcld_ilist_floating_openai_playground_save"><?php esc_html_e("Save as Draft", 'iList'); ?></button>
                                                      <button class="button qcld_ilist_floating_openai_playground_clear"><?php esc_html_e("Clear", 'iList'); ?></button>
                                                  </p>
                                              </td>
                                          </tr>
                                          </tbody>
                                      </table>
                                   
                                    </div>

                                </div>  
                            </div>


                            </div>
                        </div>
                    </div>
      
                </div>
            </div>
        </div>
    </div>
      <?php 
    //}
  }
}


add_action( 'wp_ajax_qcld_ilist_floating_openai_keyword_suggestion_content_function', 'qcld_ilist_floating_openai_keyword_suggestion_content_callback' );
add_action( 'wp_ajax_nopriv_qcld_ilist_floating_openai_keyword_suggestion_content_function', 'qcld_ilist_floating_openai_keyword_suggestion_content_callback' );

if ( ! function_exists( 'qcld_ilist_floating_openai_keyword_suggestion_content_callback' ) ) {
    function qcld_ilist_floating_openai_keyword_suggestion_content_callback(){

        check_ajax_referer( 'iList', 'security');

        set_time_limit(600);

        $OPENAI_API_KEY                     = get_option('sl_openai_api_key');
        $ai_engines                         = get_option('sl_openai_engines');
        $max_token                          = get_option('sl_openai_max_token') ? get_option('sl_openai_max_token') : 4000;
        $temperature                        = get_option('sl_openai_temperature') ? get_option('sl_openai_temperature') : 0;
        $ppenalty                           = get_option('sl_openai_presence_penalty');
        $fpenalty                           = get_option('sl_openai_frequency_penalty');

        $qcld_ilist_article_text            = isset($_POST['keyword'])                          ? sanitize_text_field( wp_unslash($_POST['keyword'] ) ) : '';
        $keyword_number                     = isset( $_POST['keyword_number'] )                 ? sanitize_text_field( wp_unslash($_POST['keyword_number'] ) ) : '';
        $qcld_ilist_article_language              = isset($_POST['qcld_ilist_article_language'])            ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_language'] ) ) : '';
        $qcld_ilist_article_number_of_heading     = isset($_POST['qcld_ilist_article_number_of_heading'])   ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_number_of_heading'] ) ) : '';
        $qcld_ilist_article_heading_tag           = isset($_POST['qcld_ilist_article_heading_tag'])         ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_heading_tag'] ) ) : '';
        $qcld_ilist_article_heading_style         = isset($_POST['qcld_ilist_article_heading_style'])       ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_heading_style'] ) ) : '';
        $qcld_ilist_article_heading_tone          = isset($_POST['qcld_ilist_article_heading_tone'])        ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_heading_tone'] ) ) : '';
        $qcld_ilist_article_heading_img           = isset($_POST['qcld_ilist_article_heading_img'])         ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_heading_img'] ) ) : '';
        $qcld_ilist_article_heading_tagline       = isset($_POST['qcld_ilist_article_heading_tagline'])     ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_heading_tagline'] ) ) : '';
        $qcld_ilist_article_heading_intro         = isset($_POST['qcld_ilist_article_heading_intro'])       ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_heading_intro'] ) ) : '';
        $qcld_ilist_article_heading_conclusion    = isset($_POST['qcld_ilist_article_heading_conclusion'])  ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_heading_conclusion'] ) ) : '';
        $qcld_ilist_article_label_anchor_text     = isset($_POST['qcld_ilist_article_label_anchor_text'])   ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_label_anchor_text'] ) ) : '';
        $qcld_ilist_article_target_url            = isset($_POST['qcld_ilist_article_target_url'])          ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_target_url'] ) ) : '';
        $qcld_ilist_article_target_label_cta      = isset($_POST['qcld_ilist_article_target_label_cta'])    ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_target_label_cta'] ) ) : '';
        $qcld_ilist_article_cta_pos               = isset($_POST['qcld_ilist_article_cta_pos'])             ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_cta_pos'] ) ) : '';
        $qcld_ilist_article_label_keywords        = isset($_POST['qcld_ilist_article_label_keywords'])      ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_label_keywords'] ) ) : '';
        $qcld_ilist_article_label_word_to_avoid   = isset($_POST['qcld_ilist_article_label_word_to_avoid']) ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_label_word_to_avoid'] ) ) : '';
        $qcld_ilist_article_label_keywords_bold   = isset($_POST['qcld_ilist_article_label_keywords_bold']) ? intval( sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_label_keywords_bold'] ) ) ) : '';
        $qcld_ilist_article_heading_faq           = isset($_POST['qcld_ilist_article_heading_faq'])         ? intval( sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_heading_faq'] ) ) ) : '';

        $img_size                           = isset($_POST['qcld_ilist_article_img_size'])            ? sanitize_text_field( wp_unslash($_POST['qcld_ilist_article_img_size'] ) ) : '1024x1024';
        //$img_size = "512x512";

        if ( empty($qcld_ilist_article_language) ) {
            $qcld_ilist_article_language = "en";
        }
        // if number of heading is not set, set it to 5
        if ( empty($qcld_ilist_article_number_of_heading) ) {
            $qcld_ilist_article_number_of_heading = 2;
        }
        // if writing style is not set, set it to descriptive
        if ( empty($qcld_ilist_article_heading_style) ) {
            $qcld_ilist_article_heading_style = "infor";
        }
        // if writing tone is not set, set it to assertive
        if ( empty($qcld_ilist_article_heading_tone) ) {
            $qcld_ilist_article_heading_tone = "formal";
        }
        // if heading tag is not set, set it to h2
        if ( empty($qcld_ilist_article_heading_tag) ) {
            $qcld_ilist_article_heading_tag = "h2";
        }

        $writing_style  = apply_filters('qcld_ilist_floating_openai_filter_for_style', $qcld_ilist_article_heading_style, $qcld_ilist_article_language );
        $tone_text      = apply_filters('qcld_ilist_floating_openai_filter_for_tone', $qcld_ilist_article_heading_tone, $qcld_ilist_article_language );

        if ( $qcld_ilist_article_language == "en" ) {

            if ( $qcld_ilist_article_number_of_heading == 1 ) {
                $prompt_text = " blog topic about ";
            } else {
                $prompt_text = " blog topics about ";
            }
            
            $intro_text = "Write an introduction about ";
            $conclusion_text = "Write a conclusion about ";
            $tagline_text = "Write a tagline about ";
            $introduction = "Introduction";
            $conclusion = "Conclusion";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " questions and answers about " . $qcld_ilist_article_text . ".";
            $faq_heading = "Q&A";
            $style_text = "Writing style: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Keywords: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Exclude following keywords: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Write a Call to action about: " . $qcld_ilist_article_text . " and create a href tag link to: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "de" ) {
            $prompt_text = " blog-Themen über ";
            $intro_text = "Schreiben Sie eine Einführung über ";
            $conclusion_text = "Schreiben Sie ein Fazit über ";
            $tagline_text = "Schreiben Sie eine Tagline über ";
            $introduction = "Einführung";
            $conclusion = "Fazit";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " Fragen und Antworten über " . $qcld_ilist_article_text . ".";
            $faq_heading = "Fragen und Antworten";
            $style_text = "Schreibstil: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Schlüsselwörter: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Ausschließen folgende Schlüsselwörter: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Schreiben Sie eine Call to action über: " . $qcld_ilist_article_text . " und erstellen Sie einen href-Tag-Link zu: " . $qcld_ilist_article_target_label_cta . ".";
        } else  if ( $qcld_ilist_article_language == "fr" ) {
            $prompt_text = " sujets de blog sur ";
            $intro_text = "Écrivez une introduction sur ";
            $conclusion_text = "Écrivez une conclusion sur ";
            $tagline_text = "Rédigez un slogan sur ";
            $introduction = "Introduction";
            $conclusion = "Conclusion";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " questions et réponses sur " . $qcld_ilist_article_text . ".";
            $faq_heading = "Questions et réponses";
            $style_text = "Style d'écriture: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Mots clés: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Exclure les mots-clés suivants: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Écrivez un appel à l'action sur: " . $qcld_ilist_article_text . " et créez un lien href tag vers: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "es" ) {
            $prompt_text = " temas de blog sobre ";
            $intro_text = "Escribe una introducción sobre ";
            $conclusion_text = "Escribe una conclusión sobre ";
            $tagline_text = "Escribe una eslogan sobre ";
            $introduction = "Introducción";
            $conclusion = "Conclusión";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " preguntas y respuestas sobre " . $qcld_ilist_article_text . ".";
            $faq_heading = "Preguntas y respuestas";
            $style_text = "Estilo de escritura: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Palabras clave: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Excluir las siguientes palabras clave: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Escribe una llamada a la acción sobre: " . $qcld_ilist_article_text . " y cree un enlace de etiqueta html <a href> para: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "it" ) {
            $prompt_text = " argomenti di blog su ";
            $intro_text = "Scrivi un'introduzione su ";
            $conclusion_text = "Scrivi una conclusione su ";
            $tagline_text = "Scrivi un slogan su ";
            $introduction = "Introduzione";
            $conclusion = "Conclusione";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " domande e risposte su " . $qcld_ilist_article_text . ".";
            $faq_heading = "Domande e risposte";
            $style_text = "Stile di scrittura: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Parole chiave: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Escludere le seguenti parole chiave: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Scrivi un call to action su: " . $qcld_ilist_article_text . " e crea un href tag link a: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "pt" ) {
            $prompt_text = " tópicos de blog sobre ";
            $intro_text = "Escreva uma introdução sobre ";
            $conclusion_text = "Escreva uma conclusão sobre ";
            $tagline_text = "Escreva um slogan sobre ";
            $introduction = "Introdução";
            $conclusion = "Conclusão";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " perguntas e respostas sobre " . $qcld_ilist_article_text . ".";
            $faq_heading = "Perguntas e respostas";
            $style_text = "Estilo de escrita: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Palavras-chave: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Excluir as seguintes palavras-chave: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Escreva um call to action sobre: " . $qcld_ilist_article_text . " e crie um href tag link para: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "nl" ) {
            $prompt_text = " blogonderwerpen over ";
            $intro_text = "Schrijf een inleiding over ";
            $conclusion_text = "Schrijf een conclusie over ";
            $tagline_text = "Schrijf een slogan over ";
            $introduction = "Inleiding";
            $conclusion = "Conclusie";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " vragen en antwoorden over " . $qcld_ilist_article_text . ".";
            $faq_heading = "Vragen en antwoorden";
            $style_text = "Schrijfstijl: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Trefwoorden: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Sluit de volgende trefwoorden uit: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Schrijf een call to action over: " . $qcld_ilist_article_text . " en maak een href tag link naar: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "ru" ) {
            $prompt_text = "Перечислите ";
            $prompt_last = " идей блога о ";
            $intro_text = "Напишите введение о ";
            $conclusion_text = "Напишите заключение о ";
            $tagline_text = "Напишите слоган о ";
            $introduction = "Введение";
            $conclusion = "Заключение";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " вопросов и ответов о " . $qcld_ilist_article_text . ".";
            $faq_heading = "Вопросы и ответы";
            $style_text = "Стиль написания: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Ключевые слова: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Исключите следующие ключевые слова: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Напишите call to action о: " . $qcld_ilist_article_text . " и сделайте href tag link на: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "ja" ) {
            $prompt_text = " に関するブログのアイデアを ";
            $prompt_last = " つ挙げてください";
            $intro_text = " について紹介文を書く";
            $conclusion_text = " についての結論を書く";
            $tagline_text = " についてのスローガンを書く";
            $introduction = "序章";
            $conclusion = "結論";
            $faq_text = $qcld_ilist_article_text . " に関する " . strval( $qcld_ilist_article_number_of_heading ) . " の質問と回答.";
            $faq_heading = "よくある質問";
            $style_text = "書き方: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = $qcld_ilist_article_text . $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . ".";
            } else {
                $keyword_text = ". キーワード: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = $qcld_ilist_article_text . $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " 次のキーワードを除外します。 " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $qcld_ilist_article_text . $intro_text;
            $myconclusion = $qcld_ilist_article_text . $conclusion_text;
            $mytagline = $qcld_ilist_article_text . $tagline_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = $qcld_ilist_article_text . " についてのコール・トゥ・アクションを書き、hrefタグリンクを作成します。 " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "zh" ) {
            $prompt_text = " 关于 ";
            $of_text = " 的 ";
            $piece_text = " 个博客创意";
            $intro_text = "写一篇关于 ";
            $intro_last = " 的介绍";
            $conclusion_text = "写一篇关于 ";
            // write a tagline about
            $tagline_text = "写一个标语关于 ";
            $conclusion_last = " 的结论";
            $introduction = "介绍";
            $conclusion = "结论";
            $faq_text = $qcld_ilist_article_text . " 的 " . strval( $qcld_ilist_article_number_of_heading ) . " 个问题和答案.";
            $faq_heading = "常见问题";
            $style_text = "写作风格: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = $prompt_text . $qcld_ilist_article_text . $of_text . strval( $qcld_ilist_article_number_of_heading ) . $piece_text . ".";
            } else {
                $keyword_text = ". 关键字: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = $prompt_text . $qcld_ilist_article_text . $of_text . strval( $qcld_ilist_article_number_of_heading ) . $piece_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " 排除以下关键字：" . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text . $intro_last;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text . $conclusion_last;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // 写一个关于 123 的号召性用语并创建一个 <a href> html 标签链接到：
            $mycta = "写一个关于 " . $qcld_ilist_article_text . " 的号召性用语并创建一个 <a href> html 标签链接到： " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "ko" ) {
            $prompt_text = " 다음과 관련된 ";
            $prompt_last = "가지 블로그 아이디어: ";
            $intro_text = "블로그 토픽에 대한 소개를 작성하십시오 ";
            $conclusion_text = "블로그 토픽에 대한 결론을 작성하십시오 ";
            $introduction = "소개";
            $conclusion = "결론";
            $faq_text = $qcld_ilist_article_text . "에 대한 " . strval( $qcld_ilist_article_number_of_heading ) . "개의 질문과 답변.";
            $faq_heading = "자주 묻는 질문";
            // write a tagline about
            $tagline_text = "에 대한 태그라인 작성 ";
            $style_text = "작성 스타일: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". 키워드: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " 다음 키워드를 제외하십시오. " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $qcld_ilist_article_text . $tagline_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = $qcld_ilist_article_text . "에 대한 호출 행동을 작성하고 href 태그 링크를 만듭니다. " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "id" ) {
            $prompt_text = " topik blog tentang ";
            $intro_text = "Tulis pengantar tentang ";
            $conclusion_text = "Tulis kesimpulan tentang ";
            $introduction = "Pengantar";
            $conclusion = "Kesimpulan";
            $faq_text = strval( $qcld_ilist_article_number_of_heading ) . " pertanyaan dan jawaban tentang " . $qcld_ilist_article_text . ".";
            $faq_heading = "Pertanyaan dan jawaban";
            // write a tagline about
            $tagline_text = "Tulis tagline tentang ";
            $style_text = "Gaya penulisan: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Kata kunci: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Hindari kata kunci berikut: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = "Tulis panggilan tindakan tentang " . $qcld_ilist_article_text . " dan buat tautan tag href ke: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "tr" ) {
            $prompt_text = " hakkında ";
            $prompt_last = " blog başlığı listele.";
            $intro_text = " ile ilgili bir giriş yazısı yaz.";
            $conclusion_text = " ile ilgili bir sonuç yazısı yaz.";
            $introduction = "Giriş";
            $conclusion = "Sonuç";
            $faq_text = $qcld_ilist_article_text . " hakkında " . strval( $qcld_ilist_article_number_of_heading ) . " soru ve cevap.";
            $faq_heading = "SSS";
            // write a tagline about
            $tagline_text = " ile ilgili bir slogan yaz.";
            $style_text = "Yazı stili: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = $qcld_ilist_article_text . $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . ".";
            } else {
                $keyword_text = ". Anahtar kelimeler: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = $qcld_ilist_article_text . $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Bu anahtar kelimeleri kullanma: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $qcld_ilist_article_text . $intro_text;
            $myconclusion = $qcld_ilist_article_text . $conclusion_text;
            $mytagline = $qcld_ilist_article_text . $tagline_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = $qcld_ilist_article_text . " hakkında bir çağrıyı harekete geçir ve bir href etiketi bağlantısı oluştur: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "hi" ) {
            $prompt_text = " के बारे में ";
            $prompt_last = " ब्लॉग विषय सूचीबद्ध करें.";
            $intro_text = "का परिचय लिखिए ";
            $conclusion_text = "के बारे में निष्कर्ष लिखिए ";
            $introduction = "प्रस्तावना";
            $conclusion = "निष्कर्ष";
            $faq_text = $qcld_ilist_article_text . " के बारे में " . strval( $qcld_ilist_article_number_of_heading ) . " प्रश्न और उत्तर.";
            $faq_heading = "सामान्य प्रश्न";
            // write a tagline about
            $tagline_text = " के बारे में एक नारा लिखिए";
            $style_text = "लेखन शैली: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = $qcld_ilist_article_text . $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . ".";
            } else {
                $keyword_text = ". कीवर्ड: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = $qcld_ilist_article_text . $prompt_text . strval( $qcld_ilist_article_number_of_heading ) . $prompt_last . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " निम्नलिखित खोजशब्दों को बाहर करें: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $qcld_ilist_article_text . $tagline_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = $qcld_ilist_article_text . " के बारे में कोई कॉल एक्शन लिखें और एक href टैग लिंक बनाएं: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "pl" ) {
            $prompt_text = " tematów blogów o ";
            $intro_text = "Napisz wprowadzenie o ";
            $conclusion_text = "Napisz konkluzja o ";
            $introduction = "Wstęp";
            $conclusion = "Konkluzja";
            $faq_text = "Napisz " . strval( $qcld_ilist_article_number_of_heading ) . " pytania i odpowiedzi o " . $qcld_ilist_article_text . ".";
            $faq_heading = "Pytania i odpowiedzi";
            // write a tagline about
            $tagline_text = "Napisz slogan o ";
            $style_text = "Styl pisania: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Słowa kluczowe:: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text . ".";
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Wyklucz następujące słowa kluczowe: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            $mycta = "Napisz wezwanie do działania dotyczące " . $qcld_ilist_article_text . " i utwórz link tagu HTML <a href> do: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "uk" ) {
            $prompt_text = " теми блогів про ";
            $intro_text = "Напишіть вступ про ";
            $conclusion_text = "Напишіть висновок про ";
            $introduction = "Вступ";
            $conclusion = "Висновок";
            $faq_text = "Напишіть " . strval( $qcld_ilist_article_number_of_heading ) . " питання та відповіді про " . $qcld_ilist_article_text . ".";
            $faq_heading = "Питання та відповіді";
            // write a tagline about
            $tagline_text = "Напишіть слоган про ";
            $style_text = "Стиль письма: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Ключові слова: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Виключіть такі ключові слова: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Напишіть заклик до дії про Google і створіть посилання на тег html <a href> для:
            $mycta = "Напишіть заклик до дії про " . $qcld_ilist_article_text . " і створіть посилання на тег html <a href> для: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "ar" ) {
            $prompt_text = " موضوعات المدونات على ";
            $intro_text = "اكتب مقدمة عن: ";
            $conclusion_text = "اكتب استنتاجًا عن: ";
            $introduction = "مقدمة";
            $conclusion = "استنتاج";
            $faq_text = "اكتب " . strval( $qcld_ilist_article_number_of_heading ) . " أسئلة وأجوبة عن " . $qcld_ilist_article_text . ".";
            $faq_heading = "الأسئلة الشائعة";
            // write a tagline about اكتب شعارًا عن
            $tagline_text = " اكتب شعارًا عن ";
            $style_text = "نمط الكتابة: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". الكلمات الدالة: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " تجنب الكلمات التالية: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $qcld_ilist_article_text . $tagline_text;
            $mycta = "اكتب عبارة تحث المستخدم على اتخاذ إجراء بشأن " . $qcld_ilist_article_text . " وأنشئ <a href> رابط وسم html من أجل: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "ro" ) {
            $prompt_text = " subiecte de blog despre ";
            $intro_text = "Scrieți o introducere despre ";
            $conclusion_text = "Scrieți o concluzie despre ";
            $introduction = "Introducere";
            $conclusion = "Concluzie";
            $faq_text = "Scrieți " . strval( $qcld_ilist_article_number_of_heading ) . " întrebări și răspunsuri despre " . $qcld_ilist_article_text . ".";
            $faq_heading = "Întrebări și răspunsuri";
            // write a tagline about
            $tagline_text = "Scrieți un slogan despre ";
            $style_text = "Stilul de scriere: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Cuvinte cheie: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Evitați cuvintele: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Scrieți un îndemn despre Google și creați o etichetă html <a href> link către:
            $mycta = "Scrieți un îndemn despre " . $qcld_ilist_article_text . " și creați o etichetă html <a href> link către: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "hu" ) {
            // Írj 5 blogtémát a Google-ról
            $prompt_text = " blog témákat a következő témában: ";
            $intro_text = "Írj bevezetést ";
            $conclusion_text = "Írj következtetést ";
            $introduction = "Bevezetés";
            $conclusion = "Következtetés";
            $faq_text = "Írj " . strval( $qcld_ilist_article_number_of_heading ) . " kérdést és választ a következő témában: " . $qcld_ilist_article_text . ".";
            $faq_heading = "GYIK";
            // write a tagline about
            $tagline_text = "Írj egy tagline-t ";
            $style_text = "Írásmód: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Kulcsszavak: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Kerülje a következő szavakat: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Írjon cselekvésre ösztönzést a 123-ról, és hozzon létre egy <a href> html címke hivatkozást:
            $mycta = "Írjon cselekvésre ösztönzést a  " . $qcld_ilist_article_text . "-rol, témában, és hozzon létre egy <a href> html címke hivatkozást: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "cs" ) {
            $prompt_text = " blog témata o ";
            $intro_text = "Napi úvodní zprávy o ";
            $conclusion_text = "Napi závěrečná zpráva o ";
            $introduction = "Úvodní zpráva";
            $conclusion = "Závěrečná zpráva";
            $faq_text = "Napi " . strval( $qcld_ilist_article_number_of_heading ) . " otázky a odpovědi o " . $qcld_ilist_article_text . ".";
            $faq_heading = "Často kladené otázky";
            // write a tagline about
            $tagline_text = "Napi tagline o ";
            $style_text = "Styl psaní: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Klíčová slova: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Vyhněte se slovům: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = "Napi hovor k akci o " . $qcld_ilist_article_text . " a vytvořte href tag link na: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "el" ) {
            $prompt_text = " θέματα ιστολογίου για ";
            $intro_text = "Γράψτε μια εισαγωγή για ";
            $conclusion_text = "Γράψτε μια συμπέραση για ";
            $introduction = "Εισαγωγή";
            $conclusion = "Συμπέραση";
            $faq_text = "Γράψτε " . strval( $qcld_ilist_article_number_of_heading ) . " ερωτήσεις και απαντήσεις για " . $qcld_ilist_article_text . ".";
            $faq_heading = "Συχνές ερωτήσεις";
            // write a tagline about
            $tagline_text = "Γράψτε μια tagline για ";
            $style_text = "Στυλ συγγραφής: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Λέξεις-κλειδιά: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Αποφύγετε τις εξής λέξεις: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = "Γράψτε μια κλήση σε ενέργεια για " . $qcld_ilist_article_text . " και δημιουργήστε έναν σύνδεσμο href tag στο: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "bg" ) {
            $prompt_text = " блог теми за ";
            $intro_text = "Напишете въведение за ";
            $conclusion_text = "Напишете заключение за ";
            $introduction = "Въведение";
            $conclusion = "Заключение";
            $faq_text = "Напишете " . strval( $qcld_ilist_article_number_of_heading ) . " въпроси и отговори за " . $qcld_ilist_article_text . ".";
            $faq_heading = "Често задавани въпроси";
            // write a tagline about
            $tagline_text = "Напишете tagline за ";
            $style_text = "Стил на писане: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Ключови думи: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Избягвайте думите: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = "Напишете действие за " . $qcld_ilist_article_text . " и създайте връзка href tag към: " . $qcld_ilist_article_target_label_cta . ".";

        } else if ( $qcld_ilist_article_language == "sv" ) {
            $prompt_text = " bloggämnen om ";
            $intro_text = "Skriv en introduktion om ";
            $conclusion_text = "Skriv en slutsats om ";
            $introduction = "Introduktion";
            $conclusion = "Slutsats";
            $faq_text = "Skriv " . strval( $qcld_ilist_article_number_of_heading ) . " frågor och svar om " . $qcld_ilist_article_text . ".";
            $faq_heading = "FAQ";
            // write a tagline about
            $tagline_text = "Skriv en tagline om ";
            $style_text = "Skrivstil: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Nyckelord: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Undvik ord: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = "Skriv ett åtgärdsförslag om " . $qcld_ilist_article_text . " och skapa en href tag-länk till: " . $qcld_ilist_article_target_label_cta . ".";

        } else {
            $prompt_text = " blog topics about ";
            $intro_text = "Write an introduction about ";
            $conclusion_text = "Write a conclusion about ";
            $introduction = "Introduction";
            $conclusion = "Conclusion";
            $faq_text = "Write " . strval( $qcld_ilist_article_number_of_heading ) . " questions and answers about " . $qcld_ilist_article_text . ".";
            $faq_heading = "Q&A";
            // write a tagline about
            $tagline_text = "Write a tagline about ";
            $style_text = "Writing style: " . $writing_style . ".";
            
            if ( empty($qcld_ilist_article_label_keywords) ) {
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . ".";
            } else {
                $keyword_text = ". Keywords: " . $qcld_ilist_article_label_keywords . ".";
                $myprompt = strval( $qcld_ilist_article_number_of_heading ) . $prompt_text . $qcld_ilist_article_text . $keyword_text;
            }
            
            // if $qcld_ilist_article_label_word_to_avoid is not empty, add it to the prompt
            
            if ( !empty($qcld_ilist_article_label_word_to_avoid) ) {
                $avoid_text = " Exclude the following keywords: " . $qcld_ilist_article_label_word_to_avoid . ".";
                $myprompt = $myprompt . $avoid_text;
            }
            
            $myintro = $intro_text . $qcld_ilist_article_text;
            $myconclusion = $conclusion_text . $qcld_ilist_article_text;
            $mytagline = $tagline_text . $qcld_ilist_article_text;
            // Write a call to action about $qcld_ilist_article_text and create a href tag link to: $qcld_ilist_article_target_label_cta.
            $mycta = "Write a call to action about " . $qcld_ilist_article_text . " and create a href tag link to: " . $qcld_ilist_article_target_label_cta . ".";
            
        }



        $result_data = '';

        if(!empty($qcld_ilist_article_text)){

            $qcld_ai_settings_open_ai = get_option('qcld_ai_settings_open_ai');

            if( $ai_engines == 'gpt-3.5-turbo' || $ai_engines == 'gpt-4' || $ai_engines == 'gpt-4o' || $ai_engines == 'gpt-4o-mini' ){
                $gptkeyword = [];
                $ch = curl_init();
                $url = 'https://api.openai.com/v1/chat/completions';

                array_push($gptkeyword, array(
                           "role"       => "user",
                           "content"    =>  $myprompt
                        ));

                $post_fields = array(
                    "model"         => $ai_engines,
                    "messages"      => $gptkeyword,
                    "max_tokens"    => (int)$max_token,
                    "temperature"   => ( float ) $temperature
                );
                $header  = [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $OPENAI_API_KEY
                ];
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, wp_json_encode($post_fields));
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error: ' . curl_error($ch);
                }
                curl_close($ch);
                $complete = json_decode( $result );
                // we need to catch the error here
                
                if ( isset( $complete->error ) ) {
                    $complete = $complete->error->message;
                    // exit
                    echo  esc_html( $complete ) ;
                    exit;
                } else {
                    //$complete = $complete->choices[0]->message->content;
                    $complete = isset( $complete->choices[0]->message->content ) ? trim( $complete->choices[0]->message->content ) : '';
                }

            }else{

                $request_body = [
                    "prompt"            => $myprompt,
                    "model"             => $ai_engines,
                    "max_tokens"        => (int)$max_token,
                    "temperature"       => (float)$temperature,
                    "presence_penalty"  => (float)$ppenalty,
                    "frequency_penalty" => (float)$fpenalty,
                    "top_p"             => 1,
                    "best_of"           => 1,
                ];
                $data    = wp_json_encode($request_body);
                $url     = "https://api.openai.com/v1/completions";
                $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;

                $curl = curl_init($url);
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $headers    = array(
                   "Content-Type: application/json",
                   $apt_key ,
                );
                curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                $result     = curl_exec($curl);
                curl_close($curl);
               // $results    = json_decode($result);

               // $result_data = isset( $results->choices[0]->text ) ? trim( $results->choices[0]->text ) : '';


                $complete = json_decode( $result );
                // we need to catch the error here
                
                if ( isset( $complete->error ) ) {
                    $complete = $complete->error->message;
                    // exit
                    echo  esc_html( $complete ) ;
                    exit;
                } else {
                    //$complete = $complete->choices[0]->text;
                    $complete = isset( $complete->choices[0]->text ) ? trim( $complete->choices[0]->text ) : '';
                }

            }
        
            // trim the text
            $complete = !empty( $complete ) ? trim( $complete ) : '';
            $mylist = array();
            $mylist = preg_split( "/\r\n|\n|\r/", $complete );
            // delete 1. 2. 3. etc from beginning of the line
            $mylist = preg_replace( '/^\\d+\\.\\s/', '', $mylist );
            $allresults = "";
            $qcld_ilist_article_heading_tag = isset($_REQUEST["qcld_ilist_article_heading_tag"]) ? sanitize_text_field( $_REQUEST["qcld_ilist_article_heading_tag"] ) : '';

            $avoid_text = isset($avoid_text) ? $avoid_text : '';
            $mylist     = array_filter($mylist);
            $mylist     = array_slice($mylist, 0, (int) $qcld_ilist_article_number_of_heading );

            $allresults  = apply_filters('qcld_ilist_floating_openai_article_heading_tag', $allresults, $mylist, $myprompt, $qcld_ilist_article_heading_tag, $style_text, $tone_text, $avoid_text, $qcld_ilist_article_label_word_to_avoid );

        
            
            if ( $qcld_ilist_article_heading_intro == "1" ) {
                // we need to catch the error here

                $allresults  = apply_filters('qcld_ilist_floating_openai_article_heading_intro', $allresults, $myintro, $introduction );
            
            }
            
            // if wpai_add_faq is checked then call api with faq prompt
            
            if ( $qcld_ilist_article_heading_faq == "1" ) {
                // we need to catch the error here

                $allresults  = apply_filters('qcld_ilist_floating_openai_article_heading_faq', $allresults, $faq_text, $faq_heading );

            
            }
            
            //if myconclusion is not empty,calls the openai api
            
            if ( $qcld_ilist_article_heading_conclusion == "1" ) {

                $allresults  = apply_filters('qcld_ilist_floating_openai_article_heading_conclusion', $allresults, $myconclusion, $conclusion );

            
            }
            
            // qcld_ilist_article_heading_tagline is checked then call the openai api
            
            if ( $qcld_ilist_article_heading_tagline == "1" ) {

                $allresults  = apply_filters('qcld_ilist_floating_openai_article_heading_tagline', $allresults, $mytagline, $conclusion );

            
            }
            
            // if qcld_ilist_article_label_keywords_bold is checked then then find all keywords and bold them. keywords are separated by comma
            if ( $qcld_ilist_article_label_keywords_bold == "1" ) {
                // check to see at least one keyword is entered
                
                if ( $qcld_ilist_article_label_keywords != "" ) {
                    // split keywords by comma if there are more than one but if there is only one then it will not split
                    
                    if ( strpos( $qcld_ilist_article_label_keywords, ',' ) !== false ) {
                        $keywords = explode( ",", $qcld_ilist_article_label_keywords );
                    } else {
                        $keywords = array( $qcld_ilist_article_label_keywords );
                    }
                    
                    // loop through keywords and bold them
                    foreach ( $keywords as $keyword ) {
                        $keyword = trim( $keyword );
                        // replace keyword with bold keyword but make sure exact match is found. for example if the keyword is "the" then it should not replace "there" with "there".. capital dont matter
                        $allresults = preg_replace( '/\\b' . $keyword . '\\b/', '<strong>' . $keyword . '</strong>', $allresults );
                    }
                }
            
            }
            // if qcld_ilist_article_target_url and qcld_ilist_article_label_anchor_text is not empty then find qcld_ilist_article_label_anchor_text in the text and create a link using qcld_ilist_article_target_url
            if ( $qcld_ilist_article_target_url != "" && $qcld_ilist_article_label_anchor_text != "" ) {
                // create a link if anchor text found.. rules: 1. only for first occurance 2. exact match 3. case insensitive 4. if anchor text found inside any h1,h2,h3,h4,h5,h6, a then skip it. 5. use anchor text to create link dont replace it with existing text
                $allresults = preg_replace(
                    '/(?<!<h[1-6]><a href=")(?<!<a href=")(?<!<h[1-6]>)(?<!<h[1-6]><strong>)(?<!<strong>)(?<!<h[1-6]><em>)(?<!<em>)(?<!<h[1-6]><strong><em>)(?<!<strong><em>)(?<!<h[1-6]><em><strong>)(?<!<em><strong>)\\b' . $qcld_ilist_article_label_anchor_text . '\\b(?![^<]*<\\/a>)(?![^<]*<\\/h[1-6]>)(?![^<]*<\\/strong>)(?![^<]*<\\/em>)(?![^<]*<\\/strong><\\/em>)(?![^<]*<\\/em><\\/strong>)/i',
                    '<a href="' . $qcld_ilist_article_target_url . '">' . $qcld_ilist_article_label_anchor_text . '</a>',
                    $allresults,
                    1
                );
            }


            // if qcld_ilist_article_target_label_cta is not empty then call api to get cta text and create a link using qcld_ilist_article_target_label_cta
            
            if ( $qcld_ilist_article_target_label_cta != "" ) {


                $gptkeyword = [];

                $qcld_ai_settings_open_ai = get_option('qcld_ai_settings_open_ai');

                if( $ai_engines == 'gpt-3.5-turbo' || $ai_engines == 'gpt-4' || $ai_engines == 'gpt-4o' || $ai_engines == 'gpt-4o-mini'){
                    $ch = curl_init();
                    $url = 'https://api.openai.com/v1/chat/completions';

                    array_push($gptkeyword, array(
                               "role"       => "user",
                               "content"    =>  $mycta
                            ));

                    $post_fields = array(
                        "model"         => $ai_engines,
                        "messages"      => $gptkeyword,
                        "max_tokens"    => (int)$max_token,
                        "temperature"   => ( float ) $temperature
                    );
                    $header  = [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $OPENAI_API_KEY
                    ];
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, wp_json_encode($post_fields));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error: ' . curl_error($ch);
                    }
                    curl_close($ch);
                    //$complete = json_decode( $result );
                   // $complete = isset($complete->choices[0]->message->content) ? $complete->choices[0]->message->content : '';

                    // we need to catch the error here
                    $completecta = json_decode( $result );
                    
                    if ( isset( $completecta->error ) ) {
                        $completecta = $completecta->error->message;
                        // exit
                        echo  esc_html( $completecta ) ;
                        exit;
                    } else {
                        //$completecta = $completecta->choices[0]->message->content;
                        $completecta = isset( $completecta->choices[0]->message->content ) ? trim( $completecta->choices[0]->message->content ) : '';
                        // trim the text
                        $completecta = !empty($completecta) ? trim( $completecta ) : '';
                        // add <p> to the beginning of the text
                        $completecta = "<p>" . $completecta . "</p>"."\n";
                        
                        if ( $wpai_cta_pos == "beg" ) {
                            $allresults = preg_replace(
                                '/(<h[1-6]>)/',
                                $completecta . ' $1',
                                $allresults,
                                1
                            );
                        } else {
                            $allresults = $allresults . $completecta;
                        }
                    
                    }

                }else{

                    // call api to get cta text
                    $request_body = [
                        "prompt"            => $mycta,
                        "model"             => $ai_engines,
                        "max_tokens"        => (int)$max_token,
                        "temperature"       => (float)$temperature,
                        "presence_penalty"  => (float)$ppenalty,
                        "frequency_penalty" => (float)$fpenalty,
                        "top_p"             => 1,
                        "best_of"           => 1,
                    ];
                    $data    = wp_json_encode($request_body);
                    $url     = "https://api.openai.com/v1/completions";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;

                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);

                    // we need to catch the error here
                    $completecta = json_decode( $result );
                    
                    if ( isset( $completecta->error ) ) {
                        $completecta = $completecta->error->message;
                        // exit
                        echo  esc_html( $completecta ) ;
                        exit;
                    } else {
                        //$completecta = $completecta->choices[0]->text;
                        $completecta = isset( $completecta->choices[0]->text ) ? trim( $completecta->choices[0]->text ) : '';
                        // trim the text
                        $completecta = !empty($completecta) ? trim( $completecta ) : '';
                        // add <p> to the beginning of the text
                        $completecta = "<p>" . $completecta . "</p>"."\n";
                        
                        if ( $wpai_cta_pos == "beg" ) {
                            $allresults = preg_replace(
                                '/(<h[1-6]>)/',
                                $completecta . ' $1',
                                $allresults,
                                1
                            );
                        } else {
                            $allresults = $allresults . $completecta;
                        }
                    
                    }

                }
            
            }
            
            // if add image is checked then we should send api request to get image

            if ( $qcld_ilist_article_heading_img == "1" ) {

                $imgresult  = apply_filters('qcld_ilist_floating_openai_article_heading_img',  $qcld_ilist_article_text, $img_size );

                //var_dump( $imgresult );
                //wp_die();

                // get half of qcld_ilist_article_number_of_heading and insert image in the middle
                $half = intval( $qcld_ilist_article_number_of_heading ) / 2;
                $half = round( $half );
                $half = $half - 1;
                // use qcld_ilist_article_heading_tag to add heading tag to image
                $allresults = explode( "</" . $qcld_ilist_article_heading_tag . ">", $allresults );
                $allresults[$half] = $allresults[$half] . $imgresult;
                $allresults = implode( "</" . $qcld_ilist_article_heading_tag . ">", $allresults );
                    
                $Parsedown = new Parsedown();
                
                $allresults = !empty( $allresults ) ? $Parsedown->text( $allresults ) : $allresults;

                wp_send_json( [ 'status' => 'success', 'keywords' => $allresults ] );
                wp_die();

            } else {

                wp_send_json( [ 'status' => 'success', 'keywords' => $allresults ] );
                wp_die();
            }


        }
    
        wp_send_json( [ 'status' => 'success', 'keywords' => $result_data ] );
        wp_die();
        
        // var_dump($dataresponse);wp_die();

    }
}

add_action( 'wp_ajax_qcld_ilist_floating_openai_save_draft_post_extra', 'qcld_ilist_floating_openai_save_draft_post_callback' );
add_action( 'wp_ajax_nopriv_qcld_ilist_floating_openai_save_draft_post_extra', 'qcld_ilist_floating_openai_save_draft_post_callback' );

if ( ! function_exists( 'qcld_ilist_floating_openai_save_draft_post_callback' ) ) {
    function qcld_ilist_floating_openai_save_draft_post_callback(){

        check_ajax_referer( 'iList', 'security');

        $qcld_ilist_floating_result = array(
            'status' => 'error',
            'msg'    => 'Something went wrong',
        );
        
        if ( isset( $_POST['title'] ) && !empty($_POST['title']) && isset( $_POST['content'] ) && !empty($_POST['content']) ) {

            $qcld_ilist_floating_allowed_html_content_post = wp_kses_allowed_html( 'post' );
            $qcld_ilist_floating_title     = sanitize_text_field( wp_unslash( $_POST['title'] ) );
            $qcld_ilist_floating_content   = wp_kses( $_POST['content'], $qcld_ilist_floating_allowed_html_content_post );
            $qcld_ilist_floating_post_id   = wp_insert_post( array(
                'post_title'    => $qcld_ilist_floating_title,
                'post_content'  => $qcld_ilist_floating_content,
                ) 
            );
            
            if ( !is_wp_error( $qcld_ilist_floating_post_id ) ) {
                if ( array_key_exists( 'qcld_ilist_floating_settings', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_meta_key', $_POST['qcld_ilist_floating_settings'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_language', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_language', $_POST['qcld_ilist_floating_language'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_preview_title', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_preview_title', $_POST['qcld_ilist_floating_preview_title'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_number_of_heading', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_number_of_heading', $_POST['qcld_ilist_floating_number_of_heading'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_heading_tag', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_heading_tag', $_POST['qcld_ilist_floating_heading_tag'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_writing_style', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_writing_style', $_POST['qcld_ilist_floating_writing_style'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_writing_tone', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_writing_tone', $_POST['qcld_ilist_floating_writing_tone'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_modify_headings', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_modify_headings', $_POST['qcld_ilist_floating_modify_headings'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_add_img', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_add_img', $_POST['qcld_ilist_floating_add_img'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_add_tagline', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_add_tagline', $_POST['qcld_ilist_floating_add_tagline'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_add_intro', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_add_intro', $_POST['qcld_ilist_floating_add_intro'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_add_conclusion', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_add_conclusion', $_POST['qcld_ilist_floating_add_conclusion'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_anchor_text', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_anchor_text', $_POST['qcld_ilist_floating_anchor_text'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_target_url', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_target_url', $_POST['qcld_ilist_floating_target_url'] );
                }
                if ( array_key_exists( 'qcld_ilist_floating_generated_text', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_generated_text', $_POST['qcld_ilist_floating_generated_text'] );
                }
                // qcld_ilist_floating_cta_pos
                if ( array_key_exists( 'qcld_ilist_floating_cta_pos', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_cta_pos', $_POST['qcld_ilist_floating_cta_pos'] );
                }
                // qcld_ilist_floating_target_url_cta
                if ( array_key_exists( 'qcld_ilist_floating_target_url_cta', $_POST ) ) {
                    update_post_meta( $qcld_ilist_floating_post_id, 'qcld_ilist_floating_target_url_cta', $_POST['qcld_ilist_floating_target_url_cta'] );
                }
                $qcld_ilist_floating_result['status']  = 'success';
                $qcld_ilist_floating_result['msg']     = esc_html('Data Successfully Submitted.');
                $qcld_ilist_floating_result['id']      = $qcld_ilist_floating_post_id;
                $qcld_ilist_floating_result['post_link'] = esc_url( admin_url('edit.php') );

            }
        
        }
        
        wp_send_json( $qcld_ilist_floating_result );
    }
}


add_action( 'wp_ajax_qcld_ilist_floating_openai_keyword_rewrite_article', 'qcld_ilist_floating_openai_keyword_rewrite_article_callback' );
add_action( 'wp_ajax_nopriv_qcld_ilist_floating_openai_keyword_rewrite_article', 'qcld_ilist_floating_openai_keyword_rewrite_article_callback' );
if ( ! function_exists( 'qcld_ilist_floating_openai_keyword_rewrite_article_callback' ) ) {
    function qcld_ilist_floating_openai_keyword_rewrite_article_callback () {

        check_ajax_referer( 'iList', 'security');

        set_time_limit(600);

        $keyword        = isset( $_POST['keyword'] ) ?  $_POST['keyword'] : '';
        $OPENAI_API_KEY = get_option('sl_openai_api_key');
        $ai_engines     = get_option('sl_openai_engines');
        $max_token      = get_option('sl_openai_max_token') ? get_option('sl_openai_max_token') : 4000;
        $temperature    = get_option('sl_openai_temperature') ? get_option('sl_openai_temperature') : 0;
        $ppenalty       = get_option('sl_openai_presence_penalty');
        $fpenalty       = get_option('sl_openai_frequency_penalty');

        $datas = explode("\n",$keyword);

        $result_data = '';

        foreach( $datas as $data ) {

            if(!empty($data)){

                $prompt         = "rewrite this paragraph for a unique artical:\n\n" . $data;

                $gptkeyword = [];

                if($ai_engines == 'gpt-3.5-turbo' || $ai_engines == 'gpt-4' || $ai_engines == 'gpt-4o' || $ai_engines == 'gpt-4o-mini' ){

                    $ch = curl_init();
                    $url = 'https://api.openai.com/v1/chat/completions';

                    array_push($gptkeyword, array(
                               "role"       => "user",
                               "content"    =>  $prompt
                            ));

                    $post_fields = array(
                        "model"         => $ai_engines,
                        "messages"      => $gptkeyword,
                        "max_tokens"    => (int)$max_token,
                        "temperature"   => 0
                    );
                    $header  = [
                        'Content-Type: application/json',
                        'Authorization: Bearer ' . $OPENAI_API_KEY
                    ];
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, wp_json_encode($post_fields));
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Error: ' . curl_error($ch);
                    }
                    curl_close($ch);

                    $complete    = json_decode($result);

                    $Parsedown = new Parsedown();

                    $result_data .= isset( $complete->choices[0]->message->content ) ? $Parsedown->text( trim( $complete->choices[0]->message->content ) ) : '';


                }else{

                    $request_body = [
                        "prompt"            => $prompt,
                        "model"             =>  $ai_engines,
                        "max_tokens"        => (int)$max_token,
                        "temperature"       => (float)$temperature,
                        "presence_penalty"  => (float)$ppenalty,
                        "frequency_penalty" => (float)$fpenalty,
                    ];
                    $data    = wp_json_encode($request_body);
                    $url     = "https://api.openai.com/v1/completions";
                    $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;

                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_POST, true);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $headers    = array(
                       "Content-Type: application/json",
                       $apt_key ,
                    );
                    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                    $result     = curl_exec($curl);
                    curl_close($curl);
                    $results    = json_decode($result);
                    
                    $Parsedown = new Parsedown();

                    $result_data .= isset( $results->choices[0]->text ) ? $Parsedown->text( trim( $results->choices[0]->text ) ) : '';

                }

            }

        }

    
        wp_send_json( [ 'status' => 'success', 'keywords' => $result_data ] );
        wp_die();

    }
}



add_action( 'wp_ajax_qcld_ilist_floating_openai_qcld_ilist_content_generator_by_ajax', 'qcld_ilist_floating_openai_qcld_ilist_content_generator_by_ajax_callback' );
add_action( 'wp_ajax_nopriv_qcld_ilist_floating_openai_qcld_ilist_content_generator_by_ajax', 'qcld_ilist_floating_openai_qcld_ilist_content_generator_by_ajax_callback' );
if ( ! function_exists( 'qcld_ilist_floating_openai_qcld_ilist_content_generator_by_ajax_callback' ) ) {
    function qcld_ilist_floating_openai_qcld_ilist_content_generator_by_ajax_callback(){


        check_ajax_referer( 'iList', 'security');

        $qcld_ilist_floating_result = array(
            'status' => 'error',
            'msg'    => 'Something went wrong',
        );

        if(isset($_REQUEST['title']) && !empty($_REQUEST['title'])) {
            $qcld_ilist_floating_prompt = sanitize_text_field(wp_unslash($_REQUEST['title']));

            $OPENAI_API_KEY = get_option('sl_openai_api_key');
            $ai_engines     = get_option('sl_openai_engines');
            $max_token      = get_option('sl_openai_max_token') ? get_option('sl_openai_max_token') : 4000;
            $temperature    = get_option('sl_openai_temperature') ? get_option('sl_openai_temperature') : 0;
            $ppenalty       = get_option('sl_openai_presence_penalty');
            $fpenalty       = get_option('sl_openai_frequency_penalty');

            if ( isset( $qcld_ilist_floating_prompt ) && !empty( $qcld_ilist_floating_prompt ) ) {

                    $gptkeyword = [];
                    if($ai_engines == 'gpt-3.5-turbo' || $ai_engines == 'gpt-4' || $ai_engines == 'gpt-4o' || $ai_engines == 'gpt-4o-mini'){
                        $ch = curl_init();
                        $url = 'https://api.openai.com/v1/chat/completions';

                        array_push($gptkeyword, array(
                                   "role"       => "user",
                                   "content"    =>  $qcld_ilist_floating_prompt
                                ));

                        $post_fields = array(
                            "model"         => $ai_engines,
                            "messages"      => $gptkeyword,
                            "max_tokens"    => (int)$max_token,
                            "temperature"   => ( float ) $temperature
                        );
                        $header  = [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $OPENAI_API_KEY
                        ];
                        curl_setopt($ch, CURLOPT_URL, $url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, wp_json_encode($post_fields));
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                        $result = curl_exec($ch);
                        if (curl_errno($ch)) {
                            echo 'Error: ' . curl_error($ch);
                        }
                        curl_close($ch);


                        $complete    = json_decode($result);

                        if ( isset( $complete->error ) ) {
                            $qcld_ilist_floating_result['msg'] = esc_html( trim( $complete->error->message ) );
                        } else {
                            $qcld_ilist_floating_result['data']    = $complete->choices[0]->message->content;
                            $qcld_ilist_floating_result['status']  = 'success';
                        }

                        //return $qcld_ilist_floating_result;

                        wp_send_json( $qcld_ilist_floating_result );

                        /*  
                        echo $result;
                        echo PHP_EOL;
                        ob_flush();
                        flush();
                        return strlen($result);
                        */

                    }else{

                        $ai_engines = 'text-davinci-003';
                        $request_body = [
                            "prompt"            => $qcld_ilist_floating_prompt,
                            "model"             =>  $ai_engines,
                            "max_tokens"        => (int)$max_token,
                            "temperature"       => (float)$temperature,
                            "presence_penalty"  => (float)$ppenalty,
                            "frequency_penalty" => (float)$fpenalty,
                            "stream"            => true,
                        ];
                        
                        $data    = wp_json_encode($request_body);
                        $url     = "https://api.openai.com/v1/completions";
                        $apt_key = "Authorization: Bearer ". $OPENAI_API_KEY;

                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_URL, $url);
                        curl_setopt($curl, CURLOPT_POST, true);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        $headers    = array(
                           "Content-Type: application/json",
                           $apt_key,
                        );
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                        $result     = curl_exec($curl);
                        curl_close($curl);

                        //return $qcld_ilist_floating_result;
                        $complete    = json_decode($result);

                        if ( isset( $complete->error ) ) {
                            $qcld_ilist_floating_result['msg'] = esc_html( trim( $complete->error->message ) );
                        } else {
                            $qcld_ilist_floating_result['data'] = $complete->choices[0]->text;
                            $qcld_ilist_floating_result['status'] = 'success';
                        }

                        wp_send_json( $qcld_ilist_floating_result );

                       /* echo $result;
                        echo PHP_EOL;
                        ob_flush();
                        flush();
                        return strlen($result);*/

                    }

            
            }


        }
    }

}