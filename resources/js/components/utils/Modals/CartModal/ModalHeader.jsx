import React, { useEffect, useState } from "react";
import { useQuery } from "react-query";
import AddCustomerModal from "../AddCustomerModal/AddCustomerModal";
import Select from "react-select";
import "../PaymentModal/payment.css";
import useFetch from "../../../Hooks/useFatch";

const options = [{ value: 0, label: "Walkin Customer" }];

// function ------------------
// const ProductDataLoad = async () => {
//     const secretKey = "pos_password";
//     const url = `${import.meta.env.VITE_API_URI}/api/customers`;

//     const response = await fetch(url, {
//         method: "GET",
//         headers: {
//             "Content-Type": "application/json",
//             "X-Secret-Key": secretKey,
//         },
//     });

//     const data = await response.json();
//     return data;
// };

const ModalHeader = ({
    selectedOptionHead,
    setSelectedOptionHead,
    cartDataValue,
    totalPrice,
    prescriptionData,
}) => {
    // modal value
    const [open, setOpen] = useState(false);

    const onOpenModal = () => setOpen(true);
    const onCloseModal = () => setOpen(false);
    // modal value

    const { data, isLoading, isSuccess, error } = useFetch(
        "[customer]",
        `/api/customers`
    );
    const transformedOptions = data?.data
        ? data?.data.map((item) => ({ value: item.id, label: item.text }))
        : [];
    const allOptions = [...options, ...transformedOptions];
    const selectOption = allOptions?.find(
        (item) => item?.value === Number(prescriptionData?.data?.customer?.id)
    );
    return (
        <div className="card__header">
            <div className="input-group">
                <div
                    style={{
                        height: "40px",
                        width: "100%",
                        display: "flex",
                        alignItems: "center",
                    }}
                >
                    <div
                        style={{
                            width: "250%",
                        }}
                    >
                        <Select
                            value={
                                selectOption?.label
                                    ? selectOption?.label
                                    : selectedOptionHead
                                    ? selectedOptionHead
                                    : selectedOptionHead == ""
                                    ? "Walking Customer"
                                    : ""
                            }
                            isDisabled={totalPrice < 1 || selectOption?.label}
                            placeholder={
                                selectOption?.label
                                    ? selectOption?.label
                                    : "Walkin Customer"
                            }
                            Customer
                            className="form-control"
                            defaultValue={
                                selectedOptionHead
                                    ? selectedOptionHead
                                    : selectOption
                            }
                            onChange={setSelectedOptionHead}
                            options={allOptions}
                        ></Select>
                    </div>

                    <div
                        style={{
                            width: "10%",
                        }}
                    >
                        <button
                            onClick={onOpenModal}
                            data-bs-dismiss="offcanvas"
                            aria-label="Close"
                            className="btn btn-primary btn-sm"
                            type="button"
                            style={{
                                height: "36px",
                            }}
                        >
                            <i className="fa fa-user-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            {open && (
                <AddCustomerModal
                    onCloseModal={onCloseModal}
                    onOpenModal={onCloseModal}
                    open={open}
                />
            )}
        </div>
    );
};

export default ModalHeader;
