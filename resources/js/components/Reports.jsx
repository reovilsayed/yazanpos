import React from "react";
import ReactDOM from "react-dom/client";
import Report from "./ComponentsList/Report/Repord";
import { QueryClient, QueryClientProvider, useQuery } from "react-query";
import { RouterProvider, createBrowserRouter } from "react-router-dom";
import "./index.css";
const queryClient = new QueryClient();
const router = createBrowserRouter([
    {
        path: "reports",
        element: <Report />,
    },
]);

const Reports = () => {
    return (
        <div>
            <RouterProvider router={router}></RouterProvider>
        </div>
    );
};

export default Reports;

if (document.getElementById("reports-view")) {
    const Index = ReactDOM.createRoot(document.getElementById("reports-view"));

    Index.render(
        <React.StrictMode>
            <QueryClientProvider client={queryClient}>
                <Reports />
            </QueryClientProvider>
        </React.StrictMode>
    );
}
