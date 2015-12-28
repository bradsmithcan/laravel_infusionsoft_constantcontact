/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function actionType() {

    var theme_type = $("#theme_type").val();

    if ($(".action_type_opt:checked").val() == "form") {
        $('#email_services').slideDown('fast');
        $('#form-' + theme_type).show();
        $('#button-' + theme_type).hide();

    } else {
        $('#email_services').slideUp('fast');
        $('#form-' + theme_type).hide();
        $('#button-' + theme_type).show();
    }
}
function shorLinkActionType() {
    var theme_type = $("#theme_type").val();
    if ($(".action_type_short_link:checked").val() == "2") {
        $('#custom_short_link').slideDown('fast');
    } else {
        $('#custom_short_link').slideUp('fast');
    }
}
$(document).ready(function () {

    open_url();

    $('.action_type_opt:radio').change(
            function () {
                actionType();
            }
    );
    $('.action_type_short_link:radio').change(
            function () {
                shorLinkActionType();
            }
    );

    $("#page_url").change(function(){

        open_url();

    });

    $("#mysnips").click(function () {


        $('#loadload').show()
        var remarketing = $("textarea").val();
        var pageurl = $("#page_url").val();
        var user_id = $("#mypro").val();
        var domain_id = $("#domains").val();
        var custom_short_link_option = $('input[name=shortRadios]:checked').val();
        var custom_short_link = $("#short_url").val();
        var service_id = $("#email_service_id").val();
        var create_button_snip = $("#create_button_snip").val();
        var mess = $("#inputMessage").val();
        var button_text = $("#button_text").val();
        var button_url = $("#button_url").val();
        var bggcolor = $("#bggcolor").val();
        var text_color = $(".pick-a-color1").val();
        var action_color = $("input#action_color").val();
        var action_text_color = $("input#action_text_color").val();
        var theme_type = $("#theme_type").val();
        var post_text = $("#post_text").val();
        var feed_type = $("#type_selector").val();
        var is_candy = $("#is_candy").val();
        var action_type = $(".action_type_opt:checked").val();
        if (is_candy == 1) {
            var img_file_path = $('#candy_upload_path_id').val();
        } else {
            var img_file_path = $('#upload_path_id').val();
        }

        $("#error_upload_msg").addClass('hidden');
        if (is_candy == 1 && img_file_path == 1) {
            $("#error_upload_msg").removeClass('hidden');
            console.log('File required');
            $("#candy_file_path").focus();
            return false;
        }

        if (pageurl == "") {
            $("#page_url").focus();
            return false;
        }
        else {

            $.ajax({
                url: "/link",
                type: "POST",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _token: $('#is_token').val(),
                    remarketing_code: remarketing,
                    pageurl: pageurl,
                    user_id: user_id,
                    domain_id: domain_id,
                    short_option: custom_short_link_option,
                    short_link: custom_short_link,
                    email_service_id: service_id,
                    create_button_snip_code: create_button_snip,
                    message: mess,
                    buttontext: button_text,
                    buttonurl: button_url,
                    bg_gcolor: bggcolor,
                    textcolor: text_color,
                    actioncolor: action_color,
                    action_textcolor: action_text_color,
                    action_type: action_type,
                    themetype: theme_type,
                    posttext: post_text,
                    upload_path: img_file_path,
                    feedtype: feed_type
                },
                success: function (data) {
                    // alert(data);
                    //BootstrapDialog.alert('You have successfully Created Snip. Please View on Dashboard!');
                    /*BootstrapDialog.show({
                     title: 'Snips Success',
                     message: 'You have successfully Created Snip. Please View on Dashboard!'
                     });*/

                    $wrap = $('<div style="padding: 10px"></div>');
                    $wrap.append('<h1>Done. Now, share the links!</h1>');

                    var obj = jQuery.parseJSON(data);

                    $.each(obj, function (i, item) {
                        console.log(item.length);
                        if (item.length > 10) {
                            $wrap.append('<p><input type="text" class="form-control" value="' + item + '" /> </p>');
                            $wrap.append('<p><input type="hidden" id="url" class="form-control" value="' + item + '" /> </p>');
                            $wrap.append('<p><a href="' + item + '" class="btn btn-success" target="_blank">Preview</a> </p>');
                        }
                    });

                    $wrap.append("<div id='fb-root'></div><div class='fb-share-button' data-href='" + data + "' data-layout='button_count'></div> &nbsp;<a class='twitter popup' href='javascript:void(0)' onclick='tweetme()'>Tweet</a>");

                    (function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                            return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=578233692291345";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));


                    $('#myModal').removeClass('hidden');
                    $('#myModal').modal('show');
                    $('#myModal').modal({backdrop: 'static'});

                    $('#modal-body').html($wrap.html()).height('auto');

                    $('#loadload').hide();
//                    window.location = "/link";

                    console.log('Success');
                },
                error: function (callBack) {
                    console.log('Failed');

                }
            });
        }
        return false;
    });

    $("#mysnips-edit").click(function () {

        $('#loadload').show()

        var remarketing = $("textarea").val();
        var pageurl = $("#page_url").val();
        var user_id = $("#mypro").val();
        var domain_id = $("#domains").val();
        var custom_short_link_option = $('input[name=shortRadios]:checked').val();
        var custom_short_link = $("#short_url").val();
        var service_id = $("#email_service_id").val();
        var create_button_snip = $("#create_button_snip").val();
        var mess = $("#inputMessage").val();
        var button_text = $("#button_text").val();
        var button_url = $("#button_url").val();
        var bggcolor = $("#bggcolor").val();
        var text_color = $(".pick-a-color1").val();
        var action_color = $("input#action_color").val();
        var action_text_color = $("input#action_text_color").val();
        var theme_type = $("#theme_type").val();
        var post_text = $("#post_text").val();
        var feed_type = $("#type_selector").val();
        var is_candy = $("#is_candy").val();
        var action_type = $(".action_type_opt:checked").val();
        if (is_candy == 1) {
            var img_file_path = $('#candy_upload_path_id').val();
        } else {
            var img_file_path = $('#upload_path_id').val();
        }

        $("#error_upload_msg").addClass('hidden');
        if (is_candy == 1 && img_file_path == 1) {
            $("#error_upload_msg").removeClass('hidden');
            console.log('File required');
            $("#candy_file_path").focus();
            return false;
        }

        if (pageurl == "") {
            $("#page_url").focus();
            return false;
        }
        else {

            $.ajax({
                url: "/link/" + $('#snip_id').val(),
                type: "PUT",
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    _token: $('#is_token').val(),
                    remarketing_code: remarketing,
                    pageurl: pageurl,
                    user_id: user_id,
                    domain_id: domain_id,
                    short_option: custom_short_link_option,
                    short_link: custom_short_link,
                    email_service_id: service_id,
                    create_button_snip_code: create_button_snip,
                    message: mess,
                    buttontext: button_text,
                    buttonurl: button_url,
                    bg_gcolor: bggcolor,
                    textcolor: text_color,
                    actioncolor: action_color,
                    action_textcolor: action_text_color,
                    action_type: action_type,
                    themetype: theme_type,
                    posttext: post_text,
                    upload_path: img_file_path,
                    feedtype: feed_type
                },
                success: function (data) {
                    // alert(data);
                    //BootstrapDialog.alert('You have successfully Created Snip. Please View on Dashboard!');
                    /*BootstrapDialog.show({
                     title: 'Snips Success',
                     message: 'You have successfully Created Snip. Please View on Dashboard!'
                     });*/

                    $wrap = $('<div style="padding: 10px;;"></div>');
                    $wrap.append('<h1>Done. Now, share the links!</h1>');

                    var obj = jQuery.parseJSON(data);

                    $.each(obj, function (i, item) {
                        console.log(item.length);
                        if (item.length > 10) {
                            $wrap.append('<p><input type="text" class="form-control" value="' + item + '" /> </p>');
                            $wrap.append('<p><input type="hidden" id="url" class="form-control" value="' + item + '" /> </p>');
                            $wrap.append('<p><a href="' + item + '" class="btn btn-success" target="_blank">Preview</a> </p>');
                        }
                    });

                    $wrap.append("<div id='fb-root'></div><div class='fb-share-button' data-href='" + data + "' data-layout='button_count'></div> &nbsp;<a class='twitter popup' href='javascript:void(0)' onclick='tweetme()'>Tweet</a>");

                    (function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id))
                            return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.4&appId=578233692291345";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));
                    
                    $('#myModal').removeClass('hidden');
                    $('#myModal').modal('show');
                    $('#myModal').modal({backdrop: 'static'});

                    $('#modal-body').html($wrap.html()).height('auto');

                    $('#loadload').hide();
//                    window.location = "/link";

                    console.log('Success');
                },
                error: function (callBack) {
                    console.log('Failed');

                }
            });
        }
        return false;
    });

});

