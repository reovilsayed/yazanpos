import axios from "axios";
const secretKey = "pos_password";
export const axiosInstance = axios.create({
    baseURL: `${import.meta.env.VITE_API_URI}`,
    headers: {
        "Content-Type": "application/json",
        "X-Secret-Key": secretKey,
    },
});
