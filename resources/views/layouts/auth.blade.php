<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P4Global | Login</title>


    <!--STYLESHEET-->
    <!--=================================================-->

    <!--Open Sans Font [ OPTIONAL ] -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">


    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">


    <!--Nifty Stylesheet [ REQUIRED ]-->
    <link href="/assets/css/nifty.css" rel="stylesheet">


    <!--Font Awesome [ OPTIONAL ]-->
    <link href="/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">


    <!--Demo [ DEMONSTRATION ]-->
    <link href="/assets/css/demo/nifty-demo.min.css" rel="stylesheet">


    <link href="/assets/css/p4.css" rel="stylesheet">


</head>

<!--TIPS-->
<!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->

<body>
<div id="container" class="cls-container">

    <!-- BACKGROUND IMAGE -->
    <!--===================================================-->
    {{--<div id="bg-overlay" class="bg-img img-balloon"></div>--}}


    <!-- HEADER -->
    <!--===================================================-->
    <div class="cls-header cls-header-lg">
        <div class="cls-brand">
            <a class="box-inline" href="index.html">
                <!-- <img alt="Nifty Admin" src="/assets/img/logo.png" class="brand-icon"> -->
                <img src="/assets/img/login-logo.png" />
            </a>
        </div>
    </div>
    <!--===================================================-->

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    <!-- LOGIN FORM -->
    <!--===================================================-->
    @yield('content')
    <!--===================================================-->


    <!-- DEMO PURPOSE ONLY -->
    <!--===================================================-->
    {{--<div class="demo-bg">--}}
        {{--<div id="demo-bg-list">--}}
            {{--<div class="demo-loading"><i class="fa fa-refresh"></i></div>--}}
            {{--<img class="demo-chg-bg bg-trans" src="/assets/img/bg-img/thumbs/bg-trns.jpg" alt="Background Image">--}}
            {{--<img class="demo-chg-bg" src="/assets/img/bg-img/thumbs/bg-img-1.jpg" alt="Background Image">--}}
            {{--<img class="demo-chg-bg active" src="/assets/img/bg-img/thumbs/bg-img-2.jpg" alt="Background Image">--}}
            {{--<img class="demo-chg-bg" src="/assets/img/bg-img/thumbs/bg-img-3.jpg" alt="Background Image">--}}
            {{--<img class="demo-chg-bg" src="/assets/img/bg-img/thumbs/bg-img-4.jpg" alt="Background Image">--}}
            {{--<img class="demo-chg-bg" src="/assets/img/bg-img/thumbs/bg-img-5.jpg" alt="Background Image">--}}
            {{--<img class="demo-chg-bg" src="/assets/img/bg-img/thumbs/bg-img-6.jpg" alt="Background Image">--}}
            {{--<img class="demo-chg-bg" src="/assets/img/bg-img/thumbs/bg-img-7.jpg" alt="Background Image">--}}
        {{--</div>--}}
    {{--</div>--}}
    <!--===================================================-->



</div>
<!--===================================================-->
<!-- END OF CONTAINER -->



<!--JAVASCRIPT-->
<!--=================================================-->

<!--jQuery [ REQUIRED ]-->
<script src="/assets/js/jquery-2.1.1.min.js"></script>


<!--BootstrapJS [ RECOMMENDED ]-->
<script src="/assets/js/bootstrap.min.js"></script>


<!--Fast Click [ OPTIONAL ]-->
<script src="/assets/plugins/fast-click/fastclick.min.js"></script>


<!--Nifty Admin [ RECOMMENDED ]-->
<script src="/assets/js/nifty.min.js"></script>


</body>
</html>
