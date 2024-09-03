<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/test.css') }}">
</head>

<body>
    <div class="container">
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 product_card">
                    <span id="product_id">{{$product->id}}</span>
                    {!! $product->scrapped_data !!}
                </div>
            @endforeach
        </div>
    </div>
</body>

</html>
