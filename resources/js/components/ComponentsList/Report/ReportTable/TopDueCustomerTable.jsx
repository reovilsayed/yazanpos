import React from "react";

export const TopDueCustomerTable = ({ dueData }) => {
    const handelNavigate = (id) => {
        if (id) {
            window.location.href = `/customers/${id}`;
        }
    };
    return (
        <div>
            <div>
                {dueData?.map((due) => (
                    <div className="d-flex justify-content-between py-2">
                        {/* <span style={{ width: "20%", color: "#9d9d9d" }}>
                            {due?.customer_id}
                        </span> */}
                        <div
                            style={{
                                width: "50%",
                            }}
                        >
                            <span
                                onClick={() => handelNavigate(due?.customer_id)}
                                className="hover_blue"
                                style={{
                                    fontSize: "11px",
                                    color: "#646464",
                                    fontWeight: 600,
                                }}
                            >
                                {due?.customer_name}
                            </span>
                        </div>
                        <span
                            style={{
                                width: "50%",
                                color: "#646464",
                                textAlign: "right",
                            }}
                        >
                            {due?.total_order_amount.toFixed(2)} $
                        </span>
                    </div>
                ))}
            </div>
        </div>
    );
};
