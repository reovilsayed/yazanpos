import React from "react";
import ReactDOM from "react-dom/client";
import Products from "./ComponentsList/Products/Products";
import { QueryClient, QueryClientProvider, useQuery } from "react-query";
import { RouterProvider, createBrowserRouter } from "react-router-dom";
import "./index.css";
import { CartProvider } from "react-use-cart";
const queryClient = new QueryClient();
const router = createBrowserRouter([
    {
        path: "point-of-sale",
        element: <Products />,
    },
]);

const Pos = () => {
    return (
        <div>
            <CartProvider>
                <QueryClientProvider client={queryClient}>
                    <RouterProvider router={router}></RouterProvider>
                </QueryClientProvider>
            </CartProvider>
        </div>
    );
};

export default Pos;

if (document.getElementById("pos-view")) {
    const Index = ReactDOM.createRoot(document.getElementById("pos-view"));

    Index.render(
        <React.StrictMode>
            <Pos />
        </React.StrictMode>
    );
}
