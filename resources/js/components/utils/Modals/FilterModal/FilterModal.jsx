import React, { useEffect, useState } from "react";
import { useQuery } from "react-query";

import Select from "react-select";
import useFetch from "../../../Hooks/useFatch";

const ProductDataLoad = async (api) => {
    const secretKey = "pos_password";
    const url = `${import.meta.env.VITE_API_URI}/${api}`;

    const response = await fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "X-Secret-Key": secretKey,
        },
    });

    const data = await response.json();
    return data;
};

const FilterModal = ({
    addGenericToFilter,
    setAddGenericToFilter,
    genericOption,
    supplierOption,
    categoryOption,
    setGenericOption,
    setSupplierOption,
    setCategoryOption,
}) => {
    // load generic api data
    const { data, isLoading, isSuccess, error } = useFetch(
        "[genericData]",
        `api/generics`
    );
    const {
        data: suppliersData,
        isLoading: suppliersLoading,
        isSuccess: suppliersSuccess,
    } = useFetch("[suppliersData]", `api/suppliers`);
    const {
        data: categoriesData,
        isLoading: categoriesLoading,
        isSuccess: categoriesSuccess,
    } = useFetch("[categoriesData]", `api/categories`);
    //------------------- generic transform---------------
    const transformedOptions = data?.data
        ? data?.data?.map((item) => ({ value: item.id, label: item.text }))
        : [];
    // -----------------generic transform--------------------
    // -----------------supplier transform--------------------
    const transformedOptions1 = suppliersData?.data
        ? suppliersData?.data?.map((item) => ({
              value: item.id,
              label: item.text,
          }))
        : [];
    // -----------------supplier transform--------------------
    // -----------------category transform--------------------

    const transformedOptions2 = categoriesData?.data
        ? categoriesData?.data.map((item) => ({
              value: item.id,
              label: item.text,
          }))
        : [];
    // -----------------category transform--------------------

    const selectedGeneric = transformedOptions.filter(
        (item) => item.value === addGenericToFilter
    );
    const selectedSupplier = transformedOptions1.filter(
        (item) => item.value === addGenericToFilter
    );
    const selectedCategory = transformedOptions2.filter(
        (item) => item.value === addGenericToFilter
    );

    const handelClose = () => {
        setAddGenericToFilter("");
    };

    useEffect(() => {
        setGenericOption(selectedGeneric);
        setSupplierOption(selectedSupplier);
        setCategoryOption(selectedCategory);
    }, [addGenericToFilter]);

    useEffect(() => {
        const offcanvas = document.getElementById("offcanvasBottom");
        const offcanvasModal = new bootstrap.Offcanvas(offcanvas);
    }, []);
    return (
        <>
            <div
                className="offcanvas offcanvas-end"
                data-bs-scroll="true"
                data-bs-backdrop="false"
                tabIndex="-1"
                id="offcanvasBottom"
                aria-labelledby="offcanvasBottomLabel"
                style={{
                    cursor: "pointer",
                }}
            >
                <div className="offcanvas-header">
                    <h5 className="offcanvas-title" id="offcanvasBottomLabel">
                        Filter{" "}
                    </h5>
                    <button
                        type="button"
                        className="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                    ></button>
                </div>
                <div className="offcanvas-body small overflow-x-hidden max-w-100">
                    <div className="row row-cols-1 row-cols-md-1 ">
                        <label
                            htmlFor="Generic"
                            style={{
                                paddingBottom: "10px",
                            }}
                        >
                            {" "}
                            Generic
                        </label>
                        <Select
                            placeholder="Select Your Value"
                            isMulti
                            defaultValue={genericOption}
                            value={genericOption}
                            onChange={setGenericOption}
                            options={transformedOptions}
                            onFocus={handelClose}
                        />
                        <label
                            htmlFor="Generic"
                            style={{
                                paddingBottom: "10px",
                                paddingTop: "10px",
                            }}
                        >
                            {" "}
                            Supplier
                        </label>
                        <Select
                            placeholder="Select Your Value"
                            isMulti
                            defaultValue={supplierOption}
                            value={supplierOption}
                            onChange={setSupplierOption}
                            options={transformedOptions1}
                            onFocus={handelClose}
                        />
                        <label
                            htmlFor="Generic"
                            style={{
                                paddingBottom: "10px",
                                paddingTop: "10px",
                            }}
                        >
                            {" "}
                            Category
                        </label>
                        <Select
                            placeholder="Select Your Value"
                            isMulti
                            defaultValue={categoryOption}
                            value={categoryOption}
                            onChange={setCategoryOption}
                            options={transformedOptions2}
                            onFocus={handelClose}
                        />
                    </div>
                </div>
            </div>
        </>
    );
};

export default FilterModal;
