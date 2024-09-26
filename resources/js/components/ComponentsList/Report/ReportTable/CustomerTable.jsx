import React from "react";
import { Link } from "react-router-dom";

export const CustomerTable = ({ customerData }) => {
    const handelNavigate = (id) => {
        if (id) {
            window.location.href = `/customers/${id}`;
        }
    };
    return (
        <div>
            <div>
                <div>
                    {customerData?.map((customer) => (
                        <div className="d-flex justify-content-between py-2">
                            {/* <span style={{ width: "20%", color: "#9d9d9d" }}>
                                {customer?.customer_id}.
                            </span> */}
                            <div
                                style={{
                                    width: "50%",
                                }}
                                className=""
                            >
                                <span
                                    onClick={() =>
                                        handelNavigate(customer?.customer_id)
                                    }
                                    className="hover_blue"
                                    style={{
                                        fontSize: "11px",
                                        color: "#646464",
                                        fontWeight: 600,
                                    }}
                                >
                                    {customer?.customer_name}
                                </span>
                            </div>
                            <span
                                style={{
                                    width: "50%",
                                    color: "#646464",
                                    textAlign: "right",
                                }}
                            >
                                {customer?.total_order_amount.toFixed(2)} $
                            </span>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};
