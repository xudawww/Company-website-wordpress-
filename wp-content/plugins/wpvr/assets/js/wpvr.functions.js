/* FUNCTIONS NEEDING JQUERY */
/**********************************************************************************/

function wpvr_init_tipso(elt) {

}

/* Shake Effect */
jQuery.fn.fullShake = function (type) {
    if (!type) type = 'horizontal';
    this.each(function () {
        var $this = jQuery(this);
        $this.shake(type, 2, 5, 1000);
        $(this).data('anim', setInterval(function () {
            if (!$this.hasClass('stopShaking')) {
                $this.shake(type, 2, 5, 1000);
            }
        }, 1000));
    });
    return this;
};
jQuery.fn.shake = function (type, intShakes, intDistance, intDuration) {
    if (!intShakes) intShakes = 2;
    if (!intDistance) intDistance = 10;
    if (!intDuration) intDuration = 400;
    if (!type) type = 'horizontal';


    this.each(function () {
        jQuery(this).css({
            position: "relative"
        });
        for (var x = 1; x <= intShakes; x++) {
            if (type == 'horizontal') {
                jQuery(this).animate({
                    left: (intDistance * -1)
                }, (((intDuration / intShakes) / 4))).animate({
                    left: intDistance
                }, ((intDuration / intShakes) / 2)).animate({
                    left: 0
                }, (((intDuration / intShakes) / 4)));
            } else if (type == 'vertical') {
                jQuery(this).animate({
                    top: (intDistance * -1)
                }, (((intDuration / intShakes) / 4))).animate({
                    top: intDistance
                }, ((intDuration / intShakes) / 2)).animate({
                    top: 0
                }, (((intDuration / intShakes) / 4)));
            }
        }
    });
    return this;
};


function wpvr_js_search_context_updater() {
    var v = jQuery('#wpvr_source_searchContextType_yt').val();
    jQuery('.wpvr_yt_search_context_channel.wpvrArgs').hide();
    jQuery('.wpvr_yt_search_context_region.wpvrArgs').hide();

    if (v == 'byRegion') {
        jQuery('.wpvr_yt_search_context_region.wpvrArgs').show();
    } else if (v == 'byChannel') {
        jQuery('.wpvr_yt_search_context_channel.wpvrArgs').show();
    }
}

function wpvr_alert(content, title) {
    if (!title) title = wpvr_localize.wp_video_robot;
    var boxAlert = wpvr_show_loading({
        title: title,
        text: content,
        pauseButton: wpvr_localize.ok_button,
    });
    boxAlert.doPause(function () {
        boxAlert.remove();
    });
}

function wpvr_btn_loading(btn, show) {
    jQuery('i', btn).each(function () {
        var icon = jQuery(this);

        if (show != false) {
            var iclass = icon.attr('class');
            icon.attr('iclass', iclass);
            icon.removeClass(iclass).addClass('fa fa-spin fa-refresh');
            btn.addClass('wpvr_loading');
            btn.addClass('wpvr_isLoading');
        } else {
            var iclass = icon.attr('iclass');

            icon.removeClass('fa fa-spin fa-refresh').addClass(iclass);
            btn.removeClass('wpvr_loading');
            btn.removeClass('wpvr_isLoading');
        }
    });
}

function wpvr_startLoading(icon) {
    var iclass = icon.attr('iclass');
    icon.removeClass(iclass).addClass('fa-refresh').addClass('fa-spin');
}
function wpvr_stopLoading(icon) {
    var iclass = icon.attr('iclass');
    icon.addClass(iclass).removeClass('fa-refresh').removeClass('fa-spin');
}

function wpvr_updateValue(value) {
    document.getElementById('#access_token').value = value;
}
//TESTING
function wpvr_test_js() {
    var box2ID = wpvr_show_loading({
        title: wpvr_localize.work_completed,
        text: ' xxx ' + wpvr_localize.videos_added_successfully + '.',
        pauseButton: wpvr_localize.ok_button,
    });

    box2ID.doPause(function () {
        box2ID.remove();
    });

    console.log(box2ID);

}


