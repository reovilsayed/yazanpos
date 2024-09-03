import React, { useState } from "react";

const ProductDetailsModal = ({ productDetails }) => {
    return (
        <>
            <div
                className="modal fade"
                id="productDetails"
                tabIndex="-1"
                aria-labelledby="productDetailsLabel"
                aria-hidden="true"
            >
                <div className="modal-dialog modal-center modal-lg">
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5
                                className="modal-title"
                                id="productDetailsLabel"
                            >
                                {name}
                            </h5>

                            <button
                                type="button"
                                className="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Close"
                            ></button>
                        </div>
                        <div className="modal-body">
                            <div
                                dangerouslySetInnerHTML={{
                                    __html:
                                        productDetails?.generic?.description ||
                                        "",
                                }}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default ProductDetailsModal;
