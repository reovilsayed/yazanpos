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
    const [customDiscountAmount, setCustomDiscountAmount] = useState(0.0);
    const [paymentFields, setPaymentFields] = useState([
        { paymentType: "Cash", received: 0 },
    ]);

    const [sowDiscountTypeDropdown, setSowDiscountTypeDropdown] =
        useState(false);
    const toggleDropdown = () => setSowDiscountTypeDropdown((prev) => !prev);

    // Centralized useEffect to handle discount and payment updates
    useEffect(() => {
        const totalPaid = paymentFields.reduce(
            (sum, field) => sum + (parseFloat(field.received) || 0),
            0
        );

        // Calculate the discount
        var discount = 0;
        if (customDiscount > 0) {
            discount =
                discountType === "Percentage"
                    ? (grand_total * customDiscount) / 100.0
                    : customDiscount;
        }
        // Calculate the due amount
        const newDueAmount = grand_total - discount - totalPaid;

        setDueAmount(newDueAmount > 0 ? newDueAmount.toFixed(2) : 0);
        setCustomDiscountAmount(discount);

        // Update the status
        setStatus(
            totalPaid > 0 ? (newDueAmount > 0 ? "Due" : "Paid") : "Unpaid"
        );
    }, [grand_total, customDiscount, discountType, paymentFields]);

    // Handle custom discount changes
    const handleCustomDiscount = (event) => {
        const { value } = event.target;
        let newDiscount = parseFloat(value);
        if (isNaN(newDiscount) || newDiscount < 0) newDiscount = 0;
        if (newDiscount > grand_total - totalDiscount) return;
        setCustomDiscount(newDiscount);
    };

    // Handle discount type toggle
    const handleDiscountType = (value) => {
        setDiscountType(value);
        toggleDropdown();
    };

    // Payment field management
    const addPaymentField = () => {
        setPaymentFields([
            ...paymentFields,
            { paymentType: "Cash", received: dueAmount },
        ]);
    };

    const removePaymentField = (index) => {
        const updatedFields = paymentFields.filter(
            (_, itemIndex) => itemIndex !== index
        );
        setPaymentFields(updatedFields);
    };

    const updatePaymentField = (index, value) => {
        const updatedFields = paymentFields.map((item, itemIndex) =>
            itemIndex === index
                ? { ...item, received: parseFloat(value) || 0 }
                : item
        );
        setPaymentFields(updatedFields);
    };

    const updatePaymentFieldType = (index, value) => {
        const updatedFields = paymentFields.map((item, itemIndex) =>
            itemIndex === index ? { ...item, paymentType: value } : item
        );
        setPaymentFields(updatedFields);
    };

    // Handle payment submission
    const paymentRequest = async () => {
        setLoading(true);
        const totalPaid = paymentFields.reduce(
            (acc, current) => acc + parseFloat(current.received || 0),
            0
        );
        const changeAmount =
            grand_total - (customDiscountAmount + totalDiscount + totalPaid);

        const paymentInfo = {
            pay_amount: grand_total - customDiscountAmount,
            received_amount: totalPaid,
            change_amount: changeAmount > 0 ? changeAmount : 0,
            due_amount: dueAmount,
            status,
            customer_id: selectedOptionHead.value
                ? selectedOptionHead.value
                : prescriptionData?.customer?.id,
            notes,
            split_payment: paymentFields,
        };

        const cartInfo = {
            products: items,
            discount:
                customDiscountAmount && totalDiscount
                    ? customDiscountAmount + totalDiscount
                    : 0,
            total: grand_total - customDiscountAmount,
            sub_total: cartTotal,
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
        toast.success("Order Success");
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
                                                                            customDiscountAmount
                                                                        }
                                                                    />
                                                                    <span className="input-group-text bg-light">
                                                                        $
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
                                                                        value={parseFloat(
                                                                            dueAmount
                                                                        ).toFixed(
                                                                            2
                                                                        )}
                                                                    />
                                                                    <span className="input-group-text bg-light">
                                                                        $
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
                                                                                item.received >
                                                                                0.0
                                                                                    ? item.received
                                                                                    : ""
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
                                                            value={
                                                                customDiscount >
                                                                0.0
                                                                    ? customDiscount
                                                                    : ""
                                                            }
                                                            placeholder={`Enter discount in ${discountType.toLowerCase()} amount`}
                                                            aria-label="Text input with segmented"
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
                                                                    <th>
                                                                        Unit
                                                                        Price
                                                                    </th>
                                                                    <th>
                                                                        Sub
                                                                        Total
                                                                    </th>
                                                                    <th>
                                                                        Discount
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
                                                                                {
                                                                                    " X "
                                                                                }
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
                                                                                    $
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <span>
                                                                                    {Number(
                                                                                        product?.itemTotal
                                                                                    ).toFixed(
                                                                                        2
                                                                                    )}{" "}
                                                                                    $
                                                                                </span>
                                                                            </td>
                                                                            <td>
                                                                                <span>
                                                                                    {Number(
                                                                                        product?.discount ??
                                                                                            0
                                                                                    ).toFixed(
                                                                                        2
                                                                                    )}{" "}
                                                                                    $
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

                                                                                    $
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
                                                                    $
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
                                                                            totalDiscount
                                                                        ).toFixed(
                                                                            2
                                                                        )}
                                                                        {customDiscount >
                                                                        0.0 ? (
                                                                            <>
                                                                                {
                                                                                    " + "
                                                                                }
                                                                                {parseFloat(
                                                                                    customDiscountAmount
                                                                                ).toFixed(
                                                                                    2
                                                                                )}
                                                                                {
                                                                                    " = "
                                                                                }
                                                                                {parseFloat(
                                                                                    totalDiscount +
                                                                                        customDiscountAmount
                                                                                ).toFixed(
                                                                                    2
                                                                                )}
                                                                            </>
                                                                        ) : (
                                                                            ""
                                                                        )}
                                                                    </span>{" "}
                                                                    $
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total</th>
                                                                <td className="text-end">
                                                                    <span>
                                                                        {parseFloat(
                                                                            cartTotal -
                                                                                (totalDiscount +
                                                                                    customDiscountAmount)
                                                                        ).toFixed(
                                                                            2
                                                                        )}
                                                                    </span>
                                                                    $
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
                                        onClick={paymentRequest}
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