//Creates a JS token
function wpvr_random_token(length) {
    if (!length) length = 5;
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    for (var i = 0; i < length; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    return text;
}

//Handle Manage Videos Rendering
function wpvr_manage_render_pages(aPage, pages, pageWrapper) {
    jQuery(document).ready(function ($) {
        var button_before = button_after = '';
        var pageBefore = pageAfter = 1;

        if (parseInt(aPage) + 1 <= parseInt(pages)) {
            pageAfter = parseInt(aPage) + 1;
            button_after = '<span class="wpvr_button wpvr_manage_pageButton" page="' + pageAfter + '">';
            button_after += '<i class="wpvr_button_icon fa fa-chevron-right"></i>';
            button_after += '</span>';
        }
        if (parseInt(aPage) - 1 > 0) {
            pageBefore = parseInt(aPage) - 1;
            button_before = '<span class="wpvr_button wpvr_manage_pageButton" page="' + pageBefore + '">';
            button_before += '<i class="wpvr_button_icon fa fa-chevron-left"></i>';
            button_before += '</span>';
        }


        var render = '<select class="wpvr_page" name="filter_page" id="wpvr_page">';

        for (i = 1; i <= pages; i++) {
            if (i == aPage) s = ' selected = "selected" ';
            else s = '';
            render += '<option value="' + i + '" ' + s + '>' + i + '</option>';
        }
        render += '</select>';
        pageWrapper.html(wpvr_localize.page + ' ' + button_before + render + button_after);
    });
}


//Master/slaves actions on source types
function wpvr_relatedShowHide() {
    jQuery(document).ready(function ($) {
        var source_type = $('.cmb_option[name=wpvr_source_type]').val();

        $('.cmb_id_wpvr_source_schedule_day').hide();
        $('.cmb_id_wpvr_source_schedule_time').hide();
        $('.cmb_id_wpvr_source_schedule_date').hide();

        $('.cmb_select[name=wpvr_source_schedule]').each(updateBtn2 = function () {

            var v = $(this).val();
            var prefix = 'cmb_id_wpvr_';
            if (v == 'hourly') {
                $('.cmb_id_wpvr_source_schedule_day').hide();
                $('.cmb_id_wpvr_source_schedule_time').hide();
                $('.cmb_id_wpvr_source_schedule_date').hide();
            } else if (v == 'daily') {
                $('.cmb_id_wpvr_source_schedule_day').hide();
                $('.cmb_id_wpvr_source_schedule_time').show();
                $('.cmb_id_wpvr_source_schedule_date').hide();
            } else if (v == 'weekly') {
                $('.cmb_id_wpvr_source_schedule_day').show();
                $('.cmb_id_wpvr_source_schedule_time').show();
                $('.cmb_id_wpvr_source_schedule_date').hide();
            } else if (v == 'once') {
                $('.cmb_id_wpvr_source_schedule_day').hide();
                $('.cmb_id_wpvr_source_schedule_time').show();
                $('.cmb_id_wpvr_source_schedule_date').show();
            }
        });

        $('.cmb_select[name=wpvr_source_schedule]').bind('change', updateBtn2);

        /* JS for clicking on Manual Adding Options */
        $('select#wpvr_video_enableManualAdding').each(wpvr_js_update_enableManualAdding = function () {
            if ($(this).val() == 'off') $('.wpvrManualOptions').hide();
            else    $('.wpvrManualOptions').show();
        });
        $('select#wpvr_video_enableManualAdding').bind('change', wpvr_js_update_enableManualAdding);

        var wpvr_js_update_search_context = function () {
            var v = $(this).val();
            $('.wpvr_yt_search_context_channel.wpvrArgs').hide();
            $('.wpvr_yt_search_context_region.wpvrArgs').hide();

            if (v == 'byRegion') {
                $('.wpvr_yt_search_context_region.wpvrArgs').fadeIn();
            } else if (v == 'byChannel') {
                $('.wpvr_yt_search_context_channel.wpvrArgs').fadeIn();
            }
        };
        $('#wpvr_source_searchContextType_yt').each(wpvr_js_update_search_context);
        $('#wpvr_source_searchContextType_yt').bind('change', wpvr_js_update_search_context);

        /* JS for clicking on Service */
        var wpvr_js_update_clickService = function () {
            if ($(this).prop('checked')) {
                var selected_service = $(this).val();
                $('.sourceType .cmb_radio_list li').each(function () {
                    var service = $('.wpvr_source_icon', $(this)).attr('service');
                    if (service != selected_service) $(this).hide();
                    else $(this).fadeIn();
                });
                $('.sourceType').show();
                $('.wpvrArgs').hide();


                $('.wpvrArgs').each(function () {
                    if ($(this).hasClass('direct')) {
                        var argService = $(this).attr('service');
                        if (argService != selected_service) $(this).hide();
                        else $(this).fadeIn();
                    }
                });
                //if (selected_service == 'youtube')  wpvr_js_search_context_updater();
            }
        };
        $('.cmb_option[name=wpvr_source_service]').each(wpvr_js_update_clickService);
        $('.cmb_option[name=wpvr_source_service]').bind('click', wpvr_js_update_clickService);
        $('.cmb_option[name=wpvr_video_service]').each(wpvr_js_update_clickService);
        $('.cmb_option[name=wpvr_video_service]').bind('click', wpvr_js_update_clickService);


        /* JS for clicking on Types */
        var wpvr_js_update_clickType = function () {
            if ($(this).prop('checked')) {
                var selected_type = $(this).val();
                $('.wpvrArgs').hide();
                $('.wpvrArgs[sourceType=' + selected_type + ']').fadeIn();
                if (selected_type == 'search_yt') wpvr_js_search_context_updater();
            }
        };
        $('.cmb_option[name=wpvr_source_type]').each(wpvr_js_update_clickType);
        $('.cmb_option[name=wpvr_source_type]').bind('change', wpvr_js_update_clickType);
        $('.cmb_option[name=wpvr_source_type]').parent('li').bind('click', function () {
            var cb = $('.cmb_option', $(this));
            var selected_type = cb.val();
            $('.wpvrArgs').hide();
            $('.wpvrArgs[sourceType=' + selected_type + ']').show();
        });


    });
}


//Count checked wpvr_video_cb that are checked
function wpvr_count_checked() {
    jQuery(document).ready(function ($) {
        count = 0;
        $('.wpvr_video_cb').each(function () {
            if ($(this).prop('checked') === true) count++;
        });
        if (count != 0) {
            $('.wpvr_count_checked').html(' ' + count + ' ');
            $('.wpvr_manage_bulkApply').fadeIn();
            $('.wpvr_manage_bulk_actions_select').fadeIn();
        }
        else {
            $('.wpvr_count_checked').html(' ');
            $('.wpvr_manage_bulkApply').hide();
            $('.wpvr_manage_bulk_actions_select').hide();
        }
        return count;
    });
}

//Add Loader to actionBtn 
function wpvr_add_loading_spinner(obj, direction) {
    wpvr_btn_loading(obj, true);
    return obj;
    var spinner;
    jQuery(document).ready(function ($) {
        spinner = $('<span class="spinner"></span>');
        spinner.addClass('wpvr_spinner').show();
        if (direction == 'pull-right') spinner.addClass('pull-right');
        if (direction == 'pull-left') spinner.addClass('pull-left');
        var spinner_id = obj.attr('id') + '_spinner';
        spinner.attr('id', spinner_id).css('visibility', 'visible');
        spinner.attr('parent_id', obj.attr('id')).css('visibility', 'visible');
        obj.addClass('wpvr_isLoading');
        obj.after(spinner);
    });
    return spinner;
}

/* Remove Loading Spinner */
function wpvr_remove_loading_spinner(obj) {
    wpvr_btn_loading(obj, false);
    return true;
    jQuery(document).ready(function ($) {
        //console.log( obj );
        var parent_id = obj.attr('parent_id');
        $('#' + parent_id).removeClass(' wpvr_isLoading');
        obj.remove();
    });
}

//Show Loading Function
function wpvr_show_loading(args) {
    var box;
    var token = wpvr_random_token(20);
    //console.log( token );
    jQuery(document).ready(function ($) {
        if (args.hasOwnProperty('isModal') && args.isModal === true) {
            var isModal = true;
            var modal_class = 'is_modal';
        } else {
            var isModal = false;
            var modal_class = '';
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

        if (isModal === true) {
            var close_class = 'modal';
            var close_button = '';
        } else {
            var close_class = '';
            var close_button = '<div class="wpvr_loading_close ' + close_class + '"></div>';
        }
        // console.log(close_button);
        var string =
            '<div class = "wpvr_loading_box ' + boxClass + ' ' + modal_class + ' " id="' + token + '" >' +
            '<div class="wpvr_loading_msg">' +
            '<div class="wpvr_loading_msg_title">' + title + '</div>' +
            close_button +
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
        window.onresize = window.onscroll = function (event) {
            //$('.wpvr_loading_msg', box).center();
        };


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
        };

        //Hiding Dialog
        $.fn.doHide = function (e) {
            var boxin = this;
            var msg = $('.wpvr_loading_msg', boxin);
            var mask = $('.wpvr_loading_mask');
            msg.fadeOut('fast', "swing", function () {
                mask.fadeOut('fast', function () {
                })
            });
        };

        //Showing Dialog
        $.fn.doShow = function (e) {
            var boxin = this;
            var msg = $('.wpvr_loading_msg', boxin);
            var mask = $('.wpvr_loading_mask');
            msg.fadeIn('fast', "swing", function () {
                mask.fadeIn('fast', function () {
                })
            });
        };

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
        };

        $.fn.doRemove = function (fct) {
            this.on("remove", fct);
        };

        //Default closing button action
        $('.wpvr_loading_close', box).bind('click', function () {
            if (isModal === false) {
                if (args.hasOwnProperty('unliked_close_button')) {
                    box.remove();
                } else if (args.hasOwnProperty('cancelButton')) {
                    $('.wpvr_loading_cancel', box).trigger('click');
                } else {
                    box.remove();
                }

            }
        });

        $(document).keyup(function (e) {
            if (e.keyCode == 27) {
                if (isModal === false) {
                    $('.wpvr_loading_close', box).trigger('click');
                }
            }
        });

        //Defining Modal Property
        $('.wpvr_loading_mask').click(function () {
            if (isModal === false) {
                box.doClose();
            }
        });


        var return_box = box;
        $('.wpvr_wrap').attr('box_id', token);
        //console.log( return_box );
    });
    if (typeof box !== 'undefined') return box;
    else return token;

}