function open_url(){

    $('#iframe-preview').height($(window).height());

    var valuedata = $("#page_url").val();
    if (valuedata && !valuedata.match(/^http([s]?):\/\/.*/)) {
        valuedata = 'http://' + valuedata;
    }

    /* check for youtube thing inside the url
     */

    if ( valuedata.indexOf('youtube') !== -1 ) {
        valuedata = getId(valuedata);
    }

    $('#iframe-preview').attr('src', valuedata);

}

function tweetme() {

    var width = 575,
            height = 400,
            left = ($(window).width() - width) / 2,
            top = ($(window).height() - height) / 2,
            opts = 'status=1' +
            ',width=' + width +
            ',height=' + height +
            ',top=' + top +
            ',left=' + left;

    window.open("https://twitter.com/intent/tweet?url=http://" + $("#url").val(), 'twitter', opts);

}

$(document).ready(function () {

    $("select#post_text").val("Bottom_Left");

    $(".layoutsnip").find("span.input-group-addon > i").addClass("background_snip_color");
    $(".colorpicker-saturation").find("i").addClass("check");
    $("#customize").click(function () {
        $(".snip_create").hide();
        $(".layoutsnip").show();
        $('#customize').css('display', 'none');
        $('#edit_mess').css('display', 'block');
        //$( "#customize" ).replaceWith('<a href="#"class="btn btn-default" id="edit_mess">Edit Message</a>');

        //return false;
    });
    $("#edit_mess").click(function () {
        $(".snip_create").show();
        $(".layoutsnip").hide();
        $('#customize').css('display', 'block');
        $('#edit_mess').css('display', 'none');
        //$("#edit_mess" ).replaceWith('<a href="#"class="btn btn-default" id="customize">Customize</a>');
        //return false;
    });
});

