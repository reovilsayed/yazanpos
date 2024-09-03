    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=0" />
        <!--fav icon-->
        <link rel="shortcut icon" href="{{ asset('images/fabicon.png') }}" />
        <link rel="icon" type="image/png" href="{{ asset('images/fabicon.png') }}" />
        <!-- text icons -->
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
            crossorigin="anonymous" />
        <!-- Plugin CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/animatecss/3.5.2/animate.min.css'>
        <link rel='stylesheet' href='{{ asset('css/nice-select2.css') }}'>
        <!-- Custom CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
        <!-- Add this line to the <head> section of your HTML file -->
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"> --}}
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}" />
        <style>
            .widget {
                align-items: center;
                background: #f0f3ff;
                border-radius: 8px 8px 0 8px;
                justify-content: space-between;
                line-height: 1.1;
                margin-left: auto;
                max-width: 190px;
                padding: 11px 16px;
            }

            .widget p {
                color: #111ae9;
                display: flex;
                font-size: 13px;
                font-weight: 500;
                justify-content: space-between;
            }
     
        </style>
        <title>{{ env('APP_NAME') }}</title>
        @stack('styles')
        @livewireStyles
    </head>

    <body>

        <div class="dashboard_header">
            <div class="fluid_container">
                <div class="header_row">
                    <div class="hamburger_menu" id="hamburger_menu">
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                            width="512" height="512" x="0" y="0" viewBox="0 0 20 20"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="hamburger_menu_open">
                            <g>
                                <path clip-rule="evenodd"
                                    d="m3 5c0-.26522.10536-.51957.29289-.70711.18754-.18753.44189-.29289.70711-.29289h12c.2652 0 .5196.10536.7071.29289.1875.18754.2929.44189.2929.70711s-.1054.51957-.2929.70711c-.1875.18753-.4419.29289-.7071.29289h-12c-.26522 0-.51957-.10536-.70711-.29289-.18753-.18754-.29289-.44189-.29289-.70711zm0 5c0-.26522.10536-.51957.29289-.70711.18754-.18753.44189-.29289.70711-.29289h6c.2652 0 .5196.10536.7071.29289.1875.18754.2929.44189.2929.70711 0 .2652-.1054.5196-.2929.7071s-.4419.2929-.7071.2929h-6c-.26522 0-.51957-.1054-.70711-.2929-.18753-.1875-.29289-.4419-.29289-.7071zm0 5c0-.2652.10536-.5196.29289-.7071.18754-.1875.44189-.2929.70711-.2929h12c.2652 0 .5196.1054.7071.2929s.2929.4419.2929.7071-.1054.5196-.2929.7071-.4419.2929-.7071.2929h-12c-.26522 0-.51957-.1054-.70711-.2929-.18753-.1875-.29289-.4419-.29289-.7071z"
                                    fill="#000000" fill-rule="evenodd" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                            xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs"
                            width="512" height="512" x="0" y="0" viewBox="0 0 329.26933 329"
                            style="enable-background:new 0 0 512 512" xml:space="preserve" class="hamburger_menu_close">
                            <g>
                                <path
                                    d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"
                                    fill="#000000" data-original="#000000" class=""></path>
                            </g>
                        </svg>
                    </div>
                    <a href="#" class="logo">
                        <img style="height: 70px; width: 100px; border-radius: 10px;"
                            src="{{ Settings::option('logo') ? Storage::url(Settings::option('logo')) : asset('images/logo.png') }}"
                            alt="" />
                    </a>

                    <div class="search_panel">
                        <span class="search_btn m_srch_trigger_btn" id="m_srch_trigger"><img
                                src={{ asset('images/search.svg') }} alt="" /></span>
                        <form action="{{ route('products.index') }}" method="get">
                            <div class="search_box_inner earch_box_desktop">
                                <input type="hidden" name="search[column]" value="name">
                                <input type="text" placeholder="Search Here......" name="search[query]"
                                    value="{{ @request()->search['query'] }}" />
                                <span class="search_btn"><img src={{ asset('images/search.svg') }}
                                        alt="" /></span>
                            </div>
                        </form>
                    </div>
                    <div class="search_box_mobile" id="m_srch_trigger_box">
                        <div class="search_box_inner">
                            <form action="{{ route('products.index') }}" method="get">
                                <input type="hidden" name="search[column]" value="name">
                                <input type="text" placeholder="Search Here......" name="search[query]"
                                    value="{{ @request()->search['query'] }}" />
                                <span class="search_btn"><img src={{ asset('images/search.svg') }}
                                        alt="" /></span>
                            </form>
                        </div>
                    </div>

                    <div class="float_header_right">
                        <div class="admin_panel panel_inline">


                            <span class="text-center">Developed by <a href="https://sohojware.com/"
                                    target="_blank">Sohojware
                                    Team</a>, <br> Phone:
                                <a href="https://wa.me/8801738324024" target="_blank">01738324024</a>
                            </span>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="dashboard_body">
            <div class="fluid_container">
                <div class="dashboard_body_inner">
                    <div class="navigation" id="navigation">
                        <x-sidenav.navlist />
                    </div>

                    <div class="dashboard_content">
                        <div class="dashboard_content_inner" style="margin-bottom: 50px">
                            {{ $slot }}


                        </div>
                    </div>
                </div>
            </div>

        </div>

        <form action="{{ route('logout') }}" method="post" id="logout-form">
            @csrf
        </form>




        <div class="menu_overlay" id="menu_overlay"></div>

        <!--web fonts-->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" defer crossorigin="anonymous"></script>
        <!--framework-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
        </script>
        <!--plugins-->
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script> -->

        <!--DOC of selectpicker: https://bluzky.github.io/nice-select2/-->
        <script src="{{ asset('js/nice-select2.js') }}"></script>
        <!--custom script-->
        <script src="{{ asset('js/custom.js?ver=1') }}"></script>
        <script>
            $('.logout-trigger').click(() => $('#logout-form').submit());
        </script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script>
            toastr.options = {
                "newestOnTop": true,
                "positionClass": "toast-bottom-left",
                "preventDuplicates": true,
                "showDuration": "150",
                "hideDuration": "200",
                "timeOut": "2500",
                "extendedTimeOut": "500",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
        </script>
        @if (session()->has('success'))
            <x-alert.success />
        @endif
        <x-alert.error />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            const baseUrl = "{{ env('VITE_API_URI', 'https://pos.sohojware.com') }}";

            // Function to add headers to AJAX requests
            const addHeaders = function(xhr) {
                xhr.setRequestHeader('x-secret-key', "{{ env('PASSWORD') }}");
            };

            $('.products-ajax').select2({
                ajax: {
                    url: `${baseUrl}/api/products`,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    beforeSend: addHeaders
                }
            });

            $('.customers-ajax').select2({
                ajax: {
                    url: `${baseUrl}/api/customers`,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    beforeSend: addHeaders
                }
            });

            $('.suppliers-ajax').select2({
                ajax: {
                    url: `${baseUrl}/api/suppliers`,
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    beforeSend: addHeaders
                }
            });
              $('.products-generic-card .form-select').select2();
        </script>
        @livewireScripts
        @stack('script')
    </body>

    </html>