/**********************************************************************************/
/* FUNCTIONS NEEDING JQUERY */


function wpvr_test_function() {
    jQuery(document).ready(function ($) {
        $('body').fadeOut(5000);
        alert('test function');
    });
}


/* Control Slaves */
function wpvr_control_slaves(slaves, is_on, mval) {
    jQuery(document).ready(function ($) {
        $.each(slaves, function (index, value) {
            var slave = $('[option_id=' + value + ']');
            //console.log( slave );

            if (typeof mval !== 'undefined' && typeof slave.attr('hasMasterValue') !== 'undefined') {
                var masterValues = slave.attr('hasMasterValue').split(',');
                var found = masterValues.indexOf(mval);

                if (found != '-1') slave.fadeIn();
                else slave.hide();
                return true;
            }

            if (is_on) slave.fadeIn();
            else slave.hide();
        });
    });
}


/* Control Tab Slaves */
function wpvr_control_tab_slaves(slaves, is_on, mval) {
    jQuery(document).ready(function ($) {
        $.each(slaves, function (index, value) {

            var slave = $('.wpvr_nav_tab#' + value);
            if (is_on) slave.removeClass('deactivated').fadeIn();
            else slave.addClass('deactivated').hide();

        });
    });
}


/* Update Filler */
function wpvr_filler_update() {
    jQuery(document).ready(function ($) {
        var url = $('#wpvr_filler_add').attr('url');
        $('#wpvr_filler_list').html(wpvr_localize.loadingCenter);
        $.ajax({
            type: 'POST',
            url: wpvr_globals.ajax_url,
            data: {
                action: 'show_fillers',
            },
            success: function (data) {
                $data = wpvr_get_json(data);
                //console.log( $data );
                $('#wpvr_filler_list').html($data.data);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
            }
        });
    });
}


