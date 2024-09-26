import React, { useDebugValue, useEffect, useState } from "react";
import PaymentModal from "../PaymentModal/PaymentModal";
import "../PaymentModal/payment.css";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import ModalHeader from "./ModalHeader";
import { useCart } from "react-use-cart";

const ModalFooter = ({
    totalDiscount,
    resetDiscountItems,
    totalPrice,
    totalQuantity,
    refresh,
    setRefresh,
    selectedOptionHead,
    customerDiscount,
    setCustomerDiscound,
    cartDataValue,
    prescriptionData,
    setSelectedOptionHead,
}) => {
    const { isEmpty, cartTotal, emptyCart } = useCart();

    const [open, setOpen] = useState(false);
    const onOpenModal = () => setOpen(true);
    const onCloseModal = () => setOpen(false);

    const handleReset = () => {
        emptyCart();
        resetDiscountItems();
    };

    return (
        <>
            <ModalHeader
                prescriptionData={prescriptionData}
                cartDataValue={cartDataValue}
                totalPrice={cartTotal}
                selectedOptionHead={selectedOptionHead}
                setSelectedOptionHead={setSelectedOptionHead}
            />
            <div className="card bg-light">
                <table className="table table-hover table-bordered">
                    <tbody>
                        {/* <tr>
                        <th>Total Quantity:</th>
                        <td>{totalQuantity}</td>
                    </tr> */}
                        <tr>
                            <th>Sub Total:.</th>
                            <td>{parseFloat(cartTotal).toFixed(2)} $</td>
                        </tr>
                        <tr>
                            <th>Discount:</th>
                            <td>
                                {parseFloat(totalDiscount).toFixed(2)}
                                $
                            </td>
                        </tr>
                        <tr>
                            <th>Total: </th>
                            <td>
                                {parseFloat(cartTotal - totalDiscount).toFixed(
                                    2
                                )}
                                $
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div className="d-flex gap-1 justify-content-end">
                    <button
                        className="btn btn-sm p-2 h-auto btn-danger"
                        onClick={handleReset}
                    >
                        Reset &nbsp; <i className="fa fa-undo"></i>
                    </button>
                    <button
                        disabled={isEmpty || cartTotal == 0}
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                        className="btn btn-sm p-2 h-auto btn-success"
                        onClick={onOpenModal}
                    >
                        Pay Now &nbsp; <i className="fa fa-cash-register"></i>
                    </button>
                </div>
                {open && (
                    <PaymentModal
                        resetDiscountItems={resetDiscountItems}
                        grand_total={cartTotal - totalDiscount}
                        open={open}
                        onCloseModal={onCloseModal}
                        totalDiscount={totalDiscount}
                        selectedOptionHead={selectedOptionHead}
                        prescriptionData={prescriptionData}
                        setSelectedOptionHead={setSelectedOptionHead}
                    />
                )}
            </div>
        </>
    );
};

export default ModalFooter;
