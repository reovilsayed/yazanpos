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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css'>
    <link rel='stylesheet' href='{{ asset('css/nice-select2.css') }}'>
    <!-- Custom CSS -->
    <!-- Add this line to the <head> section of your HTML file -->

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}" />
    <title>{{ env('APP_NAME') }}</title>
    <style>
        .cart {
            width: 100%;
            /* Default width for MD and smaller devices */

            /* LG devices and larger */
            @media (min-width: 992px) {
                width: 50%;
            }
        }
    </style>

</head>

<body style="background-color: #f1f9fe">

    <div class="container-fluid">
        {{ $slot }}
    </div>

    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
   
    @if (session()->has('success'))
        <x-alert.success />
    @endif
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                autoWidth: true,
                dots: false,
                items: 3,
            });
        });

        $('.btn-toggle').click((e) => {
            if (e.target.classList.contains('btn-outline-primary')) {
                e.target.classList.remove('btn-outline-primary')
                e.target.classList.add('btn-primary')
            } else {
                e.target.classList.add('btn-outline-primary')
                e.target.classList.remove('btn-primary')
            }
        });

        $('#supplier-btn').click((e) => {
            $('.btn-supplier').removeClass(['btn-primary', 'btn-outline-primary'])
            $('.btn-supplier').addClass(['btn-outline-primary'])
        });
        $('#category-btn').click((e) => {
            $('.btn-category').removeClass(['btn-primary', 'btn-outline-primary'])
            $('.btn-category').addClass(['btn-outline-primary'])
        });
    </script>
    <script>
        let myDocument = document.documentElement;
        $('#fullscreen').click(() => {
            if ($('#fullscreen').data('fullscreen') == "true") {
                if (myDocument.requestFullscreen) {
                    myDocument.requestFullscreen();
                } else if (myDocument.msRequestFullscreen) {
                    myDocument.msRequestFullscreen();
                } else if (myDocument.mozRequestFullScreen) {
                    myDocument.mozRequestFullScreen();
                } else if (myDocument.webkitRequestFullscreen) {
                    myDocument.webkitRequestFullscreen();
                }
                $('#fullscreen').data('fullscreen', "false")
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.msexitFullscreen) {
                    document.msexitFullscreen();
                } else if (document.mozexitFullscreen) {
                    document.mozexitFullscreen();
                } else if (document.webkitexitFullscreen) {
                    document.webkitexitFullscreen();
                }

                $('#fullscreen').data('fullscreen', "true")
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
   
    @stack('script')
</body>

</html>
