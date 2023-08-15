import api from "./../api";
import type { AxiosPromise } from "axios";

export type Token = {
    cabinetUserId: number;
    accessTokenEndTime: number;
    refreshTokenEndTime: number;
}

export const tokenList = (): AxiosPromise<Token[]> => {
    return api.get('/chat_app_api/token')
}

export const tokenRefresh = (cabinetUserId: number): AxiosPromise<Token> => {
    return api.post('chat_app_api/token/' + cabinetUserId)
}

export const tokenRemove = (cabinetUserId: number): AxiosPromise<Token> => {
    return api.delete('chat_app_api/token/' + cabinetUserId)
}

export type License = {
    licenseId: number;
    licenseTo: number;
    cabinetUserId: number;
    isUse: boolean;
}

export const licenseList = (): AxiosPromise<License> => {
    return api.get('chat_app_api/license')
}

export const licenseChange = (licenseId: number): AxiosPromise<License> => {
    return api.post('chat_app_api/license/' + licenseId)
}

export type Callback = {
    licenseId: number;
    type: string;
    url: string;
}

export const callbackList = (): AxiosPromise<Callback> => {
    return api.get('chat_app_api/callback')
}
