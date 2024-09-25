import React, { useEffect, useState } from "react";
import { DayPickers } from "../../utils/DayPickers/DayPickers";
import { format } from "date-fns";
import { usePost } from "../../Hooks/useFatch";
import { ReportCard } from "./ReportCard/ReportCart";
import { CustomerTable } from "./ReportTable/CustomerTable";
import TopSellingTable from "./ReportTable/TopSellingTable";
import TopSupplierTable from "./ReportTable/TopSupplierTable";
import { TopDueCustomerTable } from "./ReportTable/TopDueCustomerTable";
import moment from "moment";
import { HashLoader, PulseLoader } from "react-spinners";
import "./ReportCard/ReportCard.css";
import { LiaLongArrowAltDownSolid } from "react-icons/lia";

const Report = () => {
    const [date, setDate] = useState({ startDate: "", endDate: "", type: "" });

    const originalDate = new Date();
    const start = "2024/01/01";
    const end = moment(originalDate).format("YYYY/MM/DD");
    const [filterDate1, setFilterDate1] = useState("");
    const [filterDate2, setFilterDate2] = useState("");

    const [from, setFrom] = useState(start);
    const [to, setTo] = useState(end);

    const { data, isLoading } = usePost(
        ["report", from, to, date],
        `api/reports`,
        {
            start_date: date?.startDate ? date?.startDate : from,
            end_date: date?.startDate ? date?.endDate : to,
        }
    );

    return (
        <div>
            <div
                className="py-2 px-4"
                style={{
                    background: "#fff",
                    borderRadius: "0 0px 10px 10px",
                }}
            >
                <DayPickers
                    setFrom={setFrom}
                    setTo={setTo}
                    from={from}
                    to={to}
                    start={start}
                    end={end}
                    date={date}
                    setDate={setDate}
                    filterDate1={filterDate1}
                    setFilterDate1={setFilterDate1}
                    filterDate2={filterDate2}
                    setFilterDate2={setFilterDate2}
                />
                {/* Report Card */}
                {isLoading ? (
                    <div
                        style={{
                            width: "100%",
                            height: "100vh",
                            display: "flex",
                            justifyContent: "center",
                            alignItems: "center",
                        }}
                    >
                        {" "}
                        <HashLoader color="#36d7b7" />
                    </div>
                ) : (
                    <>
                        <ReportCard data={data} />{" "}
                        <div
                            className="mt-2 px-3 py-4"
                            style={{
                                background: "#fff",
                                borderRadius: "0 0px 10px 10px",
                            }}
                        >
                            <div className="report_table_responsive">
                                <div
                                    className="p-4 screen_table"
                                    style={{
                                        border: "1px solid #eaeaea",
                                        borderRadius: "10px",
                                        height: "650px",
                                        overflowY: "auto",
                                        cursor: "pointer",
                                    }}
                                >
                                    <div
                                        style={{
                                            display: "flex",
                                            justifyContent: "space-between",
                                            alignItems: "center",
                                            marginBottom: "20px",
                                            fontWeight: 600,
                                        }}
                                    >
                                        <span
                                            style={{
                                                fontSize: "14px",
                                                fontWeight: 600,
                                            }}
                                        >
                                            Top Customers
                                        </span>
                                        <span>
                                            <LiaLongArrowAltDownSolid
                                                style={{
                                                    color: "#969191",
                                                }}
                                                size={20}
                                            />
                                        </span>
                                    </div>
                                    <div
                                        style={{
                                            // maxHeight: "450px",
                                            // height: "450px",
                                            paddingTop: "20px",
                                            // background: "red",
                                            // overflowY: "scroll",
                                        }}
                                    >
                                        <CustomerTable
                                            customerData={data?.top_customers}
                                        />
                                    </div>
                                </div>
                                <div
                                    className="p-4 screen_table"
                                    style={{
                                        border: "1px solid #eaeaea",
                                        borderRadius: "10px",
                                        height: "650px",
                                        overflowY: "auto",

                                        cursor: "pointer",
                                    }}
                                >
                                    <div
                                        style={{
                                            display: "flex",
                                            justifyContent: "space-between",
                                            alignItems: "center",
                                            fontWeight: 600,
                                            marginBottom: "20px",
                                        }}
                                    >
                                        <span
                                            style={{
                                                fontSize: "14px",
                                                fontWeight: 600,
                                            }}
                                        >
                                            Top Selling Products
                                        </span>
                                        <span>
                                            <LiaLongArrowAltDownSolid
                                                style={{
                                                    color: "#969191",
                                                }}
                                                size={20}
                                            />
                                        </span>
                                    </div>

                                    <div
                                        style={{
                                            // maxHeight: "450px",
                                            // height: "450px",

                                            paddingTop: "20px",
                                            // background: "red",
                                            // overflowY: "scroll",
                                        }}
                                    >
                                        <TopSellingTable
                                            sellingData={
                                                data?.top_selling_products
                                            }
                                        />
                                    </div>
                                </div>
                                <div
                                    id="scroll_id"
                                    className="p-4 screen_table"
                                    style={{
                                        border: "1px solid #eaeaea",
                                        borderRadius: "10px",
                                        height: "650px",
                                        maxHeight: "650px",
                                        overflowY: "auto",
                                        cursor: "pointer",
                                    }}
                                >
                                    <div
                                        style={{
                                            display: "flex",
                                            justifyContent: "space-between",
                                            alignItems: "center",
                                            fontWeight: 600,
                                            marginBottom: "20px",
                                        }}
                                    >
                                        <span
                                            style={{
                                                fontSize: "14px",
                                                fontWeight: 600,
                                            }}
                                        >
                                            Top Suppliers
                                        </span>
                                        <span>
                                            <LiaLongArrowAltDownSolid
                                                style={{
                                                    color: "#969191",
                                                }}
                                                size={20}
                                            />
                                        </span>
                                    </div>

                                    <div
                                        style={{
                                            // maxHeight: "450px",
                                            // height: "450px",
                                            paddingTop: "20px",
                                            // background: "red",
                                            // overflowY: "scroll",
                                        }}
                                    >
                                        <TopSupplierTable
                                            SupplierData={data?.top_suppliers}
                                        />
                                    </div>
                                </div>
                                {/* <div
                                    className="p-4 screen_table"
                                    style={{
                                        border: "1px solid #eaeaea",
                                        borderRadius: "10px",
                                        height: "650px",
                                        overflowY: "auto",
                                        cursor: "pointer",
                                    }}
                                >
                                    <div
                                        style={{
                                            display: "flex",
                                            justifyContent: "space-between",
                                            alignItems: "center",
                                            fontWeight: 600,
                                            marginBottom: "20px",
                                        }}
                                    >
                                        <span
                                            style={{
                                                fontSize: "14px",
                                                fontWeight: 600,
                                            }}
                                        >
                                            Top Due Customers
                                        </span>
                                        <span>
                                            <LiaLongArrowAltDownSolid
                                                style={{
                                                    color: "#969191",
                                                }}
                                                size={20}
                                            />
                                        </span>
                                    </div>
                                    <div
                                        style={{
                                            // maxHeight: "450px",
                                            // height: "450px",
                                            paddingTop: "20px",
                                            // background: "red",
                                            // overflowY: "scroll",
                                        }}
                                    >
                                        <TopDueCustomerTable
                                            dueData={data?.top_due_customers}
                                        />
                                    </div>
                                </div> */}
                            </div>
                        </div>
                    </>
                )}
                {/* Report Card */}
            </div>
        </div>
    );
};

export default Report;
