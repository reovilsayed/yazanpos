import React from "react";

const TopSellingTable = ({ sellingData }) => {
    return (
        <div>
            <div>
                {sellingData?.map((customer) => (
                    <div className="d-flex justify-content-between py-2">
                        {/* <span style={{ width: "20%", color: "#9d9d9d" }}>
                            {customer?.product_id}.
                        </span> */}
                        <div
                            style={{
                                width: "50%",
                            }}
                        >
                            <span
                                className="hover_blue"
                                style={{
                                    fontSize: "11px",
                                    color: "#646464",
                                    fontWeight: 600,
                                }}
                            >
                                {customer?.product_name}
                            </span>
                            <div>
                                <span
                                    style={{
                                        color: "#6c757d ",
                                        fontSize: "10px",
                                        fontWeight: 700,
                                    }}
                                >
                                    ({customer?.product_category})
                                </span>
                                <span
                                    style={{
                                        fontSize: "8px",
                                        fontWeight: 900,
                                        color: "rgba(0, 0, 0, 0.6)",
                                    }}
                                >
                                    {customer?.product_strenght
                                        ? customer?.product_strenght
                                        : ""}
                                </span>
                            </div>
                        </div>
                        <span
                            style={{
                                width: "50%",
                                color: "#646464",
                                textAlign: "right",
                            }}
                        >
                            {customer?.total_price.toFixed(2)} Tk
                        </span>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default TopSellingTable;
