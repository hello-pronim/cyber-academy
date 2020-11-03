(function ($) {
    'use strict';

    /**
     * All of the code for your admin-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(document).ready(function () {
        $(document).on("input", 'input', function (e) {
            if (e.keyCode == 13) {
                return false;
            }
        });
        $(document).on("keydown", function (e) {
            if (e.target.nodeName == "TEXTAREA") {
                return true;
            }
            if (e.keyCode == 13) {
                return false;
            }
        });

        let $_navTabs = $(document).find('.nav-tab'),
            $_navTabContent = $(document).find('.nav-tab-content');
        $(document).find('#sccp_post_types').select2();
        $(document).find('#sccp_post_types_1').select2();
        $(document).find('#sccp_post_types_2').select2();
        $('[id^=ays_users_roles_]').select2();        

        $_navTabs.on('click', function (e) {
            e.preventDefault();
            let active_tab = $(this).attr('data-tab');
            $_navTabs.each(function () {
                $(this).removeClass('nav-tab-active');
            });
            $_navTabContent.each(function () {
                $(this).removeClass('nav-tab-content-active');
            });
            $(this).addClass('nav-tab-active');
            $(document).find('.nav-tab-content' + $(this).attr('href')).addClass('nav-tab-content-active');
            $(document).find("[name='sccp_tab']").val(active_tab);
        });

        $(document).find('#blocked_ips').DataTable();

        $('[data-toggle="tooltip"]').tooltip();

        $(function() {  
            $('.ays_all').click(function() {
                var ays_all_checkboxes = $(this).closest('#tab2').find('.modern-checkbox-options');
                if($(this).is(':checked')) {
                    ays_all_checkboxes.attr('checked', 'checked');
                } else {
                    ays_all_checkboxes.removeAttr('checked');
                    $('.ays_all_mess').removeAttr('checked');
                    $('.ays_all_audio').removeAttr('checked');
                }
                ays_all_checkboxes.trigger("change");

            });
        });

        $(function() {  
            $('.ays_all_mess').click(function() {
                var ays_all_mess_checkboxes = $(this).closest('#tab2').find('.modern_checkbox_mess').not(':disabled');
                if($(this).is(':checked')) {
                    ays_all_mess_checkboxes.attr('checked', 'checked');
                } else {
                    ays_all_mess_checkboxes.removeAttr('checked');
                }
            });
        });

        $(function() {  
            $('.ays_all_audio').click(function() {
                var ays_all_audio_checkboxes = $(this).closest('#tab2').find('.modern_checkbox_audio').not(':disabled');
                if($(this).is(':checked')) {
                    ays_all_audio_checkboxes.attr('checked', 'checked');
                } else {
                    ays_all_audio_checkboxes.removeAttr('checked');
                }
            });
        });

        var checkbox = $('.modern-checkbox-options');
        for (var i = 0; i < checkbox.length; i++) {

            var classname = checkbox[i].className.split(' ');
            if (checkbox[i].checked == true) {
                $('.' + classname[1] + '-mess').attr('disabled', false);
                $('.' + classname[1] + '-audio').attr('disabled', false);
            } else {
                $('.' + classname[1] + '-mess').attr('disabled', true);
                $('.' + classname[1] + '-audio').attr('disabled', true);
            }
        }
        checkbox.change(function () {

            var classname = this.className.split(' ');            
            if (this.checked == true) {
                $('.' + classname[1] + '-mess').attr('disabled', false);
                $('.' + classname[1] + '-audio').attr('disabled', false);
            } else {
                $('.' + classname[1] + '-mess').attr('checked', false);
                $('.' + classname[1] + '-mess').attr('disabled', true);
                $('.' + classname[1] + '-audio').attr('checked', false);
                $('.' + classname[1] + '-audio').attr('disabled', true);
            }

        });

        $(document).on('click', '.upload_audio', function (e) {
            openSCCPMusicMediaUploader(e, $(this));
        });        


        //--------------preview
        
        $('#reset_to_default').on('click', function () {
            setTimeout(function(){
                if($(document).find('#sccp_custom_css').length > 0){
                    if(wp.codeEditor){
                        $(document).find('#sccp_custom_css').next('.CodeMirror').remove();
                        $(document).find('#sccp_custom_css').val('');
                        wp.codeEditor.initialize($(document).find('#sccp_custom_css'), cm_settings);
                    }
                }
            }, 100);

             $('#ays_tooltip').css({
                "background-image": "unset", 
                "padding": "5", 
                "opacity": "1"
            });

            $('#bg_color').val('#ffffff').change();
            $('#text_color').val('#ff0000').change();
            $('#border_color').val('#b7b7b7').change();
            $('#boxshadow_color').val('rgba(0,0,0,0)').change();
            $('#ays-sccp-bg-img').attr('src', '').change();
            $('input#ays_sccp_bg_image').val('');
            $('#sccp_bg_image_container').hide().change();
            $('#sccp_bg_image').show().change();
            $('.sccp_opacity_demo_val').val(1);
            $('#font_size').val(12).change();
            $('#border_width').val(1).change();
            $('#border_radius').val(3).change();
            $('#border_style').val('solid').change();
            $('#tooltip_position').val('mouse').change();
            $('#ays_sccp_custom_class').val('');
            $('#sscp_timeout').val(1000);
            $('#ays_tooltip_padding').val(5);
        });
        
        $(document).on('input', '.sccp_opacity_demo_val', function(){
            $(document).find('#ays_tooltip').css('opacity', $(this).val());
        });

        $('#bg_color').wpColorPicker({
            defaultColor: '#ffffff',
            change(event, ui) {
                $('#ays_tooltip').css('background-color', ui.color.toString())
            }
        });
        $('#text_color').wpColorPicker({
            defaultColor: '#ff0000',
            change(event, ui) {
                $('#ays_tooltip, #ays_tooltip>*').css('color', ui.color.toString())
            }
        });
        $('#border_color').wpColorPicker({
            defaultColor: '#b7b7b7',
            change(event, ui) {
                $('#ays_tooltip').css('border-color', ui.color.toString())
            }
        });
        $('#boxshadow_color').wpColorPicker({
            defaultColor: 'rgba(0,0,0,0)',
            change(event, ui) {
                $('#ays_tooltip').css('box-shadow', ui.color.toString()+" 0px 0px 15px 1px");
            }
        });
        $('#font_size').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip, #ays_tooltip>*').css('font-size', val + 'px')
        });
        $('#border_width').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('border-width', val + 'px')
        });
        $('#border_radius').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('border-radius', val + 'px')
        });
        $('#border_style').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('border-style', val)
        });
        $('#ays_tooltip_padding').on('change', function () {
            let val = $(this).val();
            $('#ays_tooltip').css('padding', val)
        });

        $('#ays_tooltip').children().css('font-size', $('#font_size').val() + 'px');
        $('#ays_tooltip').children().css('margin', "0");


        //----------end preview

        function openSCCPMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload',
                button: {
                    text: 'Upload'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                $('.sccp_upload_audio').html('<audio id="sccp_audio" controls><source src="' + attachment.url + '" type="audio/mpeg"></audio>');                
                $('.upload_audio_url').val(attachment.url);
            }).open();

            return false;
        }

        function openSCCPMusicMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload music',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'audio'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                $('.sccp_upload_audio').html('<audio id="sccp_audio" controls><source src="' + attachment.url + '" type="audio/mpeg"></audio><button type="button" class="close ays_close" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
                $('.sccp_upload_audio').show();
                $('.upload_audio_url').val(attachment.url);
            }).open();
            return false;
        }

        $(document).on('click', '.ays_close', function () {
            $('#sccp_audio').trigger('pause'); // Stop playing        
            $('.sccp_upload_audio').hide();
            $('.upload_audio_url').val('');

        });
            
        //    AV block content
         $("input[type='text'].sccp_blockcont_shortcode").on("click", function () {
           $(this).select();
        });

         $("label.ays_actDect").on("click", function () {
            var date_id = $(this).find('input[id*="ays-sccp-date-"]').data('id');
            console.log(date_id);
            
            $(this).find('#ays-sccp-date-from-' + date_id + ', #ays-sccp-date-to-' + date_id).datetimepicker({
                controlType: 'select',
                oneLine: true,
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss"
            });
        });

        $(document).find('.sccp_schedule_date').datetimepicker({
            controlType: 'select',
            oneLine: true,
            dateFormat: "yy-mm-dd",
            timeFormat: "HH:mm:ss"
        });

        let id = $('.all_block_contents').data('last-id');
        $(document).on('click', '.add_new_block_content', function () {
            var last_id = $('.blockcont_one').last().attr('id');
            if (last_id == undefined) {
                last_id = id;
            } else {
                last_id = last_id.substring(7);
            }

            if (id == last_id) {
                id++;
            }
            var content = '';
            for (var key in sccp.bc_user_role) {            
               content += "<option  value='" + key + "' >" + sccp.bc_user_role[key]['name'] + "</option>";              
            }
               
            $('.all_block_contents').append(' <div class="blockcont_one" id="blocont' + id + '">\n' +
                '                    <div class="copy_protection_container form-group row ays_bc_row">\n' +
                '                        <div class="col">\n' +
                '                            <label for="sccp_blockcont_shortcode" class="sccp_bc_label">Shortcode</label>\n' +
                '                            <input type="text"  name="sccp_blockcont_shortcode[]" class="ays-text-input sccp_blockcont_shortcode select2_style" value="[ays_block id=\'' + id + '\'] Content [/ays_block]" readonly>\n' +
                '                            <input type="hidden"  name="sccp_blockcont_id[]" value="' + id + '">\n' +
                '                        </div>\n' +
                '                        <div class="col">\n' +
                '                           <div class="input-group bc_count_limit">\n' +
                '                               <div class="bc_count">\n' +
                '                                   <label for="sccp_blockcont_pass" class="sccp_bc_label">Password</label>\n' +
                '                               </div>\n' +
                '                               <div class="bc_limit">\n' +
                '                                   <label for="sccp_blockcont_limit_' + id + '" class="sccp_bc_limit">Limit<a class="ays_help" data-toggle="tooltip"\n' +
                '                                  title="Choose the maximum amount of the usage of the password">\n' +
                '                                    <i class="ays_fa ays_fa_info_circle"></i>\n' +
                '                                </a></label>\n' +
                '                                <input type="number" id="sccp_blockcont_limit_' + id + '" name="bc_pass_limit_' + id + '" >\n' +
                '                               </div>\n' +
                '                           </div>\n' +
                '                               <div class="input-group">\n' +
                '                                   <input type="password"  name="sccp_blockcont_pass[]" class="ays-text-input select2_style form-control">\n' +
                '                                   <div class="input-group-append ays_inp-group">\n' +
                '                                       <span class="input-group-text show_password">\n' +
                '                                           <i class="ays_fa fa-eye" aria-hidden="true"></i>\n' +
                '                                       </span>\n' +                
                '                                   </div>\n' +                
                '                               </div>\n' +                
                '                        </div>\n' +
                '                        <div>\n' +
                '                           <p style="margin-top:60px;">OR</p>\n' +
                '                        </div>\n' +
                '                        <div class="col">\n' +
                '                           <label for="sccp_blockcont_roles" class="sccp_bc_label">Only for</label>\n' +
                '                           <div class="input-group">\n' +
                '                                <select name="ays_users_roles_'+id+'[]" class="ays_bc_users_roles" id="ays_users_roles_'+id+'" multiple>\n' +
                                                    content +
                '                                </select>\n' +
                '                            </div>\n' +
                '                       </div>\n' +
                '                       <div class="col">\n' +
                '                           <label for="sccp_blockcont_schedule" style="margin-left: 35px;">Schedule</label>\n' +
                '                           <div class="input-group">\n' +
                '                               <label style="display: flex;" class="ays_actDect"><span style="font-size:small;margin-right: 4px;">From</span>\n' +
                '                                   <input type="text" id="ays-sccp-date-from-'+id+'" data-id="'+id+'" class="ays-text-input ays-text-input-short sccp_schedule_date" name="bc_schedule_from_'+id+'" value="">\n' +
                '                               <div class="input-group-append">\n' +
                '                                       <label for="ays-sccp-date-from-'+id+'" style="height: 34px; padding: 5px 10px;" class="input-group-text">\n' +
                '                                            <span><i class="ays_fa ays_fa_calendar"></i></span>\n' +
                '                                        </label>\n' +
                '                                    </div>\n' +
                '                               </label>\n' +
                '                               <label style="display: flex;" class="ays_actDect"><span style="font-size:small;margin-right: 21px;">To</span>\n' +
                '                                   <input type="text" id="ays-sccp-date-to-'+id+'" data-id="'+id+'" class="ays-text-input ays-text-input-short sccp_schedule_date" name="bc_schedule_to_'+id+'" value="">\n' +
                '                               <div class="input-group-append">\n' +
                '                                       <label for="ays-sccp-date-to-'+id+'" style="height: 34px; padding: 5px 10px;" class="input-group-text">\n' +
                '                                            <span><i class="ays_fa ays_fa_calendar"></i></span>\n' +
                '                                        </label>\n' +
                '                                    </div>\n' +
                '                               </label>\n' +
                '                           </div>\n' +
                '                       </div>\n' +
                '                       <div>\n' +
                '                            <br>\n' +
                '                            <p class="blockcont_delete_icon"><i class="ays_fa fa-trash-o" aria-hidden="true"></i></p>\n' +
                '                        </div>' +
                '                    </div>\n' +
                '                </div>');
            
            id++;
            $('[id^=ays_users_roles_]').select2();            
            $("input[type='text'].sccp_blockcont_shortcode").on("click", function () {
                 $(this).select();
            });

            $("label.ays_actDect").on("click", function () {
                var date_id = $(this).find('input[id*="ays-sccp-date-"]').data('id');
                console.log(date_id);
                
                $(this).find('#ays-sccp-date-from-' + date_id + ', #ays-sccp-date-to-' + date_id).datetimepicker({
                    controlType: 'select',
                    oneLine: true,
                    dateFormat: "yy-mm-dd",
                    timeFormat: "HH:mm:ss"
                });
            });

            $(document).find('.sccp_schedule_date').datetimepicker({
                controlType: 'select',
                oneLine: true,
                dateFormat: "yy-mm-dd",
                timeFormat: "HH:mm:ss"
            });
            
        });
       
        $(document).on('click', '.blockcont_delete_icon', function () {
            var real_del = confirm('Do you want to delete?');
            if (real_del == true) {
                var id = $(this).closest('.blockcont_one').attr('id');
                if (id == undefined) {
                    id = 0;
                } else {
                    id = id.substring(7); 
                    var lastval = $('.deleted_ids').val().toString();
                    lastval = lastval.toString() + ',' + id.toString();
                    $('.deleted_ids').val(lastval);
                }
                
                $(this).parent().parent().parent().css({
                    'animation-name': 'slideOutLeft',
                    'animation-duration': '.4s', 
                    'box-shadow': '2px 0px 8px #bfb2b2'
                });
                var a = $(this);
                setTimeout(function(){
                     a.parent().parent().parent().remove();
                }, 400);
            }
            
        });

        var count = 1;
        $(document).on('click', '.show_password', function () {

            if (count % 2) {
                $(this).parent().parent().find('input').attr('type', 'text');
            } else {
                $(this).parent().parent().find('input').attr('type', 'password');
            }
            count++;
        });        

        //--------------AV end
        
        $(document).on('click', '.ays-edit-sccp-bg-img', function (e) {
            openSccpMediaUploader(e, $(this));
        });

        $(document).on('click', 'a.add-sccp-bg-image', function (e) {
            openSccpMediaUploader(e, $(this));
        });

        $(document).on('click', '.ays-remove-sccp-bg-img', function () {
            console.log('av');
            $(this).parent().find('img#ays-sccp-bg-img').attr('src', '');
            $(this).parent().parent().find('input#ays_sccp_bg_image').val('');
            $(this).parent().fadeOut();
            $(this).parent().parent().find('a.add-sccp-bg-image').show();
            $(document).find('#ays_tooltip').css({'background-image': 'none'});
        });

        setTimeout(function(){
            if($(document).find('#sccp_custom_css').length > 0){
                if(wp.codeEditor)
                    wp.codeEditor.initialize($(document).find('#sccp_custom_css'), cm_settings);
            }
        }, 500);

        $(document).find('a[href="#tab5"]').on('click', function (e) {        
            setTimeout(function(){
                if($(document).find('#sccp_custom_css').length > 0){
                    if(wp.codeEditor){
                        $(document).find('#sccp_custom_css').next('.CodeMirror').remove();
                        wp.codeEditor.initialize($(document).find('#sccp_custom_css'), cm_settings);
                    }
                }
            }, 500);
        });

        function openSccpMediaUploader(e, element) {
            e.preventDefault();
            let aysUploader = wp.media({
                title: 'Upload',
                button: {
                    text: 'Upload'
                },
                library: {
                    type: 'image'
                },
                multiple: false
            }).on('select', function () {
                let attachment = aysUploader.state().get('selection').first().toJSON();
                if(element.hasClass('add-sccp-bg-image')){
                    element.parent().find('.ays-sccp-bg-image-container').fadeIn();
                    element.parent().find('img#ays-sccp-bg-img').attr('src', attachment.url);
                    element.next().val(attachment.url);
                    $(document).find('.ays-tooltip-live-container').css({'background-image': 'url("'+attachment.url+'")'});
                    element.hide();
                }else if(element.hasClass('ays-edit-sccp-bg-img')){
                    element.parent().find('.ays-sccp-bg-image-container').fadeIn();
                    element.parent().find('img#ays-sccp-bg-img').attr('src', attachment.url);
                    $(document).find('#ays_sccp_bg_image').val(attachment.url);
                    $(document).find('.ays-tooltip-live-container').css({'background-image': 'url("'+attachment.url+'")'});
                }else{
                    element.text('Edit Image');
                    element.parent().parent().find('.ays-sccp-image-container').fadeIn();
                    element.parent().parent().find('img#ays-sccp-img').attr('src', attachment.url);
                    $('input#ays-sccp-image').val(attachment.url);
                }
            }).open();

            return false;
        }

    });
})(jQuery);
