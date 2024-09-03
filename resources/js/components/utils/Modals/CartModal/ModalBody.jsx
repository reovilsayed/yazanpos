import React, { Fragment, useEffect, useRef, useState } from "react";
import { toast } from "react-toastify";
import image from "../../../assets/no-image.jpg";
import ModalHeader from "./ModalHeader";
import ModalFooter from "./ModalFooter";

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
                {cartDataValue?.map((data, index) => (
                    <Fragment key={index}>
                        {/* Single Cart */}
                        <div
                            className="row border-bottom border-primary"
                            style={{
                                padding: "5px 5px",
                            }}
                        >
                            <div className="col-md-2 col-3">
                                <img
                                    src={data?.image ? data.image : image}
                                    alt=""
                                />
                            </div>
                            <div className="col-md-10 col-9">
                                <div className="d-flex justify-content-between">
                                    <h6 className="m-0">
                                        <small>{data?.name}</small>{" "}
                                        {/* {data?.size && (
                                            <small>({data?.size})</small>
                                        )} */}
                                        <small>({data?.category?.name})</small>{" "}
                                        <small>{data?.strength}</small>
                                        <small
                                            style={{
                                                marginLeft: "3px",
                                            }}
                                        >
                                            <span> ({data?.price} Taka)</span>{" "}
                                            {/* Replace with your currency formatting logic */}
                                        </small>
                                    </h6>
                                    <button
                                        onClick={() => {
                                            play();
                                            handelDeleteCartData(data);
                                        }}
                                        className="btn btn-danger btn-sm "
                                    >
                                        <i className="fa fa-trash"></i>
                                    </button>
                                </div>
                                <p
                                    style={{
                                        padding: "0",
                                        margin: "0px",
                                        fontSize: "12px",
                                    }}
                                >
                                    <span>
                                        {cartQuantity?.length > 0
                                            ? cartQuantity?.map((cartData) => {
                                                  if (cartData.id === data.id) {
                                                      return (
                                                          cartData.quantity *
                                                          data.price
                                                      ).toFixed(2);
                                                  }
                                              })
                                            : 0}
                                    </span>
                                    Taka
                                </p>
                                <select
                                    className="form-control p-1"
                                    style={{
                                        fontSize: "12px",
                                        marginTop: "3px",
                                    }}
                                >
                                    {/* {productModel.batches.map((batch) => (
                                    <option key={batch.id} value={batch.id}>
                                        {batch.pivot.batch_name} (
                                        {batch.pivot.remaining_quantity -
                                            (item.batches[batch.id]?.quantity ||
                                                0)}
                                        )
                                    </option>
                                ))} */}
                                    {data.batches.map((batch) => {
                                        return (
                                            <option key={batch.id} value={0}>
                                                {cartQuantity.length > 0 ? (
                                                    <>
                                                        {cartQuantity?.map(
                                                            (item) => {
                                                                if (
                                                                    item.id ==
                                                                    data.id
                                                                ) {
                                                                    return (
                                                                        <>
                                                                            {batch
                                                                                ?.pivot
                                                                                .remaining_quantity -
                                                                                item.quantity}
                                                                            ({" "}
                                                                            {batch
                                                                                ?.pivot
                                                                                .batch_name ||
                                                                                "batch name"}
                                                                            )
                                                                        </>
                                                                    );
                                                                }
                                                            }
                                                        )}
                                                    </>
                                                ) : (
                                                    <>
                                                        {
                                                            batch?.pivot
                                                                .remaining_quantity
                                                        }
                                                        (
                                                        {batch?.pivot
                                                            .batch_name ||
                                                            "batch name"}
                                                        )
                                                    </>
                                                )}
                                            </option>
                                        );
                                    })}
                                </select>
                                <div className="mt-2 d-flex gap-1">
                                    <div
                                        style={{ transform: "scale(.9)" }}
                                        className="d-flex gap-2"
                                    >
                                        <button
                                            onClick={() => {
                                                play();
                                                removeFromCart(data, 10);
                                            }}
                                            className="btn btn-outline-danger btn-sm p-1 h-auto"
                                        >
                                            -10
                                        </button>
                                        <button
                                            onClick={() => {
                                                play();
                                                removeFromCart(data, 5);
                                            }}
                                            className="btn btn-outline-danger btn-sm p-1 h-auto"
                                        >
                                            -5
                                        </button>
                                        <button
                                            onClick={() => {
                                                play();
                                                removeFromCart(data, 1);
                                            }}
                                            className="btn btn-outline-danger btn-sm p-1 px-2 h-auto"
                                        >
                                            -
                                        </button>
                                    </div>
                                    <p className="h6 d-flex justify-content-center align-items-center">
                                        {cartQuantity.length > 0 ? (
                                            <>
                                                {cartQuantity?.map(
                                                    (cartData) => {
                                                        if (
                                                            cartData.id ===
                                                            data.id
                                                        ) {
                                                            return cartData.quantity;
                                                        }
                                                    }
                                                )}
                                            </>
                                        ) : (
                                            <>0</>
                                        )}
                                    </p>
                                    <div
                                        style={{ transform: "scale(.9)" }}
                                        className="d-flex gap-2"
                                    >
                                        <button
                                            onClick={() => {
                                                play();
                                                addToCart(data, 1);
                                            }}
                                            className="btn btn-outline-dark btn-sm p-1 px-2 h-auto"
                                        >
                                            +
                                        </button>
                                        <button
                                            onClick={() => {
                                                play();
                                                addToCart(data, 5);
                                            }}
                                            className="btn btn-outline-dark btn-sm p-1 h-auto"
                                        >
                                            +5
                                        </button>
                                        <button
                                            onClick={() => {
                                                play();
                                                addToCart(data, 10);
                                            }}
                                            className="btn btn-outline-dark btn-sm p-1 h-auto"
                                        >
                                            +10
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {/* Single Cart */}
                    </Fragment>
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
