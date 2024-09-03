import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
// import "react-responsive-modal/styles.css";
import { Modal } from "react-responsive-modal";
import "./custom.css";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";

const PaymentModal = ({
    open,
    onOpenModal,
    onCloseModal,
    refresh,
    setRefresh,
    paymentData,
    totalPrice,
    discountValue,
    selectedOptionHead,
    totalQuantity,
    disCount,
    grand_total,
    prescriptionData,
    setSelectedOptionHead,
}) => {
    const [dueAmount, setDueAmount] = useState(0);
    const [returnAmount, setReturnAmount] = useState(0);
    const [type, setType] = useState("Cash");
    const [status, setStatus] = useState("Unpaid");
    const [received, setReceived] = useState(0);
    const [notes, setNotes] = useState("");
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const handelValue = (e) => {
        if (grand_total > Number(e.target.value)) {
            setDueAmount(Number(grand_total - e.target.value).toFixed(2));
            setReturnAmount(0);
            setReceived(Number(e.target.value));
        } else {
            setReturnAmount(Number(e.target.value - grand_total));
            setDueAmount(0);
            setReceived(Number(e.target.value));
        }
    };
    const handelPaymentType = (e) => {
        setType(e.target.value);
    };
    const handelPaymentStatus = (e) => {
        setStatus(e.target.value);
    };
    useEffect(() => {
        if (Number(received) === 0) {
            setStatus("Unpaid");
        }
        if (grand_total === Number(received)) {
            setStatus("Paid");
        }
        if (returnAmount > 0 && Number(received) > grand_total) {
            setStatus("Paid");
        }
        if (dueAmount > 0) {
            setStatus("Due");
        }
    }, [dueAmount, returnAmount, status, received, grand_total]);
    // payment request

    const payment_request = async () => {
        setLoading(true);
        const paymentInfo = {
            pay_amount: grand_total,
            received_amount: received,
            change_amount: returnAmount.toFixed(2),
            due_amount: dueAmount,
            status,
            customer_id: selectedOptionHead.value
                ? selectedOptionHead?.value
                : prescriptionData?.customer?.id,
            type,
            notes,
        };
        const cartInfo = {
            products: paymentData,
            discount: discountValue ? discountValue : 0,
            total: Number(grand_total),
            sub_total: Number(totalPrice),
            total_quantity: totalQuantity && totalQuantity,
        };
        const secretKey = "pos_password";
        const url = `${import.meta.env.VITE_API_URI}/api/create-order`;
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Secret-Key": secretKey,
            },
            body: JSON.stringify({ paymentInfo, cartInfo }),
        });

        const data = await response.json();
        toast.success("Oder Success");
        setLoading(false);
        localStorage.removeItem("disCount");
        localStorage.removeItem("CartCalculation");
        localStorage.removeItem("cartItems");
        setSelectedOptionHead("");
        setRefresh(!refresh);
        onCloseModal();
        // navigate("/point-of-sale");
    };
    // payment request

    return (
        <div>
            <div>
                <Modal open={open} center>
                    <div
                        className="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg "
                        role="document"
                    >
                        <div className="modal-content ">
                            <div className="modal-header ">
                                <h5
                                    className="modal-title py-2"
                                    id="modalTitleId"
                                >
                                    Make Payment
                                </h5>
                                <button
                                    type="button"
                                    id="close"
                                    className="btn-close"
                                    onClick={onCloseModal}
                                ></button>
                            </div>
                            <div className="modal_body_here">
                                <div className="modal-body">
                                    <div className="row">
                                        {/* Payment Details */}
                                        <div className="col-md-6">
                                            <div className="card">
                                                <div className="card-body">
                                                    <div className="row">
                                                        <div className="col-md-6">
                                                            <div className="form-group">
                                                                <label htmlFor="receivedAmount">
                                                                    Received
                                                                    Amount
                                                                </label>
                                                                <input
                                                                    type="number"
                                                                    onChange={
                                                                        handelValue
                                                                    }
                                                                    className="form-control"
                                                                    defaultValue={
                                                                        received
                                                                    }
                                                                />
                                                            </div>
                                                        </div>
                                                        <div className="col-md-6">
                                                            <div className="form-group">
                                                                <label htmlFor="payingAmount">
                                                                    Paying
                                                                    Amount
                                                                </label>
                                                                <input
                                                                    readOnly
                                                                    type="number"
                                                                    className="form-control"
                                                                    value={
                                                                        grand_total
                                                                    }
                                                                />
                                                            </div>
                                                        </div>
                                                        <div className="col-md-6 pt-4">
                                                            <div className="form-group">
                                                                <label htmlFor="changeReturn">
                                                                    Change
                                                                    Return
                                                                </label>
                                                                <input
                                                                    readOnly
                                                                    defaultValue="0"
                                                                    value={returnAmount.toFixed(
                                                                        2
                                                                    )}
                                                                    type="number"
                                                                    className="form-control"
                                                                />
                                                            </div>
                                                        </div>
                                                        <div className="col-md-6 pt-4">
                                                            <div className="form-group">
                                                                <label htmlFor="dueAmount">
                                                                    Due Amount
                                                                </label>
                                                                <div className="input-group">
                                                                    <input
                                                                        readOnly
                                                                        defaultValue="0"
                                                                        value={
                                                                            dueAmount
                                                                        }
                                                                        type="number"
                                                                        className="form-control"
                                                                    />
                                                                    <span className="input-group-text bg-light">
                                                                        Tk
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="col-md-6 pt-4">
                                                            <div className="form-group">
                                                                <label htmlFor="paymentType">
                                                                    Payment Type
                                                                </label>
                                                                <select
                                                                    id="paymentType"
                                                                    name="payment_type"
                                                                    className="form-control"
                                                                    onChange={
                                                                        handelPaymentType
                                                                    }
                                                                >
                                                                    <option value="Cash">
                                                                        Cash
                                                                    </option>
                                                                    <option value="Bkash">
                                                                        Bkash
                                                                    </option>
                                                                    <option value="Nagad">
                                                                        Nagad
                                                                    </option>
                                                                    <option value="Card">
                                                                        Card
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div className="col-md-6 pt-4">
                                                            <div className="form-group">
                                                                <label htmlFor="paymentStatus">
                                                                    Payment
                                                                    Status
                                                                </label>
                                                                <select
                                                                    id="paymentStatus"
                                                                    name="payment_status"
                                                                    className="form-control"
                                                                    disabled
                                                                    onChange={
                                                                        handelPaymentStatus
                                                                    }
                                                                    value={
                                                                        status
                                                                    }
                                                                >
                                                                    <option value="Paid">
                                                                        Paid
                                                                    </option>
                                                                    <option value="Due">
                                                                        Due
                                                                    </option>
                                                                    <option value="Unpaid">
                                                                        Unpaid
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div
                                                            className="col-md-12"
                                                            style={{
                                                                paddingTop:
                                                                    "14px",
                                                                paddingBottom:
                                                                    "14px",
                                                            }}
                                                        >
                                                            <div className="form-group">
                                                                <label htmlFor="notes">
                                                                    Notes
                                                                </label>
                                                                <textarea
                                                                    onChange={(
                                                                        e
                                                                    ) =>
                                                                        setNotes(
                                                                            e
                                                                                .target
                                                                                .value
                                                                        )
                                                                    }
                                                                    id="notes"
                                                                    name="notes"
                                                                    className="form-control"
                                                                    cols="30"
                                                                    rows="10"
                                                                    placeholder="Enter notes"
                                                                ></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {/* Cart Summary */}
                                        <div className="col-md-6">
                                            <div className="card">
                                                <div className="card-body">
                                                    <div
                                                        className="table-responsive"
                                                        style={{
                                                            height: "300px",
                                                        }}
                                                    >
                                                        <table className="table">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>
                                                                        Product
                                                                    </th>
                                                                    <th>Qty</th>
                                                                    <th>
                                                                        Sub
                                                                        Total
                                                                    </th>
                                                                    <th>
                                                                        Total
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                {paymentData?.map(
                                                                    (
                                                                        product,
                                                                        index
                                                                    ) => (
                                                                        <tr
                                                                            key={
                                                                                index
                                                                            }
                                                                        >
                                                                            <td>
                                                                                {index +
                                                                                    1}
                                                                            </td>
                                                                            <td>
                                                                                {
                                                                                    product?.name
                                                                                }
                                                                            </td>
                                                                            <td>
                                                                                {
                                                                                    product?.quantity
                                                                                }
                                                                            </td>
                                                                            <td>
                                                                                <span>
                                                                                    {Number(
                                                                                        product?.price
                                                                                    ).toFixed(
                                                                                        2
                                                                                    )}{" "}
                                                                                    Tk.
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <span>
                                                                                    {Number(
                                                                                        product?.quantity *
                                                                                            product?.price
                                                                                    ).toFixed(
                                                                                        2
                                                                                    )}
                                                                                    Tk.
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                    )
                                                                )}
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <table className="table table-primary">
                                                        <tbody>
                                                            <tr>
                                                                <th>
                                                                    Sub Total
                                                                </th>
                                                                <td className="text-end">
                                                                    <span>
                                                                        {" "}
                                                                        {
                                                                            totalPrice
                                                                        }
                                                                    </span>
                                                                    Tk
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>
                                                                    Discount
                                                                </th>
                                                                <td className="text-end">
                                                                    <span>
                                                                        {" "}
                                                                        {disCount
                                                                            ? disCount
                                                                            : discountValue}{" "}
                                                                    </span>{" "}
                                                                    Tk
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total</th>
                                                                <td className="text-end">
                                                                    <span>
                                                                        {
                                                                            grand_total
                                                                        }
                                                                    </span>
                                                                    Tk
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div className="modal-footer">
                                {(selectedOptionHead?.value == 0 &&
                                    received < grand_total) ||
                                (received < grand_total &&
                                    !selectedOptionHead) ? (
                                    <button
                                        type="button"
                                        disabled
                                        className="btn btn-secondary"
                                    >
                                        Walkin Customer Can't Keep Due
                                    </button>
                                ) : (
                                    <button
                                        // disabled={loading}
                                        type="button"
                                        className="btn btn-primary"
                                        onClick={payment_request}
                                    >
                                        {loading ? "Loading.." : " Complete"}
                                    </button>
                                )}
                            </div>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    );
};

export default PaymentModal;
