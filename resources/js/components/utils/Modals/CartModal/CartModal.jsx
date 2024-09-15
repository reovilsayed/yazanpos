import React, { useRef, useEffect, useState } from "react";
import ModalHeader from "./ModalHeader";
import ModalBody from "./ModalBody";
import ModalFooter from "./ModalFooter";
import { useQuery } from "react-query";
import { customerDataLoad } from "../../../Hooks/useFetching";
import "./cartmodal.css";
const CartModal = ({
    cartDataValue,
    setRefresh,
    refresh,
    handelDeleteCartData,
    genericOption,
    supplierOption,
    categoryOption,
    setGenericOption,
    setSupplierOption,
    setCategoryOption,
    play,
    prescriptionData,
}) => {
    const offcanvasRef = useRef(null);
    const [selectedOptionHead, setSelectedOptionHead] = useState("");
    const [customerId, setCustomerId] = useState(null);
    const [hasFetched, setHasFetched] = useState(false);
    const [localCart, setLocalCart] = useState([]);

    useEffect(() => {
        setCustomerId(
            selectedOptionHead?.value ? selectedOptionHead?.value : ""
        );
        if (prescriptionData?.data?.customer?.id) {
            setSelectedOptionHead({
                value: prescriptionData?.data?.customer?.id,
            });
        }
    }, [selectedOptionHead, prescriptionData?.data?.customer?.id]);
    //--------------------- single Data Load Customer-----------
    const { data, isLoading, isSuccess, error } = useQuery(
        ["customer_single", customerId, prescriptionData?.data?.customer?.id],
        () =>
            customerDataLoad(
                Number(customerId) > 0
                    ? customerId
                    : prescriptionData?.data?.customer?.id
                    ? prescriptionData?.data?.customer?.id
                    : null
            ),
        {
            enabled:
                Number(customerId) > 0 ||
                !!customerId ||
                !!prescriptionData?.data?.customer?.id,
            onSuccess: () => {
                setHasFetched(true);
            },
        }
    );

    const [customerDiscount, setCustomerDiscound] = useState(
        data?.discount ? data?.discount : null
    );

    useEffect(() => {
        setCustomerDiscound(data?.discount);
    }, [selectedOptionHead, data]);
    //---------------------- single Data Load Customer---------

    //---------------------- handel cart Calculation-----------

    const [cartQuantity, setCartQuantity] = useState([]);

    // -------Remove to cart----------------
    const removeFromCart = (product, quantity) => {
        localStorage.setItem("disCount", JSON.stringify(0));
        const existingItems =
            JSON.parse(localStorage.getItem("CartCalculation")) || [];
        const updatedItems = existingItems.map((item) =>
            item.id === product.id
                ? {
                      ...item,
                      quantity: item.quantity - quantity,
                      price: product.price,
                  }
                : item
        );

        // Save  updated Value local storage
        localStorage.setItem("CartCalculation", JSON.stringify(updatedItems));
        setRefresh(!refresh);
    };

    // -------add to cart----------------
    const addToCart = (product, quantity) => {
        localStorage.setItem("disCount", JSON.stringify(0));
        const existingItems =
            JSON.parse(localStorage.getItem("CartCalculation")) || [];
        const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];

        const removeDoc = cartItems.indexOf(
            cartItems.find((pd) => pd.id === product.id)
        );

        const existingProduct = existingItems.find(
            (item) => item.id === product.id
        );

        if (!existingProduct) {
            const updatedItems = [
                ...existingItems,
                {
                    id: product.id,
                    quantity: quantity,
                    porduct_id: product.batches
                        .map((batch) => batch?.id)
                        .join(","),
                    price: product.price,
                    name: product.name,
                },
            ];

            // Save the updated array to local storage
            localStorage.setItem(
                "CartCalculation",
                JSON.stringify(updatedItems)
            );

            setRefresh(!refresh);
        } else {
            const updatedItems = existingItems.map((item) =>
                item.id === product.id
                    ? {
                          ...item,
                          quantity: item.quantity + quantity,
                          price: product.price,
                      }
                    : item
            );

            // Save the updated array to local storage
            localStorage.setItem(
                "CartCalculation",
                JSON.stringify(updatedItems)
            );

            setRefresh(!refresh);
        }
    };
    // -------add to cart----------------

    // const totalPrice = Math.ceil(
    //     cartQuantity.reduce((total, item) => item.price + total, 0)
    // );
    const totalQuantity = cartQuantity.reduce(
        (total, item) => item.quantity + total,
        0
    );

    useEffect(() => {
        cartDataValue.length == 0 && setCustomerDiscound(null);
        const existingItems =
            JSON.parse(localStorage.getItem("CartCalculation")) || [];

        setLocalCart(existingItems);

        const updateDocRemove = existingItems.filter(
            (data) => data.quantity > 0
        );
        localStorage.setItem(
            "CartCalculation",
            JSON.stringify(updateDocRemove)
        );
        setCartQuantity(existingItems);
    }, [refresh, cartDataValue]);
    // handel cart Calculation
    // ---------------Total Price Calculation--------------
    const total = localCart.reduce(
        (acc, item) => {
            const totalPrice = item.quantity * item.price;
            return {
                quantity: acc.quantity + item.quantity,
                price: acc.price + totalPrice,
            };
        },
        { quantity: 0, price: 0 }
    );

    const totalPrice = total.price.toFixed(2);
    // ---------------Total Price Calculation--------------
    useEffect(() => {
        const bootstrap = window.bootstrap;
        new bootstrap.Offcanvas(offcanvasRef.current);
        return () => {
            const offcanvas = bootstrap.Offcanvas.getInstance(
                offcanvasRef.current
            );
            if (offcanvas) {
                offcanvas.dispose();
            }
        };
    }, [offcanvasRef]);

    return (
        <div
            className="offcanvas offcanvas-end responsive"
            tabIndex="-1"
            id="offcanvasExample"
            aria-labelledby="offcanvasExampleLabel"
            ref={offcanvasRef}
            data-bs-backdrop="false"
        >
            <div className="offcanvas-body p-0">
                <div className="card p-0">
                    {/* Modal Data */}
                    {/* <ModalHeader
                        prescriptionData={prescriptionData}
                        cartDataValue={cartDataValue}
                        totalPrice={totalPrice}
                        selectedOptionHead={selectedOptionHead}
                        setSelectedOptionHead={setSelectedOptionHead}
                    /> */}

                    <ModalBody
                        cartDataValue={cartDataValue}
                        setRefresh={setRefresh}
                        refresh={refresh}
                        setCustomerDiscound={setCustomerDiscound}
                        prescriptionData={prescriptionData}
                        totalPrice={totalPrice}
                        selectedOptionHead={selectedOptionHead}
                        setSelectedOptionHead={setSelectedOptionHead}
                        totalQuantity={totalQuantity}
                        genericOption={genericOption}
                        supplierOption={supplierOption}
                        categoryOption={categoryOption}
                        setGenericOption={setGenericOption}
                        setSupplierOption={setSupplierOption}
                        setCategoryOption={setCategoryOption}
                        customerDiscount={customerDiscount}
                    />

                    {/* Modal Data */}
                </div>
            </div>
        </div>
    );
};

export default CartModal;