function getId(url) {

    var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
    var match = url.match(regExp);

    if (match && match[2].length == 11) {

        var collector = "https://www.youtube.com/embed/"+match[2];

        $("#page_url").val(collector);

        return "https://www.youtube.com/embed/"+match[2];
    }

}

function changetheme() {

    var theme_types = $("#theme_type").val();

    actionType();
    $("#full_wid_img").addClass('hidden');
    $('#is_candy').val(2);
    if (theme_types == "Candy") {
        $("#candy").css("display", "block");
        $("#big-candy").css("display", "none");
        $("#social").css("display", "none");
        $("#full_width").css("display", "none");
        $("#bean").css("display", "none");

        $('#candy #profile_left_msg').val($("#inputMessage").val());
        if ($("#button_text").val() != '')
            $('#candy .snip_click').val($("#button_text").val());

    }
    else if (theme_types == "Big-Candy") {
        $("#big-candy").css("display", "block");
        $("#candy").css("display", "none");
        $("#social").css("display", "none");
        $("#full_width").css("display", "none");
        $("#bean").css("display", "none");

        $('#big-candy #profile_left_msg').val($("#inputMessage").val());
        if ($("#button_text").val() != '')
            $('#big-candy .snip_click').val($("#button_text").val());

        $('#is_candy').val(1);
        $("#full_wid_img").removeClass('hidden');
    }
    else if (theme_types == "Full-Width") {
        $("#full_width").css("display", "block");
        $("#candy").css("display", "none");
        $("#big-candy").css("display", "none");
        $("#social").css("display", "none");
        $("#bean").css("display", "none");

        $('#full_width #profile_left_msg').val($("#inputMessage").val());
        if ($("#button_text").val() != '')
            $('.full-width .snip_click').val($("#button_text").val());
        $("#full_wid_img").removeClass('hidden');

    }
    else if (theme_types == "Bean") {
        $("#bean").css("display", "block");
        $("#social").css("display", "none");
        $("#big-candy").css("display", "none");
        $("#full_width").css("display", "none");
        $("#candy").css("display", "none");

        $('#bean #profile_left_msg').val($("#inputMessage").val());
        if ($("#button_text").val() != '')
            $('#bean .snip_click').val($("#button_text").val());

    } else {

        $("#social").css("display", "block");
        $("#big-candy").css("display", "none");
        $("#candy").css("display", "none");
        $("#full_width").css("display", "none");
        $("#bean").css("display", "none");
        $("#bigbox").css("display", "none");
        $('#social #profile_left_msg').val($("#inputMessage").val());
        if ($("#button_text").val() != '')
            $('#social .snip_click').val($("#button_text").val());

    }
}

function edit_message() {
    var edt_mess = $("#inputMessage").val();
    $("span.messagetext").text(edt_mess);

}
function buttontext() {
    var btn_text = $("#button_text").val();
    $(".social_btn").text(btn_text);
}

function closecreate() {
    $(".createone").css("display", "none");
}
function position_change() {

}
      