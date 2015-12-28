@section('live_content')

<div id="bg" style="background-image:url('@if(old('bg')) {!! asset('images/backgrounds/'.old('bg'))!!} @elseif(isset($growPage['bg'])) {!! asset('images/backgrounds/'.$growPage['bg']) !!}@elseif(isset($backgrounds[0])){!! asset('images/backgrounds/'.$backgrounds[0]['name']) !!} @endif '); height: 620px;">
    <section id="newsletter-part" class="scale-max animated slideInDown">
        <div class="overlay"></div>
        <div class="item-title text-center">
            <h1 class="newsletter-title" data-id="redirect-heading"  id="col_title"
                style="word-wrap: break-word;@if(old('title_color'))color:{!!old('title_color') !!};@elseif(isset($growPage['title_color'])) color:{!! $growPage['title_color'] !!} @endif">
                @if(old('title'))
                    {!! old('title') !!}
                @elseif(isset($growPage['title']))
                    {!! $growPage['title'] !!}
                @else
                    Title
                @endif
            </h1>
            <div data-id="text-img">
                <img id="img_c" src="@if(old('image')){!! asset('images/growpage/tmp/'.old('image'))!!}@elseif(isset($growPage['upload_path']) && !empty($growPage['upload_path'])){!! asset('images/growpage/'.$growPage['upload_path'])!!}@endif"
                     style="
                     @if(!old('image') && empty(old('image')))
                        @if(!isset($growPage['upload_path']) || empty($growPage['upload_path']))
                             display:none;
                        @endif
                     @endif" width="200" height="200" class="mCS_img_loaded" />
            </div>

            <p data-id="text-desc" id="col_desc" style="@if(old('descrip_color'))color:{!! old('descrip_color')!!};@elseif(isset($growPage['descrip_color']))color: {!! $growPage['descrip_color'] !!} @endif" >
                @if(old('descrip')){!!old('descrip')!!}@elseif(isset($growPage['descrip'])){!! $growPage['descrip'] !!}@else Description @endif </p>
            <div id="type_email" style="@if(old('type') == '0') display:block; @elseif(isset($growPage['type']) && $growPage['type'] == '0') display:block;@elseif(!isset($growPage['type']))  display:block; @else display: none;  @endif ">
                <input type="email" placeholder="Enter Your Best Email Address Here" class="form-control colpick">
            </div>
            <div id="subscribe">
                <a class="btn btn-lg btn-primary " id="col_btn" href="@if(old('btnurl')){!!old('btnurl') !!}@elseif(isset($growPage['btnurl'])){!! $growPage['btnurl'] !!}@endif"
                   style="@if(old('btntxt_color'))color:{!!old('btntxt_color')!!};@elseif(isset($growPage['btntxt_color']))color: {!! $growPage['btntxt_color'] !!} @endif" >
                    @if(old('btntxt')){!!old('btntxt')!!}@elseif(isset($growPage['btntxt'])) {!! $growPage['btntxt'] !!} @else Submit @endif</a>
                <div class="block-message">
                    <div class="message-2">
                        <a href="@if(isset($growPage['page_url'])){!!$growPage['page_url']!!}@endif" id="close-me" data-id="text-decline" style="color:#000000">No Thanks</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style type="text/css">
    #newsletter-part {
        position: relative;
    }
</style>
<script type="text/javascript">
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = "/upload-image";
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            done: function (e, data) {
                var img = data.result.path;
                var path = '/images/growpage/tmp/'+img;
                $('#img_c').attr('src',  path);
                $('#img_c').show();
                $('#img_hidden').val(img);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                        'width',
                        progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
                .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(function() {
        $('#remove_image').click(function () {
            $('#img_c').hide();
            var image = $('#img_hidden').val();
            $('#img_hidden').val('');
            $('#img_c').attr('src', '');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: 'remove',
                type: 'POST',
                data: {_token: CSRF_TOKEN, image: image},
                success: function (data) {
                    console.log(data);
                }
            });

        });
    });
    $('.bg').change(function(){
       var url = $(this).next('a').attr('href');
        $('#bg').css('background-image', 'url(' + url + ')');
    });

    $('#btnurl').keyup(function(){
        $('#col_btn').attr('href', $(this).val());
    });

    $('.btntxt').keyup(function(){
        $('#col_btn').html($(this).val());
    });
    $('.p_url').keyup( function(){
        $('#close-me').attr('href', $(this).val());
    });

    $('.type').change(function(){
        if($(this).val() != 1){
            $('#type_email').css('display', 'block');
        }else{
            $('#type_email').css('display', 'none');
        }
    });

    $('.cont_desc').keyup(function(){
        $('#col_desc').html($(this).val());
    });

    $('.cont_title').keyup(function(){
        $('#col_title').html($(this).val());
    });
    $(function(){
        $('.btntxt_color').colorpicker({
            @if(old('btntxt_color'))
                 color: "{!! old('btntxt_color') !!}",
            @elseif(isset($growPage['btntxt_color']))
                 color: "{!! $growPage['btntxt_color'] !!}",
            @else
                color: "#000000",
            @endif
        }).on('changeColor.btntxt_color', function(event){
            $('#col_btn').css('color', event.color.toHex());
        });

        $('.title_color').colorpicker({
            @if(old('title_color'))
                 color: "{!! old('title_color') !!}",
            @elseif(isset($growPage['title_color']))
                color: "{!! $growPage['title_color'] !!}",
            @else
                color: "#000000",
            @endif
        }).on('changeColor.title_color', function(event){
            $('#col_title').css('color', event.color.toHex());
        });

        $('.descrip_color').colorpicker({
            @if(old('descrip_color'))
                color: "{!! old('descrip_color') !!}",
            @elseif(isset($growPage['descrip_color']))
                 color: "{!! $growPage['descrip_color'] !!}",
            @else
                color: "#000000",
            @endif
        }).on('changeColor.title_color', function(event){
            $('#col_desc').css('color', event.color.toHex());
        });
    });

    $(".type").change(function(){
        var type = $(this).val();
        if(type == 0){
            $("#email_section").slideDown();
        } else if(type == 1){
            $("#email_section").slideUp();
        }
    });

    $("#remove-img").click(function(){
        $(this).parent().remove();
    });

</script>
@endsection
