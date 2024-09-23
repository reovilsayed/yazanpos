import React, { useState } from "react";
import Modal from "react-responsive-modal";
import { toast } from "react-toastify";
import { useCart } from "react-use-cart";

function AddProductModal({ open, onCloseModal }) {
    const [productdata, setProductData] = useState({});

    const handleProductData = (event) => {
        const { name, value } = event.target;
        setProductData((prev) => {
            return { ...prev, [name]: value };
        });
    };
    const { addItem } = useCart();
    const addProduct = () => {
        if (productdata["name"] && productdata["price"]) {
            addItem({
                ...productdata,
                price: parseFloat(productdata["price"]),
                id: `custom-${crypto.randomUUID()}`,
            });
            setProductData();
            toast.success("Custom product added");
            onCloseModal();
        } else {
            toast.error("Please re-check product data.");
        }
    };
    return (
        <div>
            <div>
                <Modal
                    open={open}
                    center
                    classNames={{
                        overlay: "customOverlay1",
                        modal: "customModal1",
                    }}
                >
                    <div
                        className="modal-dialog modal-dialog-scrollable modal-dialog-centered "
                        role="document"
                    >
                        <div className="modal-content ">
                            <div className="modal-header ">
                                <h5
                                    className="modal-title py-2"
                                    id="modalTitleId"
                                >
                                    Custom Product
                                </h5>
                                <button
                                    type="button"
                                    id="close"
                                    className="btn-close"
                                    onClick={onCloseModal}
                                ></button>
                            </div>
                            <div className="modal-body">
                                <div className="row">
                                    <div className="form-group">
                                        <label htmlFor="name">Name</label>
                                        <input
                                            type="text"
                                            id="name"
                                            name="name"
                                            className="form-control"
                                            onChange={handleProductData}
                                        />
                                    </div>
                                </div>
                                <div className="row">
                                    <div className="form-group">
                                        <label htmlFor="price">Price</label>
                                        <input
                                            onChange={handleProductData}
                                            type="number"
                                            id="price"
                                            name="price"
                                            className="form-control"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="modal-footer add_footer">
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    onClick={onCloseModal}
                                >
                                    Cancel
                                </button>
                                <button
                                    type="submit"
                                    className="btn btn-primary"
                                    onClick={addProduct}
                                >
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    );
}

export default AddProductModal;
