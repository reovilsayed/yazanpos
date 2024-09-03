<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favicon.png" type="image/x-icon">
    <title> Email template </title>

    <!-- Google Font css -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">

    <style type="text/css">
        body {
            text-align: center;
            margin: 0 auto;
            width: 100%;
            font-family: 'Public Sans', sans-serif;
            background-color: #e2e2e2;
            display: block;
        }

        .responsive-table {
            width: 100%;
            max-width: 650px;
            margin: 0 auto;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        h5 {
            margin: 10px;
            color: #777;
        }

        .text-center {
            text-align: center
        }

        .main-bg-light {
            background-color: #fafafa;
        }

        .header-menu ul li a {
            font-size: 14px;
            color: #252525;
            font-weight: 500;
        }

        .product-table tbody tr td img {
            width: 30%;
            margin-right: 0;
        }

        .product-table tbody tr td .product-detail {
            text-align: left;
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        .product-table tbody tr td .product-detail li {
            display: block;
            width: 100%;
            font-size: 16px;
            font-weight: 600;
            white-space: nowrap;
        }

        .product-table tbody tr td .product-detail li span {
            color: #939393;
        }

        .order-table {
            background-image: url(images/order-poster.jpg);
            background-position: center;
            background-repeat: no-repeat;
            border-radius: 5px;
            overflow: hidden;
            padding: 18px 27px;
            margin-top: 40px;
        }

        .footer-table {
            position: relative;
            margin-top: 34px;
        }

        .footer-table::before {
            position: absolute;
            content: "";
            background-image: url(images/footer-left.svg);
            background-position: top right;
            top: 0;
            left: -71%;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            z-index: -1;
            background-size: contain;
            opacity: 0.3;
        }

        .footer-table::after {
            position: absolute;
            content: "";
            background-image: url(images/footer-right.svg);
            background-position: top right;
            top: 0;
            right: 0;
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            z-index: -1;
            background-size: contain;
            opacity: 0.3;
        }
    </style>
</head>

<body style="margin: 20px auto;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" class="responsive-table"
        style="background-color: #fff; box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);-webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);">
        <tbody>
            <tr>
                <td>
                    <table class="header-table" align="center" border="0" cellpadding="0" cellspacing="0"
                        width="100%">
                        <tbody>
                            <tr class="header"
                                style="background-color: #f7f7f7;display: flex;align-items: center;justify-content: center;width: 100%;">
                                <td class="header-logo" style="padding: 10px 32px;">
                                    <span style="display: block; text-align: left;">
                                        <img src="{{ Settings::option('logo') ? Storage::url(Settings::option('logo')) : asset('images/logo.png') }}"
                                            class="main-logo" alt="logo" width="60">
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    @yield('content')
                    <table class="text-center footer-table" align="center" border="0" cellpadding="0"
                        cellspacing="0" width="100%"
                        style="
                      background-color: #282834;
                      color: white;
                      padding: 24px;
                      overflow: hidden;
                      z-index: 0;">
                        <tbody>
                            <tr>
                                <td>
                                    <table border="0" cellpadding="0" cellspacing="0"
                                        class="footer-social-icon text-center" align="center"
                                        style="margin: 8px auto 20px">
                                        <tbody>
                                            <tr>

                                                <td style="font-size: 15px; font-weight: 500">
                                                    <span style="color: #fff">
                                                        Developed By: <a href="https://sohojware.com/"
                                                            style="color: #387ADF" target="_blank">Sohojware Team</a>,
                                                        Phone: <a href="https://wa.me/8801738324024"
                                                            style="color: #387ADF"
                                                            target="_blank">01738324024</a></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
            </tr>
        </tbody>
    </table>


</body>

</html>