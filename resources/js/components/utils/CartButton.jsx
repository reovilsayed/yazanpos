import React from "react";

const CartButton = ({
    cartDataValue,
    genericOption,
    supplierOption,
    categoryOption,
}) => {
    return (
        <div>
            {/* Cart Button */}
            <div>
                {" "}
                <button
                    type="button"
                    className="btn btn-dark btn-lg position-fixed"
                    style={{ bottom: "20px", right: "20px", zIndex: 100 }}
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasExample"
                    aria-controls="offcanvasExample"
                >
                    <i className="fa fa-shopping-bag"></i>
                    <sup> {cartDataValue?.length || 0}</sup>
                </button>
            </div>
            {/* Cart Button */}

            {/* Another Button */}
            <div>
                <button
                    data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasBottom"
                    aria-controls="offcanvasBottom"
                    className="btn btn-primary btn-lg position-fixed"
                    data-fullscreen="true"
                    id="fullscreen"
                    style={{ bottom: "20px", right: "100px", zIndex: 100 }}
                >
                    <i className="fa fa-filter"></i>
                    <sup>
                        {genericOption.length +
                            supplierOption.length +
                            categoryOption.length || 0}
                    </sup>
                </button>
            </div>
            {/* Another Button */}
            {/* full screen btn */}
            {/* <div>
                <button
                    style={{ bottom: "20px", right: "190px", zIndex: 100 }}
                    className="btn btn-warning btn-lg position-fixed"
                    data-fullscreen="true"
                    id="fullscreen"
                >
                    <i className="fa fa-expand"></i>
                </button>
            </div> */}
            {/* full screen btn */}
        </div>
    );
};

export default CartButton;
