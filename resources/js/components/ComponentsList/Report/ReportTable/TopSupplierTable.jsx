import React from "react";

const TopSupplierTable = ({ SupplierData }) => {
    return (
        <div>
            <div>
                {SupplierData?.map((supplier) => (
                    <div className="d-flex justify-content-between py-2">
                        {/* <span style={{ width: "15%", color: "#9d9d9d" }}>
                            {supplier?.supplier_id}.
                        </span> */}
                        <div
                            style={{
                                width: "50%",
                            }}
                            className=""
                        >
                            <span
                                className="hover_blue"
                                style={{
                                    fontSize: "11px",
                                    color: "#646464",
                                    fontWeight: 600,
                                }}
                            >
                                {supplier?.supplier_name}
                            </span>
                        </div>
                        <span
                            style={{
                                width: "50%",
                                color: "#646464",
                                textAlign: "right",
                            }}
                        >
                            {supplier?.total_amount.toFixed(2)} Tk
                        </span>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default TopSupplierTable;
