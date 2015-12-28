
{!! $relink_item['code'] !!}

<script src="{!! URL::asset('') !!}assets/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src='{!! URL::asset('') !!}assets/js/nprogress.js'></script>
<link rel='stylesheet' href='{!! URL::asset('') !!}assets/css/nprogress.css'/>

<script type="text/javascript">

    NProgress.start();
    window.setTimeout(function () {
        NProgress.done();
        document.location.href = '<?php echo $relink_item['redirect_url'] ?>';
    },4000);

</script>