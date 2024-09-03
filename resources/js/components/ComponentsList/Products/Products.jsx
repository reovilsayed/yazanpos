import React, {
    Fragment,
    useCallback,
    useEffect,
    useState,
} from "react";
import CartButton from "../../utils/CartButton";
import Product from "../Product/Product";
import CartModal from "../../utils/Modals/CartModal/CartModal";
import FilterModal from "../../utils/Modals/FilterModal/FilterModal";
import ProductDetailsModal from "../../utils/Modals/ProductDetailsModal/ProductDetailsModal";


import useSound from "use-sound";
import boopSfx from "../../assets/Click Sound Effect.mp3";
import { HashLoader, MoonLoader, PulseLoader } from "react-spinners";
import { useInfiniteFetch } from "../../Hooks/useFetching";
import InfiniteScroll from "react-infinite-scroller";
import { useLocation, useParams } from "react-router-dom";
import { ToastContainer, toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";
import useFetch from "../../Hooks/useFatch";

const Products = () => {
    const location = useLocation();
    const queryParams = new URLSearchParams(location.search);
    const prescriptionUserValue = queryParams.get("prescription");

    //------------- Load prescription Data----------------
    const {
        data: prescriptionData,
        isLoading: prescriptionLoading,
        isSuccess: prescriptionSuccess,
    } = useFetch(
        ["prescription", prescriptionUserValue],
        `/api/prescription?prescription=${prescriptionUserValue}`,
        {
            enabled: !!prescriptionUserValue,
        }
    );

    //------------- Load prescription Data----------------
    const [refresh, setRefresh] = useState(false);
    const [productInfo, setProductInfo] = useState({});
    const [cartDataValue, setCartDataValue] = useState([]);
    const [query, setQuery] = useState("");
    const [addGenericToFilter, setAddGenericToFilter] = useState("");
    const [badge, setBadge] = useState(0);
    const [play] = useSound(boopSfx, {
        volume: 1,
    });
    //----------------- Filter Value-------------------
    const [genericOption, setGenericOption] = useState([]);
    const [supplierOption, setSupplierOption] = useState([]);
    const [categoryOption, setCategoryOption] = useState([]);

    const genericFilterValue = genericOption.map((item) => {
        return item.value;
    });
    const supplierFilterValue = supplierOption.map((item) => {
        return item.value;
    });
    const categoryFIlterValue = categoryOption.map((item) => {
        return item.value;
    });
    const generic = genericFilterValue.join(",");
    const supplier = supplierFilterValue.join(",");
    const category = categoryFIlterValue.join(",");
    //----------------- Filter Value-------------------

    // Filter Value

    // ------------------------------ Open Modal ----------------------------
    const openProductDetailsModal = (productData) => {
        setProductInfo(productData);
        const modal = new bootstrap.Modal(
            document.getElementById("productDetails")
        );
        modal.show();
    };
    // ------------------------------ Open Modal ----------------------------

    // -----------------------------Save Local Storage Data-------------------
    const saveToLocalsStorage = (product) => {
        const existingItems =
            JSON.parse(localStorage.getItem("cartItems")) || [];

        const existingProduct = existingItems.find(
            (item) => item.id === product.id
        );

        if (!existingProduct) {
            const updatedItems = [...existingItems, product];

            // -------------- updated local storage---------------
            localStorage.setItem("cartItems", JSON.stringify(updatedItems));
            setRefresh(!refresh);
            return toast.success(`${product.name} added cart`);
        }
        toast.error(`${product.name} already cart`);
    };

    // -----------------------------Save Local Storage Data-------------------

    // -----------------------------remove Local Storage Data-----------------
    const handelDeleteCartData = (data) => {
        const existingItems =
            JSON.parse(localStorage.getItem("cartItems")) || [];
        const updatedItems = existingItems.filter(
            (item) => item.id !== data.id
        );
        localStorage.setItem("cartItems", JSON.stringify(updatedItems));

        const existingItems1 =
            JSON.parse(localStorage.getItem("CartCalculation")) || [];
        const updatedItems1 = existingItems1.filter(
            (item) => item.id !== data.id
        );
        localStorage.setItem("CartCalculation", JSON.stringify(updatedItems1));
        localStorage.setItem("disCount", JSON.stringify("0"));

        setRefresh(!refresh);
        toast.success(`${data.name} remove from cart`);
    };
    // -----------------------------remove Local Storage Data-----------------

    // -----------------------------Load Api Products Data--------------------

    const {
        data,
        isError,
        isLoading,
        isSuccess,
        isFetching,
        hasNextPage,
        fetchNextPage,
        refetch,
    } = useInfiniteFetch(
        ["products", query, addGenericToFilter, generic, supplier, category],
        `/api/point-of-sale?search=${query}&genericsInput=${addGenericToFilter}&genericsInput=${generic}&suppliersInput=${supplier}&categoriesInput=${category}`
    );

    const handleScroll = useCallback(() => {
        const scrollTop = document.documentElement.scrollTop;
        const shouldFetchNextPage = scrollTop < 500 && scrollTop === 0;

        if (shouldFetchNextPage && hasNextPage && !isFetching) {
            fetchNextPage();
        }
    }, [fetchNextPage, hasNextPage, isFetching]);

    useEffect(() => {
        window.addEventListener("scroll", handleScroll);

        return () => {
            window.removeEventListener("scroll", handleScroll);
        };
    }, [handleScroll]);
    // -----------------------------Load Api Products Data--------------------

    useEffect(() => {
        const cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
        setCartDataValue(cartItems);
    }, [refresh]);

    // -----------------------------Get Local Storage Data--------------------
    useEffect(() => {
        if (prescriptionData?.data?.products?.length > 0) {
            localStorage.setItem("CartCalculation", JSON.stringify(null));
            localStorage.setItem(
                "cartItems",
                JSON.stringify(
                    prescriptionData?.data?.products
                        ? prescriptionData?.data?.products
                        : []
                )
            );
            setRefresh(!refresh);
            // prescriptionData?.products.map((product) => {
            //     saveToLocalsStorage(product);
            // });
        }
    }, [prescriptionUserValue, prescriptionData?.data?.products?.length]);

    return (
        <>
            {/*------------------ Search-----------------  */}
            <div className="row my-2 g-2 shadow-sm">
                <div className="col-md-12 fixed left-0 right-0">
                    <input
                        type="text"
                        value={query}
                        onChange={(e) => setQuery(e.target.value)}
                        placeholder="Search products ....."
                        className="form-control"
                    />
                </div>
                {/*------------------ Search-----------------  */}

                {/*------------------- Cart Modal ---------------*/}
                <CartModal
                    prescriptionData={prescriptionData}
                    cartDataValue={cartDataValue}
                    setRefresh={setRefresh}
                    handelDeleteCartData={handelDeleteCartData}
                    refresh={refresh}
                    genericOption={genericOption}
                    supplierOption={supplierOption}
                    categoryOption={categoryOption}
                    setGenericOption={setGenericOption}
                    setSupplierOption={setSupplierOption}
                    setCategoryOption={setCategoryOption}
                    play={play}
                />
            </div>

            {/*------------------- products wrapper-------------------- */}
            <div
                className=" overflow-y-scroll overflow-x-none pt-3"

                // style="max-height:90vh"
            >
                <>
                    <InfiniteScroll
                        dataLength={data?.pages[0]?.data?.data?.length || 0}
                        next={fetchNextPage}
                        height={`calc(100vh - 210px)`}
                        hasMore={hasNextPage}
                        loader={
                            <div
                                style={{
                                    textAlign: "center",
                                    paddingTop: "25px",
                                }}
                            >
                                <PulseLoader color="#36d7b7" />
                            </div>
                        }
                        endMessage={
                            <div style={{ textAlign: "center" }}>
                                No more items
                            </div>
                        }
                        onScroll={handleScroll}
                        style={{
                            overflowY: "scroll",
                            maxHeight: "90vh",
                            padding: "20px 10px",
                        }}
                    >
                        {" "}
                        <div className="row g-3">
                            {isLoading ? (
                                <div
                                    style={{
                                        width: "100%",
                                        height: "100vh",
                                        display: "flex",
                                        justifyContent: "center",
                                        alignItems: "center",
                                    }}
                                >
                                    {" "}
                                    <HashLoader color="#36d7b7" />
                                </div>
                            ) : data?.pages[0]?.data?.data.length ? (
                                data?.pages?.length ? (
                                    data?.pages?.map((products, index) => (
                                        <Fragment key={index}>
                                            {products?.data?.data?.map(
                                                (product, index) => (
                                                    <Product
                                                        key={index}
                                                        product={product}
                                                        openProductDetailsModal={
                                                            openProductDetailsModal
                                                        }
                                                        saveToLocalsStorage={
                                                            saveToLocalsStorage
                                                        }
                                                        cartDataValue={
                                                            cartDataValue
                                                        }
                                                        handelDeleteCartData={
                                                            handelDeleteCartData
                                                        }
                                                        setAddGenericToFilter={
                                                            setAddGenericToFilter
                                                        }
                                                        addGenericToFilter={
                                                            addGenericToFilter
                                                        }
                                                        setBadge={setBadge}
                                                        play={play}
                                                    />
                                                )
                                            )}
                                        </Fragment>
                                    ))
                                ) : (
                                    "  We couldn’t find products that match your  filters."
                                )
                            ) : (
                                "  We couldn’t find products that match your  filters."
                            )}
                        </div>
                    </InfiniteScroll>
                </>
            </div>
            {/*------------------- products wrapper-------------------- */}

            {/* -----------------------cart button--------------------- */}
            <CartButton
                cartDataValue={cartDataValue}
                genericOption={genericOption}
                supplierOption={supplierOption}
                categoryOption={categoryOption}
            />
            {/* -----------------------cart button--------------------- */}

            {/* -----------------------Modal--------------------- */}
            <FilterModal
                addGenericToFilter={addGenericToFilter}
                setAddGenericToFilter={setAddGenericToFilter}
                genericOption={genericOption}
                supplierOption={supplierOption}
                categoryOption={categoryOption}
                setGenericOption={setGenericOption}
                setSupplierOption={setSupplierOption}
                setCategoryOption={setCategoryOption}
            />
            <ProductDetailsModal productDetails={productInfo} />
            {/* -----------------------Modal--------------------- */}

            {/* --------------------- toasty --------------------- */}
            <ToastContainer
                position="bottom-left"
                autoClose={1000}
                hideProgressBar={false}
                newestOnTop={false}
                closeOnClick
                rtl={false}
                pauseOnFocusLoss
                draggable
                pauseOnHover={false}
                theme="colored"
            />
            {/* --------------------- toasty --------------------- */}
        </>
    );
};

export default Products;
