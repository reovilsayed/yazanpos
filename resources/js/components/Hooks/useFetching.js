import axios from "axios";
import { useEffect } from "react";
import { useInfiniteQuery, useQueryClient } from "react-query";

export const useInfiniteFetch = (key, url, body, options = {}) => {
    const { prefetch, ...configOptions } = options;
    const queryClient = useQueryClient();
    const secretKey = "pos_password";
    const fetchPosts = async ({ pageParam = 1 }) => {
        const response = await axios.get(`${url}&page=${pageParam}`, {
            headers: {
                "Content-Type": "application/json",
                "X-Secret-Key": secretKey,
            },
        });
        return response; // Assuming your API returns data in a specific format
    };

    const {
        data,
        isLoading,
        isError,
        isSuccess,
        error,
        hasNextPage,
        fetchNextPage,
        isFetching,
    } = useInfiniteQuery(key, fetchPosts, {
        ...configOptions,
        getNextPageParam: (data, allPages) => {
            const currentPage = data?.data?.current_page;
            const lastPageNumber = data?.data?.last_page;

            // Calculate the next page number
            const nextPage = currentPage + 1;
            // Check if the next page exceeds the last page
            return nextPage <= lastPageNumber ? nextPage : null;
        },
    });

    useEffect(() => {
        if (error?.response?.status === 401) {
            localStorage.setItem("authData", null);
        }
    }, [isError, error]);

    const refetch = (explicitKey) => {
        queryClient.invalidateQueries(explicitKey || key);
    };

    const setData = (callback) => {
        queryClient.setQueryData(key, (data) => {
            return callback(data);
        });
    };

    return {
        data,
        isLoading,
        isError,
        isSuccess,
        hasNextPage,
        isFetching,
        fetchNextPage,
        refetch,
        setData,
    };
};
export const customerDataLoad = async (id) => {
    const secretKey = "pos_password";
    const url = `${import.meta.env.VITE_API_URI}/api/single-customer?id=${id}`;

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
