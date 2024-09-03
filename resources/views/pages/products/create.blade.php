<x-layout>
    @push('styles')
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.6.0/bootstrap-tagsinput.min.css"
            integrity="sha512-X6069m1NoT+wlVHgkxeWv/W7YzlrJeUhobSzk4J09CWxlplhUzJbiJVvS9mX1GGVYf5LA3N9yQW5Tgnu9P4C7Q=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
            <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
        <style>
            .bootstrap-tagsinput .tag {
                margin-right: 2px;
                background-color: #5bc0de;
                padding: 3px 5px;
            }

            .bootstrap-tagsinput {
                display: block;
                margin-bottom: 10px;
            }

            /*
     CSS for the main interaction
    */
            .tabset>input[type="radio"] {
                position: absolute;
                left: -200vw;
            }

            .tabset .tab-panel {
                display: none;
            }

            .tabset>input:first-child:checked~.tab-panels>.tab-panel:first-child,
            .tabset>input:nth-child(3):checked~.tab-panels>.tab-panel:nth-child(2),
            .tabset>input:nth-child(5):checked~.tab-panels>.tab-panel:nth-child(3),
            .tabset>input:nth-child(7):checked~.tab-panels>.tab-panel:nth-child(4),
            .tabset>input:nth-child(9):checked~.tab-panels>.tab-panel:nth-child(5),
            .tabset>input:nth-child(11):checked~.tab-panels>.tab-panel:nth-child(6) {
                display: block;
            }

            /*
     Styling
    */
            body {
                font: 16px/1.5em "Overpass", "Open Sans", Helvetica, sans-serif;
                color: #333;
                font-weight: 300;
            }

            .tabset>label {
                position: relative;
                display: inline-block;
                padding: 10px 10px 20px;
                border: 1px solid transparent;
                border-bottom: 0;
                cursor: pointer;
                font-weight: 500;
                font-size: 15px;

            }

            .tabset>label::after {
                content: "";
                position: absolute;
                left: 15px;
                bottom: 10px;
                width: 22px;
                height: 4px;
                background: #8d8d8d;
            }

            input:focus-visible+label {
                outline: 2px solid rgba(0, 102, 204, 1);
                border-radius: 3px;
            }

            .tabset>label:hover,
            .tabset>input:focus+label,
            .tabset>input:checked+label {
                color: #06c;
            }

            .tabset>label:hover::after,
            .tabset>input:focus+label::after,
            .tabset>input:checked+label::after {
                background: #06c;
            }

            .tabset>input:checked+label {
                border-color: #ccc;
                border-bottom: 1px solid #ccc;
                margin-bottom: -1px;
            }

            .tab-panel {
                padding: 20px 0;
                /* border-top: 1px solid #ccc; */
            }


  

        

            .tabset {
                max-width: 65em;
            }

            section {
                /* width: 100%; */
                /* height: 100vh; */
                /* display: flex;
                align-items: center;
                justify-content: center; */
                margin-top: 10px;
            }

      

            .accordion-item {
                border-radius: .4rem;
                margin-bottom: 8px;
                border-top:1px solid #ccc !important;
                /* background-color: #f8f9fa; */
                /* Light background color */
            }

            /* .accordion-item hr {
                border: 1px solid rgba(0, 0, 0, 0.1);
            } */

            .accordion-link {
                font-size: 1.6rem;
                color: rgba(0, 0, 0, 0.8);
                /* Dark text color */
                text-decoration: none;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1rem 0;
            }

            .accordion-link h3 {
                font-weight: 500;
                font-size: 20px;
            }

            .accordion-link i {
                color: #6c757d;
                /* Adjust arrow color */
                padding: 0 10px;
            }

            .accordion-link ul {
                display: flex;
                align-items: flex-end;
                list-style-type: none;
                margin-left: 25px;
            }

            .accordion-link li {
                font-size: 10px;
                color: rgba(0, 0, 0, 0.6);
                /* Darker text color */
                padding: 0 0 1px 5px;
            }

            .accordion-link div {
                display: flex;
            }

            .accordion-link .ion-md-arrow-down {
                display: none;
            }

            .answer {
                max-height: 0;
                overflow: hidden;
                position: relative;
                transition: max-height 650ms;
            }

            .answer p {
                color: #000;
                /* Adjust text color */
                font-size: 15px;
                padding: 2rem;
            }

            .accordion-item:target .answer {
                max-height: 20rem;
            }

            .accordion-item:target .accordion-link .ion-md-arrow-forward {
                display: none;
            }

            .accordion-item:target .accordion-link .ion-md-arrow-down {
                display: block;
            }
        </style>
    @endpush
    <x-products.createOrEdit :product="$product" :generics="$generics" :categories="$categories" :suppliers="$suppliers" :units="$units"
        :productAttributes="$product_attributes" />

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

        <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#price').on('input', function() {
                    let price = $(this).val();
                    let trade_price = price * 0.88;
                    $('#trade_price').val(trade_price.toFixed(2));
                });
            });
        </script>
    @endpush
</x-layout>
