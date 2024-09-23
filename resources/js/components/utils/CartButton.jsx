import React from "react";
import { useCart } from "react-use-cart";

const CartButton = ({
    cartDataValue,
    genericOption,
    supplierOption,
    categoryOption,
}) => {
    const {
      isEmpty,
      totalUniqueItems,
      items,
      updateItemQuantity,
      removeItem,
    } = useCart();
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
                    <sup> {totalUniqueItems || 0}</sup>
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
        </div>
    );
};

export default CartButton;
