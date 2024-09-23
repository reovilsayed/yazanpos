import React, { useEffect, useState } from "react";
import image_url from "../../assets/no-image.jpg";
import ProductDetailsModal from "../../utils/Modals/ProductDetailsModal/ProductDetailsModal";
import "../../Styles/Products.css";
import { useCart } from "react-use-cart";

//!! -----------Style----------------
// style
const productCardStyle = {
    position: "relative",
};

const deleteBtnStyle = {
    backgroundColor: "#dc3545",
    color: "#fff",
    border: "none",
    fontSize: "12px",
    position: "absolute",
    right: "1px",
    zIndex: 10,
    height: "20px",
    width: "20px",
    borderRadius: "50%",
    top: "-10px",
    left: "-10px",
};

const genericBtnStyle = {
    fontSize: "10px",
    position: "absolute",
    bottom: "-8px",
    right: "0",
    zIndex: 10,
};

const customCardStyle = {
    border: "1px solid #dee2e6",
    borderRadius: "0.25rem",
    position: "relative",
    cursor: "pointer",
};

const productSelectedStyle = {
    border: "2px solid #007bff",
};

const noQuantityStyle = {
    border: "2px solid #dc3545",
};

const badgeStyle = {
    backgroundColor: "#007bff",
    position: "absolute",
    top: 0,
    right: 0,
    color: "#fff",
    padding: "2px 8px",
    borderRadius: "5px",
    zIndex: 2,
};
const badgeStyle1 = {
    backgroundColor: "#b7368cd1",
    position: "absolute",
    bottom: 0,
    left: 0,
    color: "#fff",
    padding: "2px 8px",
    borderRadius: "0 5px 5px 0px",
    zIndex: 3,
};

const cardHeaderImgStyle = {
    height: "120px",
    width: "100%",
    objectFit: "cover",
};

const cardBodyStyle = {
    padding: "8px",
};

const cardBodyPStyle = {
    margin: 0,
    fontSize: "16px",
    overflow: "hidden",
    whiteSpace: "nowrap",
    textOverflow: "ellipsis",
};

const cardBodySmallStyle = {
    display: "block",
    marginTop: "4px",
    fontSize: "12px",
};

const btnInfoStyle = {
    fontSize: "10px",
    position: "absolute",
    right: "5px",
    bottom: "50px",
};

// style
//!! -----------Style----------------

const Product = ({
    product,
    openProductDetailsModal,
    play,
}) => {
    const { addItem, removeItem, inCart } = useCart();
    const active = inCart(product.id);
    return (
        <div
            className="col-lg-2 col-md-3 col-sm-3 col-6 my-hover-effect g-3"
            style={{
                cursor: "pointer",
            }}
        >
            <div className="effect_products" style={productCardStyle}>
                {inCart(product.id) ? (
                    <button
                        style={deleteBtnStyle}
                        onClick={() => {
                            removeItem(product.id);
                            play();
                        }}
                    >
                        <i className="fa fa-times"></i>
                    </button>
                ) : (
                    ""
                )}

                <div
                    style={{
                        border: active
                            ? "2px solid rgb(35, 151, 253)"
                            : "1px solid rgba(108, 117, 125, 0.378)",
                        maxHeight: "auto",
                    }}
                    className="custom-card"
                >
                    <span style={badgeStyle}>{product?.price} Tk.</span>
                    <div
                        onClick={() => {
                            addItem(product);
                            play();
                        }}
                        className="card-header position-relative"
                    >
                        <img
                            style={{
                                height: "120px",
                                width: "100%",
                                objectFit: "cover",
                            }}
                            src={product?.image ? product?.image : image_url}
                            alt={product.name}
                        />
                    </div>

                    <div
                        style={cardBodyStyle}
                        className="card-body position-relative"
                    >
                        <p
                            title={product.name}
                            className="d-flex gap-2 "
                            style={cardBodyPStyle}
                        >
                            {product?.name.length > 15
                                ? `${product.name.substring(0, 15)}...`
                                : product.name}
                            <small className="text-secondary">
                                ({" "}
                                {product?.category?.name
                                    ? product?.category?.name
                                    : null}
                                )
                            </small>
                        </p>
                        <button
                            onClick={() => openProductDetailsModal(product)}
                            className="btn btn-primary btn-sm position-absolute rounded-circle"
                            style={btnInfoStyle}
                        >
                            <i className="fa fa-info"></i>
                        </button>
                    </div>
                </div>
            </div>
            {/* Single Product  */}
        </div>
    );
};

export default Product;
