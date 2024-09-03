import React, { useDebugValue, useEffect, useState } from "react";
import PaymentModal from "../PaymentModal/PaymentModal";
import "../PaymentModal/payment.css";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import ModalHeader from "./ModalHeader";

const ModalFooter = ({
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
    const [open, setOpen] = useState(false);
    const onOpenModal = () => setOpen(true);
    const onCloseModal = () => setOpen(false);
    const [paymentData, setPaymentData] = useState([]);
    const navigate = useNavigate();
    useEffect(() => {
        const paymentProduct =
            JSON.parse(localStorage.getItem("CartCalculation")) || [];

        setPaymentData(paymentProduct);
    }, [refresh]);

    const [disCount, setDisCount] = useState(0);
    const [discountValue, setDiscountValue] = useState(0);
    const [totalDiscount, setTotalDisCount] = useState(0);
    const [showDropdown, setShowDropdown] = useState(false);
    const toggleDropdown = () => {
        setShowDropdown(!showDropdown);
    };

    const grand_total = (totalPrice - totalDiscount).toFixed(2);
    const [discountType, setDiscountType] = useState("Fixed");

    useEffect(() => {
        if (discountType == "Fixed") {
            localStorage.setItem("disCount", JSON.stringify(disCount));
        }
        if (discountType == "Percentage") {
            if (disCount > 12 && discountType == "Percentage") {
                // localStorage.setItem("disCount", JSON.stringify("0"));
                // toast.warn("You will not get more than 12% discount");
                setDisCount(0);
                return;
            }
            localStorage.setItem(
                "disCount",
                JSON.stringify(discountValue / 100) * totalPrice
            );
        }
    }, [discountType, refresh, disCount]);

    const handelChange = (e) => {
        setDisCount(e.target.value);
    };
    const handelBlur = (e) => {
        setDiscountValue(e.target.value);

        setCustomerDiscound(null);
        setRefresh(!refresh);
    };

    const handelRemoveLoacalStorage = () => {
        localStorage.removeItem("disCount");
        localStorage.removeItem("CartCalculation");
        localStorage.removeItem("cartItems");
        setTotalDisCount(0);
        setDisCount(0);
        setCustomerDiscound(null);
        setRefresh(!refresh);
        // if (prescriptionData?.customer?.id) {
        //     navigate("/point-of-sale");
        // }
    };

    useEffect(() => {
        if (cartDataValue.length == 0) {
            localStorage.setItem("disCount", JSON.stringify("0"));
            setDisCount(0);
        }
        if (customerDiscount > 0) {
            setDiscountType("Percentage");
        }
        setTotalDisCount(JSON.parse(localStorage.getItem("disCount")));
        customerDiscount
            ? setTotalDisCount(
                  parseFloat(((customerDiscount / 100) * totalPrice).toFixed(2))
              )
            : setTotalDisCount(
                  parseFloat(
                      JSON.parse(localStorage.getItem("disCount"))
                  ).toFixed(2)
              );
    }, [refresh, customerDiscount, totalDiscount, cartDataValue, discountType]);

    const setDiscountAndCloseDropdown = (type) => {
        setDiscountType(type);
        setShowDropdown(false);
    };

    return (
        <>
            <ModalHeader
                prescriptionData={prescriptionData}
                cartDataValue={cartDataValue}
                totalPrice={totalPrice}
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
                            <td>{totalPrice} Tk</td>
                        </tr>
                        <tr>
                            <th>Discount:</th>
                            <td>
                                {totalDiscount}
                                Tk.
                            </td>
                        </tr>
                        <tr>
                            <th>Total: </th>
                            <td>
                                {grand_total ? grand_total : 0}
                                Tk.
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div>
                    <div className="input-group mb-3">
                        <button
                            disabled={totalPrice == 0}
                            type="button"
                            className="btn btn-outline-secondary dropdown-toggle"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            onClick={toggleDropdown}
                        >
                            {discountType}
                        </button>
                        <ul
                            className={`dropdown-menu ${
                                showDropdown ? "show" : ""
                            }`}
                        >
                            <li>
                                <a
                                    className="dropdown-item"
                                    href="#"
                                    onClick={() =>
                                        setDiscountAndCloseDropdown(
                                            "Percentage"
                                        )
                                    }
                                >
                                    Percentage
                                </a>
                            </li>
                            <li>
                                <a
                                    className="dropdown-item"
                                    href="#"
                                    onClick={() =>
                                        setDiscountAndCloseDropdown("Fixed")
                                    }
                                >
                                    Fixed
                                </a>
                            </li>
                        </ul>
                        <input
                            disabled={totalPrice == 0}
                            type="text"
                            value={
                                customerDiscount > 0
                                    ? customerDiscount
                                    : disCount
                            }
                            onBlur={(e) => handelBlur(e)}
                            onChange={(e) => handelChange(e)}
                            className="form-control"
                            placeholder={
                                discountType == "Percentage"
                                    ? "You will not get more than 12% discount"
                                    : ""
                            }
                            aria-label="Text input with segmented  "
                        />
                    </div>
                </div>

                <div className="d-flex gap-1 justify-content-end">
                    <button
                        className="btn btn-sm p-2 h-auto btn-danger"
                        onClick={handelRemoveLoacalStorage}
                    >
                        Reset &nbsp; <i className="fa fa-undo"></i>
                    </button>
                    <button
                        disabled={paymentData.length == 0 || totalPrice == 0}
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
                        refresh={refresh}
                        setRefresh={setRefresh}
                        totalPrice={totalPrice}
                        grand_total={grand_total}
                        open={open}
                        onCloseModal={onCloseModal}
                        onOpenModal={onCloseModal}
                        paymentData={paymentData}
                        discountValue={totalDiscount}
                        disCount={totalDiscount}
                        selectedOptionHead={selectedOptionHead}
                        totalQuantity={totalQuantity}
                        prescriptionData={prescriptionData}
                        setSelectedOptionHead={setSelectedOptionHead}
                    />
                )}
            </div>
        </>
    );
};

export default ModalFooter;
