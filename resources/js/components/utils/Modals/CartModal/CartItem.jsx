import React, { Fragment, useState } from "react";
import { useCart } from "react-use-cart";
import useSound from "use-sound";
import boopSfx from "../../../assets/Click Sound Effect.mp3";
import { calculateDiscount } from "../../../../utils/lib";
import image from "../../../assets/no-image.jpg";

function CartItem({ item, updateDiscountItems, preDiscounts }) {
    const { items, updateItem, updateItemQuantity, removeItem } = useCart();

    const [discountType, setDiscountType] = useState("Fixed");
    const [discount, setDiscount] = useState(0.0);
    const [discountReason, setDiscountReason] = useState(
        item?.discountReason ?? ""
    );
    const handlediscountReason = (event) => {
        const { value } = event.target;
        if (!value.length) return;
        setDiscountReason(value);
        updateItem(item.id, {
            discountReason: value,
        });
    };

    const handleDiscountType = (value) => {
        var discountPrice = 0;

        if (value?.title && value?.amount) {
            discountPrice = calculateDiscount(
                item.price * item.quantity,
                value?.amount,
                true
            );
            if (discountPrice > item.itemTotal) return;
            setDiscountType(value?.title);
            setDiscountReason(value?.title);
            updateItem(item.id, {
                discountPrice,
                discount: value?.amount,
                discountReason: value?.title,
            });
            setDiscount(value?.amount);
        } else {
            discountPrice =
                discount > 0
                    ? calculateDiscount(
                          item.price * item.quantity,
                          discount,
                          value === "Percentage"
                      )
                    : item.itemTotal;
            if (discountPrice > item.itemTotal) return;
            setDiscountType(value);
            updateItem(item.id, {
                discountPrice,
                discount: discount,
            });
        }
        updateDiscountItems(item.id, item.itemTotal - discountPrice);
        toggleDropdown();
    };

    const [sowDiscountTypeDropdown, setSowDiscountTypeDropdown] =
        useState(false);
    const toggleDropdown = () => setSowDiscountTypeDropdown((prev) => !prev);

    const handleDiscount = (event) => {
        if (discountType !== "Fixed" && discountType !== "Percentage") return;
        const { value } = event.target;
        let newDiscount = parseFloat(value);
        if (isNaN(newDiscount) || newDiscount < 0) {
            newDiscount = 0;
        }
        const discountPrice =
            newDiscount > 0
                ? calculateDiscount(
                      item.price * item.quantity,
                      newDiscount,
                      discountType === "Percentage"
                  )
                : item.itemTotal;
        if (discountPrice > item.itemTotal) return;
        setDiscount(newDiscount);
        updateItem(item.id, {
            discountPrice,
            discount: newDiscount,
        });
        updateDiscountItems(item.id, item.itemTotal - discountPrice);
    };

    const handleUpdateQuantity = (newQuantity) => {
        play();
        updateItemQuantity(item.id, newQuantity);
        const itemTotal = item.price * newQuantity;

        const discountPrice =
            discount > 0
                ? calculateDiscount(
                      itemTotal,
                      discount,
                      discountType === "Percentage"
                  )
                : itemTotal;
        updateItem(item.id, {
            discountPrice,
        });
    };

    const [play] = useSound(boopSfx, {
        volume: 1,
    });

    /* const { data } = usePost([], "/api/get-variation-price", {
        parent_id: 37514,
        variation: {
            size: "sm",
            color: "asd",
        },
    }); */

    const [variation, setVariation] = useState({});

    const handleVariation = async (key, value) => {
        const newVariation = { ...variation, [key]: value };
        setVariation(newVariation);
        const secretKey = "pos_password";
        const url = `${import.meta.env.VITE_API_URI}/api/get-variation-price`;
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Secret-Key": secretKey,
            },
            body: JSON.stringify({
                parent_id: item.id,
                variation: newVariation,
            }),
        });

        const data = await response.json();
        if (data?.price) {
            updateItem(item.id, { price: data.price });
        }
    };

    return (
        <Fragment>
            <div
                className="row border-bottom border-primary"
                style={{
                    padding: "5px 5px",
                }}
            >
                <div className="col-md-2 col-3">
                    <img src={item?.image ? item.image : image} alt="" />
                </div>
                <div className="col-md-10 col-9">
                    <div className="d-flex justify-content-between">
                        <h6 className="m-0">
                            <small>{item?.name}</small>{" "}
                            {item?.category?.name ? (
                                <small>({item?.category?.name})</small>
                            ) : (
                                ""
                            )}{" "}
                            {item?.strength ? (
                                <small>{item?.strength}</small>
                            ) : (
                                ""
                            )}
                        </h6>
                        <button
                            onClick={() => {
                                play();
                                removeItem(item?.id);
                                updateDiscountItems(item?.id, 0);
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
                        <span>{parseFloat(item.quantity).toFixed(2)}</span>
                        {" X "}
                        <span>{parseFloat(item.price).toFixed(2)}</span>
                        {" = "}
                        <span>{parseFloat(item.itemTotal).toFixed(2)}</span> $
                    </p>
                    <p
                        style={{
                            padding: "0",
                            margin: "0px",
                            fontSize: "12px",
                        }}
                    >
                        After discount ={" "}
                        <span>
                            {parseFloat(
                                item.discountPrice ?? item.itemTotal
                            ).toFixed(2)}
                        </span>{" "}
                        $
                    </p>
                    <div className="mt-2 d-flex gap-1">
                        <div
                            style={{ transform: "scale(.9)" }}
                            className="d-flex gap-2"
                        >
                            <button
                                onClick={() => {
                                    handleUpdateQuantity(item.quantity - 10);
                                }}
                                className="btn btn-outline-danger btn-sm p-1 h-auto"
                            >
                                -10
                            </button>
                            <button
                                onClick={() => {
                                    handleUpdateQuantity(item.quantity - 5);
                                }}
                                className="btn btn-outline-danger btn-sm p-1 h-auto"
                            >
                                -5
                            </button>
                            <button
                                onClick={() => {
                                    handleUpdateQuantity(item.quantity - 1);
                                }}
                                className="btn btn-outline-danger btn-sm p-1 px-2 h-auto"
                            >
                                -
                            </button>
                        </div>
                        <p className="h6 d-flex justify-content-center align-items-center">
                            {item.quantity}
                        </p>
                        <div
                            style={{ transform: "scale(.9)" }}
                            className="d-flex gap-2"
                        >
                            <button
                                onClick={() => {
                                    handleUpdateQuantity(item.quantity + 1);
                                }}
                                className="btn btn-outline-dark btn-sm p-1 px-2 h-auto"
                            >
                                +
                            </button>
                            <button
                                onClick={() => {
                                    handleUpdateQuantity(item.quantity + 5);
                                }}
                                className="btn btn-outline-dark btn-sm p-1 h-auto"
                            >
                                +5
                            </button>
                            <button
                                onClick={() => {
                                    handleUpdateQuantity(item.quantity + 10);
                                }}
                                className="btn btn-outline-dark btn-sm p-1 h-auto"
                            >
                                +10
                            </button>
                        </div>
                    </div>
                    {item.is_variable > 0 ? (
                        <div>
                            <div className="input-group my-3">
                                {item.attributes?.map((attribute, index) => (
                                    <select
                                        key={index}
                                        class={`form-select ${
                                            index === 0
                                                ? "me-3"
                                                : index ===
                                                  item.attributes.length - 1
                                                ? "ms-3"
                                                : "mx-3"
                                        }`}
                                        aria-label="Default select example"
                                    >
                                        <option
                                            onClick={() =>
                                                handleVariation(
                                                    attribute.name,
                                                    null
                                                )
                                            }
                                            selected
                                        >
                                            {attribute?.name}
                                        </option>
                                        {attribute?.value?.map(
                                            (value, valueIndex) => (
                                                <option
                                                    onClick={() =>
                                                        handleVariation(
                                                            attribute.name,
                                                            value
                                                        )
                                                    }
                                                    valueIndex={valueIndex}
                                                    value={value}
                                                >
                                                    {value}
                                                </option>
                                            )
                                        )}
                                    </select>
                                ))}
                            </div>
                        </div>
                    ) : (
                        ""
                    )}

                    <div>
                        <div className="input-group my-3">
                            <input
                                disabled={item.price == 0}
                                type="text"
                                /* onBlur={(e) => handelBlur(e)} */
                                onChange={handlediscountReason}
                                value={discountReason ?? ""}
                                className="form-control"
                                placeholder={`Enter discount reason`}
                                aria-label="Text input with segmented  "
                            />
                            <input
                                disabled={item.price == 0}
                                type="number"
                                /* onBlur={(e) => handelBlur(e)} */
                                onChange={(e) => handleDiscount(e)}
                                value={discount > 0 ? discount : ""}
                                className="form-control"
                                placeholder={`Enter discount in ${discountType.toLowerCase()} amount`}
                                aria-label="Text input with segmented  "
                            />
                            <button
                                disabled={item.price == 0}
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
                                    sowDiscountTypeDropdown ? "show" : ""
                                }`}
                            >
                                <li
                                    className="dropdown-item"
                                    onClick={() =>
                                        handleDiscountType("Percentage")
                                    }
                                >
                                    Percentage
                                </li>
                                <li
                                    className="dropdown-item"
                                    onClick={() => handleDiscountType("Fixed")}
                                >
                                    Fixed
                                </li>
                                {preDiscounts?.map((preDiscount, index) => (
                                    <li
                                        key={index}
                                        className="dropdown-item"
                                        onClick={() =>
                                            handleDiscountType(preDiscount)
                                        }
                                    >
                                        {preDiscount?.title}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            {/* Single Cart */}
        </Fragment>
    );
}

export default CartItem;
