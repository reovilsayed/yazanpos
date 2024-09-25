<x-layout>
    {{-- <div class="box_model">
        <div class="dsh_row row">
            <div class="left_chart">
                <div class="dash_head">
                    <h4>My Earnings</h4>
                    <div>
                        <label><i></i>Revenue</label>

                    </div>
                </div>
                <div class="dash_body">
                    <div id="chart0" class="chart chart0">
                    </div>
                </div>
            </div>
            <div class="rt_box">
                <div class="hide_md">
                    <div class="dash_head">
                        <div class="select_wrapper dsh_op">

                        </div>
                    </div>
                </div>
                <div class="vr_grid_box">
                    <div class="vr_item grn">
                        <i><img src="images/wlt.png" alt="" /></i>
                        <h3>Today's Earnings</h3>
                        <label>{{ $todayEarning }} Tk.</label>
                    </div>
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>Today's Sale</h3>
                        <label>{{ $todaysSale }} Tk.</label>
                    </div>
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>Last 7 days Sale</h3>
                        <label>{{ $sevensSale }} Tk.</label>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="box_model">
        <div class="dsh_row row">
            <div class="left_chart">
                <div class="dash_body">

                    <div class="chart-title__heading">
                        <div id="chart1" class="chart chart1">
                        </div>
                        <h3 class="chart-title">My Sales</h3>
                    </div>
                </div>
            </div>
            <div class="rt_box">

                <div class="vr_grid_box">
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>Today's Sale</h3>
                        <label>{{ $todaysSale }} Tk.</label>
                    </div>
                    <div class="vr_item grn">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>Last 7 days Sale</h3>
                        <label>{{ $sevensSale }} Tk.</label>
                    </div>
                    <div class="vr_item">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>Today Total Orders</h3>
                        <label>{{ $orders }}</label>
                    </div>
                    <div class="vr_item">
                        <i><img src="images/chks.png" alt="" /></i>
                        <h3>Today Paid Orders</h3>
                        <label>{{ $paidToday }}</label>
                    </div>
                    {{-- <div class="vr_item">
                        <i><img src="images/clos.png" alt="" /></i>
                        <h3>Today Due Orders</h3>
                        <label>{{ $dueToday }}</label>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            $.ajax({
                url: "/get-chart-data-month",
                type: "GET",
                success: function(response) {
                    new ApexCharts(document.getElementById("chart1"), {
                        series: [{
                                name: "Sale",
                                data: response.data.sales,
                            },
                            {
                                name: "Earning",
                                data: response.data.profit,
                            }
                        ],
                        chart: {
                            type: "bar",
                            height: 400,
                            redrawOnParentResize: true,
                            redrawOnWindowResize: true,
                            toolbar: {
                                show: true,
                            },
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: "55%",
                                endingShape: "rounded",
                                borderRadius: 12,
                            },
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            show: false,
                        },
                        grid: {
                            show: false,
                        },
                        xaxis: {
                            categories: [
                                "January",
                                "February",
                                "March",
                                "April",
                                "May",
                                "June",
                                "July",
                                "August",
                                "September",
                                "October",
                                "November",
                                "December",
                            ],
                            tickAmount: 12,
                            labels: {
                                show: true,
                                rotate: 0,
                                trim: true,
                                style: {
                                    colors: "#000000",
                                    fontSize: "12px",
                                    fontFamily: "Cabin, sans-serif",
                                    fontWeight: 600,
                                },
                            },
                            axisBorder: {
                                show: false,
                                color: "#456456",
                                height: 1,
                                width: "100%",
                                offsetX: 0,
                                offsetY: 0,
                            },
                        },
                        yaxis: {
                            tickAmount: 8,
                            title: {
                                text: "Per Month",
                                style: {
                                    color: "#525050",
                                    fontSize: "20px",
                                    fontFamily: "Cabin, sans-serif",
                                    fontWeight: 600,
                                },
                            },
                            labels: {
                                show: true,
                                style: {
                                    colors: "#000000",
                                    fontSize: "12px",
                                    fontFamily: "Cabin, sans-serif",
                                    fontWeight: 600,
                                },
                            },
                        },
                        fill: {
                            opacity: 1,
                            colors: ["#008FFB", "#90C1E7", "#D1E3F1"],
                        },
                        stroke: {
                            width: 3,
                            colors: ["#008FFB", "#90C1E7", "#D1E3F1"],
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " Tk.";
                                },
                            },
                        },
                        legend: {
                            fontSize: "14px",
                            fontFamily: "Cabin, sans-serif",
                            fontWeight: 600,
                            labels: {
                                colors: "#525050",
                            },
                            markers: {
                                fillColors: ["#008FFB", "#90C1E7", "#D1E3F1"],
                                radius: 12,
                            },
                            itemMargin: {
                                horizontal: 30,
                                vertical: 0,
                            },
                        },

                        responsive: [{
                            breakpoint: 1600,
                            options: {
                                chart: {
                                    height: 200,
                                },
                                yaxis: {
                                    title: {
                                        style: {
                                            fontSize: '16px',
                                        },
                                    },
                                },
                                legend: {
                                    fontSize: '12px',
                                    itemMargin: {
                                        horizontal: 15,
                                    },
                                },
                            },
                        }]
                    }).render();
                },
                error: function(error) {
                    console.log(error);
                },
            });
        </script>
    @endpush
</x-layout>
