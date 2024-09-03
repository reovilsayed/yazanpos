<x-layout>

    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <button onclick="printDiv('printableArea')" class="btn btn-success me-1 mb-2"><i
                        class="fa fa-print me-2"></i>Print</button>
                <div class="card" id="printableArea">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <div class="position-relative">
                                    <div class="position-absolute" style="right: 0px;">
                                        <img width="100%" src="{{ asset('images/prescription-nav .png') }}"
                                            alt="">
                                    </div>
                                    {{-- <div style=" position: absolute; top: 118px;left:0px; width:28%;">
                                        <h5 class="font-size-15 mb-1">Invoice No:</h5>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 mb-3 ">

                            <div class="row">
                               


                            </div>

                            <div class="row mt-5 m-1">
                                <div class="col-md-8 col-sm-7">
                                    <h5>
                                        Name <span class="ms-2"> : {{ $priscription->customer->name }}</span>
                                    </h5>
                                </div>
                                <div class="col-md-2 col-sm-3">
                                    <h5>
                                        Sex <span class="ms-2"> : {{ $priscription->gender }}</span>
                                    </h5>
                                </div>
                                <div class="col-md-2 col-sm-2">
                                    <h5>
                                        Age <span class="ms-2"> : {{ $priscription->age }}</span>
                                    </h5>
                                </div>
                            </div>

                            <div class=" mt-4">
                                <div class=" mt-5 mb-3 ">
                                    <div class="row mt-3">
                                        <div class="col-md-4 col-sm-4 border-end">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h6>SYMPTOMS *</h6>
                                                    <p>{{ $priscription->symptoms }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-sm-8">
                                            {{-- <div class="">
                                                    <img style="height: 60px"
                                                        src="{{ asset('images/prescription-svgrepo-com.svg') }}" alt="">
                                                </div> --}}
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row row-cols-3">
                                                        <div class="col-sm-5">
                                                            <h6>MEDICIN *</h6>
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <h6>SCHEDULED *</h6>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <h6>DOSE *</h6>
                                                        </div>
                                                    </div>
                                                    @foreach ($priscription->products as $product)
                                                      

                                                        <div class="row row-cols-3 mt-4">

                                                            <div class="col-sm-5">
                                                                <p>{{ $product->name .' '. $product->strength.' '.$product->category->name }}
                                                                </p>
                                                            </div>

                                                            <div class="col-sm-5">
                                                      
                                                                <div class="d-flex gap-2">
                                                                        @foreach ($product->pivot->scheduled as $key => $value)

                                                                        <p >{{ ucwords($key) }} = {{ $value }}</p>
                                                                        @endforeach
                                                                    </div>
                                                            </div>

                                                            <div class="col-sm-2 ">
                                                                <p>{{ ucwords($product->pivot->dose) }}</p>
                                                            </div>

                                                        </div>
                                                        
                                                    @endforeach



                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-12 p-0" style=" height: 58px;">
                                        <div class="position-relative">
                                            {{-- <div class="position-absolute"
                                                style="right: 0px;  width: 73%; margin-right: 12px; border-top: 2px solid rgb(130, 127, 127);">

                                                <img class="mt-2" style="height: 70px; margin-left: 132px;" src="{{asset('images/qr-code.png')}}" alt="">

                                            </div> --}}
                                            <div class="position-absolute" style="right: 0px; width: 100%;">
                                                <img width="100%" style="height: 185px"
                                                    src="{{ asset('images/prescription_footer-.png') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- end col -->
        </div>
    </div>
    @push('script')
        <script type="text/javascript">
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;

                document.body.innerHTML = printContents;

                window.print();

                document.body.innerHTML = originalContents;
            }
        </script>
    @endpush
</x-layout>
