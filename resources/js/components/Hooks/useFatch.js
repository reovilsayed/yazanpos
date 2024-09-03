import { useEffect } from "react";
import { useQuery, useQueryClient } from "react-query";
import { axiosInstance } from "../Axios/axiosInstance";

const useFetch = (key, url, body, options = {}) => {
    const { prefetch, pagePrefetchKey, ...configOptions } = options;
    const queryClient = useQueryClient();

    const { data, isLoading, isError, isSuccess, error } = useQuery(
        key,
        () => axiosInstance.get(url, body),
        {
            ...configOptions,
        }
    );

    useEffect(() => {
        if (pagePrefetchKey && data?.next_page_url) {
            queryClient.prefetchQuery(
                pagePrefetchKey,
                () =>
                    axiosInstance.get(
                        data?.next_page_url,
                        prefetch?.body ? prefetch.body : body
                    ),
                {
                    ...configOptions,
                }
            );
        }
    }, [pagePrefetchKey, data]);

    if (isError) {
        if (error?.response?.status === 401) {
            /* localStorage.setItem("authData", null);
            dispatch({
                type: "logout",
                payload: error?.response?.data || error,
            }); */
            console.error(error);
        }
    }
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
        refetch,
        setData,
    };
};

export const usePost = (key, url, body, options = {}) => {
    const { prefetch, pagePrefetchKey, ...configOptions } = options;
    const queryClient = useQueryClient();

    const { data, isLoading, isError, isSuccess, error } = useQuery(
        key,
        () => axiosInstance.post(url, body),
        {
            ...configOptions,
        }
    );

    useEffect(() => {
        if (pagePrefetchKey && data?.next_page_url) {
            queryClient.prefetchQuery(
                pagePrefetchKey,
                () =>
                    axiosInstance.post(
                        data?.next_page_url,
                        prefetch?.body ? prefetch.body : body
                    ),
                {
                    ...configOptions,
                }
            );
        }
    }, [pagePrefetchKey, data]);

    if (isError) {
        if (error?.response?.status === 401) {
            /* localStorage.setItem("authData", null);
            dispatch({
                type: "logout",
                payload: error?.response?.data || error,
            }); */
            console.error(error);
        }
    }
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
        refetch,
        setData,
    };
};

export default useFetch;
