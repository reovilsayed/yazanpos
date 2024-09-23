import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom";
// import "react-responsive-modal/styles.css";
import { Modal } from "react-responsive-modal";
import "./custom.css";
import { toast } from "react-toastify";
import { useCart } from "react-use-cart";
import { calculateDiscount } from "../../../../utils/lib";

const PaymentModal = ({
    resetDiscountItems,
    open,
    onCloseModal,
    selectedOptionHead,
    totalDiscount,
    grand_total,
    prescriptionData,
    setSelectedOptionHead,
}) => {
    const { items, totalItems, cartTotal, emptyCart } = useCart();

    const [status, setStatus] = useState("Unpaid");
    const [notes, setNotes] = useState("");
    const [loading, setLoading] = useState(false);
    const [dueAmount, setDueAmount] = useState(grand_total);

    const [discountType, setDiscountType] = useState("Fixed");
    const [customDiscount, setCustomDiscount] = useState(0.0);
    const handleCustomDiscount = (event) => {
        const { value } = event.target;
        let newDiscount = parseFloat(value);
        if (isNaN(newDiscount) || newDiscount < 0) {
            newDiscount = 0;
        }
        const discountPrice =
            newDiscount > 0
                ? calculateDiscount(
                      grand_total,
                      newDiscount,
                      discountType === "Percentage"
                  )
                : grand_total;

        if (discountPrice > grand_total) return;
        setCustomDiscount(grand_total - discountPrice);
        setDueAmount((prev) =>
            prev > discountPrice ? prev - discountPrice : 0
        );
    };
    const handleDiscountType = (value) => {
        const discountPrice =
            discount > 0
                ? calculateDiscount(
                      grand_total,
                      discount,
                      value === "Percentage"
                  )
                : grand_total;
        if (discountPrice > grand_total) return;
        setCustomDiscount(grand_total - discountPrice);
        setDueAmount((prev) =>
            prev > discountPrice ? prev - discountPrice : 0
        );
        setDiscountType(value);
        toggleDropdown();
    };
    const [sowDiscountTypeDropdown, setSowDiscountTypeDropdown] =
        useState(false);
    const toggleDropdown = () => setSowDiscountTypeDropdown((prev) => !prev);

    const [paymentFields, setPaymentFields] = useState([
        {
            paymentType: "Cash",
            received: 0,
        },
    ]);

    const addPaymentField = () => {
        var tmp = paymentFields;
        tmp.push({
            paymentType: "Cash",
            received: 0,
        });
        var newReceived = 0;
        tmp = tmp.map((item, index) => {
            if (index < tmp.length - 1) {
                newReceived = grand_total - item.received;
                newReceived =
                    newReceived > customDiscount
                        ? newReceived - customDiscount
                        : newReceived;
                return item;
            }
            return { ...item, received: newReceived };
        });
        setPaymentFields(tmp);
        setDueAmount(0);
    };

    const removePaymentField = (index) => {
        var tmp = paymentFields;
        tmp = tmp.filter((item, itemIndex) => itemIndex !== index);
        setPaymentFields(tmp);
    };

    const updatePaymentField = (index, value) => {
        var paid = 0;
        var tmp = paymentFields.map((item, itemIndex) => {
            if (itemIndex === index) {
                paid += value;
                return {
                    ...item,
                    received: value,
                };
            }
            paid += item.received;
            return item;
        });
        setPaymentFields(tmp);
        setDueAmount(grand_total > paid ? grand_total - paid : 0);
    };

    const updatePaymentFieldType = (index, value) => {
        var tmp = paymentFields.map((item, itemIndex) => {
            if (itemIndex === index) {
                return {
                    ...item,
                    paymentType: value,
                };
            }
            return item;
        });
        setPaymentFields(tmp);
    };
    const handelPaymentStatus = (e) => {
        setStatus(e.target.value);
    };

    useEffect(() => {
        var received = paymentFields.reduce((accumulator, currentValue) => {
            return accumulator + (currentValue?.received ?? 0.0);
        }, 0);
        setStatus(received > 0 ? (dueAmount > 0 ? "Due" : "Paid") : "Unpaid");
    }, [paymentFields]);

    const payment_request = async () => {
        setLoading(true);
        var received = paymentFields.reduce((accumulator, currentValue) => {
            return accumulator + Number(currentValue?.received ?? 0.0);
        }, 0);
        var change_amount =
            grand_total - (totalDiscount + customDiscount) - received;
        const paymentInfo = {
            pay_amount: Number(grand_total),
            received_amount: received,
            change_amount: change_amount > 0 ? change_amount : 0.0,
            due_amount: dueAmount,
            status,
            customer_id: selectedOptionHead.value
                ? selectedOptionHead?.value
                : prescriptionData?.customer?.id,
            notes,
            split_payment: paymentFields,
        };
        const cartInfo = {
            products: items,
            discount: Number(totalDiscount + customDiscount) ?? 0,
            total: Number(cartTotal - (totalDiscount + customDiscount)),
            sub_total: Number(cartTotal),
            total_quantity: totalItems,
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
        emptyCart();
        resetDiscountItems();
        setSelectedOptionHead("");
        onCloseModal();
        setLoading(false);
    };

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
                                                        <div className="col-md-4">
                                                            <div className="form-group">
                                                                <label htmlFor="payingAmount">
                                                                    Total Amount
                                                                </label>
                                                                <div className="input-group">
                                                                    <input
                                                                        readOnly
                                                                        disabled
                                                                        type="number"
                                                                        className="form-control"
                                                                        value={
                                                                            grand_total -
                                                                            customDiscount
                                                                        }
                                                                    />
                                                                    <span className="input-group-text bg-light">
                                                                        Tk
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="col-md-4">
                                                            <div className="form-group">
                                                                <label htmlFor="payingAmount">
                                                                    Due Amount
                                                                </label>
                                                                <div className="input-group">
                                                                    <input
                                                                        readOnly
                                                                        disabled
                                                                        type="number"
                                                                        className="form-control"
                                                                        value={
                                                                            dueAmount -
                                                                                customDiscount >
                                                                            0
                                                                                ? dueAmount -
                                                                                  customDiscount
                                                                                : 0
                                                                        }
                                                                    />
                                                                    <span className="input-group-text bg-light">
                                                                        Tk
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div className="col-md-4">
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
                                                    </div>
                                                    {paymentFields.map(
                                                        (item, index) => (
                                                            <div
                                                                key={index}
                                                                className="row align-items-end"
                                                            >
                                                                <div className="col-md-5">
                                                                    <div className="form-group">
                                                                        <select
                                                                            id="paymentType"
                                                                            name="payment_type"
                                                                            className="form-control"
                                                                            onChange={(
                                                                                event
                                                                            ) =>
                                                                                updatePaymentFieldType(
                                                                                    index,
                                                                                    event
                                                                                        .target
                                                                                        .value
                                                                                )
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
                                                                <div className="col-md-6">
                                                                    <div className="form-group">
                                                                        <label htmlFor="receivedAmount">
                                                                            Received
                                                                        </label>
                                                                        <input
                                                                            type="number"
                                                                            onChange={(
                                                                                event
                                                                            ) =>
                                                                                updatePaymentField(
                                                                                    index,
                                                                                    event
                                                                                        .target
                                                                                        .value
                                                                                )
                                                                            }
                                                                            className="form-control"
                                                                            value={
                                                                                item.received
                                                                            }
                                                                        />
                                                                    </div>
                                                                </div>
                                                                {paymentFields.length >
                                                                1 ? (
                                                                    <button
                                                                        type="button"
                                                                        onClick={() =>
                                                                            removePaymentField(
                                                                                index
                                                                            )
                                                                        }
                                                                        style={{
                                                                            width: "fit-content",
                                                                            height: "fit-content",
                                                                        }}
                                                                        class="btn btn-outline-danger form-group"
                                                                    >
                                                                        {"-"}
                                                                    </button>
                                                                ) : (
                                                                    ""
                                                                )}
                                                            </div>
                                                        )
                                                    )}

                                                    <button
                                                        type="button"
                                                        onClick={
                                                            addPaymentField
                                                        }
                                                        class="btn btn-outline-info"
                                                    >
                                                        Split Bill
                                                    </button>

                                                    <div className="input-group my-3">
                                                        <button
                                                            type="button"
                                                            className="btn btn-outline-secondary dropdown-toggle"
                                                            data-bs-toggle="dropdown"
                                                            aria-expanded="false"
                                                            onClick={
                                                                toggleDropdown
                                                            }
                                                        >
                                                            {discountType}
                                                        </button>
                                                        <ul
                                                            className={`dropdown-menu ${
                                                                sowDiscountTypeDropdown
                                                                    ? "show"
                                                                    : ""
                                                            }`}
                                                        >
                                                            <li
                                                                className="dropdown-item"
                                                                onClick={() =>
                                                                    handleDiscountType(
                                                                        "Percentage"
                                                                    )
                                                                }
                                                            >
                                                                Percentage
                                                            </li>
                                                            <li
                                                                className="dropdown-item"
                                                                onClick={() =>
                                                                    handleDiscountType(
                                                                        "Fixed"
                                                                    )
                                                                }
                                                            >
                                                                Fixed
                                                            </li>
                                                        </ul>
                                                        <input
                                                            type="number"
                                                            className="form-control"
                                                            onChange={
                                                                handleCustomDiscount
                                                            }
                                                            placeholder={`Enter discount in ${discountType.toLowerCase()} amount`}
                                                            aria-label="Text input with segmented  "
                                                        />
                                                    </div>

                                                    <div className="row mt-2">
                                                        <div className="col-md-12">
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
                                                                {items?.map(
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
                                                                                        product?.itemTotal
                                                                                    ).toFixed(
                                                                                        2
                                                                                    )}{" "}
                                                                                    Tk.
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <span>
                                                                                    {Number(
                                                                                        product?.discountPrice ??
                                                                                            product.itemTotal
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
                                                                        {parseFloat(
                                                                            cartTotal
                                                                        ).toFixed(
                                                                            2
                                                                        )}
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
                                                                        {parseFloat(
                                                                            totalDiscount +
                                                                                customDiscount
                                                                        ).toFixed(
                                                                            2
                                                                        )}{" "}
                                                                    </span>{" "}
                                                                    Tk
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total</th>
                                                                <td className="text-end">
                                                                    <span>
                                                                        {parseFloat(
                                                                            cartTotal -
                                                                                (totalDiscount +
                                                                                    customDiscount)
                                                                        ).toFixed(
                                                                            2
                                                                        )}
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
                                {
                                    <button
                                        type="button"
                                        className={`btn ${
                                            dueAmount > 0
                                                ? "btn-secondary"
                                                : "btn-primary"
                                        }`}
                                        onClick={payment_request}
                                        disabled={dueAmount > 0 || loading}
                                    >
                                        {loading
                                            ? "Loading.."
                                            : dueAmount > 0
                                            ? "Can't keep due"
                                            : " Complete"}
                                    </button>
                                }
                            </div>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    );
};

export default PaymentModal;
