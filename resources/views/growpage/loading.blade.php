<!doctype html>
<html lang="en">
<head>
    <title>{!! $growPage_item['title'] !!}</title>
    <link href="{!! asset('assets/css/custom.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/css/newsletter.css') !!}" rel="stylesheet" />
    <script src="{!! asset('assets/js/jquery-1.10.2.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(showGrowPage, '{!! $growPage_item['second'] !!}');

            function showGrowPage(){
                $('#newsletter-part').show();
            }
        });
    </script>
</head>
<body>
<iframe src="{!! $growPage_item['page_url'] !!}" frameborder="0" style="height: 100%;width: 100%"></iframe>

<section id="newsletter-part" class="scale-max animated slideInDown"  style="display:none;background-image: url('{!! asset('/images/backgrounds/'.$growPage_item['bg']) !!}')">
    <div class="overlay"></div>
    <div class="item-title text-center">
        <h1 class="newsletter-title" data-id="redirect-heading" @if($growPage_item['title_color']) style="color:{!! $growPage_item['title_color'] !!}" @endif>{!! $growPage_item['title'] !!}</h1>
            @if($growPage_item['upload_path'])
                <div data-id="text-img">
                    <img src="{!! asset('/images/growpage/'.$growPage_item['upload_path']) !!}" width="200" height="200" class="mCS_img_loaded">
                </div>
            @endif
                <p data-id="text-desc" @if($growPage_item['descrip_color']) style="color:{!! $growPage_item['descrip_color'] !!}" @endif>{!! $growPage_item['descrip'] !!}</p>
            @if($growPage_item['type'] == 0)
                {!! Form::open(array('url' => '')) !!}
                    <input type="hidden" id="_token" name="_token" value="{!! csrf_token() !!}">
                    <input type="hidden" id="growpage" value="{!! $growPage_item['id'] !!}">
                    <input type="email" id="email" placeholder="Enter Your Best Email Address Here" class="form-control colpick">
            @endif
        <div id="subscribe">
            @if($growPage_item['type'] == 0)
                    <a class="btn btn-lg btn-primary" id="submit" @if($growPage_item['btntxt_color']) style="color:{!! $growPage_item['btntxt_color'] !!}" @endif>{!! $growPage_item['btntxt'] !!}</a>
                {!! Form::close() !!}
            @elseif($growPage_item['type'] == 1)
                <a class="btn btn-lg btn-primary" href="{!! $growPage_item['btnurl'] !!}" @if($growPage_item['btntxt_color']) style="color:{!! $growPage_item['btntxt_color'] !!}" @endif>{!! $growPage_item['btntxt'] !!}</a>
            @endif
            <div class="block-message">
                <div class="message-2">
                    <a href="{!! $growPage_item['page_url'] !!}" id="close-me" data-id="text-decline">No Thanks</a>
                </div>
            </div>
        </div>
    </div>
</section>

<script src='{!! asset('assets/js/nprogress.js') !!}'></script>

<script type="text/javascript">
    $("#close-me").click(function(){
        NProgress.start();
        window.setTimeout(function () {
            NProgress.done();
            document.location.href = '{!!$growPage_item['page_url']!!}';
        },1000);
    });

    $("#submit").click(function(){
        var CSRF_TOKEN = $("#_token").val();
        var growpage = $("#growpage").val();
        var email = $("#email").val();

        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if(re.test(email))
        {
            $.ajax({
                url: '/subscribe',
                type: 'POST',
                data: {
                    _token: CSRF_TOKEN,
                    growpage: growpage,
                    email: email
                },

                success: function (data) {
                    if(data == 'ok')
                    {
                        document.location.href = '{!!$growPage_item['btnurl']!!}';
                    }
                    else{
                        $("#email").css({"border-color":"rgba(255, 0, 0, 0.53)"});
                    }
                },
                error: function () {
                    $("#email").css({"border-color":"rgba(255, 0, 0, 0.53)"});
                }
            });
        }
        else{
            $("#email").css({"border-color":"rgba(255, 0, 0, 0.53)"});
        }
    })
</script>

</body>
</html>