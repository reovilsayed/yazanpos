@php
    $setting = App\Models\Setting::first();
    // dd($setting->logo);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0" />
    <!--fav icon-->
    <link rel="shortcut icon" href="images/fabicon.ico" />
    <link rel="icon" type="image/png" href="images/fabicon.png" />
    <!-- text icons -->
    <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        crossorigin="anonymous" />
    <!-- Plugin CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css'>
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('style.css')}}" />

    <title>{{ env('APP_NAME') }}</title>
</head>

<body class="auth_body">
    <div class="wrapper_scroll_cmn">
        <div class="login_pages_contents">
            <img src="{{asset('images/auth-page-bg.png')}}" class="auth-page-bg" alt="">
            <div class="login_pages_contents_left">
                <ul class="circles_animated">
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
                @yield('content')
            </div>
        </div>
    </div>


    <!--web fonts-->
    <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" defer crossorigin="anonymous"></script>
    <!--framework-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <!--plugins-->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!--custom script-->
    <script src="{{asset('js/custom.js')}}"></script>

</body>

</html>
