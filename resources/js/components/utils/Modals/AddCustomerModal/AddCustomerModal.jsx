import React, { useState } from "react";
import "react-responsive-modal/styles.css";
import { Modal } from "react-responsive-modal";
import "./addCustomar.css";
import "./modal.css";
import { toast } from "react-toastify";

const AddCustomerModal = ({ onCloseModal, onOpenModal, open }) => {
    const handelSubmit = async (e) => {
        e.preventDefault();
        const name = e.target.name.value;
        const email = e.target.email.value;
        const phone = e.target.phone.value;
        const address = e.target.address.value;
        const discount = e.target.discount.value;

        const secretKey = "pos_password";
        const url = `${import.meta.env.VITE_API_URI}/api/create-customer`;
        const response = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Secret-Key": secretKey,
            },
            body: JSON.stringify({ name, email, phone, address, discount }),
        });

        const data = await response.json();
        toast.success("Customer created successfully");
        onOpenModal();
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
                        <div className="modal-content">
                            <div className="modal-header">
                                <h5 className="modal-title" id="modalTitleId">
                                    Add new customer
                                </h5>
                                <button
                                    type="button"
                                    className="btn-close"
                                    onClick={onCloseModal}
                                ></button>
                            </div>
                            <form onSubmit={handelSubmit}>
                                <div className="modal-body">
                                    <div className="row row-cols-2">
                                        <div className="form-group">
                                            <label htmlFor="name">Name</label>
                                            <input
                                                type="text"
                                                id="name"
                                                name="name"
                                                className="form-control"
                                            />
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="phone">Phone</label>
                                            <input
                                                type="tel"
                                                id="phone"
                                                name="phone"
                                                className="form-control"
                                            />
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="email">Email</label>
                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                className="form-control"
                                            />
                                        </div>
                                        <div className="form-group">
                                            <label htmlFor="address">
                                                Address
                                            </label>
                                            <input
                                                type="text"
                                                id="form-control"
                                                name="address"
                                                className="form-control"
                                            />
                                        </div>
                                        <div className="input-group mt-4">
                                            <span className="input-group-text bg-light">
                                                Discount
                                            </span>
                                            <input
                                                type="number"
                                                name="discount"
                                                className="form-control"
                                            />
                                            <span className="input-group-text bg-light">
                                                Percentage
                                            </span>
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
                                    >
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </Modal>
            </div>
        </div>
    );
};

export default AddCustomerModal;
