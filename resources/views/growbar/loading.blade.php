<!doctype html>
<html lang="en">
<head>
    <title>{!! $growPage_item['title'] !!}</title>
    <link href="{!! asset('assets/css/custom.css') !!}" rel="stylesheet" />
    <link href="{!! asset('assets/css/newsletter.css') !!}" rel="stylesheet" />
    <script src="{!! asset('assets/js/jquery-1.10.2.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(showGrowPage, {!! $growPage_item['second'] !!});

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
                <input type="email" placeholder="Enter Your Best Email Address Here" class="form-control colpick">
            @endif
        <div id="subscribe">
            <a class="btn btn-lg btn-primary" href="{!! $growPage_item['btnurl'] !!}" @if($growPage_item['btntxt_color']) style="color:{!! $growPage_item['btntxt_color'] !!}" @endif>{!! $growPage_item['btntxt'] !!}</a>
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
    })
</script>

</body>
</html>