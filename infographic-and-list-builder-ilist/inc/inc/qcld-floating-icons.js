(function ($){
    'use strict';

    $( document ).ready(function() {


        $(document).on('click','#qcld_ilist_content_generator', function(){

            //console.log('working');
            $('#qcld_ilist_content_generator_modal').modal( { backdrop: 'static', keyboard: false  }, 'show');
            jQuery('#qcld_ilist_content_generator_modal').modal('show')
            
        });


        $(document).on('click','#qcld_ilist_floating_openai_keyword_suggestion', function(){
            var qcld_keyword_suggestion         = $('#qcld_ilist_floating_openai_keyword_suggestion_mf').val();
            var qcld_keyword_number             = $('#qcld_keyword_number').val();
            var qcld_ilist_article_language           = $('#qcld_ilist_article_language').val();
            var qcld_ilist_article_number_of_heading  = $('#qcld_ilist_article_number_of_heading').val();
            var qcld_ilist_article_heading_tag        = $('#qcld_ilist_article_heading_tag').val();
            var qcld_ilist_article_heading_style      = $('#qcld_ilist_article_heading_style').val();
            var qcld_ilist_article_heading_tone       = $('#qcld_ilist_article_heading_tone').val();
            var qcld_ilist_article_heading_img        = $('#qcld_ilist_article_heading_img').val();
            var qcld_ilist_article_heading_img        = $("input[name=qcld_ilist_article_heading_img]:checked").val();
            var qcld_ilist_article_heading_tagline    = $("input[name=qcld_ilist_article_heading_tagline]:checked").val();
            var qcld_ilist_article_heading_intro      = $("input[name=qcld_ilist_article_heading_intro]:checked").val();
            var qcld_ilist_article_heading_conclusion = $("input[name=qcld_ilist_article_heading_conclusion]:checked").val();
            var qcld_ilist_article_label_anchor_text  = $('#qcld_ilist_article_label_anchor_text').val();
            var qcld_ilist_article_target_url         = $('#qcld_ilist_article_target_url').val();
            var qcld_ilist_article_target_label_cta   = $('#qcld_ilist_article_target_label_cta').val();
            var qcld_ilist_article_cta_pos            = $('#qcld_ilist_article_cta_pos').val();
            var qcld_ilist_article_label_keywords     = $('#qcld_ilist_article_label_keywords').val();
            var qcld_ilist_article_label_word_to_avoid= $('#qcld_ilist_article_label_word_to_avoid').val();
            var qcld_ilist_article_label_keywords_bold= $("input[name=qcld_ilist_article_label_keywords_bold]:checked").val();
            var qcld_ilist_article_heading_faq        = $("input[name=qcld_ilist_article_heading_faq]:checked").val();
            var qcld_ilist_article_img_size           = $('#qcld_ilist_article_img_size').val();

            $('#qcld_ilist_floating_openai_keyword_suggestion').addClass('spinning');
            $('#qcld_ilist_floating_openai_keyword_suggestion').prop("disabled",true);
            $('#qcld_ilist_floating_bait_article_keyword_data').hide();
            $('.qcld_seo-playground-buttons').hide();

            $.ajax({
              url: qcld_ilist_floating_ajaxurl,
              method: 'POST',
              data: {
                  'action': 'qcld_ilist_floating_openai_keyword_suggestion_content_function',
                  'keyword'                         : qcld_keyword_suggestion,
                  'keyword_number'                  : qcld_keyword_number,
                  'qcld_ilist_article_language'           : qcld_ilist_article_language,
                  'qcld_ilist_article_number_of_heading'  : qcld_ilist_article_number_of_heading,
                  'qcld_ilist_article_heading_tag'        : qcld_ilist_article_heading_tag,
                  'qcld_ilist_article_heading_style'      : qcld_ilist_article_heading_style,
                  'qcld_ilist_article_heading_tone'       : qcld_ilist_article_heading_tone,
                  'qcld_ilist_article_heading_img'        : qcld_ilist_article_heading_img,
                  'qcld_ilist_article_heading_tagline'    : qcld_ilist_article_heading_tagline,
                  'qcld_ilist_article_heading_intro'      : qcld_ilist_article_heading_intro,
                  'qcld_ilist_article_heading_conclusion' : qcld_ilist_article_heading_conclusion,
                  'qcld_ilist_article_label_anchor_text'  : qcld_ilist_article_label_anchor_text,
                  'qcld_ilist_article_target_url'         : qcld_ilist_article_target_url,
                  'qcld_ilist_article_target_label_cta'   : qcld_ilist_article_target_label_cta,
                  'qcld_ilist_article_cta_pos'            : qcld_ilist_article_cta_pos,
                  'qcld_ilist_article_label_keywords'     : qcld_ilist_article_label_keywords,
                  'qcld_ilist_article_label_word_to_avoid': qcld_ilist_article_label_word_to_avoid,
                  'qcld_ilist_article_label_keywords_bold': qcld_ilist_article_label_keywords_bold,
                  'qcld_ilist_article_heading_faq'        : qcld_ilist_article_heading_faq,
                  'qcld_ilist_article_img_size'           : qcld_ilist_article_img_size,
                  'security'                        : qcld_ilist_floating_ajax_nonce
                  //'selectedlanguage': selectedlanguage,
              },
              dataType: 'json',
              success: function(response) {
                //$('#qcld_ilist_floating_bait_keyword_data').append(response.keywords);
                $('#qcld_ilist_floating_openai_keyword_suggestion').prop("disabled",false);
                $('#qcld_ilist_floating_openai_keyword_suggestion').removeClass('spinning');
                $('.qcld_seo-playground-buttons').show();
                //$('#qcld_ilist_floating_bait_article_keyword_data').html('<div class="qcld_copied-content-wrap"><div class="qcld_copied-content_text btn d-none link-success">Copied</div><a class="btn btn-sm btn-secondary qcld-copied-content_text"><span class="dashicons dashicons-admin-page"></span></a></div><textarea id="qcld_ilist_floating_content_result_msg">' + response.keywords +'</textarea>');
                //$('#qcld_ilist_floating_bait_article_keyword_data').append('<div class="qcld_ilist_floating_content_result_wrap"><div class="qcld_ilist_floating_rewrite_result_count">' + response.keywords.length +'</div></div>');
                        // qcld_ilist_floating_content_result_msg
                $('#qcld_ilist_floating_content_result_msg').focus();
                $('#qcld_ilist_floating_content_result_msg').focusout();
                $('#qcld_ilist_floating_bait_article_keyword_data').show();
                $('#qcld_ilist_floating_content_rewrite_result').show();
                $('.qcld_ilist_floating_bait_single_field .qcld_ilist_floating_rewrite_result_count').text( response.keywords.length );
                var editor = tinyMCE.get('qcld_ilist_floating_content_result_msg');
                var basicEditor = true;
                if ( $('#wp-qcld_ilist_floating_content_result_msg-wrap').hasClass('tmce-active') && editor ) {
                    basicEditor = false;
                }
                if(basicEditor){
                    $('#qcld_ilist_floating_content_result_msg').val( response.keywords );
                }else{
                    editor.setContent( response.keywords );
                }
              }
            });

        });


        $(document).on('click', '.qcld_ilist_floating_openai_article_save', function (e) {
            var qcld_ilist_floating_draft_btn = $(this);
            var title = $('#qcld_ilist_floating_openai_keyword_suggestion_mf').val();
            var content = $('#qcld_ilist_floating_content_result_msg').val();

            var editor = tinyMCE.get('qcld_ilist_floating_content_result_msg');
            var basicEditor = true;
            if ( $('#wp-qcld_ilist_floating_content_result_msg-wrap').hasClass('tmce-active') && editor ) {
                basicEditor = false;
            }

            if(!basicEditor){
                var content = editor.getContent();

            }

            if(title === ''){
                alert('Please enter title');
            }else if(content === ''){
                alert('Please wait content generated');
            }else{
                $.ajax({
                    url: qcld_ilist_floating_ajaxurl,
                    data: {title: title, content: content, action: 'qcld_ilist_floating_openai_save_draft_post_extra', security: qcld_ilist_floating_ajax_nonce },
                    dataType: 'json',
                    type: 'POST',
                    beforeSend: function (){
                        qcld_ilist_floating_draft_btn.attr('disabled','disabled');
                        qcld_ilist_floating_draft_btn.append('<span class="spinner"></span>');
                        qcld_ilist_floating_draft_btn.find('.spinner').css('visibility','unset');
                    },
                    success: function (res){
                        qcld_ilist_floating_draft_btn.removeAttr('disabled');
                        qcld_ilist_floating_draft_btn.find('.spinner').remove();
                        if(res.status === 'success'){
                            window.location.replace( res.post_link );
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (){
                        qcld_ilist_floating_draft_btn.removeAttr('disabled');
                        qcld_ilist_floating_draft_btn.find('.spinner').remove();
                        alert('Something went wrong');
                    }
                });
            }
        });

        $(document).on('click','#qcld_ilist_floating_openai_keyword_rewrite_article',function(event){
            var qcld_ilist_floating_content_rewrite = $('#qcld_ilist_floating_content_rewrite').val();
            $('#qcld_ilist_floating_openai_keyword_rewrite_article').addClass('spinning');
            $('#qcld_ilist_floating_content_rewrite_result').hide();
            $.ajax({
              url: qcld_ilist_floating_ajaxurl,
              method: 'POST',
              data: {
                  'action': 'qcld_ilist_floating_openai_keyword_rewrite_article',
                  'security': qcld_ilist_floating_ajax_nonce,
                  'keyword': qcld_ilist_floating_content_rewrite,
              },
              dataType: 'json',
              success: function(response) {
                //$('#qcld_ilist_floating_content_rewrite_result').html('<div class="qcld_copied-content-wrap"><div class="qcld_copied-content btn d-none link-success">Copied</div><a class="btn btn-sm btn-secondary qcld-copied-content"><span class="dashicons dashicons-admin-page"></span></a></div><textarea id="qcld_ilist_floating_content_rewrite_result_msg">' + response.keywords +'</textarea>');
                //$('#qcld_ilist_floating_content_rewrite_result').append('<div class="qcld_ilist_floating_rewrite_result_count_wrap"><div class="qcld_ilist_floating_rewrite_result_count">' + response.keywords.length +'</div></div>');
                $('#qcld_ilist_floating_content_rewrite_result').show();
                var editor = tinyMCE.get('qcld_ilist_floating_content_rewrite_result_msg');
                var basicEditor = true;
                if ( $('#wp-qcld_ilist_floating_content_rewrite_result_msg-wrap').hasClass('tmce-active') && editor ) {
                    basicEditor = false;
                }
                if(basicEditor){
                    $('#qcld_ilist_floating_content_rewrite_result_msg').val( response.keywords );
                }else{
                    editor.setContent( response.keywords );
                }
                var words = $.trim(response.keywords).split(" ");
                //console.log(words.length)
                $('.qcld_ilist_floating_rewrite_result_count_wrap .qcld_ilist_floating_rewrite_result_count').text( words.length );
                $('#qcld_ilist_floating_content_rewrite_result_msg').focus();
                $('#qcld_ilist_floating_content_rewrite_result_msg').focusout();
                $('#qcld_ilist_floating_openai_keyword_rewrite_article').removeClass('spinning');
              }
            });
          

        });

        $(document).on('click', '.qcld_ilist_floating_openai_article_clear', function (e) {

            $('#qcld_ilist_floating_openai_keyword_suggestion_mf').val('');
            $('#qcld_ilist_floating_content_result_msg').val('');
            $('.qcld_seo-playground-buttons').hide();
            $('.qcld_ilist_floating_rewrite_result_count').hide();

        });

        $(document).on('keyup focusout','#qcld_ilist_floating_content_rewrite',function(event){
            var currentDom = $(this);
            $('.qcld_ilist_floating_content_rewrite_count').remove();
            var words = $.trim(currentDom.val()).split(" ");
            $('.qcld_ilist_floating_content_rewrite_count_wrap').html('<span class="qcld_ilist_floating_content_rewrite_count">'+words.length+'</span>');
        });

        $(document).on('keyup focusout','#qcld_ilist_floating_content_rewrite_result_msg',function(event){
            var currentDomss = $(this);
            var editor = tinyMCE.get('qcld_ilist_floating_content_rewrite_result_msg');
            var basicEditor = true;
            if ( $('#wp-qcld_ilist_floating_content_rewrite_result_msg-wrap').hasClass('tmce-active') && editor ) {
                basicEditor = false;
            }
            if(basicEditor){
                var wordsss = $.trim(currentDomss.val()).split(" ");
            }else{
                var datasssss = editor.setContent( );
                var wordsss = $.trim(datasssss).split(" ");
            }
            $('.qcld_ilist_floating_rewrite_result_count_wrap .qcld_ilist_floating_rewrite_result_count').text(wordsss.length);
        });

        $(document).on('keyup focusout','#qcld_ilist_floating_content_result_msg',function(event){
            var currentDoms = $(this);
            var wordss = $.trim(currentDoms.val()).split(" ");
            $('.qcld_ilist_floating_bait_single_field .qcld_ilist_floating_rewrite_result_count').text(wordss.length);
        });

        $(document).on('click','.qcld-copied-content',function(event){
            var currentDom = $(this);
            var copy_con = $('#qcld_ilist_floating_content_rewrite_result_msg').val();

            var editor = tinyMCE.get('qcld_ilist_floating_content_rewrite_result_msg');
            var basicEditor = true;
            if ( $('#wp-qcld_ilist_floating_content_rewrite_result_msg-wrap').hasClass('tmce-active') && editor ) {
                basicEditor = false;
            }

            if(!basicEditor){
                var copy_con = editor.getContent();

            }
            

            $(this).addClass("qcld_copied");

            $(".qcld_copied-content").removeClass("d-none");
            setTimeout(() => {
                $(".qcld_copied-content").addClass("d-none");
            }, 1500);
            var $temp = $("<input>");
            //$("body").append($temp);
            currentDom.append($temp);
            $temp.val( copy_con ).select();
            document.execCommand("copy");
            $temp.remove();

        });
        $(document).on('click','.qcld-copied-content_text',function(event){
            var currentDom = $(this);
            var copy_con = currentDom.parent().parent().parent().find('#qcld_ilist_floating_content_result_msg').val();
            var copy_text = (copy_con !== '') ? copy_con : currentDom.parent().parent().parent().find('#qcld_ilist_floating_content_result_msg').text();

            var editor = tinyMCE.get('qcld_ilist_floating_content_result_msg');
            var basicEditor = true;
            if ( $('#wp-qcld_ilist_floating_content_result_msg-wrap').hasClass('tmce-active') && editor ) {
                basicEditor = false;
            }

            if(!basicEditor){
                var copy_text = editor.getContent();
            }

            currentDom.addClass("qcld_copied");

            currentDom.parent().find(".qcld_copied-content_text").removeClass("d-none");
            setTimeout(() => {
            currentDom.parent().find(".qcld_copied-content_text").addClass("d-none");
            }, 1500);

            var $temp = $("<input>");
            currentDom.append($temp);
            $temp.val( copy_text ).select();
            document.execCommand("copy");
            $temp.remove();

        });

        var qcld_ilist_floating_generator_working = false;
        var eventGenerator = false;
        var qcld_ilist_floating_limitLines = 5;
        function qcld_stopOpenAIGenerator(){
            $('.qcld_seo-playground-buttons').show();
            $('.qcld_ilist_floating_openai_generator_stop').hide();
            qcld_ilist_floating_generator_working = false;
            $('.qcld_ilist_floating_generator_button .spinner').hide();
            $('.qcld_ilist_floating_generator_button').removeAttr('disabled');
            //eventGenerator.close();
        }
        $(document).on('click', '.qcld_ilist_floating_openai_generator_stop', function (e) {
            qcld_stopOpenAIGenerator();
        });

        $(document).on('click', '.qcld_ilist_floating_openai_generator_button', function (e) {
            var btn = $(this);
            var title = $('.qcld_ilist_floating_prompt').val();
            if( title !== '' ) {
                var count_line = 0;
                var qcld_ilist_floating_generator_result = $('.qcld_ilist_floating_generator_result');
                qcld_ilist_floating_generator_result.val('');
                $('.qcld_ilist_floating_openai_generator_stop').show();
                $('.qcld_seo-playground-buttons').hide();
                $('.qcld_ilist_floating_openai_generator_button').addClass('spinning');

                var editor = tinyMCE.get('qcld_ilist_floating_generator_result');
                var basicEditor = true;
                if ( $('#wp-qcld_ilist_floating_generator_result-wrap').hasClass('tmce-active') && editor ) {
                    basicEditor = false;
                }
                var qcld_ilist_floating_currentContent_Text = '';
                //console.log( eventGenerator );

                $.ajax({
                    url: qcld_ilist_floating_ajaxurl,
                    data: { title: title, action: 'qcld_ilist_floating_openai_qcld_ilist_content_generator_by_ajax', security: qcld_ilist_floating_ajax_nonce },
                    dataType: 'json',
                    type: 'POST',
                    beforeSend: function (){
                        btn.attr('disabled','disabled');
                        btn.find('.spinner').show();
                        btn.find('.spinner').css('visibility','unset');
                    },
                    success: function (res){
                        btn.removeAttr('disabled');
                        $('.qcld_ilist_floating_openai_generator_stop').hide();
                        $('.qcld_ilist_floating_openai_generator_button').removeClass('spinning');
                        //console.log( res)
                        if(res.status === 'success'){
                            //window.location.href;
                            $('.qcld_seo-playground-buttons').show();
                            if(basicEditor){
                                qcld_ilist_floating_currentContent_Text = $('#qcld_ilist_floating_generator_result').val();
                            }else{
                                qcld_ilist_floating_currentContent_Text = editor.getContent();
                                qcld_ilist_floating_currentContent_Text = qcld_ilist_floating_currentContent_Text.replace(/<\/?p(>|$)/g, "");
                            }
                            if(e.data === "[DONE]"){
                                count_line += 1;
                                if(basicEditor) {

                                    $('#qcld_ilist_floating_generator_result').val( qcld_ilist_floating_currentContent_Text + '<br><br>' );

                                }else{

                                    editor.setContent( qcld_ilist_floating_currentContent_Text + '<br><br>' );

                                }
                            } else{
                               

                                if(basicEditor){
                                    
                                    if(res.title){
                                        $('.qcld_ilist_floating_prompt').val( res.title );
                                    }
                                    $('#qcld_ilist_floating_generator_result').val( res.data );

                                }else{
                                    if(res.title){
                                        $('.qcld_ilist_floating_prompt').val( res.title );
                                    }
                                    editor.setContent(qcld_ilist_floating_currentContent_Text+  res.data );

                                }


                            }
                            
                            if(count_line === qcld_ilist_floating_limitLines){
                                qcld_stopOpenAIGenerator();
                            }




                        }else{
                            alert(res.msg);
                        }
                    },
                    error: function (){
                        btn.removeAttr('disabled');
                        btn.find('.spinner').remove();
                        $('.qcld_ilist_floating_openai_generator_stop').hide();
                        alert('Something went wrong');
                    }
                });

            }
        });
    
        $(document).on('click', '.qcld_ilist_floating_openai_playground_save', function (e) {
            var qcld_ilist_floating_draft_btn = $(this);
            var title = $('.qcld_ilist_floating_prompt').val();
            var editor = tinyMCE.get('qcld_ilist_floating_generator_result');
            var basicEditor = true;
            if ( $('#wp-qcld_ilist_floating_generator_result-wrap').hasClass('tmce-active') && editor ) {
                basicEditor = false;
            }
            var content = '';
            if (basicEditor){
                content = $('#qcld_ilist_floating_generator_result').val();
            }else{
                content = editor.getContent();
            }
            if(title === ''){
                alert('Please enter title');
            }
            else if(content === ''){
                alert('Please wait content generated');
            }
            else{
                $.ajax({
                    url: ajaxurl,
                    data: {title: title, content: content, action: 'qcld_ilist_floating_openai_save_draft_post_extra', security: qcld_ilist_floating_ajax_nonce },
                    dataType: 'json',
                    type: 'POST',
                    beforeSend: function (){
                        qcld_ilist_floating_draft_btn.attr('disabled','disabled');
                        qcld_ilist_floating_draft_btn.append('<span class="spinner"></span>');
                        qcld_ilist_floating_draft_btn.find('.spinner').css('visibility','unset');
                    },
                    success: function (res){
                        qcld_ilist_floating_draft_btn.removeAttr('disabled');
                        qcld_ilist_floating_draft_btn.find('.spinner').remove();
                        if(res.status === 'success'){
                            //window.location.href;
                            window.location.replace( res.post_link );
                        }
                        else{
                            alert(res.msg);
                        }
                    },
                    error: function (){
                        qcld_ilist_floating_draft_btn.removeAttr('disabled');
                        qcld_ilist_floating_draft_btn.find('.spinner').remove();
                        alert('Something went wrong');
                    }
                });
            }
        });
        $(document).on('click', '.qcld_ilist_floating_openai_playground_clear', function (e) {

            $('.qcld_ilist_floating_prompt').val('');
            var editor = tinyMCE.get('qcld_ilist_floating_generator_result');
            var basicEditor = true;
            if ( $('#wp-qcld_ilist_floating_generator_result-wrap').hasClass('tmce-active') && editor ) {
                basicEditor = false;
            }
            if(basicEditor){
                $('#qcld_ilist_floating_generator_result').val('');
            }
            else{
                editor.setContent('');
            }
        });

    });

})(jQuery)