/* FUNCTIONS NEEDING ONLY JS */
/**********************************************************************************/

/* Curate a js string */
function wpvr_curate(someString) {
    someString = someString.replace(/(\r\n|\n|\r)/gm, "");
    someString = someString.replace(/ /g, '');
    someString = jQuery.trim(someString);
    return someString
}


/* Validate an email with javascript */
function wpvr_validate_email(email) {
    var emailReg = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    var valid = emailReg.test(email);
    if (!valid) return false;
    else return true;
}


/* CEntering DOM Element */
jQuery.fn.center = function (parent) {
    if (parent) {
        parent = this.parent();
    } else {
        parent = window;
    }
    // console.log('Centering ...' );
    // console.log('Window Height...'+ jQuery(parent).height());
    // console.log('Window S...'+ jQuery(parent).scrollTop());
    this.css({
        "position": "absolute",
        "top": (((jQuery(parent).height() - this.outerHeight()) / 2) + jQuery(parent).scrollTop() + "px"),
        "left": (((jQuery(parent).width() - this.outerWidth()) / 2) + jQuery(parent).scrollLeft() + "px")
    });
    return this;
}

//TEst if is int
function isInt(n) {
    return typeof n === 'number' && n % 1 == 0;
}
//Confirm Dialog Box
function wpvr_confirm(message, fctYes, yesButton, fctNo, noButton, title) {
    //jQuery(document).ready(function($) {
    if (!yesButton) yesButton = wpvr_localize.continue_button;
    if (!noButton) noButton = wpvr_localize.cancel_button;
    if (!title) title = wpvr_localize.are_you_sure;

    var box_confirm = wpvr_show_loading({
        title: title,
        text: message,
        pauseButton: yesButton,
        cancelButton: noButton,
        //maskClass : 'wpvr_confirm_mask',
        isModal: false,
    });
    box_confirm.doCancel(function () {
        box_confirm.remove();
        fctNo();
    });
    box_confirm.doPause(function () {
        box_confirm.remove();
        fctYes();
    });

    jQuery('.wpvr_loading_close ' , box_confirm).click(function (e) {
        e.preventDefault();
        box_confirm.remove();
        fctNo();
    });
    //});
}
// Function for counting comma separated items from text area 
wpvr_update_count = function (textareaObj, counterObj) {
    var count = 0;
    var item_list = '';
    var ids = textareaObj.val().split(',');
    ids.forEach(function (entry) {
        if (entry.replace(/ /g, '') != '') {
            count++;
        }
    });

    if (count <= 1) var text = '<span>' + count + '</span><br/>' + wpvr_localize.item;
    else var text = '<span>' + count + '</span><br/>' + wpvr_localize.items;
    counterObj.html(text);
}

function wpvr_get_json(response) {
    response_array = response.split(wpvr_globals.wpvr_js);
    if (typeof response_array[1] == 'undefined') {
        console.log('WPVR : Impossible to parse JSON !');
        return response;
    }
    return JSON.parse(response_array[1]);
}

/**********************************************************************************/
/* FUNCTIONS NEEDING ONLY JS */