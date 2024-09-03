<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .warning-title {
            color: red;
            margin-bottom: 10px;
        }

        .warning-content {
            margin-bottom: 20px;
        }
    </style>
</head>


<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-6 offset-lg-3">
                <div class="row">
                    <div class="card px-0">
                        <div class="card-header text-white" style="background-color: #135D66">
                            <h3 class="text-center">Snap Shop User Delete</h3>
                        </div>
                        <div class="card-body">
                            <h2 class="warning-title">Warning: Account Deletion</h2>
                            <div class="warning-content">
                                <p>You are about to delete your account. This action is irreversible. Please consider
                                    the following before proceeding:</p>
                                <ul>
                                    <li><strong>Order History:</strong> You will lose access to your order history,
                                        including details of past purchases and any active warranties or returns.</li>
                                    <li><strong>Reactivation:</strong> You will not be able to reactivate your account
                                        once deleted. A new account must be created if you wish to use our services
                                        again in the future.</li>
                                </ul>
                                <p>If you understand and accept the consequences, please confirm your account deletion
                                    or choose to cancel and retain your account.</p>
                            </div>
                            <a class="btn btn-warning" href="{{ route('customer.dashboard') }}">Click here to Delete
                                Your Profile</a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
