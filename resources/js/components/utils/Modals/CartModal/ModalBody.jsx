import React, { Fragment, useEffect, useRef, useState } from "react";
import { toast } from "react-toastify";
import ModalHeader from "./ModalHeader";
import ModalFooter from "./ModalFooter";
import { useCart } from "react-use-cart";
import CartItem from "./CartItem";

const ModalBody = ({
    cartDataValue,
    setRefresh,
    refresh,
    handelDeleteCartData,
    cartQuantity,
    setCartQuantity,
    addToCart,
    removeFromCart,
    play,
    setCustomerDiscound,
    prescriptionData,
    totalPrice,
    selectedOptionHead,
    setSelectedOptionHead,
    totalQuantity,
    genericOption,
    supplierOption,
    categoryOption,
    setGenericOption,
    setSupplierOption,
    setCategoryOption,
    customerDiscount,
}) => {
    const { isEmpty, totalUniqueItems, items, updateItemQuantity, removeItem } =
        useCart();

    const [itemDiscounts, setItemDiscounts] = useState(
        items.map((item) => {
            return { id: item.id, discount: item.discount ?? 0 };
        })
    );

    const updateDiscountItems = (itemId, discount) => {
        var updated = false;

        const tmp = itemDiscounts.map((item) => {
            if (item.id == itemId) {
                item = { ...item, discount };
                updated = true;
            }
            return item;
        });

        if (!updated) {
            tmp.push({ id: itemId, discount });
        }

        setItemDiscounts(tmp);
    };

    const resetDiscountItems = () => setItemDiscounts([]);

    return (
        <div>
            <div className="offcanvas-header">
                <h5 className="offcanvas-title" id="offcanvasExampleLabel">
                    Product List
                </h5>
                <button
                    type="button"
                    className="btn-close text-reset "
                    data-bs-dismiss="offcanvas"
                    aria-label="Close"
                ></button>
            </div>
            <div className="card-body p-0 table-responsive pb-4">
                {items?.map((item, index) => (
                    <CartItem
                        item={item}
                        updateDiscountItems={updateDiscountItems}
                        key={index}
                    />
                ))}
            </div>

            <div className="footer_body_modal">
                {/* <ModalHeader
                    prescriptionData={prescriptionData}
                    cartDataValue={cartDataValue}
                    totalPrice={totalPrice}
                    selectedOptionHead={selectedOptionHead}
                    setSelectedOptionHead={setSelectedOptionHead}
                /> */}
                <ModalFooter
                    totalDiscount={itemDiscounts.reduce(
                        (accumulator, currentValue) => {
                            return (
                                accumulator + (currentValue?.discount ?? 0.0)
                            );
                        },
                        0
                    )}
                    resetDiscountItems={resetDiscountItems}
                    setRefresh={setRefresh}
                    totalPrice={totalPrice}
                    cartDataValue={cartDataValue}
                    refresh={refresh}
                    totalQuantity={totalQuantity}
                    genericOption={genericOption}
                    supplierOption={supplierOption}
                    categoryOption={categoryOption}
                    setGenericOption={setGenericOption}
                    setSupplierOption={setSupplierOption}
                    setCategoryOption={setCategoryOption}
                    selectedOptionHead={selectedOptionHead}
                    customerDiscount={customerDiscount}
                    setCustomerDiscound={setCustomerDiscound}
                    prescriptionData={prescriptionData}
                    setSelectedOptionHead={setSelectedOptionHead}
                />
            </div>
        </div>
    );
};

export default ModalBody;
