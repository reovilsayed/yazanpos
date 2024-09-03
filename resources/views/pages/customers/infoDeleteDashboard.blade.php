<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-6 offset-lg-3">
                <h2 class="text-center mb-5">SnapShop User Dashboard</h2>
                <div class="row">
                    <div class="card px-0">
                        <div class="card-header text-white" style="background-color: #135D66">
                            <h3 class="text-center">Profile info</h3>
                        </div>
                        <div class="card-body">

                            <h4>Welcome, {{ $user->name }}!</h4>
                            <ul>
                                <li>Customer Name: {{ $user->name }}</li>
                                <li>Email: {{ $user->email ?? 'no Email added' }}</li>
                                <li>Phone: {{ $user->phone ?? 'No Phone Number added.' }}</li>
                                <li>
                                    Total Order: {{ $user->orders->count() }}
                                </li>
                                <li>
                                    Total spend: {{ $user->orders->sum('paid') }} Tk.
                                </li>
                                <!-- Add more customer information here -->
                            </ul>
                        </div>
                        <div class="card-footer d-flex justify-content-between">
                            <form action="{{ route('logout') }}" method="post" id="logout-form">
                                @csrf
                                <button class="btn btn-danger">LogOut</button>
                            </form>
                            <form action="{{ route('customer.infoDelete') }}" method="POST">
                                @csrf
                                <button id="deleteAccountBtn" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this account?')">Delete
                                    Account</button>

                            </form>

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
