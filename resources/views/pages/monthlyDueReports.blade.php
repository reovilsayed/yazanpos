<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Due Reports</title>
    <style>
        body {
            font-family: Arial, sans-serif, 'LiBorshonRRRANSIV1';
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        p {
            font-family: 'LiBorshonRRRANSIV1', sans-serif;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        strong {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <table>
        <thead>
            <tr>
                <th>Customer Details</th>
                <th>Order Information</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                
                <tr>

                    <td>
                        <strong>Customer Name:</strong>
                        {{ $user->name }}<br>
                        <strong>Phone:</strong> {{ $user->phone }}<br>
                        <strong>Address:</strong> {{ $user->address }}
                    </td>
                    <td>
                        <strong>Total Orders:</strong> {{ $user->orders->count() }}<br>
                        <strong>Due Orders:</strong>
                        {{ $user->dueorders->count() }}<br>
                        <strong>Due Amount:</strong>
                        {{ Settings::price($user->dueorders->sum('due')) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
