import {AxiosInstance} from "axios";

import axios from "axios"

const axiosApiInstance: AxiosInstance = axios.create({
    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json; charset=utf-8'
    },
    baseURL: 'api'
})

axiosApiInstance.interceptors.request.use(
    async config => {
        // config.auth.username
        // config.auth.password
        return config;
    },
    error => Promise.reject(error)
);

axiosApiInstance.interceptors.response.use((response) => response,
    async function (error) {
        const originalRequest = error.config;
        //if (error.response.status === 403 && !originalRequest._retry) {
        //    originalRequest._retry = true;
        //    const access_token = await refreshAccessToken();
        //    axios.defaults.headers.common['Authorization'] = 'Bearer ' + access_token;
        //    return axiosApiInstance(originalRequest);
        //}
        return Promise.reject(error);
    });

export default axiosApiInstance
