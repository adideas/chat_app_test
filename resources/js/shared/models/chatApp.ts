import type { AxiosPromise } from "axios";
import api from "./../api";

export type ChatAppOauth = {
    email: string;
    password: string;
    appId: string;
}

export const create = (message: ChatAppOauth): AxiosPromise<boolean> => {
    return api.post('chat-app', message, { baseURL: 'sso' });
};
