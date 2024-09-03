import React from "react";
import "./ReportCard.css";
import { HiArrowLongRight } from "react-icons/hi2";
import { LiaLongArrowAltDownSolid } from "react-icons/lia";
export const ReportCard = ({ data }) => {
    return (
        <div className="p-3">
            <div className="responsive_grid">
                <div
                    className="p-4"
                    style={{
                        height: "280px",
                        maxHeight: "280px",
                        border: "1px solid #eaeaea",
                        borderRadius: "10px",
                        zIndex: 1,
                        position: "relative",
                        cursor: "pointer",
                    }}
                >
                    {" "}
                    <div
                        className="d-flex justify-content-between align-items-center"
                        style={{ paddingBottom: "50px" }}
                    >
                        <span
                            style={{
                                fontSize: "14px",
                                // maxWidth: "45%",

                                width: "40%",
                                fontWeight: 600,
                            }}
                        >
                            Total Amount
                        </span>
                        <span
                            style={{
                                textAlign: "center",

                                width: "20%",
                            }}
                        >
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={20}
                            />
                        </span>
                        <span
                            style={{
                                fontSize: "14px",
                                textAlign: "right",
                                width: "40%",
                                fontWeight: 600,
                            }}
                        >
                            {data?.data?.total_amount.toFixed(2)} Tk
                        </span>
                    </div>
                    <div className="d-flex justify-content-between align-items-center ">
                        <span
                            className="hover_blue"
                            style={{
                                width: "40%",
                                color: "#646464",
                                fontSize: "13px",
                            }}
                        >
                            Total Revenue
                        </span>
                        <span
                            style={{
                                textAlign: "center",
                                width: "20%",
                            }}
                        >
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={16}
                            />
                        </span>
                        <span
                            style={{
                                width: "40%",
                                textAlign: "right",
                                color: "#646464",
                            }}
                        >
                            {data?.data?.total_revenue.toFixed(2)} Tk
                        </span>
                    </div>
                    <div className="d-flex justify-content-between pt-3">
                        <span
                            className="hover_blue"
                            style={{
                                width: "40%",
                                color: "#646464",
                                fontSize: "13px",
                            }}
                        >
                            Total Due{" "}
                        </span>
                        <span style={{ textAlign: "center", width: "20%" }}>
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={16}
                            />
                        </span>
                        <span
                            style={{
                                width: "40%",
                                textAlign: "right",
                                color: "#646464",
                            }}
                        >
                            {data?.data?.due_total.toFixed(2)} Tk
                        </span>
                    </div>
                </div>
                <div
                    className="p-4"
                    style={{
                        height: "280px",
                        maxHeight: "280px",
                        border: "1px solid #eaeaea",
                        borderRadius: "10px",
                        cursor: "pointer",
                    }}
                >
                    {" "}
                    <div
                        className="d-flex justify-content-between align-items-center"
                        style={{ paddingBottom: "50px" }}
                    >
                        <span
                            style={{
                                fontSize: "14px",
                                // maxWidth: "45%",
                                width: "40%",
                                fontWeight: 600,
                            }}
                        >
                            {" "}
                            Total Orders
                        </span>
                        <span style={{ width: "20%", textAlign: "center" }}>
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={20}
                            />
                        </span>
                        <span
                            style={{
                                fontSize: "14px",
                                width: "40%",
                                textAlign: "right",
                                fontWeight: 600,
                            }}
                        >
                            {data?.data?.total_orders}
                        </span>
                    </div>
                    <div className="d-flex justify-content-between">
                        <span
                            className="hover_blue"
                            style={{
                                width: "40%",
                                color: "#646464",
                                fontSize: "13px",
                            }}
                        >
                            Due Orders
                        </span>
                        <span
                            style={{
                                width: "20%",
                                textAlign: "center",
                            }}
                        >
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={16}
                            />
                        </span>
                        <span
                            style={{
                                width: "40%",
                                textAlign: "right",
                                color: "#646464",
                            }}
                        >
                            {data?.data?.due_orders}
                        </span>
                    </div>
                </div>
                <div
                    className=" p-4"
                    style={{
                        height: "280px",
                        maxHeight: "280px",
                        border: "1px solid #eaeaea",
                        borderRadius: "10px",
                        cursor: "pointer",
                    }}
                >
                    <div
                        className="d-flex justify-content-between "
                        style={{ paddingBottom: "50px" }}
                    >
                        <span style={{ fontSize: "14px", fontWeight: 600 }}>
                            Entity Summary
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
                    <div className="d-flex justify-content-between">
                        <span
                            className="hover_blue"
                            style={{
                                width: "40%",
                                color: "#646464",
                                fontSize: "13px",
                            }}
                        >
                            Total Customers
                        </span>
                        <span
                            style={{
                                textAlign: "center",
                                width: "20%",
                            }}
                        >
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={16}
                            />
                        </span>
                        <span
                            style={{
                                width: "40%",
                                textAlign: "right",
                                color: "#646464",
                            }}
                        >
                            {data?.data?.total_customers}
                        </span>
                    </div>
                    <div className="d-flex justify-content-between align-items-center pt-3">
                        <span
                            className="hover_blue"
                            style={{
                                width: "40%",
                                color: "#646464",
                                fontSize: "13px",
                            }}
                        >
                            {" "}
                            Total Generics
                        </span>
                        <span
                            style={{
                                textAlign: "center",
                                width: "20%",
                            }}
                        >
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={16}
                            />
                        </span>
                        <span
                            style={{
                                width: "40%",
                                textAlign: "right",
                                color: "#646464",
                            }}
                        >
                            {data?.data?.total_generics}
                        </span>
                    </div>
                    <div className="d-flex justify-content-between align-items-center pt-3">
                        <span
                            className="hover_blue"
                            style={{
                                width: "40%",
                                color: "#646464",
                                fontSize: "13px",
                            }}
                        >
                            Total Categories
                        </span>
                        <span
                            style={{
                                textAlign: "center",
                                width: "20%",
                            }}
                        >
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={16}
                            />
                        </span>
                        <span
                            style={{
                                width: "40%",
                                textAlign: "right",
                                color: "#646464",
                            }}
                        >
                            {data?.data?.total_categories}
                        </span>
                    </div>
                    <div className="d-flex justify-content-between align-items-center pt-3">
                        <span
                            className="hover_blue"
                            style={{
                                width: "40%",
                                color: "#646464",
                                fontSize: "13px",
                            }}
                        >
                            Total Suppliers
                        </span>
                        <span style={{ width: "20%", textAlign: "center" }}>
                            <HiArrowLongRight
                                style={{
                                    color: "#969191",
                                }}
                                size={16}
                            />
                        </span>
                        <span
                            style={{
                                width: "40%",
                                textAlign: "right",
                                color: "#646464",
                            }}
                        >
                            {" "}
                            {data?.data?.total_suppliers}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    );
};
