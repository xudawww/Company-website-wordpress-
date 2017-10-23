jQuery(document).ready(function ($) {
    $.getScript(wpvr_globals.functions_js).done(function () {

        $('.wpvr_date_field , .cmb_datepicker').each(function () {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                language: wpvr_globals.locale,
                autoHide: true,
            });
        });

        $('.wpvr_tipso').each(function () {
            $(this).tipso({
                background: 'rgba(0,0,0,0.8)',
                color: '#FFF',
                useTitle: true,
                width: 'auto',
                maxWidth: 200,
            });
        });

        function wpvr_js_generate_token() {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < 10; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        }

        function wpvr_init_dropdown(wrap) {

            var maxItems = wrap.attr('maxItems');
            var selectized = $('.wpvr_dropdown_select', wrap);
            var handler = $('.wpvr_dropdown_input', wrap);
            var $string = handler.val();
            var selected_items;
            var token;
            if (typeof wrap.attr('token') === 'undefined') {
                token = wpvr_js_generate_token();
            } else {
                token = wrap.attr('token');
            }

            // console.log($string);

            if (typeof $string !== 'undefined' && $string != '') selected_items = JSON.parse($string);
            else selected_items = false;

            var selectize_args = {
                maxItems: null,
                //persist: true,
                //items: [],
                selectOnTab: true,
                closeAfterSelect: false,

                delimiter: ',',
                // persist: false,
                // create: function (input) {
                //     return {
                //         value: input,
                //         text: input
                //     }
                // }

                // valueField: 'email',
                // labelField: 'name',
                // searchField: ['name', 'email'],
                // options: [
                //     {email: 'brian@thirdroute.com', name: 'Brian Reavis'},
                //     {email: 'nikola@tesla.com', name: 'Nikola Tesla'},
                //     {email: 'someone@gmail.com'}
                // ],
            };

            if (maxItems !== null) {
                selectize_args.maxItems = maxItems;
            }
            // console.log( selected_items );
            if (selected_items !== false && selected_items != []) {
                selectize_args.items = selected_items;
            }
            // console.log( selectize_args );
            var $selectized = selectized.selectize(selectize_args);


            function selectize_handler(obj) {
                //console.log( obj );
                var selectedItems = [];
                $('option', obj.currentTarget).each(function () {
                    selectedItems.push($(this).attr('value'));
                });
                var str = JSON.stringify(selectedItems, null, 2);
                var cs_string = selectedItems.join(',');
                handler.attr('value', str);
            }

            $selectized.on('change', selectize_handler);
            $selectized.on('initialize', selectize_handler);

            if (typeof wpvr_dropdown_fields === 'undefined') {
                wpvr_dropdown_fields = [];
            }

            wpvr_dropdown_fields[token] = $selectized;
            wrap.attr('token', token);
            wrap.data('selectize', $selectized);
            wrap.data('selectize_args', selectize_args);

        }

        $('.wpvr_dropdown').each(function () {
            wpvr_init_dropdown($(this));
        });


        $(document).bind('scroll', function () {
            $('.wpvr_loading_msg').center();
        });

        $(window).bind('resize', function () {
            $('.wpvr_loading_msg').center();
        });


        // console.log(wpvr_options);

        $('.wpvr_option_inside').each(function () {
            var wrap = $(this);
            var btn = $('.wpvr_api_get_from_default', wrap).click(function (e) {
                var data = btn.data();
                $('#' + data.key_target, wrap).val(data.key);
                $('#' + data.client_target, wrap).val(data.client);
                $('#' + data.secret_target, wrap).val(data.secret);
            });
        });

        // Async Single Item Processing
        function wpvr_process_update_thumbs(k, items, box) {

            // box.data('k', k);

            if (k >= items.length) {
                console.log('All items async processed !');
                box.stopHighlight();
                box.doClose();

                var box2 = wpvr_show_loading_new({
                    title: wpvr_localize.work_completed,
                    text: items.length + ' thumbnails redownloaded.',
                    pauseButton: wpvr_localize.ok_button,
                });
                box2.doPause(function () {
                    box2.doClose();
                });
                return false;
            }

            $('.wpvr_current_title', box).html(items[k].post_title);


            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: {
                    action: 'update_single_thumbnail',
                    post: items[k],
                },
                success: function (response) {
                    var $json = wpvr_get_json(response);
                    console.log($json);

                    if ($json.status == 0) {
                        wpvr_alert('Something went wrong on the single processing...');
                        return false;
                    }

                    var p = Math.round((parseInt(k) + 1 ) / items.length * 100);
                    box.doProgress({
                        pct: p,
                        text: (k + 1) + ' / ' + items.length,
                    });
                    k++;
                    wpvr_process_update_thumbs(k, items, box);


                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        }

        $('.wpvr_setter_button[action=update_all_thumbnails]').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            wpvr_btn_loading(btn);
            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: {
                    action: 'update_all_thumbnails_prepare',
                },
                success: function (response) {
                    var $json = wpvr_get_json(response);
                    wpvr_btn_loading(btn, false);
                    // console.log( $json );
                    if ($json.status != 1) {
                        wpvr_alert('Something went wrong.');
                        return false;
                    }
                    wpvr_confirm(
                        $json.msg,
                        function () {
                            var box = wpvr_show_loading({
                                title: wpvr_localize.work_in_progress + '...',
                                text: '<br/><div class="wpvr_current_title"></div>',
                                progressBar: true,
                                cancelButton: wpvr_localize.cancel_button, // OR window
                                isModal: true,
                            });

                            box.doProgress({pct: 1, text: wpvr_localize.loading + ''});
                            box.doHighlight();
                            box.data('work', 1);

                            box.doCancel(function () {
                                box.doHide();
                                wpvr_confirm(
                                    wpvr_localize.really_want_cancel,
                                    function () {
                                        box.doShow();
                                    },
                                    wpvr_localize.continue_button,
                                    function () { //IF yes
                                        box.data('work', 0);
                                        //var k = box.data('k');
                                    },
                                    wpvr_localize.cancel_anyway
                                );
                            });
                            wpvr_process_update_thumbs(0, $json.data.items, box);


                        }, 'Update all thumbnails',
                        function () {
                        }, 'Cancel'
                    );
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    wpvr_alert(thrownError);
                }
            });


        });

        $('.wp-admin.post-type-wpvr_source').each(function () {
            var wrap = $(this);
            var fixedbar = $('#wpvr_source_status_metabox', wrap);
            $(window).scroll(function () {
                // console.log('scrolled');
                if ($(window).scrollTop() > 280) {
                    fixedbar.addClass('fixed')
                } else {
                    fixedbar.removeClass('fixed')
                }
            });
        });

        $('.wp-admin').each(function () {
            var wrap = $(this);
            var fixedbar = $('#wpvr_video_actions_metabox', wrap);
            $(window).scroll(function () {
                // console.log('scrolled');
                if ($(window).scrollTop() > 280) {
                    fixedbar.addClass('fixed')
                } else {
                    fixedbar.removeClass('fixed')
                }
            });
        });

        $('#widget-list .widget').each(function () {
            if ($(this).attr('id').indexOf('wpvr') != -1) {
                $('h3', $(this)).addClass('wpvr_widget_holder');
            }

        });
        $('#plugin_update_from_iframe').click(function (e) {
            var slug = $(this).attr('data-slug');
            if (slug.indexOf('wpvr') > -1) {
                e.preventDefault();
                window.open($(this).attr('href'));
            }
        });

        $('.wpvr_merge_selected_duplicates').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var merge_url = btn.attr('url');
            var is_merging_all = btn.attr('is_merging_all');

            var items = [];
            var master_items = [];
            if (is_merging_all != '1') {
                var confirm_msg = wpvr_localize.confirm_merge_items;
                $('.wpvr_video', $('.wpvr_manage_bulk_form')).each(function () {
                    var video = $(this);
                    if ($('.wpvr_video_cb', video).prop('checked')) {
                        var ids = $('.wpvr_video_merge', video).attr('ids').split(',');
                        master_items.push(ids[0]);
                        items.push.apply(items, ids);
                    }
                });
                if (items.length == 0 && !bulk_action) return false;
            } else {
                master_items = 'all';
                var confirm_msg = wpvr_localize.confirm_merge_all_items;
            }


            // console.log( master_items );
            // return false;
            wpvr_confirm(
                confirm_msg,
                function () { //YES FCT
                    wpvr_btn_loading(btn, true);
                    var boxWaiting = wpvr_show_loading({
                        title: 'WP Video Robot',
                        text: wpvr_localize.loadingCenter,
                    });

                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'merge_items',
                            items: master_items,
                        },
                        success: function (r) {
                            wpvr_btn_loading(btn, false);
                            boxWaiting.remove();
                            var $json = wpvr_get_json(r);
                            if ($json.status != 0) {

                                var exec_time = $json.data.exec_time;
                                var count_videos = $json.data.count.videos;
                                var count_dups = $json.data.count.duplicates;

                                var merge_msg =
                                    count_videos + ' ' + wpvr_localize.videos_processed_successfully + '.<br/>' +
                                    count_dups + ' ' + wpvr_localize.duplicates_removed_in + ' ' +
                                    exec_time + ' ' + wpvr_localize.seconds + '.'
                                ;

                                // console.log(exec_time);
                                // console.log(count_videos);
                                // console.log(count_dups);

                                var boxNEW = wpvr_show_loading_new({
                                    title: wpvr_localize.wp_video_robot,
                                    text: merge_msg,
                                    isModal: false,
                                    pauseButton: wpvr_localize.ok_button,
                                });
                                boxNEW.doPause(function () {
                                    wpvr_manage_refresh(false, true);
                                    $('.wpvr_manage_bulk_actions_select').fadeOut();
                                    $('.wpvr_manage_checkAll').attr('state', 'off');
                                    $('.wpvr_manage_bulk_actions_select .wpvr_count_checked').html('');
                                    boxNEW.remove();
                                });


                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });

                    //wpvr_merge_items(0, items, box);
                },
                wpvr_localize.yes,
                function () {
                },
                wpvr_localize.cancel_button
            );
            return false;

        });
        $('#wpvr_video_metabox').hide();
        $('.wpvr_toggle_advanced_adding').click(function (e) {
            e.preventDefault();
            if ($(this).hasClass('is_advanced')) {
                $(this).removeClass('is_advanced');
                $('#wpvr_video_metabox').fadeOut();
            } else {
                $(this).addClass('is_advanced');
                $('#wpvr_video_metabox').fadeIn();
                var y = $('#wpvr_video_metabox').offset().top - 50;
                $('html, body').animate({scrollTop: y,}, 'slow');


            }
        })

        $('.wpvr_import_wizzard').each(function () {
            var btn = $(this);

            btn.click(function (e) {
                e.preventDefault();
                var spinner = wpvr_add_loading_spinner(btn, 'pull-right');

                $.ajax({
                    type: 'POST',
                    url: wpvr_globals.ajax_url,
                    data: {
                        action: 'get_video_wizzard_form',
                    },
                    success: function (data) {
                        wpvr_remove_loading_spinner(spinner);

                        var $json = wpvr_get_json(data);
                        var video_service = btn.attr('video_service');
                        var video_id = btn.attr('video_id');

                        var boxWiz = wpvr_show_loading_new({
                            title: 'Import a video manually',
                            width: '50%',
                            boxClass: 'wpvr_wizzard_wrap',
                            text: $json,
                            isModal: false,
                            //pauseButton: 'Next Step <i class="fa fa-arrow-right"></i>',
                            cancelButton: '<i class="fa fa-times"></i> ' + wpvr_localize.close_wizard,
                        });


                        var step = 1;
                        boxWiz.attr('step', step);
                        boxWiz.attr('far_step', step);
                        $('.wpvr_loading_msg', boxWiz).center();
                        boxWiz.doCancel(function () {
                            boxWiz.doClose();
                        });

                        $('.wpvr_wizzard_service', boxWiz).click(function () {
                            $('.wpvr_wizzard_service', boxWiz).removeClass('active');
                            $(this).addClass('active');
                            $('#wpvr_wizzard_service').attr('value', $(this).attr('service'));
                            $('#wpvr_wizzard_pid').attr('value', $(this).attr('pid'));
                            $('.wpvr_wizzard_next_step', boxWiz).removeClass('disabled');
                            // $('.wpvr_wizzard_next_step', boxWiz).delay(1000).trigger('click');
                        });

                        $('.wpvr_wizzard_choice', boxWiz).click(function () {
                            if ($(this).hasClass('active')) {
                                $(this).removeClass('active');
                                $(this).addClass('inactive');
                                $('.wpvr_wizzard_choice_value', $(this)).attr('value', 'off');
                            } else {
                                $(this).addClass('active');
                                $(this).removeClass('inactive');
                                $('.wpvr_wizzard_choice_value', $(this)).attr('value', 'on');
                            }
                            var chosen = 0;
                            $('.wpvr_wizzard_choice_value', boxWiz).each(function () {
                                if ($(this).attr('value') == 'on') chosen++;
                            })
                            if (chosen == 0) {
                                $('.wpvr_wizzard_run', boxWiz).addClass('disabled');
                            } else {
                                $('.wpvr_wizzard_run', boxWiz).removeClass('disabled');
                            }

                        });

                        function wpvr_check_wizzard_param() {
                            if ($(this).attr('value') == '') {
                                $('.wpvr_wizzard_next_step', boxWiz).addClass('disabled');
                            } else {
                                $('.wpvr_wizzard_next_step', boxWiz).removeClass('disabled');
                            }
                        }

                        $('.wpvr_wizzard_next_step', boxWiz).click(function (e) {
                            e.preventDefault();
                            if ($(this).hasClass('disabled')) return;
                            var step = parseInt(boxWiz.attr('step'));
                            step++;
                            $('.wpvr_wizzard_form', boxWiz)
                                .removeClass('step_1')
                                .removeClass('step_2')
                                .removeClass('step_3')
                                .removeClass('step_4')
                                .addClass('step_' + step);
                            boxWiz.attr('step', step);
                            if (step >= boxWiz.attr('far_step')) {
                                $('.wpvr_wizzard_next_step', boxWiz).addClass('disabled');
                                boxWiz.attr('far_step', step);
                            }
                            if (step == 2) {
                                $('.wpvr_wizzard_form_param', boxWiz).focus();
                            }
                            $('.wpvr_wizzard_form_param', boxWiz).each(wpvr_check_wizzard_param);
                        });


                        $('.wpvr_wizzard_form_param', boxWiz).each(wpvr_check_wizzard_param);
                        $('.wpvr_wizzard_form_param', boxWiz).keyup(wpvr_check_wizzard_param);
                        $('.wpvr_wizzard_form_param', boxWiz).change(wpvr_check_wizzard_param);
                        $('.wpvr_wizzard_form_param', boxWiz).focusout(wpvr_check_wizzard_param);
                        $('.wpvr_wizzard_form_param', boxWiz).bind('paste', function () {
                            setTimeout(function () {
                                wpvr_check_wizzard_param();
                            }, 100);
                        });


                        $('.wpvr_wizzard_prev_step', boxWiz).click(function (e) {
                            e.preventDefault();
                            var step = parseInt(boxWiz.attr('step'));
                            step--;
                            $('.wpvr_wizzard_form', boxWiz)
                                .removeClass('step_1')
                                .removeClass('step_2')
                                .removeClass('step_3')
                                .removeClass('step_4')
                                .addClass('step_' + step);
                            boxWiz.attr('step', step);
                            if (step < boxWiz.attr('far_step')) {
                                $('.wpvr_wizzard_next_step', boxWiz).removeClass('disabled');
                            }
                            if (step == 1) {
                                if ($('#wpvr_wizzard_service').attr('value') == '') {
                                    $('.wpvr_wizzard_next_step', boxWiz).addClass('disabled');
                                }
                                else {
                                    $('.wpvr_wizzard_next_step', boxWiz).removeClass('disabled');
                                }
                            } else {
                                $('.wpvr_wizzard_form_param', boxWiz).each(wpvr_check_wizzard_param);
                            }

                        });

                        if (video_service != '') {
                            $('.wpvr_wizzard_service[service=' + video_service + ']', boxWiz).trigger('click');
                        }

                        if (video_id != '') {
                            $('#wpvr_wizzard_param').attr('value', video_id);
                        }

                        $('.wpvr_wizzard_run', boxWiz).click(function (e) {
                            e.preventDefault();
                            if ($(this).hasClass('disabled')) return false;

                            var pid = $('#wpvr_wizzard_pid', boxWiz).attr('value');
                            var service = $('#wpvr_wizzard_service', boxWiz).attr('value');
                            var param = $('#wpvr_wizzard_param', boxWiz).attr('value');

                            $('.cmb_id_wpvr_video_service .cmb_option[value=' + service + ']').prop('checked', true);
                            $('#wpvr_video_' + pid + 'Id').attr('value', param);
                            $('#wpvr_video_enableManualAdding').val('on');
                            $('.wpvr_wizzard_choice_value', boxWiz).each(function () {
                                if ($(this).attr('value') == 'on') {
                                    $('#' + $(this).attr('target_id')).val('on');
                                } else {
                                    $('#' + $(this).attr('target_id')).val('off');
                                }
                            });

                            boxWiz.doClose();
                            $('.wpvr_wizzard_overlay').fadeIn();
                            $('.wpvr_manual_import_trigger').trigger('click');
                        });

                        boxWiz.doPause(function () {
                            step++;
                            $('.wpvr_wizzard_form', boxWiz)
                                .removeClass('step_1')
                                .removeClass('step_2')
                                .removeClass('step_3')
                                .removeClass('step_4')
                                .addClass('step_' + step);

                        });


                    },
                });


            })
            ;


        });

        $('.wpvr_imageselect_wrap').each(function () {
            var wrap = $(this);
            var input = $('.wpvr_imageselect_input', wrap);
            $('.wpvr_imageselect_item[data-value=' + input.val() + ']', wrap).addClass('active');
            $('.wpvr_imageselect_item', wrap).click(function (e) {
                e.preventDefault();
                $('.wpvr_imageselect_item', wrap).removeClass('active');
                $(this).addClass('active');
                input.attr('value', $(this).data('value'));
            });
        });

        $('.wpvr_popup_info').each(function () {
            var btn = $(this);
            var popup_content = btn.attr('popup_content');
            var popup_title = btn.attr('popup_title');

            btn.click(function (e) {
                e.preventDefault();
                if (typeof popup_title == 'undefined') {
                    popup_title = 'WP Video Robot';
                }

                if (typeof popup_content == 'undefined') {
                    popup_content = '';
                }

                var boxPopup = wpvr_show_loading_new({
                    title: popup_title,
                    text: '<div class="wpvr_selectable">' + wpvr_nl2br(popup_content) + '</div>',
                    pauseButton: wpvr_localize.close_button,
                });
                $('.wpvr_loading_msg', boxPopup).center();
                boxPopup.doPause(function () {
                    boxPopup.doClose();
                });
            });


        });

        $('.wpvrArgs td').each(function () {
            var td = $(this);
            var span = $('.wpvr_wanted_param', td);
            var inputs = $('input, textarea', td);
            span.click(function (e) {
                e.preventDefault();
                //inputs.val(span.html());
                inputs.each(function () {
                    var input = $(this);
                    if (!input.hasClass('wpvr_helper_input')) {
                        input.val(span.html());
                    }
                });
            });
        });
        function wpvr_nl2br(str, is_xhtml) {
            //str = str.replace(/'/g, "\\'");
            var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
            return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
        }

        $('.wpvr_read_changelog').click(function (e) {
            var url = $(this).attr('changelog_url');
            var title = $(this).attr('changelog_title');
            $.ajax({
                type: 'GET',
                url: url,
                success: function (data) {
                    var boxChangeLog = wpvr_show_loading_new({
                        height: '80%',
                        width: '70%',
                        title: title,
                        text: wpvr_nl2br(data),
                        pauseButton: wpvr_localize.close_button,
                    });
                    $('.wpvr_loading_msg', boxChangeLog).center();
                    boxChangeLog.doPause(function () {
                        boxChangeLog.doClose();
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                },
            });
        });


        $('.wpvr_import_sample_sources').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var url = btn.attr('url');
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            wpvr_confirm(
                wpvr_localize.confirm_import_sample_sources,
                function () {
                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'import_sample_sources',
                        },
                        success: function (data) {
                            var $json = wpvr_get_json(data);
                            wpvr_remove_loading_spinner(spinner);
                            wpvr_alert($json.msg);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        },
                    });
                },
                wpvr_localize.cancelButton,
                function () {
                    wpvr_remove_loading_spinner(spinner);
                }
            );
        });


        $('.wpvr_show_when_loaded').fadeIn().css('opacity', 1);
        $('.wpvr_hide_when_loaded').hide();


        $('body.post-type-wpvr_source form#post').each(function () {
            var form = $(this);
            // var test_btn = $('#wpvr_metabox_test');
            var make_test_btn_not_ready = function () {
                $('#wpvr_metabox_test').attr('ready', 0);
            };

            $('input', form).change(make_test_btn_not_ready);
            $('select', form).change(make_test_btn_not_ready);
        });


        function wpvr_refresh_manual_import_trigger(s) {
            var btn = $('.wpvr_manual_adding_btns');
            if (s.val() == 'off') btn.hide();
            else btn.fadeIn();
        }

        function wpvr_adapt_fixed_bottom_buttons() {
            if ($('body').hasClass('folded')) $('.wpvr_test_form_buttons.bottom').addClass('folded');
            else $('.wpvr_test_form_buttons.bottom').removeClass('folded');
        }

        wpvr_adapt_fixed_bottom_buttons();
        $('#collapse-menu').click(function (e) {
            wpvr_adapt_fixed_bottom_buttons();
        });

        $('.wpvr_test_screen_wrap').each(function () {
            var wrap = $(this);
            var videos_wrap_y = $('.wpvr_videos', wrap).offset().top;
            var buttons_bottom = $('.wpvr_test_form_buttons.bottom', wrap);
            $(window).scroll(function () {
                var y = $(window).scrollTop() - videos_wrap_y;
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                    if (buttons_bottom.hasClass('fixed')) {
                        buttons_bottom.hide().removeClass('fixed').fadeIn();
                    }
                } else {
                    if (y > 50) {
                        if (!buttons_bottom.hasClass('fixed')) {
                            buttons_bottom.hide().addClass('fixed').fadeIn();
                        }
                    } else {
                        buttons_bottom.hide().removeClass('fixed').show();
                    }
                }
            });
        });


        $('.wpvr_options_page').each(function () {
            var wrap = $(this);
            var videos_wrap_y = $('#wpvr_options', wrap).offset().top;
            var buttons_bottom = $('.wpvr_options_bottom_actions', wrap);
            $(window).scroll(function () {
                var y = $(window).scrollTop() - videos_wrap_y;
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 50) {
                    if (buttons_bottom.hasClass('fixed')) {
                        buttons_bottom.hide().removeClass('fixed').fadeIn();
                    }
                } else {
                    if (y > 50) {
                        if (!buttons_bottom.hasClass('fixed')) {
                            buttons_bottom.hide().addClass('fixed').fadeIn();
                        }
                    } else {
                        buttons_bottom.hide().removeClass('fixed').show();
                    }
                }
            });
        });

        $('#wpvr_video_enableManualAdding').each(function () {
            var select = $(this);
            wpvr_refresh_manual_import_trigger(select);
            select.change(function () {
                wpvr_refresh_manual_import_trigger(select);
            });
        });

        $('.wpvr_embed_video_btn').click(function (e) {
            e.preventDefault();
            var title = $(this).attr('dialog_title');
            var msg = $(this).attr('msg');
            var code = $(this).attr('code');
            var box2 = wpvr_show_loading_new({
                title: title,
                text: ' ' + msg + ' <br/> <br/><div class="wpvr_embed_code_wrapper">' + code + '</div>',
                pauseButton: wpvr_localize.ok_button,
            });
            box2.doPause(function () {
                box2.doClose();
            });
        });

        function wpvr_refresh_theme_screenshot(s) {
            var target = $('.wpvr_theme_screenshot');
            var folder = target.attr('folder');
            var theme = s.attr('value');
            if (theme == 'seven' || theme == '') theme = 'default';
            var img_src = folder + theme + '.jpg';

            target.hide().html('<img class="wpvr_theme_screenshot_img" src="' + img_src + '" />').fadeIn();
        }

        $('#player_theme').each(function () {
            var select = $(this);
            wpvr_refresh_theme_screenshot(select);
            select.change(function () {
                wpvr_refresh_theme_screenshot(select);
            });
        });

        $('.wpvr_option_slider_input_text').each(function () {
            var text = $(this);
            var slider = $('#' + text.attr('slider_id'));
            var min = parseInt(slider.attr('slider_min'));
            var max = parseInt(slider.attr('slider_max'));
            text.on('change', function () {
                var val = $(this).val();
                if (val < min) val = min;
                if (val > max) val = max;
                slider.val(parseInt(val));
                text.attr('value', val);

            });


        });
        $('.wpvr_option_slider_range').each(function () {
            var slider = $(this);
            //console.log( slider );
            var slider_input_id = slider.attr('slider_input');
            var slider_min = slider.attr('slider_min');
            var slider_max = slider.attr('slider_max');
            var slider_value = slider.attr('slider_value');
            var slider_step = slider.attr('slider_step');
            //console.log( slider_step );
            var input = $('.wpvr_option_slider_input #' + slider_input_id);
            // slider.wpvrSlider({
            var slider_elt = slider.get(0);
            noUiSlider.create(slider_elt, {

                start: parseInt(slider_value),
                step: parseInt(slider_step),
                connect: [true, false],
                range: {
                    'min': parseInt(slider_min),
                    'max': parseInt(slider_max)
                }
            });

            slider_elt.noUiSlider.on('slide', function () {
                input.val(parseInt(slider_elt.noUiSlider.get()));
            });
        });


        $('.wpvr_wuh_wrap').each(function () {
            var wrap = $(this);
            var slider = $('.wpvr_wuh_slider', wrap);
            var input_a = $('.wpvr_wuh_input.a', wrap);
            var input_b = $('.wpvr_wuh_input.b', wrap);

            var slider_elt = slider.get(0);
            noUiSlider.create(slider_elt, {
                start: [
                    parseInt(input_a.val()),
                    parseInt(input_b.val())
                ],
                connect: [false, true, false],
                step: parseInt(slider.data('step')),
                tooltips: [
                    wNumb({decimals: 0, postfix: 'H'}),
                    wNumb({decimals: 0, postfix: 'H'})
                ],
                range: {
                    'min': parseInt(slider.data('min')),
                    'max': parseInt(slider.data('max'))
                }
            });
            slider_elt.noUiSlider.on('slide', function () {
                var v = parseInt(slider.val());
                // input.val(v);

                var values = slider_elt.noUiSlider.get();
                input_a.val(parseInt(values[0]));
                input_b.val(parseInt(values[1]));
                // console.log(slider.wpvrSlider('step'));

            });
        });

        $('.wpvr_video_view_ext').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            // window.location = 'http://google.com';
            var win = window.open(btn.attr('href'), btn.attr('target'));
            win.focus();
        });

        $('.wpvr_option_value_wrap').each(function () {
            var wrap = $(this);
            var slider = $('.wpvr_option_value_slider', wrap);
            var input = $('.wpvr_option_value_input.a', wrap);

            var slider_elt = slider.get(0);


            var postfix = slider.data('tooltip-suffix');

            noUiSlider.create(slider_elt, {
                start: input.val(),
                connect: [true, false],
                step: parseInt(slider.data('step')),
                tooltips: wNumb({decimals: 0, postfix: postfix}),
                range: {
                    'min': parseInt(slider.data('min')),
                    'max': parseInt(slider.data('max'))
                }
            });
            slider_elt.noUiSlider.on('slide', function () {
                var values = slider_elt.noUiSlider.get();
                input.val(parseInt(values));

            });
        });


        $('.wpvr_option_image_wrap').each(function () {
            var _wrap = $(this);
            var _default = _wrap.attr('default');
            var _button = $('.wpvr_option_image_thumb_button', _wrap);
            var _thumb = $('.wpvr_option_image_thumb', _wrap);
            var _field = $('.wpvr_option_image_thumb_input', _wrap);

            $('body').on('click', '.wpvr_option_image_remove', function (e) {
                _thumb
                    .hide()
                    .html('<img class="wpvr_option_thumb_img" src="' + _default + '" />')
                    .fadeIn();
                _field.val('');

            });

            _button.click(function (e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Image',
                    multiple: false
                }).open()
                    .on('select', function (e) {
                        var uploaded_image = image.state().get('selection').first();
                        var image_url = uploaded_image.toJSON().url;
                        _field.val(image_url);
                        var thumb = '';
                        thumb += '<img class="wpvr_option_thumb_img" src="' + image_url + '" />';
                        thumb += '<button class="wpvr_option_image_remove"><i class="fa fa-remove"></i></button>';
                        _thumb.html(thumb);
                    });
            });

        });

        $('#wpvr_get_mb_close').click(function (e) {
            e.preventDefault();
            window.close();
        });

        $('#wpvr_get_metaboxes').click(function (e) {
            e.preventDefault();
            window.open($(this).attr('url'));
        });

        $('.wpvr_test_form_info').click(function (e) {
            var btn = $(this);
            var msg = $('#wpvr_grouped_info').html();
            e.preventDefault();
            var box2 = wpvr_show_loading_new({
                title: wpvr_localize.group_info,
                text: ' ' + msg + '',
                pauseButton: wpvr_localize.ok_button,
            });
            box2.doPause(function () {
                box2.doClose();
            });
            //wpvr_btn_loading( btn , true );
        });

        // Async Start Processing
        function wpvr_async_process_start(btn, items) {

            var start_url = btn.attr('async_start_url');
            var single_url = btn.attr('async_single_url');
            var confirm_msg = btn.attr('async_confirm_msg');
            var processed_msg = btn.attr('async_processed_msg');

            //var items = [];
            //$('.wpvr_video_cb', wrapper).each(function () {
            //    if ($(this).prop('checked')) items.push($(this).attr('value'));
            //});
            //if (items.length == 0) return false;
            var box = wpvr_show_loading({
                title: wpvr_localize.please_wait,
                text: wpvr_localize.work_in_progress + "...",
                progressBar: true, // OR window
                cancelButton: wpvr_localize.cancel_button, // OR window
                isModal: true,
            });

            box.doProgress({pct: 1, text: wpvr_localize.loading + ''});
            box.doHighlight();
            box.attr('work', 1);
            box.attr('processed_msg', processed_msg);
            box.attr('confirm_msg', confirm_msg);
            box.attr('single_url', single_url);
            box.attr('start_url', start_url);


            box.doCancel(function () {
                box.doHide();
                wpvr_confirm(
                    wpvr_localize.really_want_cancel,
                    function () {
                        box.doShow();
                    },
                    wpvr_localize.continue_button,
                    function () { //IF yes
                        box.attr('work', 0);
                        var k = box.attr('k');
                    },
                    wpvr_localize.cancel_anyway
                );
            });
            wpvr_async_process_single(0, items, box);
        }

        // Async Single Item Processing
        function wpvr_async_process_single(k, items, box) {

            box.attr('k', k);
            var url = box.attr('url');
            var processed_msg = box.attr('processed_msg');
            var single_url = box.attr('single_url');

            if (k >= items.length) {
                console.log('All items async processed !');
                box.stopHighlight();
                box.doClose();

                var box2 = wpvr_show_loading_new({
                    title: wpvr_localize.work_completed,
                    text: items.length + ' ' + processed_msg + '.',
                    pauseButton: wpvr_localize.ok_button,
                });
                box2.doPause(function () {
                    box2.doClose();
                    //wpvr_manage_refresh(false, true);
                });
                return false;
            }

            $.ajax({
                type: 'GET',
                url: single_url,
                data: {k: k,},
                success: function (r) {
                    $json = wpvr_get_json(r);
                    console.log($json);
                    if (r != 'error') {
                        //console.log(data);
                        var progress = (parseInt((k + 1) / items.length) * 100 ) + '%';
                        var p = Math.round((parseInt(k) + 1 ) / items.length * 100);
                        //console.log(p + '%');
                        box.doProgress({
                            pct: p,
                            text: (k + 1) + ' / ' + items.length,
                        });
                        k++;
                        wpvr_async_process_single(k, items, box)
                    } else {
                        console.log('OUPS! There has been an error !');
                        console.log(r);
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        }


        $('.wpvr_async_btn').each(function () {
            var btn = $(this);
            var start_url = btn.attr('async_start_url');
            var single_url = btn.attr('async_single_url');
            var confirm_msg = btn.attr('async_confirm_msg');
            var processed_msg = btn.attr('async_processed_msg');

            //CLicking the buton
            btn.click(function (e) {
                e.preventDefault();
                //wpvr_apply_bulk_action();

                $.ajax({
                    type: 'GET',
                    url: start_url,
                    success: function (data) {
                        $json = wpvr_get_json(data);

                        if (confirm_msg == '0') {
                            wpvr_async_process_start(btn, $json.data);
                        } else {
                            var new_confirm_msg = confirm_msg.replace('%c%', $json.count);
                            wpvr_confirm(
                                new_confirm_msg,
                                function () { //YES FCT
                                    wpvr_async_process_start(btn, $json.data);
                                },
                                wpvr_localize.yes,
                                function () {
                                },
                                wpvr_localize.cancel_button
                            );
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });

            });

        });


        jQuery.extend({
            getQueryParameters: function (str) {
                return (str || document.location.search).replace(/(^\?)/, '').split("&").map(function (n) {
                    return n = n.split("="), this[n[0]] = n[1], this
                }.bind({}))[0];
            }
        });

        $('.wpvr_async_graph').each(function () {
            var wrap = $(this);
            var day = wrap.attr('day');
            var daylabel = wrap.attr('daylabel');
            var daytime = wrap.attr('daytime');
            var hex_color = wrap.attr('hex_color');
            var chart_id = wrap.attr('chart_id');
            // var url = wrap.attr('url');

            var body = $('.inside', wrap);
            $('.wpvr_nav_tab#b').click(function (e) {
                if (!wrap.hasClass('async_loaded')) {
                    setTimeout(function () {
                        $.ajax({
                            type: 'POST',
                            url: wpvr_globals.ajax_url,
                            data: {
                                action: 'wpvr_render_async_stress_graph',
                                hex_color: hex_color,
                                day: day,
                                daylabel: daylabel,
                                daytime: daytime,
                                chart_id: chart_id,
                            },
                            success: function (data) {
                                $json = wpvr_get_json(data);
                                //console.log($json);
                                if ($json.status != 1) return false;

                                var $jsData = $json.data.js;

                                wpvr_async_draw_chart(
                                    $('#' + $jsData.chart_id),
                                    $('#' + $jsData.chart_id + '_legend'),
                                    { // Data Stress
                                        labels: $.parseJSON($jsData.labels),
                                        datasets: [
                                            //{
                                            //    label: $jsData.name,
                                            //    fillColor: $jsData.fillColor,
                                            //    strokeColor: $jsData.strokeColor,
                                            //    pointColor: $jsData.pointColor,
                                            //    pointHighlightFill: $jsData.pointHighlightFill,
                                            //    data: $.parseJSON($jsData.stress),
                                            //},
                                            {
                                                label: ' Scheduled Sources',
                                                fillColor: $jsData.fillColor_bis,
                                                strokeColor: $jsData.strokeColor_bis,
                                                pointColor: $jsData.pointColor_bis,
                                                pointHighlightFill: $jsData.pointHighlightFill,
                                                data: $.parseJSON($jsData.sources),
                                            },

                                            {
                                                label: ' Wanted Videos',
                                                fillColor: $jsData.fillColor,
                                                strokeColor: $jsData.strokeColor,
                                                pointColor: $jsData.pointColor,
                                                pointHighlightFill: $jsData.pointHighlightFill,
                                                data: $.parseJSON($jsData.videos),
                                            },
                                            {
                                                label: ' Max. Wanted Videos',
                                                fillColor: $jsData.fillColor_max,
                                                strokeColor: $jsData.strokeColor_max,
                                                pointColor: $jsData.pointColor_max,
                                                pointHighlightFill: $jsData.pointHighlightFill,
                                                data: $.parseJSON($jsData.max),
                                            },


                                        ],
                                    },
                                    'radar',
                                    $jsData.chart_id
                                );
                                $('.wpvr_insite_loading', body).hide();
                                $('.wpvr_graph_wrapper', body).fadeIn();
                                wrap.addClass('async_loaded');
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                console.log(thrownError);
                            }
                        });
                    }, 300);
                }
            });


        });


        $('.wpvr_has_master').each(function () {
            var slave = $(this);
            var master = $('#' + slave.attr('master_id'));
            var m_values = slave.attr('master_value').split(',');
            //console.log(m_values);
            if (m_values.indexOf(master.val()) != -1) slave.fadeIn();
            else slave.hide();
            master.each(function () {

                if ($(this).val() == 'customBefore' || $(this).val() == 'customAfter') {
                    $('.cmb_id_wpvr_source_appendCustomText').show();
                } else    $('.cmb_id_wpvr_source_appendCustomText').hide();
            });
            master.bind('change', function () {
                if (m_values.indexOf(master.val()) != -1) slave.fadeIn();
                else slave.hide();
            });


        });


        $('.wpvr_countup').each(function () {
            var target = $(this);
            var start = target.attr('count-start');
            var end = target.attr('count-end');
            console.log(target);
            //var decimal = target.attr('opt-decimal');
            //var decimal = target.attr('opt-decimal');
            var numAnim = new CountUp(target.attr('id'), start, end, 0, 2);
            numAnim.start();

        });


        $('.wpvr_wrap_loading').hide();
        $('.wpvr_wrap').fadeIn();
        $('.wpvr_super_wrap').css('visibility', 'visible').hide().fadeIn();


        /* Showing NOtices ONe after the other */
        var nCount = 0;
        var nStart = 100;
        var nStep = 400;
        $('.wpvr_wp_notice').each(function () {
            nCount++;
            var nDelay = nStart + ( nStep * nCount );
            //console.log(nDelay);
            var notice = $(this);
            setTimeout(function () {
                notice.fadeIn();
            }, nDelay);
        });

        $('#wpvr_save_source_btn').click(function (e) {
            e.preventDefault();
            var spinner = wpvr_add_loading_spinner($(this), 'pull-right');
            $('#publishing-action #publish').trigger('click');
            $('#original_post_status').attr('value', 'publish');
            $('#hidden_post_status').attr('value', 'publish');
        });

        $('.wpvr_manual_import_trigger').click(function (e) {
            e.preventDefault();
            $('#publishing-action #publish').trigger('click');
            $('#original_post_status').attr('value', 'publish');
            $('#hidden_post_status').attr('value', 'publish');

        });

        $('.wpvr_clear_logs').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            wpvr_confirm(
                wpvr_localize.confirm_clear_logs,
                function () { //YES FCT
                    wpvr_btn_loading(btn, true);
                    $.ajax({
                        url: wpvr_globals.ajax_url,
                        type: 'POST',
                        data: {
                            action: 'wpvr_clear_logs',
                        },
                        success: function (data) {
                            wpvr_btn_loading(btn, false);
                            location.reload();
                        }
                    });
                },
                wpvr_localize.continue_only,
                function () {
                },
                wpvr_localize.cancel_button
            );
        });

        //REcursive Single Add Video
        function wpvr_single_add_video(k, videos, form_url, box, isPaused) {
            if (box.attr('work') != 1) {
                box.doClose();
                return false;
            }
            if (box.attr('pause') != 'false') {
                return false;
            }

            var spinner_id = box.attr('spinner_id');


            box.attr('k', k);
            if (k >= videos.length) {
                //console.log(' ALL VIDEOS HAVE BEEN ADDED') ;
                box.stopHighlight();
                box.doClose();


                var box2 = wpvr_show_loading_new({
                    title: wpvr_localize.work_completed,
                    text: videos.length + ' ' + wpvr_localize.videos_added_successfully + '.' + wpvr_localize.videos_added_successfully_additional,
                    pauseButton: wpvr_localize.ok_button,
                });

                //var box2 = $('#'+box2ID );

                box2.doPause(function () {
                    box2.doClose();
                    wpvr_remove_loading_spinner($('#' + spinner_id));
                });

                box2.doRemove(function () {
                    wpvr_remove_loading_spinner($('#' + spinner_id));
                });

                return false;
            }
            var video = videos[k];

            if (box.attr('is_deferred') == "1") var is_deferred_get = '1';
            else var is_deferred_get = '0';

            $('.wpvr_video#video_' + video.div_id).addClass('adding');
            var session = box.attr('session');
            var vid = video.video_id;
            $.ajax({
                type: 'POST',
                //url: form_url + '?wpvr_wpload&test_add_single_video' + is_deferred_get,
                url: wpvr_globals.ajax_url,
                data: {
                    action: 'test_add_single_video',
                    video_id: video.video_id,
                    session: session,
                    is_deferred: is_deferred_get,
                },
                success: function (response) {
                    response = wpvr_get_json(response);
                    if (response.status == 0) {
                        box.stopHighlight();
                        box.doClose();
                        $('.wpvr_video[video_id=' + vid + ']').removeClass('adding');

                        var box2 = wpvr_show_loading_new({
                            title: 'WP Video Robot - ERROR',
                            text: response.msg,
                            pauseButton: wpvr_localize.ok_button,
                        });
                        box2.doPause(function () {
                            box2.doClose();
                            wpvr_remove_loading_spinner($('#' + spinner_id));
                        });
                        box2.doRemove(function () {
                            wpvr_remove_loading_spinner($('#' + spinner_id));
                        });
                        return false;
                    }
                    data = response.data;

                    //console.log( data );

                    var new_text = wpvr_localize.work_in_progress + "... <br/><br/> <strong>" + data.title + '</strong>';
                    box.doText(new_text);

                    if (response.status == 1) {
                        //console.log(data);
                        //console.log(k + ' : ' + videos.length);
                        //var progress = (parseInt((k + 1) / videos.length) * 100 ) + '%';
                        var p = Math.round((parseInt(k) + 1 ) / videos.length * 100);
                        //console.log(p + '%');
                        box.doProgress({
                            pct: p,
                            text: (k + 1) + ' / ' + videos.length,
                        });


                        var added_video = $('.wpvr_video#video_' + video.div_id);
                        added_video.removeClass('adding').addClass('added');
                        $('.wpvr_video_edit_btn', added_video).attr('href', data.edit_link.replace('&amp;', '&'));
                        $('.wpvr_video_view_btn', added_video).attr('href', data.view_link.replace('&amp;', '&'));
                        $('.wpvr_video_edit_wrap', added_video).fadeIn();
                        $('.wpvr_video_cb', added_video).remove();
                        k++;
                        wpvr_single_add_video(k, videos, form_url, box, is_deferred);

                    } else {
                        $('.wpvr_video[video_id=' + vid + ']').removeClass('adding');
                        var boxError = wpvr_show_loading_new({
                            title: 'WP Video Robot - ERROR',
                            text: wpvr_localize.errorJSON + '<br/>' + response.msg,
                        });
                    }

                    $('.wpvr_count_checked').html(' ');

                    //$('.wpvr_test_form_res').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    $('.wpvr_video[video_id=' + vid + ']').removeClass('adding');
                    var boxError = wpvr_show_loading_new({
                        title: 'WP Video Robot - ERROR',
                        text: wpvr_localize.errorJSON + '<br/>' + thrownError,
                    });

                }
            });
        }

        function wpvr_single_add_unwanted_video(k, videos, form_url, box, isPaused) {

            if (box.attr('work') != 1) {
                box.doClose();
                return false;
            }
            if (box.attr('pause') != 'false') {
                return false;
            }

            var spinner_id = box.attr('spinner_id');

            box.attr('k', k);
            if (k >= videos.length) {
                //console.log(' ALL VIDEOS HAVE BEEN ADDED') ;
                box.stopHighlight();
                box.doClose();

                var msg;
                if( box.attr('scope') == 'global'){
                    msg = videos.length + ' ' + wpvr_localize.videos_global_unwanted_successfully + '.';
                }else {
                    msg = videos.length + ' ' + wpvr_localize.videos_source_unwanted_successfully + '.';
                }
                var box2 = wpvr_show_loading_new({
                    title: wpvr_localize.work_completed,
                    text: msg,
                    pauseButton: wpvr_localize.ok_button,
                });

                //var box2 = $('#'+box2ID );

                box2.doPause(function () {
                    box2.doClose();
                    wpvr_remove_loading_spinner($('#' + spinner_id));
                });

                box2.doRemove(function () {
                    wpvr_remove_loading_spinner($('#' + spinner_id));
                });

                return false;
            }
            var video = videos[k];

            //if (box.attr('is_deferred') == "1") var is_deferred_get = '&is_deferred';
            //else var is_deferred_get = '';

            $('.wpvr_video#video_' + video.div_id).addClass('adding');
            var session = box.attr('session');
            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: {
                    action: 'test_add_unwanted_single_video',
                    video_id: video.video_id,
                    session: session,
                    scope: box.attr('scope'),
                    source_id: video.source_id,
                },
                success: function (response) {
                    response = wpvr_get_json(response);
                    data = response.data;
                    var new_text = wpvr_localize.work_in_progress + "... <br/><br/> <strong>" + data.title + '</strong>';
                    box.doText(new_text);

                    if (response.status == 1) {
                        var p = Math.round((parseInt(k) + 1 ) / videos.length * 100);
                        box.doProgress({
                            pct: p,
                            text: (k + 1) + ' / ' + videos.length,
                        });


                        var added_video = $('.wpvr_video#video_' + video.div_id);
                        added_video.removeClass('adding').addClass('unwanted');
                        $('.wpvr_video_cb', added_video).remove();
                        k++;
                        wpvr_single_add_unwanted_video(k, videos, form_url, box);

                    } else {
                        var boxError = wpvr_show_loading_new({
                            title: 'WP Video Robot - ERROR',
                            text: wpvr_localize.errorJSON + '<br/>' + response.msg,
                        });
                    }

                    $('.wpvr_count_checked').html(' ');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var boxError = wpvr_show_loading_new({
                        title: 'WP Video Robot - ERROR',
                        text: wpvr_localize.errorJSON + '<br/>' + thrownError,
                    });

                }
            });
        }


        function wpvr_show_loading_new(args) {
            var box;
            var token = wpvr_random_token(20);
            //console.log( token );
            //jQuery(document).ready(function($) {
            if (args.hasOwnProperty('isModal') && args.isModal === true) {
                var isModal = true;
                var is_modal_class = 'is_modal';
            } else {
                var isModal = false;
                var is_modal_class = '';
            }

            if (args.hasOwnProperty('progressBar') && args.progressBar === true) {
                var progressBar =
                    '<div class="wpvr_loading_progress">' +
                    '<div class="wpvr_loading_progress_text"></div>' +
                    '<div class="wpvr_loading_progress_p"></div>' +
                    '</div>';
            } else {
                var progressBar = '';
            }

            if (args.hasOwnProperty('cancelButton')) {
                var cancelButton = '<div class="wpvr_button wpvr_loading_cancel">' + args.cancelButton + '</div>';
            } else {
                var cancelButton = '';
            }

            if (args.hasOwnProperty('title')) var title = args.title;
            else var title = '';

            if (args.hasOwnProperty('boxClass')) var boxClass = args.boxClass;
            else var boxClass = '';

            if (args.hasOwnProperty('width')) var width = args.width;
            else var width = '30%';

            if (args.hasOwnProperty('height')) var height = args.height;
            else var height = 'auto';

            if (args.hasOwnProperty('maskClass')) var maskClass = args.maskClass;
            else var maskClass = '';

            if (args.hasOwnProperty('text')) var text = args.text;
            else var text = '';

            if (args.hasOwnProperty('pauseButton')) {
                var pauseButton = '<div class="wpvr_button wpvr_loading_pause">' + args.pauseButton + '</div>';
            } else {
                var pauseButton = '';
            }

            var string =
                '<div class = "wpvr_loading_box ' + boxClass + ' ' + is_modal_class + ' " id="' + token + '" >' +
                '<div class="wpvr_loading_msg">' +
                '<div class="wpvr_loading_msg_title">' + title + '</div>' +
                '<div class="wpvr_loading_close"></div>' +
                '<div class="wpvr_loading_msg_text">' + text + '</div>' +
                '<div class="wpvr_loading_footer">' +
                progressBar +
                cancelButton +
                pauseButton +
                '</div>' +
                '</div>' +
                '</div>' +
                '<div class="wpvr_loading_mask ' + maskClass + '"></div>'
            ;
            box = $(string);
            box.css('display', 'none');
            $('.wpvr_loading_msg', box).css('width', width);
            if (height != 'auto') {
                $('.wpvr_loading_msg', box).css('height', height);
                $('.wpvr_loading_msg_text', box).css('height', '86%').css('overflow-y', 'scroll').css('padding', '0 10px 0 0');
                $('.wpvr_loading_pause', box).css('margin-top', '1em').css('float', 'right');
                $('.wpvr_loading_cancel', box).css('margin-top', '1em').css('margin-left', '0').css('float', 'left');
                $('.wpvr_loading_msg_title', box).css('margin-bottom', '1em');
            }
            $('#adminmenuwrap').css('z-index', 100);
            $('body').append(box);
            box.fadeIn('fast', 'swing');

            $('.wpvr_loading_msg', box).center();


            //Closing Dialog
            $.fn.doClose = function (e) {
                var boxin = this;
                var msg = $('.wpvr_loading_msg', boxin);
                var mask = $('.wpvr_loading_mask');
                msg.fadeOut('fast', "swing", function () {
                    //console.log('first anim over !');
                    mask.fadeOut('fast', function () {
                        //console.log('second anim over !');
                        boxin.remove();
                    })
                });
            }

            //Hiding Dialog
            $.fn.doHide = function (e) {
                var boxin = this;
                var msg = $('.wpvr_loading_msg', boxin);
                var mask = $('.wpvr_loading_mask');
                msg.fadeOut('fast', "swing", function () {
                    mask.fadeOut('fast', function () {
                    })
                });
            }

            //Showing Dialog
            $.fn.doShow = function (e) {
                var boxin = this;
                var msg = $('.wpvr_loading_msg', boxin);
                var mask = $('.wpvr_loading_mask');
                msg.fadeIn('fast', "swing", function () {
                    mask.fadeIn('fast', function () {
                    })
                });
            }
            //Highlighiting Progress Bar
            $.fn.doHighlight = function (data) {
                var progress = $('.wpvr_loading_progress_p', this);
                var highlight_interval = setInterval(function () {
                    progress.toggleClass('highlight');
                }, 300);
                this.attr('hInt', highlight_interval);
                return highlight_interval;
            }
            //Stop Highlighiting Progress Bar
            $.fn.stopHighlight = function (h) {
                var h = this.attr('hInt');
                clearInterval(h);
                $('.wpvr_loading_progress_p', this).removeClass('highlight');
            }
            //Make a progress
            $.fn.doProgress = function (data) {
                var progressBack = $('.wpvr_loading_progress_text', this);
                var progress = $('.wpvr_loading_progress_p', this);
                if (data.hasOwnProperty('pct')) progress.css({'width': data.pct + '%'});
                if (data.hasOwnProperty('text')) progressBack.html(data.text);
            }
            //Write a text
            $.fn.doText = function (text) {
                $('.wpvr_loading_msg_text', this).html(text);
            }
            //Cancel Function
            $.fn.doCancel = function (fct) {
                $('.wpvr_loading_cancel', this).bind('click', fct);
            }
            //Pause Function
            $.fn.doPause = function (fct) {
                $('.wpvr_loading_pause', this).bind('click', fct);
            }

            $.fn.doRemove = function (fct) {
                this.on("remove", fct);
            }

            //Default closing button action
            $('.wpvr_loading_close', box).bind('click', function () {
                if (args.hasOwnProperty('cancelButton')) $('.wpvr_loading_cancel', box).trigger('click');
                else box.remove();
            });

            $(document).keyup(function (e) {
                if (e.keyCode == 27) {
                    $('.wpvr_loading_close', box).trigger('click');
                }
            });

            //Defining Modal Property
            if (isModal === false) {
                var mask = $('.wpvr_loading_mask');
                mask.click(function (e) {
                    e.preventDefault();
                    box.doClose();
                });
            }

            var return_box = box;
            $('.wpvr_wrap').attr('box_id', token);
            //console.log( return_box );
            //});
            if (typeof box !== 'undefined') return box;
            else return token;

        }

        //Handle Manage Videos Refreshing
        function wpvr_manage_refresh(newPages, updatePages, filter_page) {
            //jQuery(document).ready(function($) {
            updatePages = typeof updatePages !== 'undefined' ? updatePages : false;
            newPages = typeof newPages !== 'undefined' ? newPages : false;
            filter_page = typeof filter_page !== 'undefined' ? filter_page : 1;

            var form = $('form.wpvr_manage_main_form');
            //var formUrl = form.attr('url') + '?wpvr_wpload&refresh_manage_videos&filter_page=' + filter_page;
            var formData = form.serializeArray();

            formData.push({
                name: 'action',
                value: 'refresh_manage_videos',
            });
            formData.push({
                name: 'get_filter_page',
                value: filter_page,
            });

            var msgBox = $('.wpvr_manage_page_message');
            var pageBox = $('.wpvr_manage_page_select');

            var boxWaiting = wpvr_show_loading_new({
                title: 'WP Video Robot',
                text: wpvr_localize.loadingCenter,
            });

            // console.log(formData);

            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: formData,
                //dataType: "json",
                success: function (data) {
                    boxWaiting.remove();
                    $json = wpvr_get_json(data);
                    //console.log( $json );
                    $data = $json.data;

                    //console.log( $data );

                    $('html, body').animate({scrollTop: 0}, 'slow');

                    if ($('.wpvr_manage_content').attr('is_fresh') == '1')
                        $('.wpvr_manage_content').attr('is_fresh', '0');


                    //Generates the msg
                    if ($data.total_results == 0) {
                        msgBox.html('');
                        pageBox.html('');
                        $('.wpvr_manage_content').html($data.no_results_msg);
                        return false;
                    }

                    msgBox.html(
                        wpvr_localize.showing + ' <b> ' +
                        $data.show_start + '-' +
                        $data.show_end + ' </b> ' +
                        wpvr_localize.on + ' <b> ' +
                        $data.total_results + ' </b> ' +
                        wpvr_localize.items + '.'
                    );

                    //Genrates Pages Select
                    if (newPages) wpvr_manage_render_pages('1', $data.last_page, pageBox);
                    if (updatePages) wpvr_manage_render_pages($data.actual_page, $data.last_page, pageBox);

                    //$('.wpvr_manage_content').html(data.sql);
                    $('.wpvr_manage_content').html($data.html);
                    if ($data.debug) console.log($data.debug);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    boxWaiting.remove();
                    var boxError = wpvr_show_loading_new({
                        title: 'WP Video Robot - ERROR',
                        text: wpvr_localize.errorJSON + '<br/>' + thrownError,
                    });

                }
            });
            //});
        }


        //Recursive MErging Items
        function wpvr_merge_items(k, items, box) {
            //jQuery(document).ready(function($) {
            box.attr('k', k);
            var url = box.attr('url');
            //var buffer = parseInt(box.attr('buffer'));
            var buffer = 1;

            if (k >= items.length) {
                //console.log(' ALL VIDEOS HAVE BEEN ADDED') ;
                box.stopHighlight();
                box.doClose();

                var box2 = wpvr_show_loading_new({
                    title: wpvr_localize.work_completed,
                    text: items.length + ' ' + wpvr_localize.videos_processed_successfully + '.',
                    pauseButton: wpvr_localize.ok_button,
                });
                box2.doPause(function () {
                    box2.doClose();
                    wpvr_manage_refresh(false, true);
                });
                return false;
            }

            var video = items[k];
            var videos = {};
            for (var i = 0; i < Math.min(items.length, buffer); i++) {
                videos[i] = ( items[k + i] );
            }
            //console.log( videos ) ;

            $.ajax({
                type: 'POST',
                url: url + '?wpvr_wpload&merge_items',
                //dataType : 'JSON',
                data: {
                    'items': items,
                },
                success: function (r) {
                    r = wpvr_get_json(r);
                    if (r.data.status != 'error') {
                        var kPlus = Math.min(items.length, parseInt(parseInt(k) + parseInt(buffer)));
                        var progress = (parseInt(kPlus / items.length) * 100 ) + '%';
                        var p = Math.round(kPlus + 1 / items.length * 100);
                        //console.log(p + '%');
                        box.doProgress({
                            pct: p,
                            text: ( kPlus ) + ' / ' + items.length,
                        });

                        wpvr_merge_items(kPlus, items, box)
                    } else {
                        alert('OUPS! There has been an error merging duplicates.');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
            //});
        }


        //REcursive Import Videos
        function wpvr_single_import_video(k, items, box) {
            //jQuery(document).ready(function($) {
            box.attr('k', k);
            var url = box.attr('url');
            var buffer = parseInt(box.attr('buffer'));

            if (k >= items.length) {
                //console.log(' ALL VIDEOS HAVE BEEN ADDED') ;
                box.stopHighlight();
                box.doClose();

                var box2 = wpvr_show_loading_new({
                    title: wpvr_localize.work_completed,
                    text: items.length + ' ' + wpvr_localize.videos_processed_successfully + '.',
                    pauseButton: wpvr_localize.ok_button,
                });
                box2.doPause(function () {
                    box2.doClose();
                    wpvr_manage_refresh(false, true);
                });
                return false;
            }

            var video = items[k];
            var videos = {};
            for (var i = 0; i < Math.min(items.length, buffer); i++) {
                videos[i] = ( items[k + i] );
            }
            //console.log( videos ) ;

            $.ajax({
                type: 'POST',
                url: url + '?wpvr_wpload&import_single_video',
                //dataType : 'JSON',
                data: {
                    'items': videos,
                },
                success: function (r) {
                    r = wpvr_get_json(r);
                    if (r.status != 'error') {
                        var kPlus = Math.min(items.length, parseInt(parseInt(k) + parseInt(buffer)));
                        var progress = (parseInt(kPlus / items.length) * 100 ) + '%';
                        var p = Math.round(kPlus + 1 / items.length * 100);
                        //console.log(p + '%');
                        box.doProgress({
                            pct: p,
                            text: ( kPlus ) + ' / ' + items.length,
                        });

                        wpvr_single_import_video(kPlus, items, box)
                    } else {
                        alert('OUPS! There has been an error !');
                    }
                    console.log(r);

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
            //});
        }


        //REcursive single Bulk Video Action
        function wpvr_single_bulk_action(k, items, box) {
            //jQuery(document).ready(function($) {
            box.attr('k', k);
            var url = box.attr('url');
            var action = box.attr('action');

            if (k >= items.length) {
                //console.log(' ALL VIDEOS HAVE BEEN ADDED') ;
                box.stopHighlight();
                box.doClose();

                var box2 = wpvr_show_loading_new({
                    title: wpvr_localize.work_completed,
                    text: items.length + ' ' + wpvr_localize.videos_processed_successfully + '.',
                    pauseButton: wpvr_localize.ok_button,
                });
                box2.doPause(function () {
                    box2.doClose();
                    wpvr_manage_refresh(false, true);
                });
                return false;
            }

            var video_id = items[k];

            $('.wpvr_video#video_' + video_id).addClass('adding');

            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: {
                    video_id: video_id,
                    action: 'bulk_single_action',
                    bulk_action: action,
                },
                success: function (data) {
                    var $json = wpvr_get_json(data);
                    if ($json.status == 1) {
                        //console.log(data);
                        var progress = (parseInt((k + 1) / items.length) * 100 ) + '%';
                        var p = Math.round((parseInt(k) + 1 ) / items.length * 100);
                        //console.log(p + '%');
                        box.doProgress({
                            pct: p,
                            text: (k + 1) + ' / ' + items.length,
                        });

                        $('.wpvr_video#video_' + video_id).removeClass('adding').addClass('added');
                        $('.wpvr_video_cb[name=' + video_id + ']').remove();
                        k++;
                        wpvr_single_bulk_action(k, items, box)
                    } else {
                        alert('OUPS! There has been an error !');
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

            //});
        }

        $('.wpvr_do_dialog').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var title = btn.attr('dialog_title');
            var content = btn.attr('dialog_content');
            var button = btn.attr('dialog_button');
            var isModal = btn.attr('dialog_modal');

            if (title == '' || title == undefined) title = wpvr_localize.wp_video_robot;
            if (button == '' || button == undefined) button = wpvr_localize.ok_button;
            if (content == undefined) content == 'Empty message.';
            if (isModal == undefined || isModal != 1) isModal = false;
            else isModal = true;

            var boxDialog = wpvr_show_loading({
                title: title,
                text: content,
                pauseButton: button,
                isModal: isModal,
            });
            boxDialog.doPause(function () {
                boxDialog.remove();
            });


        });

        $('.isMaster').each(function () {
            var wrap = $(this);
            var slaves = wrap.attr('masterOf').split(',');
            var mval = wrap.attr('masterValue');
            var type = wrap.attr('option_type');
            if (typeof wrap.attr('tabMasterOf') !== 'undefined') var tabSlaves = wrap.attr('tabMasterOf').split(',');
            else var tabSlaves = [];

            //console.log( tabSlaves );

            if (wrap.css('display') == 'none') var masterVisible = false;
            else var masterVisible = true;


            if (type == 'switch') {

                wrap.delegate('.wpvr_switch_btn', 'lcs-statuschange', function () {
                    if ($(this).is(':checked')) {
                        if (masterVisible) var is_on = true;
                        else var is_on = false;
                    } else var is_on = false;
                    wrap.removeClass('on').removeClass('off');
                    if (is_on) {
                        wrap.addClass('on');
                    } else {
                        wrap.addClass('off');
                    }

                    wpvr_control_slaves(slaves, is_on);
                    wpvr_control_tab_slaves(tabSlaves, is_on);
                });
                $('.wpvr_switch_btn', wrap).each(function () {
                    if ($(this).prop('checked')) var is_on = true;
                    else var is_on = false;
                    wrap.removeClass('on').removeClass('off');
                    if (is_on) {
                        wrap.addClass('on');
                    } else {
                        wrap.addClass('off');
                    }
                    wpvr_control_slaves(slaves, is_on);
                    wpvr_control_tab_slaves(tabSlaves, is_on);
                });


                $('.wpvr-onoffswitch', wrap).trigger('click').trigger('click');
                $('.wpvr-onoffswitch', wrap).bind('changeClass', function () {
                    if ($(this).hasClass('wpvr-onoffswitch-checked')) {
                        if (masterVisible) var is_on = true;
                        else var is_on = false;
                    } else var is_on = false;
                    wpvr_control_slaves(slaves, is_on);
                    wpvr_control_tab_slaves(tabSlaves, is_on);
                });

                $('.wpvr_option_button>.wpvr-onoffswitch', wrap).each(function () {
                    if ($(this).hasClass('wpvr-onoffswitch-checked')) var is_on = true;
                    else var is_on = false;
                    wpvr_control_slaves(slaves, is_on);
                    wpvr_control_tab_slaves(tabSlaves, is_on);
                });


            }

            if (type == 'select') {

                $('.wpvr_option_select', wrap).bind('change', function () {
                    if ($(this).attr('value') == mval) var is_on = true;
                    else var is_on = false;
                    wpvr_control_slaves(slaves, is_on, $(this).attr('value'));
                });

                $('.wpvr_option_select', wrap).each(function () {
                    if ($(this).attr('value') == mval) var is_on = true;
                    else var is_on = false;
                    wpvr_control_slaves(slaves, is_on, $(this).attr('value'));
                });


            }

            //console.log( slaves );


        });


        $('.wpvr_load_asyncr').each(function () {
            var wrap = $(this);
            var url = wrap.attr('url');
            var method = wrap.attr('method');
            if (method == undefined) method = 'timeout';
            //console.log( method );
            if (method == 'timeout') {
                setTimeout(function () {
                    var boxWaiting = wpvr_show_loading({
                        title: 'WP Video Robot',
                        text: wpvr_localize.loadingCenter,
                    });
                    $.ajax({
                        type: 'GET',
                        url: url + '',
                        success: function (data) {
                            //$data = wpvr_get_json( data );
                            boxWaiting.remove();
                            wrap.html(data);
                            $('.wpvr_nav_tab#a', wrap).trigger('click');
                            wrap.fadeIn();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                }, 1000);
            } else {
                wrap.click(function (e) {
                    //console.log('clicked');
                    e.preventDefault();
                    var boxWaiting = wpvr_show_loading({
                        title: 'WP Video Robot',
                        text: wpvr_localize.loadingCenter,
                    });
                    $.ajax({
                        type: 'GET',
                        url: url + '',
                        success: function (data) {
                            var response = wpvr_get_json(data);
                            //console.log( response);
                            //console.log( response.msg.msg );
                            boxWaiting.remove();
                            var boxResult = wpvr_show_loading({
                                title: 'WP Video Robot',
                                text: response.msg.msg,
                                pauseButton: 'OK',
                                isModal: false,
                            });
                            boxResult.doPause(function () {
                                boxResult.remove();
                            });
                            //console.log( data );
                            //$('.wpvr_nav_tab#a' , wrap ).trigger('click');
                            //wrap.fadeIn();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                });
            }
        });


        $('.wpvr_load_asyncr_ajax').each(function () {
            var wrap = $(this);
            var _wrap = this;
            var action = wrap.attr('action');
            var method = wrap.attr('method');
            var json = wrap.attr('json');
            if (method == undefined) method = 'timeout';
            if (json == undefined) json = false;
            else json = json == 1 ? true : false;


            var params = [];
            params.push({name: 'action', value: wrap.attr('action'),});
            params.push({name: 'json', value: json,});
            $.each(_wrap.attributes, function (index, attr) {
                if (attr.name.substr(0, 5) == 'data-') {
                    params.push({
                        name: attr.name.replace('data-', ''),
                        value: attr.value,
                    });
                }
            });
            if (method == 'timeout') {
                setTimeout(function () {
                    var boxWaiting = wpvr_show_loading({
                        title: 'WP Video Robot',
                        text: wpvr_localize.loadingCenter,
                    });
                    $.ajax({
                        type: 'POST',
                        data: params,
                        url: wpvr_globals.ajax_url,
                        success: function (data) {
                            if (json) {
                                var $json = wpvr_get_json(data);
                                var output = $json.msg;
                            } else {
                                var output = data;
                            }
                            boxWaiting.remove();
                            wrap.html(output);
                            $('.wpvr_nav_tab#a', wrap).trigger('click');
                            wrap.fadeIn();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                }, 1000);
            } else {
                wrap.click(function (e) {

                    e.preventDefault();
                    var boxWaiting = wpvr_show_loading({
                        title: 'WP Video Robot',
                        text: wpvr_localize.loadingCenter,
                    });
                    $.ajax({
                        type: 'POST',
                        data: params,
                        url: wpvr_globals.ajax_url,
                        success: function (data) {
                            if (json) {
                                var $json = wpvr_get_json(data);
                                var output = $json.msg;
                            } else {
                                var output = data;
                            }
                            boxWaiting.remove();
                            var boxResult = wpvr_show_loading({
                                title: 'WP Video Robot',
                                text: output,
                                pauseButton: 'OK',
                                isModal: false,
                            });
                            boxResult.doPause(function () {
                                boxResult.remove();
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                });
            }
        });

        $('.wpvr_metabox_button').each(function () {
            var btn = $(this);
            var url = btn.attr('url');
            //var same = btn.attr('same_window');
            btn.click(function (e) {
                e.preventDefault();

                if (btn.hasClass('wpvr_isLoading')) {
                    console.log('is loading');
                    return false;
                }
                var spinner = wpvr_add_loading_spinner(btn, 'pull-right');

                if (btn.hasClass('run')) {
                    wpvr_confirm(
                        wpvr_localize.confirm_run_sources,
                        function () { //YES FCT
                            wpvr_remove_loading_spinner(spinner);
                            if (btn.hasClass('sameWindow')) window.location.href = url;
                            else window.open(url);
                        },
                        wpvr_localize.yes,
                        function () {
                            wpvr_remove_loading_spinner(spinner);
                        },
                        wpvr_localize.cancel_button
                    );
                } else {
                    wpvr_remove_loading_spinner(spinner);
                    if (btn.hasClass('test') && btn.attr('ready') != '1') {
                        var box2 = wpvr_show_loading_new({
                            title: wpvr_localize.wp_video_robot,
                            text: wpvr_localize.save_source_first,
                            pauseButton: wpvr_localize.save_source,
                            cancelButton: wpvr_localize.cancel_button,
                        });
                        box2.doPause(function () {
                            box2.doClose();
                            $('#wpvr_save_source_btn').trigger('click');
                        });
                        box2.doCancel(function () {
                            box2.doClose();
                        });
                    } else {
                        if (btn.hasClass('sameWindow')) window.location.href = url;
                        else window.open(url);
                    }
                }
            });
        });

        $('select[name=filler_from]').each(function () {
            var select = $(this);
            select.change(function () {
                var s = select.attr('value');
                if (s == 'custom_data') $('#filler_from_custom').fadeIn();
                else $('#filler_from_custom').hide();
            });
        });

        $('.wpvr_selectize_list').each(function () {
            var field = $(this);
            var maxItems = field.attr('maxItems');
            var verifyEmail = field.hasClass('verifyEmail');
            var selectized = field;
            var $selectized = selectized.selectize({
                delimiter: ',',
                maxItems: maxItems,
                persist: false,
                create: function (input) {
                    if (verifyEmail) {
                        if (wpvr_validate_email(input)) return {value: input, text: input};
                        else {
                            var boxError = wpvr_show_loading({
                                title: wpvr_localize.wp_video_robot,
                                text: 'Please enter a valid email address.',
                                pauseButton: wpvr_localize.ok_button,
                                isModal: false,
                            });
                            boxError.doPause(function () {
                                boxError.remove();
                            });
                            return {};
                        }

                    } else {
                        return {value: input, text: input};
                    }
                }
            });
        });

        $('.wpvr_cmb_selectize').each(function () {
            var field = $(this);
            var maxItems = field.attr('maxItems');
            var selectized = $('.cmb_select', field);
            var handler_id = field.attr('service');

            if (field.hasClass('createItems')) var createItems = true;
            else var createItems = false;

            if (handler_id == '') {
                if (!createItems) var handler = $('#wpvr_source_postCats');
                else var handler = $('#wpvr_source_postTags');
            } else {
                var handler = $('#' + handler_id);
            }

            var field_id = field.attr('service');
            if (field_id) var handler = $('#' + field_id);

            var $string = handler.attr('value').trim();
            //console.log($string);
            if ($string != undefined && $string.length != 0) var selected_items = JSON.parse($string);
            else selected_items = false;

            //console.log( selected_items );

            if (field.hasClass('createItems')) var createItems = true;
            else var createItems = false;


            //console.log( selected_items );

            if (maxItems != '') {
                if (!createItems) {
                    var $selectized = selectized.selectize({
                        maxItems: maxItems,
                        items: selected_items,
                    });
                } else {
                    var $selectized = selectized.selectize({
                        items: selected_items,
                        delimiter: ',',
                        maxItems: maxItems,
                        persist: false,
                        create: function (input) {
                            return {value: input, text: input};
                        },
                    });
                }
            } else {
                if (selected_items != false) {
                    $selectized = selectized.selectize({
                        maxItems: null,
                        items: selected_items,
                    });
                } else {
                    $selectized = selectized.selectize({
                        maxItems: null,
                        items: [],
                    });
                }
            }


            function selectize_handler(obj) {
                //console.log( obj );
                var selectedItems = new Array();
                $('option', obj.currentTarget).each(function () {
                    selectedItems.push($(this).attr('value'));
                });
                var str = JSON.stringify(selectedItems, null, 2);
                //console.log( handler );
                handler.attr('value', str);
            }

            if (field.hasClass('setDefault')) {
                $selectized.selectize.setValue('default');
            }
            $selectized.on('change', selectize_handler);
            $selectized.on('initialize', selectize_handler);
        });


        $('#wpvr_test_form').fadeIn();
        $('.wpvr_show_after_load').fadeIn();


        $('#wpvr_options').each(function () {
            var wrap = $(this);
            $('.wpvr_nav_tab ').click(function (e) {
                e.preventDefault();
                var navtab = $(this);

                $('.wpvr_nav_tab').removeClass('active');
                navtab.addClass('active');

                // console.log('.wpvr_options_section[section=' + navtab.attr('id') + ']');

                $('.wpvr_options_section').hide();
                $('.wpvr_options_section[section=' + navtab.attr('id') + ']').fadeIn();

            })
        });


        $('#wpvr_options_permalinkBase').change(function () {
            var c = $(this).attr('value');
            var content = $('#wpvr_options_customPermalinkBase');
            if (c == 'custom') content.fadeIn();
            else content.fadeOut();
        });
        $('#wpvr_options_enableRewriteRule').change(function () {
            var c = $(this).prop('checked');
            var content = $('.wpvr_options_enableRewriteRule_helper');
            if (c) content.fadeIn();
            else content.fadeOut();
        });
        $('#wpvr_options_enableContentPrefix').change(function () {
            var c = $(this).prop('checked');
            var content = $('#wpvr_options_contentPrefix');
            if (c) content.fadeIn();
            else content.fadeOut();
        });
        $('#wpvr_options_enableContentSuffix').change(function () {
            var c = $(this).prop('checked');
            var content = $('#wpvr_options_contentSuffix');
            if (c) content.fadeIn();
            else content.fadeOut();
        });


        $('.__wp-switch-editor').click(function (e) {
            var btn = $(this);
            //tinyMCE.execCommand('mceToggleVisualAid' );
            // tinyMCE.execCommand('mceAddControl' );
            //console.log( tinyMCE.activeEditor );
            return false;


            var x = btn.attr('id').split('-')[0];
            var wrap = $('#wp-' + x + '-wrap');
            wrap.removeClass('html-active').removeClass('tmce-active');
            if (btn.hasClass('switch-tmce')) {
                wrap.addClass('tmce-active');
            } else if (btn.hasClass('switch-html')) {
                wrap.addClass('html-active');
            }

        });

        $('#wpvr_filler_list').each(function () {
            wpvr_filler_update();
        });

        $('body').on('click', '.wpvr_filler_remove', function (e) {
            e.preventDefault();
            var k = $(this).attr('k');
            var url = $(this).attr('url');

            wpvr_confirm(
                wpvr_localize.confirm_remove_filler,
                function () { //YES FCT
                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'remove_filler',
                            k: k,
                        },
                        success: function (data) {
                            wpvr_filler_update();
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.yes,
                function () {
                },
                wpvr_localize.cancel_button
            );

        });


        $('.wpvr_field_selectize').each(function () {
            var select = $(this);
            if (select.attr('maxItems') != '') {
                var selected_items = new Array();
                $('option', select).each(function () {
                    if ($(this).attr('c') == '1')
                        selected_items.push($(this).attr('value'));
                });
                var $select = select.selectize({
                    maxItems: select.attr('maxItems'),
                    items: selected_items,
                });
            } else {
                select.selectize();
            }
        });


        $('.wpvr_filters_toggle').each(function () {
            var btn = $(this);
            var wrap = $('.wpvr_filters_wrap');
            var superwrap = $('.tablenav.top');
            var count = 0;
            btn.click(function (e) {
                e.preventDefault();
                btn.toggleClass('on');
                superwrap.toggleClass('on');
            });

            $('.wpvr_filter_dropdown', wrap).each(function () {
                if ($(this).hasClass('active')) count++;
            });
            // console.log( count );
            if (count > 0) {
                $('.wpvr_filters_count', btn).html('(' + count + ')');
                $('.wpvr_filters_toggle').trigger('click');
            }


            //s.selectize();
        });

        $('.wpvr_filters_wrap').each(function () {
            var wrap = $(this);

            $('.wpvr_admin_filters_button.refine', wrap).click(function (e) {
                e.preventDefault();
                var spinner = wpvr_add_loading_spinner($(this));
                $('#post-query-submit').trigger('click');
            });

            $('.wpvr_admin_filters_button.clear', wrap).click(function (e) {
                e.preventDefault();
                $('.wpvr_filter_dropdown_wrap ', wrap).each(function () {
                    var $select = wpvr_dropdown_fields[$(this).attr('token')][0].selectize;
                    $select.clear();
                    $('.wpvr_admin_filters_input').attr('value', '');
                    $('#cat.postform').val('0');
                    $('#filter-by-date').val('0');
                });
            });
        });

        $('body').on('click', '#wpvr_filler_delete_all', function (e) {
            e.preventDefault();
            var btn = $(this);
            var url = btn.attr('url');
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            var is_demo = $(this).attr('is_demo');
            if (is_demo == '1') {
                var boxDemo = wpvr_show_loading({
                    title: wpvr_localize.wp_video_robot,
                    text: 'This is a demo version of WP Video Robot.<br/>For security reasons, you cannot change the options.<br/> Hope you understand.',
                    pauseButton: wpvr_localize.ok_button,
                    isModal: false,
                });
                boxDemo.doPause(function () {
                    boxDemo.remove();
                });
                boxDemo.doRemove(function () {
                    wpvr_remove_loading_spinner(spinner);
                });
                return false;
            }

            wpvr_confirm(
                wpvr_localize.confirm_delete_fillers,
                function () { //YES FCT
                    var boxWaiting = wpvr_show_loading({
                        title: 'WP Video Robot',
                        text: wpvr_localize.loadingCenter,
                    });


                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'delete_all_fillers',
                        },
                        success: function (data) {

                            boxWaiting.remove();
                            var boxResult = wpvr_show_loading({
                                title: 'WP Video Robot',
                                text: wpvr_localize.fillers_deleted,
                                cancelButton: wpvr_localize.ok_button,
                                isModal: false,
                            });
                            wpvr_filler_update();
                            boxResult.doCancel(function () {
                                boxResult.remove();
                                wpvr_remove_loading_spinner(spinner);
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.yes,
                function () {
                },
                wpvr_localize.cancel_button
            );

        });

        $('body').on('click', '#wpvr_filler_add_from_preset', function (e) {
            e.preventDefault();
            var btn = $(this);
            var url = $(this).attr('url');
            var preset = $('#filler_preset').attr('value');

            if (preset == '') {
                boxError = wpvr_show_loading({
                    title: wpvr_localize.wp_video_robot,
                    text: wpvr_localize.select_preset,
                    pauseButton: wpvr_localize.ok_button,
                    isModal: false,
                });
                boxError.doPause(function () {
                    boxError.remove();
                });
                return false;
            }

            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');

            wpvr_confirm(
                wpvr_localize.confirm_add_from_preset,
                function () { //YES FCT
                    var boxWaiting = wpvr_show_loading({
                        title: 'WP Video Robot',
                        text: wpvr_localize.loadingCenter,
                    });


                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'add_fillers_from_preset',
                            preset: preset,
                        },
                        success: function (data) {
                            wpvr_filler_update();
                            boxWaiting.remove();
                            wpvr_remove_loading_spinner(spinner);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.yes,
                function () {
                    wpvr_remove_loading_spinner(spinner);
                },
                wpvr_localize.cancel_button
            );

        });
        $('.wpvr_addons_by_cats').each(function () {
            var wrap = $(this);
            var cats = $('.wpvr_addons_categories', wrap);
            var grid = $('.wpvr_addons_grid', wrap);

            $('button', cats).click(function (e) {
                e.preventDefault();
                var btn = $(this);
                $('button', cats).removeClass('wpvr_white_button');
                btn.addClass('wpvr_white_button');
                console.log(grid.attr('id'));
                var current_cat = btn.attr('cat');
                console.log(current_cat);
                $('.wpvr_addon_box', grid).each(function () {
                    var box = $(this);
                    // var c = box.attr('categories').split(',');
                    box.hide();
                    var x = $.inArray(current_cat, box.attr('categories').split(','));
                    if (x == -1) {
                        box.hide();
                    } else {
                        box.fadeIn();
                    }
                });


            });
        });
        $('body').on('click', '#wpvr_filler_run', function (e) {
            e.preventDefault();
            var btn = $(this);
            var url = btn.attr('url');

            wpvr_confirm(
                wpvr_localize.confirm_run_fillers,
                function () { //YES FCT
                    var boxWaiting = wpvr_show_loading({
                        title: 'WP Video Robot',
                        text: wpvr_localize.loadingCenter,
                    });

                    var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'run_fillers',
                        },
                        success: function (json) {
                            //wpvr_filler_update();
                            $json = wpvr_get_json(json);
                            $data = $json.data;
                            //console.log( $data );
                            boxWaiting.remove();
                            var boxResult = wpvr_show_loading({
                                title: 'WP Video Robot',
                                text: '<strong>' + $data.found + '</strong> videos found and <strong>' + $data.processed + '</strong> fields processed. ',
                                isModal: false,
                                pauseButton: wpvr_localize.ok_button,
                            });
                            boxResult.doPause(function () {
                                boxResult.remove();
                                wpvr_remove_loading_spinner(spinner);
                            });
                            boxResult.doRemove(function () {
                                wpvr_remove_loading_spinner(spinner);
                            });

                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.yes,
                function () {
                },
                wpvr_localize.cancel_button
            );

        });

        var clipboard = new Clipboard('.wpvr_copy_btn');
        $('.wpvr_copy_btn').click(function (e) {
            e.preventDefault();
        });
        clipboard.on('success', function (e) {
            var btn = $(e.trigger);

            btn.addClass('wpvr_green_button').addClass('done');
            setTimeout(function () {
                btn.removeClass('wpvr_green_button').removeClass('done');
            }, 500);


            // console.log(btn);
            // console.log(btn.attr('done'));
            // e.trigger.html('Copied !');
        });
        clipboard.on('error', function (e) {
            console.log(e);
        });


        $('#wpvr_filler_add').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var url = btn.attr('url');
            var form = $('.' + btn.attr('form'));
            var formData = form.serialize();
            var fromInput = $('.wpvr_filler_input[name=filler_from]', form);
            var toInput = $('.wpvr_filler_input[name=filler_to]', form);
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');

            if (fromInput.attr('value') == '' || toInput.attr('value') == '') {
                var boxError = wpvr_show_loading({
                    title: 'WP Video Robot',
                    pauseButton: wpvr_localize.ok_button,
                    isModal: false,
                    text: wpvr_localize.correct_entry,
                });
                boxError.doPause(function () {
                    boxError.remove();
                    wpvr_remove_loading_spinner(spinner);
                });
                boxError.doRemove(function () {
                    wpvr_remove_loading_spinner(spinner);
                });
                return false;
            }
            $('#wpvr_filler_list').html('<i class="fa fa-cogs fa-spinner"></i>');
            var boxWaiting = wpvr_show_loading({
                title: 'WP Video Robot',
                text: wpvr_localize.loadingCenter,
            });

            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: formData,
                success: function () {
                    boxWaiting.remove();
                    wpvr_remove_loading_spinner(spinner);
                    //$('#wpvr_filler_list').html( $data );
                    fromInput.attr('value', '');
                    toInput.attr('value', '');
                    $('#filler_from_custom').attr('value', '').hide();
                    wpvr_filler_update();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });


        });


        $('.wpvr_track_dups').click(function (e) {
            e.preventDefault();
            window.open($(this).attr('url'), '_blank');
        });
        function wpvr_apiConnect_update_options(val, deact) {
            if (deact) return false;
            if (val == 'advanced') {
                $('.wizard_wrap').hide();
                $('.advanced_wrap').fadeIn();
            } else {
                $('.wizard_wrap').fadeIn();
                $('.advanced_wrap').hide();
            }
        }

        $('#wpvr_options_apiConnect').change(function () {
            wpvr_apiConnect_update_options($(this).val());
        });
        $('#wpvr_options_apiConnect').trigger('change');
        $('#wpvr_options_apiConnect').each(function () {
            //var v = $(this).attr('value') ;
            //console.log( v );
            wpvr_apiConnect_update_options($(this).attr('value'));
        });


        // wpvr_apiConnect_update_options( $('#wpvr_options_apiConnect').val() );

        $('.wpvr_single_unwanted').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var icon = $('i', btn);
            var url = btn.attr('url');
            var post_id = btn.attr('post_id');
            var action = btn.attr('action');
            wpvr_startLoading(icon);
            $.ajax({
                url: wpvr_globals.ajax_url,
                type: 'POST',
                data: {
                    action: 'add_remove_unwanted',
                    post_id: post_id,
                    wpvr_action: action,
                },
                success: function (data) {
                    $json = wpvr_get_json(data);
                    //console.log( $json );
                    wpvr_stopLoading(icon);
                    if ($json.status == 1) {
                        //console.log( action );
                        if (action == 'remove') {
                            icon.removeClass('fa-undo').addClass('fa-ban');
                            $('span', btn).html(wpvr_localize.add_to_unwanted);
                            btn.attr('action', 'add');
                            btn.removeClass('wpvr_black_button').addClass('wpvr_red_button');

                        }

                        if (action == 'add') {
                            icon.removeClass('fa-ban').addClass('fa-undo');
                            $('span', btn).html(wpvr_localize.remove_from_unwanted);
                            btn.attr('action', 'remove');
                            btn.addClass('wpvr_black_button').removeClass('wpvr_red_button');
                        }
                    }

                }
            });

        });
        $('.wpvr_sidebar_toggle').click(function (e) {
            e.preventDefault();
            if ($(this).hasClass('on')) {
                $(this).removeClass('on');
                $('.wpvr_manage_box').removeClass('open');
            } else {
                $(this).addClass('on');
                $('.wpvr_manage_box').addClass('open');
            }

        });
        $('.wpvr_get_token').click(function (e) {
            e.preventDefault();
            var opt = $(this).closest('.wpvr_option');
            var url = $(this).attr('auth_url');
            var local = $(this).attr('local');
            var service = $(this).attr('service');
            var token_input_id = $(this).attr('token_input_id');
            var win = window.open(
                url,
                "grant_window",
                "width=730,height=550"
            );

            //console.log( win.parent.getElementById( token_input_id )) ;

            var pollTimer = window.setInterval(function () {
                try {
                    //console.log(win.document.URL);
                    var q = $.getQueryParameters(win.document.URL);

                    // Custom API access token
                    if (typeof q.register_token !== 'undefined' && typeof q.access_token !== 'undefined' && q.access_token != '') {
                        window.clearInterval(pollTimer);
                        box = wpvr_show_loading({
                            title: wpvr_localize.wp_video_robot,
                            text: service.toUpperCase() + ' ' + wpvr_localize.is_now_connected,
                            pauseButton: wpvr_localize.ok_button,
                            isModal: false,
                        });
                        box.doPause(function () {
                            box.remove();
                            $('#' + token_input_id).attr('value', q.access_token);
                            $('.wpvr_expire')
                                .removeClass('red')
                                .removeClass('yellow')
                                .removeClass('green')
                                .removeClass('orange')
                                .addClass('green')
                            ;
                            $('.wpvr_expire span').html('TOKEN RENEWED');
                        });


                    }
                    //REgular API Wizard Elements
                    if (win.document.URL.indexOf('wpvr.actions.php') != -1) {
                        window.clearInterval(pollTimer);
                        var box = wpvr_show_loading({
                            title: wpvr_localize.wp_video_robot,
                            text: service.toUpperCase() + ' ' + wpvr_localize.is_now_connected,
                            //text : 'YOUTUBE CONNECTED !',
                            pauseButton: wpvr_localize.ok_button,
                            isModal: false,
                        });
                        box.doPause(function () {
                            box.remove();
                            $('.wpvr_token_state[service=' + service + ']').removeClass('off').addClass('on');
                            $('.wpvr_grid_option[service=' + service + ']').removeClass('off').addClass('on');
                        });
                    }
                } catch (e) {
                }
            }, 100);


        });

        $('.wpvr_remove_token').click(function (e) {
            e.preventDefault();
            var service = $(this).attr('service');
            var url = $(this).attr('url');
            var opt = $(this).closest('.wpvr_option');

            wpvr_confirm(
                wpvr_localize.confirm_cancel_access,
                function () { //YES FCT
                    $.ajax({
                        url: wpvr_globals.ajax_url,
                        type: 'POST',
                        data: {
                            service: service,
                            action: 'wpvr_clear_token',
                        },
                        success: function (data) {
                            console.log(data);
                            $('.wpvr_token_state[service=' + service + ']').removeClass('on').addClass('off');
                            $('.wpvr_grid_option[service=' + service + ']').removeClass('on').addClass('off');
                        }
                    });
                },
                wpvr_localize.yes,
                function () {
                },
                wpvr_localize.cancel_button
            );


        });


        $('.wpvr_addon_options_wrapper').each(function () {
            var wrap = $(this);
            var addon_id = $(this).attr('addon_id');
            var form = $('.wpvr_addons_options_form', wrap);

            //console.log( addon_id );

            $('.wpvr_save_addon_options', wrap).each(function () {
                var btn = $(this);
                var url = btn.attr('url');
                var tab = btn.attr('tab');

                btn.click(function (e) {
                    e.preventDefault();

                    //Saving the tinyMCE contents
                    if (typeof(tinyMCE) != "undefined") {
                        for (var i = 0; i < tinymce.editors.length; i++) {
                            tinymce.editors[i].save();
                        }
                    }

                    if (btn.hasClass('wpvr_isLoading'))    return false;

                    var data = form.serializeArray();
                    data.push({
                        name: 'action',
                        value: 'save_addon_options',
                    }, {
                        name: 'tab',
                        value: tab,
                    }, {
                        name: 'id',
                        value: addon_id,
                    })
                    var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
                    $.ajax({
                        type: 'POST',
                        data: data,
                        url: wpvr_globals.ajax_url,
                        success: function (data) {
                            var $data = wpvr_get_json(data);
                            var $done = $data.data;
                            //console.log($done);
                            if ($data.status == 1) {
                                var box_ok = wpvr_show_loading({
                                    title: 'WP VIDEO ROBOT',
                                    text: wpvr_localize.addon_options_saved,
                                    cancelButton: wpvr_localize.ok_button,
                                    isModal: false,
                                });
                                box_ok.doCancel(function () {
                                    box_ok.remove();
                                    wpvr_remove_loading_spinner(spinner);
                                    btn.removeClass('wpvr_isLoading');
                                });
                                box_ok.doRemove(function () {
                                    wpvr_remove_loading_spinner(spinner);
                                    $('#addon_update_existing_videos').addClass('wpvr_green_button').fullShake();
                                });
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                });
            });

            $('#addon_update_existing_videos', wrap).each(function () {
                var btn = $(this);


                btn.click(function (e) {
                    btn.removeClass('wpvr_green_button');
                    //console.log( btn.data('anim') );
                    clearInterval(btn.data('anim'));
                    e.preventDefault();
                    var spinner = wpvr_add_loading_spinner(btn, 'pull-left');
                    $.ajax({
                        type: 'POST',
                        data: {
                            action: 'update_existing_videos',
                        },
                        url: wpvr_globals.ajax_url,
                        success: function (data) {
                            var $json = wpvr_get_json(data);
                            console.log($json);
                            wpvr_remove_loading_spinner(spinner);
                            var box_ok = wpvr_show_loading({
                                title: 'WP VIDEO ROBOT',
                                text: wpvr_localize.existing_videos_updated + '<br/><br/>' +
                                wpvr_localize.details + ' : ' +
                                '<div class="job_details">' +
                                $json.data.details +
                                '</divclass>'
                                ,
                                cancelButton: wpvr_localize.ok_button,
                                isModal: false,
                            });
                            box_ok.doCancel(function () {
                                box_ok.remove();
                                location.reload();
                            });
                            box_ok.doRemove(function () {
                                wpvr_remove_loading_spinner(spinner);
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                })
            });


            $('.wpvr_reset_addon_options', wrap).each(function () {
                var btn = $(this);
                var url = btn.attr('url');

                btn.click(function (e) {
                    e.preventDefault();
                    wpvr_confirm(
                        wpvr_localize.options_reset_confirm,
                        function () {
                            var spinner = wpvr_add_loading_spinner(btn, 'pull-left');
                            $.ajax({
                                type: 'POST',
                                data: {
                                    action: 'reset_addon_options',
                                    id: addon_id,
                                },
                                url: wpvr_globals.ajax_url,
                                success: function () {
                                    wpvr_remove_loading_spinner(spinner);
                                    var box_ok = wpvr_show_loading({
                                        title: 'WP VIDEO ROBOT',
                                        text: wpvr_localize.options_set_to_default,
                                        cancelButton: wpvr_localize.ok_button,
                                        isModal: false,
                                    });
                                    box_ok.doCancel(function () {
                                        box_ok.remove();
                                        location.reload();
                                    });
                                    box.doRemove(function () {
                                        wpvr_remove_loading_spinner(spinner);
                                    });
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    alert(thrownError);
                                }
                            });
                        },
                        wpvr_localize.reset_yes,
                        function () {
                        },
                        wpvr_localize.reset_no
                    );
                });
            });
        });


        $('.wpvr_manage_import').bind('click', function (e) {
            e.preventDefault();
            var form_url = $(this).attr('url');
            var bulk_url = $(this).attr('bulk_url');
            var buffer = $(this).attr('buffer');

            var iForm = '';
            //iForm += 'BUFFER='+buffer;
            iForm += '<form id="form_import_videos" enctype="multipart/form-data">';
            iForm += '<input type="hidden" name="action" value="wpvr_import_videos">';
            iForm += '<label for="upload">Choose a file </label>';
            iForm += '<input type="file" id="upload" name="uploadedfile" size="25">';
            iForm += '<br/>';
            iForm += '<label>Publish</label> ';
            iForm += '<select name="publishDate">';
            iForm += '	<option value="original">Keep original</option>';
            iForm += '	<option value="now" selected="selected">Publish Now</option>';
            iForm += '</select>';
            iForm += '<br/>';

            iForm += '<label> Reset Views </label>';
            iForm += '<select name="resetViews">';
            iForm += '	<option value="yes">' + wpvr_localize.yes + '</option>';
            iForm += '	<option value="no" selected="selected">' + wpvr_localize.yes + '</option>';
            iForm += '</select>';
            iForm += '<br/>';
            iForm += '<label>Skip Duplicates </label>';
            iForm += '<select name="skipDup">';
            iForm += '	<option value="yes">yes</option>';
            iForm += '	<option value="no" selected="selected">No</option>';
            iForm += '</select>';
            iForm += '</form>';

            var box = wpvr_show_loading({
                title: wpvr_localize.import_videos,
                text: iForm,
                pauseButton: wpvr_localize.import_btn,
                cancelButton: wpvr_localize.cancel_button,
                isModal: false,
            });
            box.doCancel(function () {
                box.remove();

            });
            box.doPause(function () {
                var file = $('#upload').attr('value');
                if (file == '') return false;
                var form = $('#form_import_videos');
                var btn = $('.wpvr_loading_pause');
                var spinner = wpvr_add_loading_spinner(btn);
                var form_data = new FormData(document.getElementById("form_import_videos"));
                console.log(form_data);

                return;
                $.ajax({
                    url: wpvr_globals.ajax_url,
                    type: 'POST',
                    data: form_data,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $data = wpvr_get_json(data);

                        wpvr_remove_loading_spinner(spinner);
                        if ($data.status != 'ok') {
                            if ($data.status == 'invalid') {
                                alert('Invalid File');
                                box.remove();
                                return false;
                            }
                        } else {
                            if ($data.countDup != '0') {
                                // FOUND DUPS
                                if ($data.countDup != $data.count) {
                                    // Found Dups and NEw Videos

                                    wpvr_confirm(
                                        //wpvr_localize.confirm_cancel_access ,
                                        'FOUND ' + $data.countDup + ' Duplicates. CONTINUE ?',
                                        function () { //YES FCT
                                            boxDup.remove();
                                            wpvr_apply_bulk_import($data.items, bulk_url, buffer)
                                            box.remove();
                                        },
                                        wpvr_localize.yes,
                                        function () {
                                            box.remove();
                                        },
                                        wpvr_localize.cancel_button
                                    );


                                } else {
                                    //Found dups and no new items
                                    box.remove();
                                    boxDup = wpvr_show_loading({
                                        title: wpvr_localize.wp_video_robot,
                                        text: 'There is no new video ! Only dups',
                                        pauseButton: wpvr_localize.ok_button,
                                        isModal: false,
                                    });
                                    boxDup.doPause(function () {
                                        boxDup.remove();
                                        //wpvr_apply_bulk_import( data.items , bulk_url , buffer)
                                        box.remove();

                                    });
                                }


                            } else {
                                // NODUPS
                                wpvr_apply_bulk_import($data.items, bulk_url, buffer)
                                box.remove();
                            }
                            /*console.log( data.items);
                             wpvr_apply_bulk_import( data.items , bulk_url , buffer)
                             box.remove();
                             */

                        }


                    }
                });
            });


        });


        $('.cmb_option[name=wpvr_video_service] , .cmb_option[name=wpvr_source_service]').change(function () {

            $('.cmb_id_wpvr_pick_a_service').fadeOut(150);
            $('.cmb_id_wpvr_video_enableManualAdding').fadeIn(150);
            $('.cmb_id_wpvr_video_disableAutoEmbed ').fadeIn(150);
            $('.cmb_id_wpvr_source_type').fadeIn(150);
        });

        //$('#publish').each(function(){
        $('[id=publish]').each(function () {
            //console.log( $(this) );
            $(this).click(function (e) {
                var obj = $('.cmb_id_wpvr_source_service');
                var btn = $(this);
                var k = 0;
                var noSelect = true;

                if (obj.hasClass('canBeEmpty')) var canBeEmpty = true;
                else var canBeEmpty = false;

                //console.log( canBeEmpty );

                e.preventDefault();

                var service_selected = 'none';
                $('.cmb_option[name=wpvr_source_service]').each(function () {
                    if ($(this).prop('checked')) service_selected = $(this).val();
                });


                var name = $('#wpvr_source_name').attr('value');
                var max_wanted = obj.attr('service');
                var wanted = $('#wpvr_source_wantedVideos').attr('value');

                $('.cmb_option[name=wpvr_source_type]').each(function () {
                    k++;


                    if ($(this).prop('checked')) {
                        if (service_selected == $(this).attr('service')) noSelect = false;
                    }
                });


                //return false;

                if (k != 0 && noSelect) {
                    var box = wpvr_show_loading({
                        title: wpvr_localize.wp_video_robot,
                        text: wpvr_localize.source_with_no_type,
                        pauseButton: wpvr_localize.ok_button,
                        isModal: false,
                    });
                    box.doPause(function () {
                        box.remove();
                    });
                } else {
                    if (max_wanted != '' && parseInt(wanted) > parseInt(max_wanted)) {
                        var box = wpvr_show_loading({
                            title: wpvr_localize.wp_video_robot,
                            text: wpvr_localize.source_with_big_wanted,
                            pauseButton: wpvr_localize.ok_button,
                            isModal: false,
                        });
                        box.doPause(function () {
                            box.remove();
                        });
                        return false;
                    }


                    if (!canBeEmpty && name == '') {
                        wpvr_confirm(
                            wpvr_localize.source_with_no_name,
                            function () { //YES FCT
                                btn.unbind('click').click();
                            },
                            wpvr_localize.yes,
                            function () {
                            },
                            wpvr_localize.cancel_button
                        );
                    } else {
                        btn.unbind('click').click();
                    }
                }

            });
        });

        setTimeout(function () {

            $('.wpvr_manage_content').each(function () {
                if ($(this).attr('refresh_once') != '1') return false;
                if ($(this).attr('is_fresh') == '1') {
                    $(this).attr('is_fresh', '0');
                    wpvr_manage_refresh(false, true, 1);

                }

            });

        }, 200);
        $('.wpvr_manage_exportAll').live('click', function (e) {

            e.preventDefault();
            var url = $(this).attr('url');
            var boxWaiting = wpvr_show_loading({
                title: 'WP Video Robot',
                text: wpvr_localize.loadingCenter,
                //text : 'WAIT ...',
            });
            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: {
                    action: 'export_all_videos',
                },
                success: function (data) {
                    boxWaiting.remove();
                    var $json = wpvr_get_json(data);
                    if ($json.status == 1) {
                        $('.wpvr_manage_message').html('<iframe id="wpvr_iframe" src="" style="display:none; visibility:hidden;"></iframe>');
                        $('#wpvr_iframe').attr('src', $json.data);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

        });

        $('.wpvr_select_page').on('change', function () {
            var p = $(this).attr('value');
            var url = $(this).attr('url');
            window.location.href = url + '&p=' + p;
        });

        $('.wpvr_select_service').on('change', function () {
            var p = $(this).attr('value');
            var url = $(this).attr('url');
            window.location.href = url + '&service=' + p;
        });

        $('.wpvr_search_within').on('keyup', function (e) {
            // alert('koko');
            if (e.keyCode == 13) {
                var url = $(this).attr('url');
                var value = $(this).attr('value');
                window.location.href = url + '&p=1&searchterm=' + value;
            }
        });

        $('.wpvr_manage_pageButton').live('click', function () {
            var aPage = $(this).attr('page');
            $('#wpvr_page').val(aPage);
            wpvr_manage_refresh(false, true, aPage);
        });

        function wpvr_apply_bulk_import(items, bulk_url, buffer) {

            var msgBox = $('.wpvr_import_message');

            if (items.length == 0) return false;

            var box = wpvr_show_loading({
                title: wpvr_localize.please_wait,
                text: wpvr_localize.work_in_progress + "...",
                progressBar: true, // OR window
                cancelButton: wpvr_localize.cancel_button, // OR window
                isModal: true,
            });

            box.doProgress({pct: 1, text: wpvr_localize.loading + ''});
            box.doHighlight();
            box.attr('work', 1);
            box.attr('url', bulk_url);
            box.attr('buffer', buffer);


            box.doCancel(function () {
                box.doHide();
                wpvr_confirm(
                    wpvr_localize.really_want_cancel,
                    function () {
                        box.doShow();
                    },
                    wpvr_localize.continue_button,
                    function () { //IF yes
                        box.attr('work', 0);
                        var k = box.attr('k');
                    },
                    wpvr_localize.cancel_anyway
                );
            });
            wpvr_single_import_video(0, items, box);
        }


        function wpvr_apply_bulk_action(bulk_action, ids, views) {
            var wrapper = $('#wpvr_manage_videos');
            var bulk_url = wpvr_globals.ajax_url;
            if (!bulk_action) {
                var bulk_action = $('.wpvr_manage_bulk_actions_select').attr('value');
                isManual = true;
            } else isManual = false;


            if (bulk_action == '') return false;
            var msgBox = $('.wpvr_manage_message');


            var items = [];
            $('.wpvr_video_cb', wrapper).each(function () {
                if ($(this).prop('checked')) items.push($(this).attr('value'));
            });
            if (items.length == 0) return false;
            var box = wpvr_show_loading({
                title: wpvr_localize.please_wait,
                text: wpvr_localize.work_in_progress + "...",
                progressBar: true, // OR window
                cancelButton: wpvr_localize.cancel_button, // OR window
                isModal: true,
            });

            box.doProgress({pct: 1, text: wpvr_localize.loading + ''});
            box.doHighlight();
            box.attr('work', 1);
            box.attr('action', bulk_action);
            box.attr('url', bulk_url);


            box.doCancel(function () {
                box.doHide();
                wpvr_confirm(
                    wpvr_localize.really_want_cancel,
                    function () {
                        box.doShow();
                    },
                    wpvr_localize.continue_button,
                    function () { //IF yes
                        box.attr('work', 0);
                        var k = box.attr('k');
                    },
                    wpvr_localize.cancel_anyway
                );
            });
            wpvr_single_bulk_action(0, items, box);
        }


        $('.wpvr_manage_bulkApply').click(function (e) {
            e.preventDefault();
            var bulk_action = $('.wpvr_manage_bulk_actions_select').attr('value');
            if (bulk_action == 'export') {


                var form = $('form.wpvr_manage_main_form');
                var formUrl = form.attr('url') + '?wpvr_wpload&export_videos';
                var formData = form.serializeArray();
                formData.push({
                    name: 'action',
                    value: 'export_videos',
                });

                var boxWaiting = wpvr_show_loading({
                    title: 'WP Video Robot',
                    text: wpvr_localize.loadingCenter,
                    //text : 'WAIT ...',
                });

                //return false;
                $.ajax({
                    type: 'POST',
                    url: wpvr_globals.ajax_url,
                    data: formData,
                    //dataType: "json",
                    success: function (data) {
                        boxWaiting.remove();
                        var $json = wpvr_get_json(data);
                        //console.log( $json );
                        if ($json.status == 1) {
                            $('.wpvr_manage_message').html('<iframe id="wpvr_iframe" src="" style="display:none; visibility:hidden;"></iframe>');
                            $('#wpvr_iframe').attr('src', $json.data);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });

            } else if (bulk_action == 'delete') {
                wpvr_confirm(
                    wpvr_localize.want_remove_items,
                    function () {
                        wpvr_apply_bulk_action();
                    },
                    wpvr_localize.yes
                    ,
                    function () {
                    },
                    wpvr_localize.cancel_button
                );
            } else {
                wpvr_apply_bulk_action();
            }

        });


        //Check All sections
        $('.wpvr_manage_checkAll').each(function () {

            $(this).bind('click', function (e) {
                e.preventDefault();
                var zone = $('#wpvr_manage_videos');
                if ($(this).attr('state') == 'off') {
                    $('.wpvr_video_cb', zone).prop('checked', true);
                    $('.wpvr_video', zone).addClass('checked');
                    $('.wpvr_manage_checkAll').attr('state', 'on');
                } else {
                    $('.wpvr_video_cb', zone).prop('checked', false);
                    $('.wpvr_video', zone).removeClass('checked');
                    $('.wpvr_manage_checkAll').attr('state', 'off');
                }
                wpvr_count_checked();
            });

        });


        /* Manage Sidebar Boxes */
        $('.wpvr_manage_box').each(function () {
            var box = $(this);
            var head = $('.wpvr_manage_box_head ', box);
            head.click(function (e) {
                e.preventDefault();
                box.toggleClass('open');
            });

        });


        //wpvr_manage_refresh();
        $('.wpvr_page').live('change', function () {
            wpvr_manage_refresh(false, true);
        });


        $('.wpvr_manage_refresh').bind('click', function (e) {
            e.preventDefault();
            wpvr_manage_refresh(false, true);
        });
        $('.wpvr_manage_search_button').bind('click', function (e) {
            e.preventDefault();
            wpvr_manage_refresh(false, true);
        });


        $('.wpvr_manage_check_ul li').each(function () {
            var li = $(this);
            var cb = $('input[type=checkbox]', li);
            cb.change(function () {
                if (cb.prop('checked')) li.addClass('checked');
                else li.removeClass('checked');
                var n = 0;
                $('.wpvr_manage_check_ul li input[type=checkbox]').each(function () {
                    if ($(this).prop('checked')) n++;
                });

                if (n >= 1) $('.wpvr_manage_is_filtering').attr('value', '1');
                else $('.wpvr_manage_is_filtering').attr('value', '0');

            });


        });


        /* CLICKS the manage_layout btns */
        $('.wpvr_layout_btn').bind('click', function (e) {
            e.preventDefault();
            var layout = $(this).attr('layout');
            $('.wpvr_layout_btn').removeClass('active');
            $(this).addClass('active');

            $('#wpvr_manage_videos').removeClass('bgrid').removeClass('sgrid').removeClass('grid').removeClass('list');
            $('#wpvr_manage_videos').addClass(layout);

            $('.wpvr_manage_layout_hidden').attr('value', layout);

        });


        /* GLOBAL FUNCTION  *************************************************************************************/

        // Count video ids entered
        $('.wpvr_wh_updater').each(function () {
            $(this).bind('change', function () {
                var start = $('#wpvr_options_wakeUpHoursA').attr('value');
                var end = $('#wpvr_options_wakeUpHoursB').attr('value');
                var rBox = $('#wpvr_options_wakeUpHours_graph');
                $.ajax({
                    url: wpvr_globals.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'wpvr_update_wakeUpHours',
                        start: start,
                        end: end
                    },
                    success: function (data) {
                        rBox.html(data);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });


            });
        });

        // Count items inside
        $('.countMyItems').each(function () {
            var wrap = $(this);
            var listener_id = wrap.attr('prefix') + wrap.attr('listener');
            var listener = $('#' + listener_id);
            var counter = $('.wpvr_count_items', wrap);

            wpvr_update_count(listener, counter);
            listener.bind('keyup', function () {
                wpvr_update_count(listener, counter);
            });
            listener.bind('change', function () {
                //console.log('Listener Changed');
                wpvr_update_count(listener, counter);
            });
        });

        // Count video ids entered
        $('#wpvr_source_videoIds').each(function () {
            wpvr_update_count($(this), $('.wpvr_count_videos'));
            $(this).bind('keyup', function () {
                wpvr_update_count($(this), $('.wpvr_count_videos'));
            });
        });

        // Count video ids entered
        $('#wpvr_source_groupIds').each(function () {
            wpvr_update_count($(this), $('.wpvr_count_groups'));
            $(this).bind('keyup', function () {
                wpvr_update_count($(this), $('.wpvr_count_groups'));
            });
        });

        // Count playlist ids entered
        $('#wpvr_source_playlistIds').each(function () {
            wpvr_update_count($(this), $('.wpvr_count_playlists'));
            $(this).bind('keyup', function () {
                wpvr_update_count($(this), $('.wpvr_count_playlists'));
            });
        });

        // Count channnel ids entered
        $('#wpvr_source_channelIds').each(function () {
            wpvr_update_count($(this), $('.wpvr_count_channels'));
            $(this).bind('keyup', function () {
                wpvr_update_count($(this), $('.wpvr_count_channels'));
            });
        });

        // Count channnel2 ids entered
        $('#wpvr_source_videoIds_dm').each(function () {
            wpvr_update_count($(this), $('.wpvr_count_videos_dm'));
            $(this).bind('keyup', function () {
                wpvr_update_count($(this), $('.wpvr_count_videos_dm'));
            });
        });

        //Make Switch Function
        $('.wpvr_make_switch').each(function () {
            var cb = $(this);
            var cbId = cb.attr('id');
            var cbClass = cb.attr('class');
            var cbName = cb.attr('name');
            if (cb.prop('checked')) var cbChecked = ' checked = "checked" ';
            else var cbChecked = '';
            var str =
                '<div class="wpvr-onoffswitch">' +
                '<input type="checkbox" name="' + cbName + '" class="wpvr-onoffswitch-checkbox ' + cbClass + '" id="' + cbId + '" ' + cbChecked + ' />' +
                '<label class="wpvr-onoffswitch-label" for="' + cbId + '">' +
                '<span class="wpvr-onoffswitch-inner">' +
                '<span class="wpvr-onoffswitch-active"><span class="wpvr-onoffswitch-switch">ON</span></span>' +
                '<span class="wpvr-onoffswitch-inactive"><span class="wpvr-onoffswitch-switch">OFF</span></span>' +
                '</span>' +
                '</label>' +
                '</div>'
            ;
            cb.after($(str));
            cb.remove();
        });

        $('.wpvr-onoffswitch-label').live('click', function () {
            var label = $(this);
            var parent = label.parent();
            var input = $('.wpvr-onoffswitch-checkbox', parent).get(0);
            parent.toggleClass('wpvr-onoffswitch-checked').trigger('changeClass');
            //if( parent.hasClass('wpvr-onoffswitch-checked') ) $(input).removeClass('isNotChecked').addClass('isChecked').prop('checked' , true );
            //else $(input).removeClass('isChecked').addClass('isNotChecked').prop('checked' , false );
            //input.prop("checked", !input.prop("checked"));

        });

        //JS single add video

        /*******************************************************************************************************/


        /* OPTIONS  *************************************************************************************/
        //Show System Infos
        $('body').on('click', '#wpvr_system_infos', function (e) {
            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))    return false;

            // var formUrl = btn.attr('url');
            var spinner = wpvr_add_loading_spinner(btn, 'pull-left');


            $.ajax({
                type: 'POST',
                data: {
                    action: 'wpvr_system_info',
                },
                url: wpvr_globals.ajax_url,
                success: function (data) {
                    var $data = wpvr_get_json(data);
                    wpvr_remove_loading_spinner(spinner);
                    var box2 = wpvr_show_loading({
                        title: wpvr_localize.system_infos,
                        width: '55%',
                        text: $data.data,
                        cancelButton: wpvr_localize.close_button,
                        pauseButton: wpvr_localize.export_button,
                    });
                    var exportBtn = $('.wpvr_loading_pause', box2);
                    box2.doPause(function () {
                        var spinnerExport = wpvr_add_loading_spinner(exportBtn, 'pull-left');
                        $.ajax({
                            type: 'POST',
                            data: {
                                action: 'wpvr_system_info',
                                do_export: '1',
                            },
                            url: wpvr_globals.ajax_url,
                            success: function (data) {
                                wpvr_remove_loading_spinner(spinnerExport);
                                var $json = wpvr_get_json(data);
                                console.log($json);
                                if ($json.status == 1) {
                                    $('#wpvr_export').html('<iframe id="wpvr_iframe" src="" style="display:none; visibility:hidden;"></iframe>');
                                    $('#wpvr_iframe').attr('src', $json.data);
                                }

                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                alert(thrownError);
                            }
                        });

                    });

                    box2.doCancel(function () {
                        box2.doClose();
                        wpvr_remove_loading_spinner(spinner);
                    });

                    box2.doRemove(function () {
                        wpvr_remove_loading_spinner(spinner);
                    });

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        //Select Images in Addon Options
        $('.wpvr_addon_option_select_image').each(function () {
            var w = $(this);
            var destSelect = $('#' + w.attr('destSelect'));
            $('li', w).click(function (e) {
                e.preventDefault();
                var btn = $(this);
                $('.wpvr_addon_option_select_image li').removeClass('active');
                btn.addClass('active');
                destSelect.val(btn.attr('v'));

            });
        });
        $('#post_template').change(function () {
            option_select_image_update($(this));
        });
        option_select_image_update($('#post_template'));
        function option_select_image_update(select) {
            var s = select.attr('value');
            var id = select.attr('id');
            $('.wpvr_addon_option_select_image[destSelect=' + id + '] li').removeClass('active');
            if (s != '') $('.wpvr_addon_option_select_image[destSelect=' + id + '] li[v=' + s + ']').addClass('active');

        }


        $('body').on('click', '.wpvr_nav_tab', function (e) {
            e.preventDefault();
            var id = $(this).attr('id');
            //console.log( id );
            var destid = $(this).attr('destid');
            if ($(this).hasClass('isLink')) {
                window.open($(this).attr('href'), '_blank');
                return false;
            }
            if ($(this).hasClass('noTab')) return false;
            $('.wpvr_nav_tab').removeClass('active');
            $(this).addClass('active');

            if (typeof destid !== 'undefined') {

                $('#' + destid + ' .wpvr_nav_tab_content').hide();
                $('#' + destid + ' .wpvr_nav_tab_content.tab_' + id).fadeIn();
                //$('#' + destid + ' .wpvr_option.tab_' + id + '[skipFade!=1]').not('.tabFix').fadeIn();
            } else {
                $('.wpvr_nav_tab_content').hide();
                $('.wpvr_nav_tab_content.tab_' + id).fadeIn();
                //$('.wpvr_option.tab_' + id + '[skipFade!=1]').not('.tabFix').fadeIn();
            }

            $('.wpvr_wrap').css('visibility', 'visible');
        });

        //Tab options
        $('body').on('click', '.wpvr_nav_link', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            window.open(url);

            $('.wpvr_nav_tab#b').trigger('click');

            return false;
        });


        $('.wpvr_nav_tab.active').trigger('click');
        $('.wpvr_addons_wrapper').fadeIn();

        //Tab options
        $('body').on('click', '.wpvr_addons_tab', function (e) {
            e.preventDefault();
            var id = $(this).attr('addon_id');

            $('.wpvr_addons_tab').removeClass('active');
            $(this).addClass('active');
            $('.wpvr_addon_content').hide();
            $('.wpvr_addon_content#' + id).fadeIn();
            $('.wpvr_addons_wrapper').css('visibility', 'visible');
        });

        $('.wpvr_addons_tab.active').trigger('click');

        //Schedule Source
        $('body').on('click', '.wpvr_add_schedule', function (e) {

            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))    return false;
            var sf = '';
            sf += '<form class="wpvr_schedule_add_form">';
            sf += '<label>Pick a source :</label><br/>';
            sf += '';
            sf += '</form>';


            box = wpvr_show_loading({
                title: wpvr_localize.wp_video_robot,
                text: sf,
                pauseButton: wpvr_localize.ok_button,
                cancelButton: wpvr_localize.cancel_button,
                isModal: false,
            });
            box.doPause(function () {
                box.remove();
            });

        });


        //Save options
        $('body').on('click', '.wpvr_save_options', function (e) {

            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))    return false;

            var max_wanted = $('#wpvr_options_wantedVideos').attr('max_value');
            var wanted = $('#wpvr_options_wantedVideos').attr('value');

            if (max_wanted != '' && parseInt(wanted) > parseInt(max_wanted)) {
                var box = wpvr_show_loading({
                    title: wpvr_localize.wp_video_robot,
                    text: wpvr_localize.source_with_big_wanted,
                    pauseButton: wpvr_localize.ok_button,
                    isModal: false,
                });
                box.doPause(function () {
                    box.remove();
                });
                return false;
            }


            var form = $('#wpvr_options');
            var formData = form.serialize();
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            var formUrl = form.attr('action');
            var is_demo = form.attr('is_demo');


            if (is_demo == '1') {
                boxDemo = wpvr_show_loading({
                    title: wpvr_localize.wp_video_robot,
                    text: 'This is a demo version of WP Video Robot.<br/>For security reasons, you cannot change the options.<br/> Hope you understand.',
                    pauseButton: wpvr_localize.ok_button,
                    isModal: false,
                });
                boxDemo.doPause(function () {
                    boxDemo.remove();
                });
                boxDemo.doRemove(function () {
                    wpvr_remove_loading_spinner(spinner);
                });
                return false;
            }


            btn.addClass('isLoading');

            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: formData,
                success: function (data) {
                    $data = wpvr_get_json(data);
                    if ($data.status == 1) {

                        var box2 = wpvr_show_loading({
                            title: wpvr_localize.options_saved,
                            text: wpvr_localize.options_saved_icon,
                            pauseButton: wpvr_localize.ok_button,
                        });
                        box2.doPause(function () {
                            box2.remove();
                            wpvr_remove_loading_spinner(spinner);
                        });
                        box2.doRemove(function () {
                            wpvr_remove_loading_spinner(spinner);
                            if ($data.data.refresh) {
                                if ($data.data.param == '') {
                                    location.reload();
                                } else {
                                    var url = window.location.href;
                                    if (url.indexOf('?') > -1) {
                                        url += '&' + $data.data.param + '=1';
                                    } else {
                                        url += '?' + $data.data.param + '=1';
                                    }
                                    window.location.href = url;
                                }
                            }
                        });
                    } else {
                        wpvr_alert('Something went wrong while saving options. Check the JS console.');
                        console.log(data);
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        //Reset Addon Licences
        $('body').on('click', '.wpvr_setter_button', function (e) {
            e.preventDefault();
            var btn = $(this);
            var action = btn.attr('action');
            var is_demo = btn.attr('is_demo');
            var show_result = btn.attr('show_result');
            if (btn.hasClass('wpvr_isLoading'))    return false;

            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');

            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: {
                    action: action,
                },
                success: function (response) {
                    response = wpvr_get_json(response);
                    data = response.data;

                    if (show_result == 1) {
                        var box = wpvr_show_loading({
                            title: wpvr_localize.wp_video_robot,
                            text: data,
                            pauseButton: wpvr_localize.ok_button,
                        });
                        box.doPause(function () {
                            box.remove();
                            wpvr_remove_loading_spinner(spinner);
                        });
                        box.doRemove(function () {
                            wpvr_remove_loading_spinner(spinner);
                        });
                    } else {
                        if (data == 'ok') {
                            var box = wpvr_show_loading({
                                title: wpvr_localize.wp_video_robot,
                                text: wpvr_localize.action_done,
                                pauseButton: wpvr_localize.ok_button,
                            });
                            box.doPause(function () {
                                box.remove();
                                wpvr_remove_loading_spinner(spinner);
                            });
                            box.doRemove(function () {
                                wpvr_remove_loading_spinner(spinner);
                            });
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });


        });

        //Reset Single Addon Licence
        $('body').on('click', '.wpvr_reset_single_addon_licence', function (e) {
            e.preventDefault();
            var btn = $(this);
            var slug = btn.attr('slug');
            if (btn.hasClass('wpvr_isLoading'))    return false;
            //var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            $('i', btn).addClass('fa-spin');
            wpvr_confirm(
                wpvr_localize.licence_reset_confirm,
                function () {

                    btn.addClass('isLoading');
                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'reset_single_addon_licence',
                            slug: slug,
                        },
                        success: function (data) {
                            $('i', btn).removeClass('fa-spin');

                            $json = wpvr_get_json(data);
                            if ($json.status == 0) {
                                var $msg = 'Reset Error : <br/>'.$json.msg;
                            } else {
                                var $msg = $json.msg;
                                $('#wpvr_addon_licence_' + $json.data).removeClass('fail').removeClass('success').html('');
                                $('#licence_' + $json.data).attr('value', '').attr('is_activated', '0');
                            }

                            var box = wpvr_show_loading({
                                title: wpvr_localize.wp_video_robot,
                                text: $msg,
                                pauseButton: wpvr_localize.ok_button,
                            });
                            box.doPause(function () {
                                box.remove();
                                //wpvr_remove_loading_spinner(spinner);
                                //location.reload();
                            });
                            box.doRemove(function () {
                                //wpvr_remove_loading_spinner(spinner);
                            });
                            btn.removeClass('isLoading');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.reset_yes,
                function () {
                    // wpvr_remove_loading_spinner(spinner);
                    $('i', btn).removeClass('fa-spin');
                },
                wpvr_localize.reset_no
            );
        });

        //Reset Addon Licences
        $('body').on('click', '#wpvr_reset_addon_licenses', function (e) {
            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))    return false;
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            wpvr_confirm(
                wpvr_localize.options_reset_confirm,
                function () {

                    btn.addClass('isLoading');
                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'reset_addon_licenses',
                        },
                        success: function (data) {
                            $json = wpvr_get_json(data);
                            if ($json.status == '1') {
                                var box = wpvr_show_loading({
                                    title: wpvr_localize.wp_video_robot,
                                    text: $json.msg,
                                    pauseButton: wpvr_localize.ok_button,
                                });
                                box.doPause(function () {
                                    box.remove();
                                    wpvr_remove_loading_spinner(spinner);
                                    location.reload();
                                });
                                box.doRemove(function () {
                                    wpvr_remove_loading_spinner(spinner);
                                });

                            }
                            btn.removeClass('isLoading');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.reset_yes,
                function () {
                    wpvr_remove_loading_spinner(spinner);
                },
                wpvr_localize.reset_no
            );
        });

        //Reset Activation
        $('body').on('click', '#wpvr_reset_activation', function (e) {
            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))    return false;
            var is_demo = btn.attr('is_demo');
            if (is_demo == '1') {
                boxDemo = wpvr_show_loading({
                    title: wpvr_localize.wp_video_robot,
                    text: 'This is a demo version of WP Video Robot.<br/>For security reasons, you cannot change the options.<br/> Hope you understand.',
                    pauseButton: wpvr_localize.ok_button,
                    isModal: false,
                });
                boxDemo.doPause(function () {
                    boxDemo.remove();
                });
                return false;
            }
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            wpvr_confirm(
                wpvr_localize.options_reset_confirm,
                function () {

                    btn.addClass('isLoading');
                    $.ajax({
                        type: 'POST',
                        data: {
                            action: 'reset_activation',
                        },
                        url: wpvr_globals.ajax_url,
                        success: function (data) {
                            $data = wpvr_get_json(data);
                            if ($data.status == 1) {
                                var box = wpvr_show_loading({
                                    title: wpvr_localize.wp_video_robot,
                                    text: wpvr_localize.license_reset,
                                    pauseButton: wpvr_localize.ok_button,
                                });
                                box.doPause(function () {
                                    box.remove();
                                    location.reload();
                                });
                                box.doRemove(function () {
                                    wpvr_remove_loading_spinner(spinner);
                                });

                            }
                            wpvr_remove_loading_spinner(spinner);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.reset_yes,
                function () {
                    wpvr_remove_loading_spinner(spinner);
                },
                wpvr_localize.reset_no
            );
        });


        //Cancel Activation
        $('body').on('click', '#wpvr_cancel_activation', function (e) {
            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))    return false;
            var is_demo = btn.attr('is_demo');
            if (is_demo == '1') {
                boxDemo = wpvr_show_loading({
                    title: wpvr_localize.wp_video_robot,
                    text: 'This is a demo version of WP Video Robot.<br/>For security reasons, you cannot change the options.<br/> Hope you understand.',
                    pauseButton: wpvr_localize.ok_button,
                    isModal: false,
                });
                boxDemo.doPause(function () {
                    boxDemo.remove();
                });
                return false;
            }
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            wpvr_confirm(
                wpvr_localize.activation_cancel_confirm,
                function () {

                    btn.addClass('isLoading');
                    $.ajax({
                        type: 'POST',
                        data: {
                            action: 'cancel_activation',
                        },
                        url: wpvr_globals.ajax_url,
                        success: function (data) {
                            $data = wpvr_get_json(data);
                            if ($data.status == 1) {
                                var box = wpvr_show_loading({
                                    title: wpvr_localize.wp_video_robot,
                                    text: wpvr_localize.license_cancelled,
                                    pauseButton: wpvr_localize.ok_button,
                                });
                                box.doPause(function () {
                                    box.remove();
                                    location.reload();
                                });
                                box.doRemove(function () {
                                    wpvr_remove_loading_spinner(spinner);
                                });

                            }
                            wpvr_remove_loading_spinner(spinner);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.reset_yes,
                function () {
                    wpvr_remove_loading_spinner(spinner);
                },
                wpvr_localize.reset_no
            );
        });

        $('.wpvr_log_canvas').each(function () {
            var canvas = $(this);
            var init_data = [
                {
                    type: 'link',
                    date: canvas.data('now'),
                    local_date: canvas.data('localnow'),
                    title: canvas.data('timezone'),
                },
            ];
            var timeline = new Timeline($('.wpvr_log_canvas_timeline', canvas), init_data);
            timeline.setOptions({
                animation: true,
                lightbox: false,
                first_separator: true,
                separator: 'month_year',
                columnMode: 'dual',
                order: 'desc',
                dateFormat: 'YYYY-MM-DD HH:mm:ss',
                responsive_width: 700,
            });
            timeline.display();

            $('.wpvr_logs_details_button', canvas).live('click', function (e) {
                e.preventDefault();
                var btn = $(this);

                if (btn.hasClass('closed')) {
                    btn.removeClass('closed').addClass('open');
                    $('.wpvr_logs_details_content').hide();
                    $('.wpvr_logs_details_content[data-log=' + btn.data('id') + ']').fadeIn();
                } else {
                    btn.removeClass('open').addClass('closed');
                    $('.wpvr_logs_details_content').hide();
                    $('.wpvr_logs_details_content[data-log=' + btn.data('id') + ']').hide();
                }


            });

            $('.wpvr_log_load_more', canvas).click(function (e) {
                e.preventDefault();
                var btn = $(this);
                if (btn.hasClass('wpvr_loading')) {
                    return;
                }
                wpvr_btn_loading(btn);
                $.ajax(
                    wpvr_globals.ajax_url, {
                        type: 'POST',
                        data: {
                            action: 'load_activity_logs',
                            page: btn.data('page'),
                            period: btn.data('period'),
                            type: btn.data('type'),
                        },
                        success: function (data) {
                            var $json = wpvr_get_json(data);
                            wpvr_btn_loading(btn, false);

                            if ($json.data.items.length == 0) {
                                $('.wpvr_log_canvas_statement', canvas).html('Nothing happened.').fadeIn();
                            } else {
                                $('.wpvr_log_canvas_statement', canvas).html('').hide();
                            }

                            timeline.appendData($json.data.items);

                            if ($json.data.page == 'end') {
                                btn.hide();
                            } else {
                                btn.data('page', $json.data.page);

                            }

                            //$.scrollTo('#timeline_date_separator_' + year, 500);
                        }
                    });

            });

            $('.wpvr_log_load_more', canvas).trigger('click');

        });


        //Register Addon Licences
        $('body').on('click', '#wpvr_register_addon_licenses', function (e) {
            e.preventDefault();
            var items = [];
            var btn = $(this);
            // if (btn.hasClass('wpvr_isLoading'))    return false;
            var form = $('#wpvr_register_addons_licences_form');
            var formData = form.serialize();
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            var formUrl = form.attr('action');

            $('.wpvr_license_input', form).each(function () {
                var item = $(this);

                if (item.attr('value') != '' && item.attr('is_activated') == '0') {
                    items.push({
                        slug: item.attr('slug'),
                        version: item.attr('version'),
                        code: item.attr('value'),
                    })
                } else {
                    $('#wpvr_addon_licence_' + item.attr('slug')).removeClass('fail').removeClass('success').html('');
                }
            });
            var json_items = JSON.stringify(items);
            if (json_items == '[]') {
                wpvr_remove_loading_spinner(spinner);
                var box2 = wpvr_show_loading({
                    title: 'WP Video Robot',
                    text: 'There is no new purchase code to activate.',
                    pauseButton: wpvr_localize.ok_button,
                });
                box2.doPause(function () {
                    box2.remove();
                    wpvr_remove_loading_spinner(spinner);
                });
                box2.doRemove(function () {
                    wpvr_remove_loading_spinner(spinner);
                });
                return false;
            }
            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: {
                    action: 'register_addon_licenses',
                    email: $('#act_email', form).attr('value'),
                    domain: $('#act_domain', form).attr('value'),
                    url: $('#act_url', form).attr('value'),
                    ip: $('#act_ip', form).attr('value'),
                    items: json_items,
                },
                success: function (data) {
                    var count_ok = 0;
                    var count_ko = 0;
                    var count_zero = 0;
                    $json = wpvr_get_json(data);
                    var details = '';
                    $.each($json.data, function (i, item) {
                        var span = $('#wpvr_addon_licence_' + i);
                        span.hide().removeClass('fail').removeClass('success');
                        details += '<li><strong>' + item.product + '</strong> : <br/>' + item.msg + '</li>';
                        if (item.status == 1) {
                            $('#licence_' + i).attr('is_activated', '1');
                            span.addClass('success').html(item.msg).fadeIn();
                            count_ok++;
                        }
                        else if (item.status == 0) {
                            $('#licence_' + i).attr('is_activated', '0');
                            span.addClass('fail').html(item.msg).fadeIn();
                            count_ko++;
                        } else {
                            count_zero++;
                            span.addClass('success').fadeIn();
                        }
                    });

                    console.log(details);
                    var msg = 'Licenses saved. ' +
                        '<a class="wpvr_show_registration_details" href="#">Show Details.</a>' +
                        '<br/><br/>' +
                        '<div class="wpvr_register_results">' +
                        '<span> ' + count_ok + ' </span>NEW ACTIVATIONS' +
                        '</div>' +
                        '<div class="wpvr_register_results">' +
                        '<span> ' + count_ko + ' </span>ERRORS' +
                        '</div>' +
                        '<div class="wpvr_clearfix"></div><br/>' +
                        '<div class="wpvr_registration_details" style="display:none;">' + details + '</div>' +
                        '</div>';

                    if ($json.status == 1) {
                        //if (wpvr_curate(data) == 'licences_saved') {
                        wpvr_remove_loading_spinner(spinner);
                        var box2 = wpvr_show_loading({
                            title: 'WP Video Robot',
                            text: msg,
                            pauseButton: wpvr_localize.ok_button,
                        });
                        $('.wpvr_show_registration_details').click(function (e) {
                            e.preventDefault();
                            $('.wpvr_registration_details').toggle();
                        });
                        box2.doPause(function () {
                            box2.remove();
                            wpvr_remove_loading_spinner(spinner);
                        });
                        box2.doRemove(function () {
                            wpvr_remove_loading_spinner(spinner);
                        });
                    } else console.log(data);

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
        //Verify purchase code
        $('body').on('click', '#wpvr_verify_purchase_code', function (e) {
            e.preventDefault();
            var btn = $(this);
            var purchaseCode = $('#wpvr_options_purchaseCode').attr('value');
            var url = btn.attr('url');

            if (purchaseCode == '') return false;
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            btn.addClass('isLoading');


            $.ajax({
                type: 'POST',
                url: url + '?wpvr_wpload&verify_purchase_code',
                data: {purchaseCode: purchaseCode},
                success: function (data) {
                    wpvr_remove_loading_spinner(spinner);
                    $('#wpvr_verify_purchase_code_result').html(data);
                    //console.log(data);
                    btn.removeClass('isLoading');

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        //Export options
        $('body').on('click', '#wpvr_export_options', function (e) {
            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))    return false;
            var url = btn.attr('url');
            btn.addClass('isLoading');
            var spinner = wpvr_add_loading_spinner(btn, 'pull-left');

            $.ajax({
                type: 'POST',
                url: wpvr_globals.ajax_url,
                data: {
                    action: 'wpvr_export_options',
                },
                success: function (data) {
                    $('#wpvr_export').html(data);
                    wpvr_remove_loading_spinner(spinner);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });
        //Back Button
        $('#backBtn').live('click', function (e) {
            e.preventDefault();
            window.history.go(-1);
            return false;
        });

        //Reset Options
        $('body').on('click', '#wpvr_reset_options', function (e) {
            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))  return false;
            var url = $(this).attr('url');
            var is_demo = $('#wpvr_options').attr('is_demo');

            var spinner = wpvr_add_loading_spinner(btn, 'pull-left');

            if (is_demo == '1') {
                boxDemo = wpvr_show_loading({
                    title: wpvr_localize.wp_video_robot,
                    text: 'This is a demo version of WP Video Robot.<br/>For security reasons, you cannot change the options.<br/> Hope you understand.',
                    pauseButton: wpvr_localize.ok_button,
                    isModal: false,
                });
                boxDemo.doPause(function () {
                    boxDemo.remove();
                    wpvr_remove_loading_spinner(spinner);
                });
                boxDemo.doRemove(function () {
                    wpvr_remove_loading_spinner(spinner);
                });
                return false;
            }

            wpvr_confirm(
                wpvr_localize.options_reset_confirm,
                function () {
                    var form = $('#wpvr_options');
                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: 'wpvr_reset_options',
                        },
                        success: function (data) {
                            $data = wpvr_get_json(data);
                            if ($data.status == 1) {
                                var box = wpvr_show_loading({
                                    title: wpvr_localize.wp_video_robot,
                                    text: wpvr_localize.options_set_to_default,
                                    pauseButton: wpvr_localize.ok_button,
                                });
                                box.doPause(function () {
                                    box.remove();
                                    wpvr_remove_loading_spinner(spinner);
                                    location.reload();
                                });
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.reset_yes,
                function () {
                    wpvr_remove_loading_spinner(spinner);
                },
                wpvr_localize.reset_no
            );
        });

        $('.wpvr_option').each(function () {
            var option = $(this);
            option.delegate('.wpvr_switch_btn ', 'lcs-statuschange', function () {

                if ($(this).is(':checked')) {
                    option.removeClass('off').addClass('on');
                    $('.wpvr_switch_input', option).val('@true');
                } else {
                    option.removeClass('on').addClass('off');
                    $('.wpvr_switch_input', option).val('@false');
                }
            });
        });


        $('.wpvr_api_connection').change(function () {
            var option = $('#wpvr_api_connection_target');
            option.removeClass('advanced').removeClass('wizzard');
            option.addClass($(this).val());
        });

        $('#permalinkBase').change(function () {
            if ($(this).val() == 'custom') {
                $('#customPermalinkBase').fadeIn();
            } else {
                $('#customPermalinkBase').hide();
            }
        });
        //OnClick Option event
        $('body').on('click', '.wpvr_option:not(.texteditor)', function (e) {

            var option = $(this);
            var btn = $('input[type=checkbox]', option);
            var x = btn.attr('name');

            if (x === undefined) return false;
            var t = x.split('wpvr_options_');
            //console.log(t[1]);
            var toBeEnabled = $('.enabledBy_' + t[1]);

            btn.change(function () {

                if (btn.hasClass('wpvr_switch_btn')) return;
                option.removeClass('on').removeClass('off');
                if (!$(this).prop('checked')) {
                    option.addClass('off');
                    toBeEnabled.attr('readonly', '').attr('disabled', '');

                } else {
                    option.addClass('on');
                    toBeEnabled.removeAttr('readonly', '').removeAttr('disabled', '');

                }
            });
        });

        $('body').on('click', '.wpvr_option a.link', function (e) {
            window.open($(this).attr('href'), '_blank');

        });

        /**************************************************************************************/

        /* LOGS ************************************************************************************/
        //Change Log page
        // $('.wpvr_log_page_select').bind('change', function () {
        //     var page_url = $(this).attr('page_url');
        //     var period = $(this).attr('period');
        //     var page_num = $(this).attr('value');
        //     var url = page_url + '&page_num=' + page_num + '&period=' + period;
        //     window.location.href = url;
        // });
        //
        // //Change Log Period
        // $('.wpvr_log_period_select').bind('change', function () {
        //     var page_url = $(this).attr('page_url');
        //     var period = $(this).attr('value');
        //     var url = page_url + '&period=' + period;
        //     window.location.href = url;
        // });

        $('.wpvr_logs_refine').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var url = btn.data('url');
            var period = $('.wpvr_log_period_select').val();
            var type = $('.wpvr_log_type_select').val();

            wpvr_btn_loading(btn, true);
            // var new_url = url + '&period='+period+'&type='+type;

            if (period != 'all') {
                url += '&period=' + period;
            }
            if (type != 'all') {
                url += '&type=' + type;
            }
            window.location.href = url;

            console.log(period);
            console.log(type);

        });
        //Refresh Log
        $('.wpvr_refresh_log').bind('click', function () {
            window.location.reload();
        });

        //Refresh Log
        $('.wpvr_refresh_page').bind('click', function (e) {
            e.preventDefault();
            window.location.reload();
        });

        // Go To Top
        $('.wpvr_goToTop').live('click', function (e) {
            e.preventDefault();
            $('html, body').animate({scrollTop: 0}, 'slow');
        });

        // Clear Log
        $('.wpvr_clear_log').bind('click', function () {
            /*if(confirm('Are you sure ?')){
             var reset_url = $(this).attr('reset_url');
             window.location.href = reset_url ;
             }
             */
            var reset_url = $(this).attr('reset_url');
            wpvr_confirm(
                wpvr_localize.want_clear_log,
                function () {
                    window.location.href = reset_url;
                },
                wpvr_localize.yes,
                function () {
                },
                wpvr_localize.cancel_button
            );


        });

        /* ************************************************************************************/

        /* SOURCES ************************************************************************************/
        //Toggling sources
        $('body').delegate('.wpvr_switch_btn', 'lcs-statuschange', function () {
            var status = ($(this).is(':checked')) ? 'checked' : 'unchecked';
        });
        $('#the-list .type-wpvr_source').each(function () {
            var source = $(this);
            var toggle = $('.wpvr_source_toggle', source);
            var source_id = toggle.attr('id');
            var loading = $('.wpvr_toggle_loading', source);
            var done = $('.wpvr_toggle_done', source);

            source.delegate('.wpvr_source_toggle', 'lcs-statuschange', function () {
                var source_status = (toggle.is(':checked')) ? 'on' : 'off';
                loading.fadeIn();

                $.ajax({
                    type: 'POST',
                    url: wpvr_globals.ajax_url,
                    data: {
                        action: 'wpvr_source_toggle_state',
                        ids: source_id,
                        status: source_status
                    },
                    success: function (data) {
                        loading.hide();
                        done.fadeIn();
                        setTimeout(function () {
                            done.fadeOut('slow');
                        }, 1000);

                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });

            });


        });


        $('.wpvr_source_toggle').bind('change', function () {
            var source_id = $(this).attr('id');
            var wpvr_source_status = $('#toggle_' + source_id);
            var source_status = wpvr_source_status.attr('status');

            console.log(source_status);

            if (source_status == "off") source_status = "on";
            else source_status = "off";
            var toggleUrl = wpvr_source_status.attr('url');
            var toggleLoading = $('#toggle_loading_' + source_id);


            return false;
            toggleLoading.fadeIn();

            $.ajax({
                type: 'POST',
                url: toggleUrl,
                data: {
                    'ids': source_id,
                    'status': source_status
                },
                success: function (data) {
                    //console.log(data);
                    toggleLoading.hide();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });


        });


        //Init show Hide function
        wpvr_relatedShowHide();
        /**************************************************************************************/
        //return false;
        /* ACTIONS *************************************************************************************/
        //Bulk Confirmation

        $('#doaction').bind('click', function (e) {

            e.preventDefault();
            var action = $('#bulk-action-selector-top').attr('value');
            var btn = $(this);
            if (action == 'delete') {
                wpvr_confirm(
                    wpvr_localize.confirm_delete_permanently,
                    function () {
                        btn.unbind('click').click();
                    },
                    wpvr_localize.yes
                    ,
                    function () {
                    },
                    wpvr_localize.cancel_button
                );
            } else if (action == 'export') {
                $(this).unbind('click').click();


            } else if (action == 'edit') {

                return false;

            } else {
                $(this).unbind('click').click();
            }
        });

        //Copy/Add Channel IDS
        $('#wpvr_channel_add_id').bind('click', function () {
            var target = $('#' + $(this).attr('target'));
            var id = $('#wpvr_channel_id').attr('value');
            var ids = target.val();

            //console.log( target );console.log( ids );

            if (ids != '') {
                ids = ids.split(',');
                ids.push(id);
                ids = ids.join(',');
            } else {
                ids = id;
            }
            target.val(ids);
            $('#wpvr_channel_id').val('');
        });
        // REset Retrieving Channel ID
        $('#wpvr_channel_button_reset').bind('click', function () {
            $('#wpvr_channel_id').attr('value', '');
            $('#wpvr_channel_username').attr('value', '');
            $('#wpvr_channel_error').html('').hide();
            $('#wpvr_channel_zone').hide();
        });

        //Retreive Channel ID
        $('#wpvr_channel_retreive').bind('click', function () {
            var btn = $(this);
            var channel_user = $('#wpvr_channel_username').attr('value');
            var service = $('#wpvr_channel_username').attr('service');
            var form_url = btn.attr('url');


            if (channel_user == '') return false;
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');

            $.ajax({
                type: 'POST',
                url: form_url + '?wpvr_wpload&retrieve_channel',
                data: {
                    'username': channel_user,
                    'service': service,
                },
                success: function (data) {
                    var $json = wpvr_get_json(data);
                    console.log($json);
                    if ($json.status != 0) {
                        $('#wpvr_channel_id').attr('value', $json.data.trim());
                        $('#wpvr_channel_zone').show();
                        //$('#wpvr_channel_error').html('').hide();
                    } else {
                        //$('#wpvr_channel_zone').hide();
                        //$('#wpvr_channel_error').html('There is no channel belonging to the selected user.').show();
                        var box_error = wpvr_show_loading({
                            title: wpvr_localize.error,
                            text: $json.msg,
                            pauseButton: wpvr_localize.ok_button,
                            isModal: false,
                        });
                        box_error.doPause(function () {
                            box_error.remove();
                        });
                    }
                    wpvr_remove_loading_spinner(spinner);


                    //$('.wpvr_test_form_res').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

        });

        //BAtch Add Selected videos on test result screen
        $('.wpvr_test_form_add').bind('click', function () {
            var btn = $(this);
            var session = btn.attr('session');
            var form = $('#wpvr_test_form');
            var form_url = form.attr('url');

            var selected = [];
            $('.wpvr_video_cb', form).each(function () {
                var input = $(this);
                if (input.prop('checked'))
                    selected.push(input.attr('name'));
            });
            if (selected.length == 0) return false;
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            //Show Loading ...
            var box_loading = wpvr_show_loading({
                title: wpvr_localize.work_in_progress,
                text: wpvr_localize.please_wait + '...',
                isModal: true,
            });
            var toAdd = selected.length;

            $.ajax({
                type: 'POST',
                url: form_url + '?wpvr_wpload&test_add_videos',
                data: {
                    'videos': selected,
                    'session': session,
                },
                success: function (data) {
                    var msg_completed = data + ' / ' + toAdd + ' ' + wpvr_localize.videos_added_successfully + '.';
                    box_loading.remove();
                    var box_ok = wpvr_show_loading({
                        title: wpvr_localize.work_completed,
                        text: msg_completed,
                        pauseButton: wpvr_localize.ok_button,
                        isModal: false,
                    });
                    box_ok.doPause(function () {
                        box_ok.remove();
                    });
                    wpvr_remove_loading_spinner(spinner);


                    //$('.wpvr_test_form_res').html(data);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        $('.wpvr_unwanted_scope').change(function () {
            $('.wpvr_unwanted_filters').removeClass('global').removeClass('source');
            $('.wpvr_unwanted_filters').addClass($(this).val());
        });

        $('.wpvr_unwanted_refine').click(function (e) {
            e.preventDefault();


            var params = {}, hash;
            var urlArray = document.URL.split('?');
            var urlBase = urlArray [0];
            var q = urlArray [1];

            if (q != undefined) {
                q = q.split('&');
                for (var i = 0; i < q.length; i++) {
                    hash = q[i].split('=');
                    // params[hash[0]] = hash[1];
                }
            }
            //console.log( params );


            params['page'] = 'wpvr-unwanted';

            var page = $('.wpvr_select_page').val();
            var scope = $('.wpvr_unwanted_scope').val();
            if (page > 1) {
                params['xpage'] = $('.wpvr_select_page').val();
            }

            if (scope != 'global') {
                params['scope'] = $('.wpvr_unwanted_scope').val();
            }


            var input_value = $('.wpvr_unwanted_filter .wpvr_dropdown_input[name=service]').val();
            if (input_value != '' && input_value != '[]') {
                params['service'] = input_value;
            }

            var input_value = $('.wpvr_unwanted_filter  .wpvr_dropdown_input[name=source]').val();
            if (input_value != '' && input_value != '[]') {
                params['source'] = input_value;
            }

            var input_value = $('.wpvr_unwanted_filter  .wpvr_unwanted_search').val();
            if (input_value != '' && input_value != '[]') {
                params['se'] = input_value;
            }


            //alert(urlBase + '?' + $.param(params));
            window.location.href = urlBase + '?' + $.param(params);


        });

        //Remove selected deferred videos
        $('.wpvr_test_form_remove').bind('click', function (e) {
            e.preventDefault();
            var btn = $(this);
            if (btn.hasClass('wpvr_isLoading'))    return false;
            var form = $('#wpvr_test_form');
            var form_url = form.attr('url');
            var form_action = form.attr('action');
            var selected = [];
            $('.wpvr_video_cb', form).each(function () {
                var input = $(this);
                if (input.prop('checked')) selected.push(input.attr('name'));
            });
            if (selected.length == 0) return false;
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            wpvr_confirm(
                wpvr_localize.want_remove_items,
                function () {

                    var box_loading = wpvr_show_loading({
                        title: wpvr_localize.work_in_progress,
                        text: wpvr_localize.please_wait + '...',
                        isModal: true,
                    });
                    var toAdd = selected.length;
                    //if( form_action == '')
                    $.ajax({
                        type: 'POST',
                        url: wpvr_globals.ajax_url,
                        data: {
                            action: form_action,
                            videos: selected
                        },
                        success: function (data) {
                            $data = wpvr_get_json(data);
                            box_loading.remove();
                            var box_ok = wpvr_show_loading({
                                title: wpvr_localize.work_completed,
                                text: $data.msg,
                                cancelButton: wpvr_localize.ok_button,
                                isModal: false,
                            });
                            box_ok.doCancel(function () {
                                box_ok.remove();
                                wpvr_remove_loading_spinner(spinner);
                                //$('#wpvr_test_form_refresh').trigger('click');
                            });
                            wpvr_remove_loading_spinner(spinner);

                            var countDef = parseInt($('.wpvr_count_deferred').html()) - parseInt(data);

                            $('.wpvr_count_deferred').html(countDef);
                            if (countDef == 0) {
                                $('.wpvr_deferred_videos').fadeOut('slow').remove();
                                $('.wpvr_nothing').fadeIn();
                                $('.wpvr_test_form_buttons').hide();
                            }
                            $('.wpvr_video.checked', form).remove();


                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            alert(thrownError);
                        }
                    });
                },
                wpvr_localize.yes,
                function () {
                    wpvr_remove_loading_spinner(spinner);
                },
                wpvr_localize.cancel_button
            );
        });

        //Add Videos to unwanted from test screen
        $('.wpvr_test_form_unwanted').bind('click', function (e) {
            e.preventDefault();
            var btn = $(this);
            var session = btn.attr('session');


            //console.log( session );
            if (btn.hasClass('wpvr_isLoading'))    return false;
            var form = $('#wpvr_test_form');
            var form_url = form.attr('url');

            var videos = [];
            $('.wpvr_video_cb', form).each(function () {
                var input = $(this);
                var video = {
                    'video_id': input.attr('name'),
                    'div_id': input.attr('div_id'),
                    'source_id': input.attr('source_id'),
                };
                if (input.prop('checked')) videos.push(video);
            });
            if (videos.length == 0) {
                btn.shake();
                return false;
            }

            var boxUnwant = wpvr_show_loading({
                title: wpvr_localize.add_to_unwanted,
                text: wpvr_localize.add_to_unwanted_msg,
                cancelButton: wpvr_localize.source_unwanted,
                pauseButton: wpvr_localize.global_unwanted,
                isModal: false,
                unliked_close_button: true,
            });
            boxUnwant.find('.wpvr_loading_close').click(function (e) {
                e.preventDefault();

                return false;
            });
            boxUnwant.doCancel(function () {
                //Source Unwant
                console.log('Source');
                boxUnwant.remove();

                var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
                var box = wpvr_show_loading({
                    title: wpvr_localize.adding_selected_videos,
                    text: wpvr_localize.work_in_progress + "...",
                    progressBar: true, // OR window
                    cancelButton: wpvr_localize.cancel_button, // OR window
                    pauseButton: wpvr_localize.pause_button, // OR window
                    isModal: true,
                });
                box.attr('scope', 'source');
                box.doProgress({pct: 1, text: wpvr_localize.loading + ''});
                box.doHighlight();
                box.attr('work', 1);
                box.attr('pause', 'false');
                //box.attr('is_deferred', is_deferred);
                box.attr('spinner_id', spinner.attr('id'));
                box.attr('session', session);
                pause_function = function () {
                    var pauseButton = $('.wpvr_loading_pause', box);
                    var k = box.attr('k');
                    var pause = box.attr('pause');


                    if (pause != 'false') {
                        box.doHighlight();
                        box.attr('pause', 'false');
                        pauseButton.html(wpvr_localize.pause_button);
                        box.doText(wpvr_localize.work_in_porogress + '...');
                        //console.log('continuing');
                        wpvr_single_add_unwanted_video(parseInt(k) + 1, videos, form_url, box);
                    } else {
                        box.stopHighlight();
                        box.attr('pause', 123);
                        pauseButton.html(wpvr_localize.continue_button);
                        box.doText(wpvr_localize.work_paused);
                        //console.log('PAUSING');
                    }


                };
                box.doCancel(function () {
                    box.attr('pause', 'false');
                    pause_function();
                    box.doHide();
                    wpvr_confirm(
                        wpvr_localize.really_want_cancel,

                        function () {
                            box.doShow();
                            pause_function();
                        },
                        wpvr_localize.continue_button,
                        function () { //IF yes
                            box.attr('work', 0);
                            var k = box.attr('k');
                            wpvr_single_add_unwanted_video(parseInt(k), videos, form_url, box);
                            wpvr_remove_loading_spinner(spinner);
                        },
                        wpvr_localize.cancel_anyway
                    );
                });
                box.doPause(pause_function);
                wpvr_single_add_unwanted_video(0, videos, form_url, box);
            });

            boxUnwant.doPause(function () {
                //Global Unwant
                boxUnwant.remove();
                var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
                var box = wpvr_show_loading({
                    title: wpvr_localize.adding_selected_videos,
                    text: wpvr_localize.work_in_progress + "...",
                    progressBar: true, // OR window
                    cancelButton: wpvr_localize.cancel_button, // OR window
                    pauseButton: wpvr_localize.pause_button, // OR window
                    isModal: true,
                });
                box.attr('scope', 'global');
                box.doProgress({pct: 1, text: wpvr_localize.loading + ''});
                box.doHighlight();
                box.attr('work', 1);
                box.attr('pause', 'false');
                //box.attr('is_deferred', is_deferred);
                box.attr('spinner_id', spinner.attr('id'));
                box.attr('session', session);
                pause_function = function () {
                    var pauseButton = $('.wpvr_loading_pause', box);
                    var k = box.attr('k');
                    var pause = box.attr('pause');


                    if (pause != 'false') {
                        box.doHighlight();
                        box.attr('pause', 'false');
                        pauseButton.html(wpvr_localize.pause_button);
                        box.doText(wpvr_localize.work_in_porogress + '...');
                        //console.log('continuing');
                        wpvr_single_add_unwanted_video(parseInt(k) + 1, videos, form_url, box);
                    } else {
                        box.stopHighlight();
                        box.attr('pause', 123);
                        pauseButton.html(wpvr_localize.continue_button);
                        box.doText(wpvr_localize.work_paused);
                        //console.log('PAUSING');
                    }


                };
                box.doCancel(function () {
                    box.attr('pause', 'false');
                    pause_function();
                    box.doHide();
                    wpvr_confirm(
                        wpvr_localize.really_want_cancel,

                        function () {
                            box.doShow();
                            pause_function();
                        },
                        wpvr_localize.continue_button,
                        function () { //IF yes
                            box.attr('work', 0);
                            var k = box.attr('k');
                            wpvr_single_add_unwanted_video(parseInt(k), videos, form_url, box);
                            wpvr_remove_loading_spinner(spinner);
                        },
                        wpvr_localize.cancel_anyway
                    );
                });
                box.doPause(pause_function);
                wpvr_single_add_unwanted_video(0, videos, form_url, box);
            });


        });

        //Add videos one at a time from test screen results
        $('.wpvr_test_form_add_each').bind('click', function (e) {
            e.preventDefault();
            var btn = $(this);
            var session = btn.attr('session');
            //console.log( session );
            //if (btn.hasClass('wpvr_isLoading'))    return false;
            var form = $('#wpvr_test_form');
            var form_url = form.attr('url');
            is_deferred = btn.attr('is_deferred');


            var videos = [];
            $('.wpvr_video_cb', form).each(function () {
                var input = $(this);
                var video = {
                    'video_id': input.attr('name'),
                    'div_id': input.attr('div_id'),
                };
                if (input.prop('checked')) videos.push(video);
            });
            if (videos.length == 0) {
                btn.shake();
                return false;
            }
            var spinner = wpvr_add_loading_spinner(btn, 'pull-right');
            var box = wpvr_show_loading({
                title: wpvr_localize.adding_selected_videos,
                text: wpvr_localize.work_in_progress + "...",
                progressBar: true, // OR window
                cancelButton: wpvr_localize.cancel_button, // OR window
                pauseButton: wpvr_localize.pause_button, // OR window
                isModal: true,
            });

            box.doProgress({pct: 1, text: wpvr_localize.loading + ''});
            box.doHighlight();
            box.attr('work', 1);
            box.attr('pause', 'false');
            box.attr('is_deferred', is_deferred);
            box.attr('spinner_id', spinner.attr('id'));
            box.attr('session', session);
            pause_function = function () {
                var pauseButton = $('.wpvr_loading_pause', box);
                var k = box.attr('k');
                var pause = box.attr('pause');


                if (pause != 'false') {
                    box.doHighlight();
                    box.attr('pause', 'false');
                    pauseButton.html(wpvr_localize.pause_button);
                    box.doText(wpvr_localize.work_in_porogress + '...');
                    //console.log('continuing');
                    wpvr_single_add_video(parseInt(k) + 1, videos, form_url, box);
                } else {
                    box.stopHighlight();
                    box.attr('pause', 123);
                    pauseButton.html(wpvr_localize.continue_button);
                    box.doText(wpvr_localize.work_paused);
                    //console.log('PAUSING');
                }


            };
            box.doCancel(function () {
                box.attr('pause', 'false');
                pause_function();
                box.doHide();
                wpvr_confirm(
                    wpvr_localize.really_want_cancel,

                    function () {
                        box.doShow();
                        pause_function();
                    },
                    wpvr_localize.continue_button,
                    function () { //IF yes
                        box.attr('work', 0);
                        var k = box.attr('k');
                        wpvr_single_add_video(parseInt(k), videos, form_url, box);
                        wpvr_remove_loading_spinner(spinner);
                    },
                    wpvr_localize.cancel_anyway
                );
            });
            box.doPause(pause_function);
            wpvr_single_add_video(0, videos, form_url, box);
        });

        //Check All videos of the section
        $('.wpvr_check_all_section').bind('click', function (e) {
            e.preventDefault();
            var zone_id = $(this).attr('zone_id');
            var zone = $('#zone_' + zone_id);
            var state = $(this).attr('state');
            if (state == 'off') {
                $('.wpvr_video_cb', zone).prop('checked', true);
                $('.wpvr_video', zone).addClass('checked');
                $(this).attr('state', 'on');
            } else {
                $('.wpvr_video_cb', zone).prop('checked', false);
                $('.wpvr_video', zone).removeClass('checked');
                $(this).attr('state', 'off');
            }
            wpvr_count_checked();
        });

        //Check All sections
        $('.wpvr_switch_btn').each(function () {
            var btn = $(this);
            btn.lc_switch();
        });
        $('.wpvr_test_form_toggleAll').each(function () {

            $(this).bind('click', function (e) {
                e.preventDefault();
                var zone_id = $(this).attr('zone_id');
                var zone = $('#wpvr_test_form');
                var state = $(this).attr('state');
                if (state == 'off') {
                    $('.wpvr_video_cb', zone).prop('checked', true);
                    $('.wpvr_video', zone).addClass('checked');
                    $('.wpvr_test_form_toggleAll').attr('state', 'on');
                } else {
                    $('.wpvr_video_cb', zone).prop('checked', false);
                    $('.wpvr_video', zone).removeClass('checked');
                    $('.wpvr_test_form_toggleAll').attr('state', 'off');
                }
                wpvr_count_checked();
            });

        });


        //Refresh the test screen results

        $('#wpvr_test_form_refresh').live('click', function (e) {
            e.preventDefault();
            window.location.reload();
        });
        function wpvr_update_select_colors() {
            $('.wpvrManualOptions').each(function () {
                var s = $('.cmb_select', $(this));
                $(this).removeClass('isOn').removeClass('isOff');
                if (s.attr('value') == 'on') $(this).addClass('isOn');
                else $(this).addClass('isOff');
            });
        }

        wpvr_update_select_colors();

        $('.wpvrManualOptions .cmb_select').change(function () {
            wpvr_update_select_colors();
        });

        $('.wpvr_toggle_grabbing_button').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var state = btn.attr('state');

            if (state == 'off') var new_value = 'on';
            else var new_value = 'off'

            btn.attr('state', new_value);

            $('.wpvrManualOptions .cmb_select').each(function () {
                $(this).attr('value', new_value);
            });
            wpvr_update_select_colors();
        });

        //Video REsult Item on click action
        $('.wpvr_video').live('click', function (e) {

            var state = $('.wpvr_video_cb', $(this)).prop('checked');
            if (state) {
                $('.wpvr_video_cb', $(this)).prop('checked', false);
                $(this).removeClass('checked');
            } else {
                $('.wpvr_video_cb', $(this)).prop('checked', true);
                $(this).addClass('checked');
            }

            wpvr_count_checked();


        });
        $('.wpvr_video_edit').live('click', function (e) {
            e.preventDefault();
            window.open($(this).attr('link'), '_blank');
            return false;
        });

        $('.wpvr_video_merge').live('click', function (e) {
            e.preventDefault();
            var ids = $(this).attr('ids');
            var views = $(this).attr('views');
            wpvr_apply_bulk_action('merge', ids, views);
            return false;
        });

        $('.wpvr_video_update').live('click', function (e) {
            e.preventDefault();
            var spinner = wpvr_add_loading_spinner($(this), 'pull-right');
            $('#submitdiv #publish').trigger('click');

        });
        $('.wpvr_video_view').live('click', function (e) {
            e.preventDefault();
            var url = $(this).attr('url');
            var service = $(this).attr('service');
            var video_id = $(this).attr('video_id');
            var post_id = $(this).attr('post_id');

            var boxPreview = wpvr_show_loading({
                width: '60%',
                // height: '90%',
                title: wpvr_localize.video_preview,
                text: '<div id="wpvr_video_preview"></div>',
            });
            //return false;
            $.ajax({
                url: wpvr_globals.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_video_preview',
                    post_id: post_id,
                    video_id: video_id,
                    service: service
                },
                success: function (data) {
                    $data = wpvr_get_json(data);
                    //console.log($data.data);
                    $('#wpvr_video_preview').html($data.data);
                    $('.wpvr_loading_msg', boxPreview).center();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });

            return false;
        });


        /* HELPER JS CODE */

        /**********************************************************/
        //$('.wpvr_helper_toggler').click(function (e) {
        //    e.preventDefault();
        //    var t = '.wpvr_fbvs_helper_form_wrap#helper_' + $(this).attr('h');
        //    console.log(t);
        //    $(t).toggle();
        //
        //});

        function wpvr_add_element_counting(target, elt, counter_id) {
            var counter = $('#' + target.attr('counter_id'));
            var str_values = target.val().trim().replace(/(\r\n|\n|\r)/gm, "");
            var arr_values;

            if (str_values != '') arr_values = str_values.split(',');
            else arr_values = [];

            arr_values.push(elt.trim());
            str_values = arr_values.join(",\n");
            target.val(str_values);
            //console.log(counter_id);
            //$('span', counter).html(arr_values.length);
            $('#' + counter_id + ' span').html(arr_values.length);

        }

        $('.wpvr_collapse_sections').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var zone_id = btn.attr('zone_id');
            var is_btn = btn.attr('is_btn');
            btn.toggleClass('open');
            //console.log( zone_id );
            if (zone_id == 'all') {
                var zone = $('.wpvr_source_result');

                if (btn.hasClass('open')) {
                    zone.addClass('open');
                    $('.wpvr_collapse_sections', zone).addClass('open');
                } else {
                    zone.removeClass('open');
                    $('.wpvr_collapse_sections', zone).removeClass('open');
                }
            } else {
                var zone = $('.wpvr_source_result#' + zone_id);
                zone.toggleClass('open');
                if (is_btn == '0') {
                    $('.wpvr_collapse_sections', zone).toggleClass('open');
                }
            }

        });


        $('.wpvr_show_section_authors').click(function (e) {
            e.preventDefault();
            var btn = $(this);
            var state = btn.attr('state');
            var zone_id = btn.attr('zone_id');
            var zone = $('.wpvr_source_result#source_' + zone_id);


            if (state == 'off') {
                btn.attr('state', 'on');
                btn.removeClass('off').addClass('on');
                zone.addClass('show_authors');
            } else {
                btn.attr('state', 'off');
                btn.removeClass('on').addClass('off');
                zone.removeClass('show_authors');
            }
        });


        $('.wpvr_helper_wrap').each(function () {
            var wrap = $(this);
            var service = wrap.attr('service');
            var helper_url = wrap.attr('helper_url');
            var helper_dest = $('#' + wrap.attr('helper_dest_id'));
            var helper_counter_id = wrap.attr('helper_counter_id');
            var helper_type = wrap.attr('helper_type');
            var helper_append = wrap.attr('helper_append');

            var helper_button = $('.wpvr_helper_button', wrap);
            var helper_input = $('.wpvr_helper_input', wrap);
            var helper_toggler = $('.wpvr_helper_toggler', wrap);
            var helper_form = $('.wpvr_helper_form', wrap);

            helper_input.keypress(function (event) {
                if (event.which == 13) {
                    event.preventDefault();
                    helper_button.trigger('click');
                }
            });


            helper_toggler.click(function (e) {
                e.preventDefault();
                $(this).toggleClass('closed');
                helper_form.toggle();
            });

            helper_button.click(function (e) {
                e.preventDefault();
                var helper_value = helper_input.attr('value');
                if (helper_value == '') return false;

                var spinner = wpvr_add_loading_spinner(helper_button);

                $.ajax({
                    type: 'POST',
                    url: wpvr_globals.ajax_url,
                    data: {
                        helper_value: helper_value,
                        helper_type: helper_type,
                        service: service,
                        action: 'use_helper',
                    },
                    success: function (data) {
                        wpvr_remove_loading_spinner(spinner);
                        var $json = wpvr_get_json(data);
                        var boxHelper = wpvr_show_loading({
                            title: 'Facebook ID Helper : ' + helper_type,
                            text: wpvr_localize.loadingCenter,
                            isModal: false,
                            cancelButton: '<i class="fa fa-times"></i> Close Helper',
                        });

                        boxHelper.doCancel(function () {
                            boxHelper.doClose();
                        });
                        if ($json.status != 1) {
                            boxHelper.doText($json.msg);
                            $('.wpvr_loading_msg', boxHelper).center();
                        }
                        var lines = '';
                        $.each($json.data, function (i, item) {
                            //console.log(i + ' : ' + i % 2);
                            if (i % 2 == 1) var odd = 'odd';
                            else var odd = '';
                            lines = lines +
                                '<div class="wpvr_helper_item ' + odd + '" >' +
                                '<div class="wpvr_helper_item_thumb pull-left">' +
                                '<img src="' + item.thumb + '" />' +
                                '</div>' +
                                '<button class="wpvr_helper_choose" item_id="' + item.id + '" >' +
                                'Choose this ' + item.label +
                                '</button>' +
                                '<div class="wpvr_helper_item_main">' +
                                '<div class="wpvr_helper_item_main_txt">' + item.name + '</div><br/>' +
                                '</div>' +
                                '<div class="wpvr_clearfix"></div>' +
                                '</div>'
                            ;

                            var list = '<div class="wpvr_helper_list">' + lines + '</div>';
                            boxHelper.doText(list);
                            $('.wpvr_loading_msg', boxHelper).center();

                            $('.wpvr_helper_choose', boxHelper).click(function (e) {
                                var item_id = $(this).attr('item_id');
                                //console.log(helper_append);
                                if (helper_append != 1) {
                                    helper_dest.attr('value', item_id);
                                } else {
                                    wpvr_add_element_counting(helper_dest, item_id, helper_counter_id);
                                }
                                helper_input.attr('value', '');
                                boxHelper.doClose();
                            });

                        });

                        //$('#wpvr_video_preview').html($data.data);
                        //$('.wpvr_loading_msg', boxPreview).center();
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(thrownError);
                    }
                });


            });
        });


        $('.wpvr_autoClean_fields#autoCleanSchedule').change(function () {
            var value = $(this).attr('value');
            if (value == 'weekly') {
                $('.wpvr_autoClean_scheduleTime_wrap').fadeIn();
                $('.wpvr_autoClean_scheduleDay_wrap').fadeIn();
            } else if (value == 'daily') {
                $('.wpvr_autoClean_scheduleTime_wrap').fadeIn();
                $('.wpvr_autoClean_scheduleDay_wrap').hide();
            } else {
                $('.wpvr_autoClean_scheduleTime_wrap').hide();
                $('.wpvr_autoClean_scheduleDay_wrap').hide();
            }
        });

        $('.wpvr_autoClean_fields#autoCleanSchedule').each(function () {
            var value = $(this).attr('value');
            if (value == 'weekly') {
                $('.wpvr_autoClean_scheduleTime_wrap').fadeIn();
                $('.wpvr_autoClean_scheduleDay_wrap').fadeIn();
            } else if (value == 'daily') {
                $('.wpvr_autoClean_scheduleTime_wrap').fadeIn();
                $('.wpvr_autoClean_scheduleDay_wrap').hide();
            } else {
                $('.wpvr_autoClean_scheduleTime_wrap').hide();
                $('.wpvr_autoClean_scheduleDay_wrap').hide();
            }
        });

    });
})
;
/* REndering Charts Async */
function wpvr_async_draw_chart(canevasObject, legendObject, data, type, chart_id) {
    // jQuery(document).ready(function ($) {


    //console.log(data);

    if (type == 'pie') {
        var chart_options = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "transparent",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 3,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 0, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 50,
            //String - Animation easing effect
            animationEasing: "easeOutQuart",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //String - A legend template
            legendTemplate: "<ul class=\"wpvr_chart_legend <%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><div class=\" wpvr_chart_legend_color pull-left\" style=\"background-color:<%=segments[i].fillColor%>\"></div><%if(segments[i].label){%><div class=\" wpvr_chart_legend_text pull-left \"><%=segments[i].label%> ( <%=segments[i].value%> )</div><%}%></li><%}%></ul>"
        };


        var width = canevasObject.parent().width();
        canevasObject.attr("width", width);
        var ctx = canevasObject.get(0).getContext("2d");
        var wpvr_chart_object = new Chart(ctx).Pie(data, chart_options);
        var legend = wpvr_chart_object.generateLegend();
        legendObject.html(legend);
        window.onresize = function (event) {
            var width = canevasObject.parent().width();
            canevasObject.attr("width", width);
            var ctx = canevasObject.get(0).getContext("2d");
            var wpvr_chart_object = new Chart(ctx).Pie(data, chart_options);
            var legend = wpvr_chart_object.generateLegend();
            legendObject.html(legend);
        };

    } else if (type == 'donut') {
        var chart_options = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 5,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 60, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 20,
            //String - Animation easing effect
            animationEasing: "swing",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //String - A legend template
            legendTemplate: "<ul class=\"wpvr_chart_legend <%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){ if(segments[i].value==0) continue;%><li><div class=\" wpvr_chart_legend_color pull-left\" style=\"background-color:<%=segments[i].fillColor%>\"></div><%if(segments[i].label){%><div class=\" wpvr_chart_legend_text pull-left \"><%=segments[i].label%> ( <%=segments[i].value%> )</div><%}%></li><%}%></ul>"
        };

        var width = canevasObject.parent().width();
        canevasObject.attr("width", width);
        var ctx = canevasObject.get(0).getContext("2d");
        var wpvr_chart_object = new Chart(ctx).Doughnut(data, chart_options);
        var legend = wpvr_chart_object.generateLegend();
        legendObject.html(legend);
        window.onresize = function (event) {
            var width = canevasObject.parent().width();
            canevasObject.attr("width", width);
            var ctx = canevasObject.get(0).getContext("2d");
            var wpvr_chart_object = new Chart(ctx).Doughnut(data, chart_options);
            var legend = wpvr_chart_object.generateLegend();
            legendObject.html(legend);
        };

    } else if (type == 'bar') {
        var chart_options = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
        }


        var width = canevasObject.parent().width();
        canevasObject.attr("width", width);
        var ctx = canevasObject.get(0).getContext("2d");
        var wpvr_chart_object = new Chart(ctx).Bar(data, chart_options);
        var legend = wpvr_chart_object.generateLegend();
        legendObject.html(legend);
        window.onresize = function (event) {
            var width = canevasObject.parent().width();
            canevasObject.attr("width", width);
            var ctx = canevasObject.get(0).getContext("2d");
            var wpvr_chart_object = new Chart(ctx).Bar(data, chart_options);
            var legend = wpvr_chart_object.generateLegend();
            legendObject.html(legend);
        };


    } else if (type == 'radar') {
        var chart_options = {
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,

            //tooltipTemplate: "<%if (label){%><%=label %>: <%}%><%= value + ' %' %>",
            // String - Template string for multiple tooltips
            multiTooltipTemplate: " <%= value %> <%=datasetLabel%>",
        };


        var width = canevasObject.parent().parent().parent().width();
        canevasObject.attr("width", width);
        var ctx = canevasObject.get(0).getContext("2d");
        //var ctx = document.getElementById(chart_id).getContext("2d");
        //console.log(ctx);
        var wpvr_chart_object = new Chart(ctx).Radar(data, chart_options);
        //console.log(wpvr_chart_object);
        //console.log(chart_options);
        //var legend = wpvr_chart_object.generateLegend();
        //legendObject.html(legend);


        //window.onresize = function (event) {
        //    var width = canevasObject.parent().parent().parent().width();
        //    console.log(width);
        //    canevasObject.attr("width", width);
        //    var ctx = canevasObject.get(0).getContext("2d");
        //    var wpvr_chart_object = new Chart(ctx).Radar(data, chart_options);
        //};

    } else {
        return false;
    }

    return wpvr_chart_object;
    // });
}

/* Rendering Charts */
function wpvr_draw_chart(canevasObject, legendObject, data, type) {

    jQuery(document).ready(function ($) {
        if (type == 'pie') {
            var chart_options = {
                //Boolean - Whether we should show a stroke on each segment
                segmentShowStroke: true,
                //String - The colour of each segment stroke
                segmentStrokeColor: "transparent",
                //Number - The width of each segment stroke
                segmentStrokeWidth: 3,
                //Number - The percentage of the chart that we cut out of the middle
                percentageInnerCutout: 0, // This is 0 for Pie charts
                //Number - Amount of animation steps
                animationSteps: 50,
                //String - Animation easing effect
                animationEasing: "easeOutQuart",
                //Boolean - Whether we animate the rotation of the Doughnut
                animateRotate: true,
                //Boolean - Whether we animate scaling the Doughnut from the centre
                animateScale: false,
                //String - A legend template
                legendTemplate: "<ul class=\"wpvr_chart_legend <%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><div class=\" wpvr_chart_legend_color pull-left\" style=\"background-color:<%=segments[i].fillColor%>\"></div><%if(segments[i].label){%><div class=\" wpvr_chart_legend_text pull-left \"><%=segments[i].label%> ( <%=segments[i].value%> )</div><%}%></li><%}%></ul>"
            };


            var width = canevasObject.parent().width();
            canevasObject.attr("width", width);
            var ctx = canevasObject.get(0).getContext("2d");
            var wpvr_chart_object = new Chart(ctx).Pie(data, chart_options);
            var legend = wpvr_chart_object.generateLegend();
            legendObject.html(legend);
            window.onresize = function (event) {
                var width = canevasObject.parent().width();
                canevasObject.attr("width", width);
                var ctx = canevasObject.get(0).getContext("2d");
                var wpvr_chart_object = new Chart(ctx).Pie(data, chart_options);
                var legend = wpvr_chart_object.generateLegend();
                legendObject.html(legend);
            };

        } else if (type == 'donut') {
            var chart_options = {
                //Boolean - Whether we should show a stroke on each segment
                segmentShowStroke: true,
                //String - The colour of each segment stroke
                segmentStrokeColor: "#fff",
                //Number - The width of each segment stroke
                segmentStrokeWidth: 5,
                //Number - The percentage of the chart that we cut out of the middle
                percentageInnerCutout: 60, // This is 0 for Pie charts
                //Number - Amount of animation steps
                animationSteps: 20,
                //String - Animation easing effect
                animationEasing: "swing",
                //Boolean - Whether we animate the rotation of the Doughnut
                animateRotate: true,
                //Boolean - Whether we animate scaling the Doughnut from the centre
                animateScale: false,
                //String - A legend template
                legendTemplate: "<ul class=\"wpvr_chart_legend <%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){ if(segments[i].value==0) continue;%><li><div class=\" wpvr_chart_legend_color pull-left\" style=\"background-color:<%=segments[i].fillColor%>\"></div><%if(segments[i].label){%><div class=\" wpvr_chart_legend_text pull-left \"><%=segments[i].label%> ( <%=segments[i].value%> )</div><%}%></li><%}%></ul>"
            };

            var width = canevasObject.parent().width();
            canevasObject.attr("width", width);
            var ctx = canevasObject.get(0).getContext("2d");
            var wpvr_chart_object = new Chart(ctx).Doughnut(data, chart_options);
            var legend = wpvr_chart_object.generateLegend();
            legendObject.html(legend);
            window.onresize = function (event) {
                var width = canevasObject.parent().width();
                canevasObject.attr("width", width);
                var ctx = canevasObject.get(0).getContext("2d");
                var wpvr_chart_object = new Chart(ctx).Doughnut(data, chart_options);
                var legend = wpvr_chart_object.generateLegend();
                legendObject.html(legend);
            };

        } else if (type == 'bar') {
            var chart_options = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
            }


            var width = canevasObject.parent().width();
            canevasObject.attr("width", width);
            var ctx = canevasObject.get(0).getContext("2d");
            var wpvr_chart_object = new Chart(ctx).Bar(data, chart_options);
            var legend = wpvr_chart_object.generateLegend();
            legendObject.html(legend);
            window.onresize = function (event) {
                var width = canevasObject.parent().width();
                canevasObject.attr("width", width);
                var ctx = canevasObject.get(0).getContext("2d");
                var wpvr_chart_object = new Chart(ctx).Bar(data, chart_options);
                var legend = wpvr_chart_object.generateLegend();
                legendObject.html(legend);
            };


        } else if (type == 'radar') {
            var chart_options = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
            }

            //console.log( data );

            var width = canevasObject.parent().width();
            canevasObject.attr("width", width);
            var ctx = canevasObject.get(0).getContext("2d");
            var wpvr_chart_object = new Chart(ctx).Radar(data, chart_options);
            var legend = wpvr_chart_object.generateLegend();
            legendObject.html(legend);


            window.onresize = function (event) {
                var width = canevasObject.parent().width();
                canevasObject.attr("width", width);
                var ctx = canevasObject.get(0).getContext("2d");
                var wpvr_chart_object = new Chart(ctx).Radar(data, chart_options);
            };

        } else return false;

        return wpvr_chart_object;
    });
}
